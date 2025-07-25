<?php

namespace App\Livewire;

use App\Models\Client;
use App\Models\User;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class UserPermission extends Component
{
    use WithPagination, WithFileUploads;

    public $userModal, $client, $tempActived, $tempRole, $tempAssociate, $tempTel, $newImage;
    public $message,  $status,  $searchTerm = '';
    public $confirmingDelete = false,  $confirmingUpdate = false,  $isProcessing = false,  $userIdToDelete = null,  $userIdToUpdate = null;

    protected $rules = [
        'newImage' => 'nullable|image|max:2048',
    ];

    protected $messages = [
        'newImage.image' => 'O arquivo enviado deve ser uma imagem.',
        'newImage.max' => 'A imagem não pode ultrapassar 2MB.',
    ];

    // Função que vai ser chamada toda vez que o searchTerm mudar
    public function updatingSearchTerm()
    {
        $this->resetPage();  // Resetar a página ao atualizar o termo de busca
    }

    // Função para confirmar a exclusão
    public function confirmDelete($userId)
    {
        $this->confirmingDelete = true;
        $this->userIdToDelete = $userId;

        $this->dispatch('open-delete-modal');
    }

    // Função para cancelar a exclusão
    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->userIdToDelete = null;
        $this->reset(['message', 'status']);
    }

    // Função para abrir o modal de atualização
    public function showUser(int $userId, int $clientId)
    {
        $this->confirmingUpdate = true;
        $this->userIdToUpdate = [$userId, $clientId];

        $this->userModal = User::find($userId);
        $this->client = Client::find($clientId);

        if ($this->userModal) {
            $this->tempActived = $this->userModal->actived;
            $this->tempRole = $this->userModal->role->value;

            if ($this->client) {
                $this->tempTel = $this->userModal->client->whatsapp;
                $this->tempAssociate = $this->userModal->client->associate;
            }
        }

        $this->dispatch('modalOpened');
    }

    // Função para cancelar a atualização e fechar o modal
    public function cancelUpdate()
    {
        $this->confirmingUpdate = false;
        $this->userIdToUpdate = null;
    }

    // Função para excluir o usuário
    public function deleteUser()
    {
        $user = User::find($this->userIdToDelete);
        if ($user) {
            $user->delete();
            $this->message = 'Usuário excluído com sucesso!';
            $this->status = 'success';
        } else {
            $this->message = 'Usuário não encontrado.';
            $this->status = 'error';
        }

        $this->confirmingDelete = false;
        $this->userIdToDelete = null;
        $this->resetPage();  // Resetar a página após exclusão
    }

    // Função para atualizar os dados do usuário
    public function updateUser()
    {
        // Impedir cliques múltiplos
        if ($this->isProcessing) {
            return;
        }

        // Marcar o início do processamento
        $this->isProcessing = true;

        // Limitação de tempo (5 segundos para completar)
        $startTime = now();

        // Validação dos dados
        $this->validate();

        // Encontrar o usuário e o cliente usando os IDs passados
        $user = User::find($this->userIdToUpdate[0]);

        if ($this->userModal) {
            // Atualizando o usuário com os novos dados de 'actived' e 'role'
            $user->actived = $this->tempActived;
            $user->role = $this->tempRole;

            // Tentar salvar as atualizações no banco
            try {
                $user->save();

                if ($this->userIdToUpdate[1] > 0) {
                    $client = Client::find($this->userIdToUpdate[1]);

                    if ($client) {
                        if ($this->newImage) {
                            $sizeImageMb = number_format((($this->newImage->getSize() / 1024) / 1024), 2);

                            if ($sizeImageMb > 2) {
                                $this->message = 'Ops..., a iamgem não pode passar de 2MB';
                                $this->status = 'error';

                                $this->isProcessing = false;
                                $this->confirmingUpdate = false;
                                $this->userIdToUpdate = null;
                                $this->resetPage();
                            } else {
                                $extension = $this->newImage->getClientOriginalExtension();
                                $imageName = strtolower(str_replace(' ', '_', $client->name)) . '.' . $extension;                                

                                $this->newImage->storeAs('img/users', $imageName, 'public');

                                $client->update([
                                    'photo' => $imageName,
                                    'whatsapp' => $this->tempTel,
                                    'associate' => $this->tempAssociate
                                ]);
                            }
                        } else {
                            $client->update([
                                'whatsapp' => $this->tempTel,
                                'associate' => $this->tempAssociate
                            ]);
                        }
                    }
                }

                // Mensagem de sucesso
                $this->message = 'Dados atualizados com sucesso!';
                $this->status = 'success';
            } catch (\Exception $e) {
                // Mensagem de erro em caso de falha
                $this->message = 'Ops..., não foi possível atualizar os dados, tente novamente!';
                $this->status = 'error';
            }
        }

        // Resetar o modal e os dados após a atualização
        $this->isProcessing = false;
        $this->confirmingUpdate = false;
        $this->userIdToUpdate = null;
        $this->resetPage();
    }

    // Função para renderizar a view e filtrar usuários com base no searchTerm
    public function render()
    {
        // Realiza a consulta para obter os usuários
        $usuarios = User::with('client')
            ->where('role', '<>', 3)
            ->when($this->searchTerm, function ($query) {
                $query->whereHas('client', function ($query) {
                    $query->where('name', 'like', '%' . $this->searchTerm . '%');
                })
                    ->orWhere('email', 'like', '%' . $this->searchTerm . '%'); // Pesquisa pelo email do usuário
            })
            ->orderBy('access_time', 'desc')
            ->get();

        // Retorna a view com as variáveis corretas
        return view('livewire.user-permission', [
            'usuarios' => $usuarios,
            'message' => $this->message,
            'status' => $this->status,
        ]);
    }
}
