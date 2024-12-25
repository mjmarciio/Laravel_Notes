<?php

namespace App\Http\Controllers;

use App\Models\Note;
use App\Models\User;
use App\Services\Operations;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index()
    {

        //load user's notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        //show home view
        return view('home', ['notes' => $notes]);
    }

    public function newNote()
    {

        return view('new_note');
    }

    public function newNoteSubmit(Request $request)
    {

        // validação da request
        $request->validate(
            // Rules
            [
                'text_title' => 'required|min:3|max:200',
                'text_note' => 'required|min:3|max:3000'
            ],
            // parametros (error messages)
            [
                'text_title.required' => 'O título é obrigatório!',
                'text_title.min' => 'A título deve ter pelo menos :min caracteres',
                'text_title.max' => 'A título deve ter menos de :max caracteres',

                'text_note.required' => 'A nota é obrigatório!',
                'text_note.min' => 'A nota deve ter pelo menos :min caracteres',
                'text_note.max' => 'A nota deve ter menos de :max caracteres'
            ]
        );

        // get user id
        $id = session('user.id');

        // create new note
        $note = new Note();
        $note->user_id = $id;
        $note->title = $request->text_title;
        $note->text = $request->text_note;
        $note->save();

        // redirect to home
        return redirect()->route('home');
    }

    public function editNote($id)
    {

        $id = Operations::decryptId($id);

        // load note
        $note = Note::find($id);

        // show edit note view
        return view('edit_note', ['note' => $note]);
    }

    public function deleteNote($id)
    {

        $id = Operations::decryptId($id);
    }
}
