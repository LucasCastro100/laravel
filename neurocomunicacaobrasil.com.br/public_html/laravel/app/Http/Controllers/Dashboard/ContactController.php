<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ContactReply;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with(['user', 'course', 'replies.user'])
            ->latest()
            ->paginate(15);

        return view('dashboard.contacts.index', [
            'title' => 'Dúvidas e Contatos',
            'contacts' => $contacts,
        ]);
    }

    public function reply(Request $request, string $uuid)
    {
        $request->validate([
            'reply' => ['required', 'string', 'min:2', 'max:2000'],
        ], [
            'reply.required' => 'A resposta é obrigatória.',
        ]);

        $contact = Contact::where('uuid', $uuid)->firstOrFail();

        ContactReply::create([
            'contact_id' => $contact->id,
            'user_id' => Auth::id(),
            'reply' => $request->reply,
        ]);

        return redirect()->back()->with('success', 'Resposta enviada!');
    }
}
