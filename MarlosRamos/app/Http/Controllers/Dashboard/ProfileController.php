<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Laravel\Facades\Image;
use Illuminate\Support\Str;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Atualiza os campos normais
        $user->fill($request->validated());
    
        // Se o e-mail mudou, remove a verificação
        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }
    
        // Lógica de imagem de perfil
        if ($request->hasFile('image')) {
            $imageFile = $request->file('image');
    
            // Usa o nome do usuário como base para o nome do arquivo
            $filename = Str::slug(strtolower($user->name), '_') . '.' . $imageFile->getClientOriginalExtension();
    
            // Caminho para salvar
            $path = 'app/public/users/';
    
            // Redimensiona e salva a imagem
            $image = Image::read($imageFile)->resize(300, 200);
            $image->save(storage_path($path . $filename));
    
            // Atualiza o caminho da imagem no usuário
            $user->image = 'users/' . $filename;
        }
    
        // Salva tudo
        $user->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
