<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class MainController extends Controller
{
    public function index(){
        
        //load user's notes
        $id = session('user.id');
        $notes = User::find($id)->notes()->get()->toArray();

        //show home view
        return view('home', ['notes' => $notes]);
        
    }

    public function newNote(){

        echo "I'm creating a new note!";
        
    }

    public function editNote($id){

        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $er) {
            
            return redirect()->route('home');
        }



    }

    public function deleteNote($id){

        try {
            $id = Crypt::decrypt($id);
        } catch (DecryptException $er) {
            
            return redirect()->route('home');
        }



    }






}
