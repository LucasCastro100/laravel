<?php

namespace App\Livewire;

use App\Models\Message;
use Livewire\Component;
use Livewire\WithPagination;

class Notice extends Component
{
    use WithPagination;

    public $searchNotice = '';
    public $message, $status, $noticeModal, $title, $situation, $description;
    public $confirmingDelete = false, $confirmingUpdate = false, $isProcessing = false;
    public $noticeToDelete = null, $noticeToUpdate = null, $noticeIdToUpdate = null;    
    public $permissionLevel = [];


    protected $rules = [
        'title' => ['required', 'string'],
        'permissionLevel' => ['required', 'array', 'min:1'],
        'permissionLevel.*' => ['in:0,1,2'],
        'situation' => ['required', 'in:0,1,2'],
        'description' => ['required'],
    ];

    protected $messages = [
        'title.required' => 'O campo TITULO é obrigatório.',
        'permissionLevel.required' => 'Pelo menos uma opção deve ser selecionada.',
        'permissionLevel.min' => 'Pelo menos uma opção deve ser selecionada.',
        'permissionLevel.*.in' => 'Opção inválida selecionada.',
        'situation.required' => 'Pelo menos uma SITUAÇÃO deve ser selecionada.',
        'situation.in' => 'Situação inválida selecionada.',
        'description.required' => 'O campo DESCRIÇÃO é obrigatório.',
    ];

    public function updatingSearchNotice()
    {
        $this->resetPage();
    }

    public function confirmDelete($userId)
    {
        $this->confirmingDelete = true;
        $this->noticeToDelete = $userId;
    }

    public function cancelDelete()
    {
        $this->confirmingDelete = false;
        $this->noticeToDelete = null;
        $this->reset(['message', 'status']);
    }

    public function showNotice(int $noticeId)
    {
        $this->confirmingUpdate = true;
        $this->noticeIdToUpdate = $noticeId;
        $this->noticeModal = Message::find($noticeId);

        if ($this->noticeModal) {
            $this->title = $this->noticeModal->title;
            $this->situation = $this->noticeModal->situation;
            $this->description = $this->noticeModal->description;
            $this->permissionLevel = $this->noticeModal->permission_level ?? [];
        }
    }

    public function deleteNotice()
    {
        $notice = Message::find($this->noticeIdToUpdate);
        if ($notice) {
            $notice->delete();
            $this->message = 'Aviso excluído com sucesso!';
            $this->status = 'success';
        } else {
            $this->message = 'Aviso não encontrado.';
            $this->status = 'error';
        }

        $this->confirmingDelete = false;
        $this->noticeToDelete = null;
        $this->resetPage();
    }

    public function updateNotice()
    {
        if ($this->isProcessing) {
            return;
        }

        $this->isProcessing = true;

        
        $startTime = now();
        $this->situation = $this->situation->value;
        $this->validate();

        $notice = Message::find($this->noticeIdToUpdate);

        if ($this->noticeModal) {
            
            $notice->title = $this->title;
            $notice->situation =  $this->situation;
            $notice->description = $this->description;
            $notice->permission_level = $this->permissionLevel;
            try {
                $notice->save();
                $this->message = 'Dados atualizados com sucesso!';
                $this->status = 'success';
            } catch (\Exception $e) {
                $this->message = 'Ops..., não foi possível atualizar os dados, tente novamente!';
                $this->status = 'error';
            }
        }

        $this->isProcessing = false;
        $this->confirmingUpdate = false;
        $this->noticeIdToUpdate = null;
        $this->resetPage();
    }

    public function cancelUpdate()
    {
        $this->confirmingUpdate = false;
        $this->noticeToUpdate = null;
    }

    public function render()
    {
        $notices = Message::where('title', 'like', '%' . $this->searchNotice . '%')->paginate(10);
        return view('livewire.notice', ['notices' => $notices]);
    }
}
