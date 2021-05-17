<?php

namespace App\Http\Controllers;

use App\Mail\SendPost;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'nome'=> 'required|min:1|max:100',
            'email' => 'required',
            'telefone' => 'required',
            'endereco' => 'required',
            'curriculo' => 'required|mimes:pdf,doc,docx,tx|min:20kb|max:500kb'
        ]);

        if ($request->file('curriculo')->isValid()) {
            $curriculo = $request->file('curriculo')->store('curriculos');
        }


        if (Post::where('email', $request->email)->exists()) {  /**Linha para vericar se o valor email já existe*/
            return response()->json(['message' => 'email já existe'], 404);
        } else {
            $post = Post::create([
                'name' => $request->nome,
                'email' => $request->email,
                'telefone' => $request->telefone,
                'endereco' => $request->endereco,
                'curriculo' => $curriculo
            ]);

            $post->ip = $request->ip();
        }

        Mail::to($post->email)->send(new SendPost($post));

        return response()->json(['message' => 'successfuly'], 200);
    }
}
