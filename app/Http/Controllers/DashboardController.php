<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function test(){
        return view('test', [
            'title' => 'Curso Laravel en PLatzi !!'
        ]);
        /*return [
            'saludo' => 'Hola',
            'nombre' => 'Platzi'
        ];*/
    }
    
    public function index(Request $request){
        //var_dump($request -> query('title'));die;
        return view ('test', [
            'title' => ($request -> query('title', 'Nada por aquí'))
        ]);
    }

}
