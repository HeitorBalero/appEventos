<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\Eventos;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class EventosController extends Controller
{
    //

    public function MostrarHome(){
        return view('homeadm');
    }

    public function MostrarCadastroEvento(){
        return view('cadastroevento');
    }

    public function CadastrarEventos(Request $request){
        $registros = $request->validate([
            'nomeEvento'=>'sring|required',
            'dataEvento'=>'date|required',
            'localEvento'=>'sring|required',
            'imgEvento'=>'sring|required'
        ]);
    
    Eventos::create($registros);
    return Redirect::route('home-adm');
    }

    public function destroy(Eventos $id){
        $id->delete();
        return Redirect::route('home-adm');
    }

    public function Update(Eventos $id, Request $request){
        $registros = $request->validate([
            'nomeEvento'=>'sring|required',
            'dataEvento'=>'date|required',
            'localEvento'=>'sring|required',
            'imgEvento'=>'sring|required'
        ]);
        $id->fill($registros);
        $id->save();

        return Redirect::route('home-adm');
    }

    public function MostrarEventoCodigo(Eventos $id){
        return view('alterar-evento',['registros'=>$id]);
    }

    public function MostrarEventoNome(Request $request){
        $registros = Eventos::query();
        $registros->When($request->nomeEvento,function($query,$valor){
            $query->where('nomeEvento','like','%'.$valor.'%');
        });
        $todosRegistros = $registros->get();
        return view('listaEventos',['registrosEventos'=>$todosRegistros]);
    }

}
