<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Models\Ponto_Coleta;

class APIController extends Controller
{
    //
    public function index(Request $request)
    {
        $pontos = Ponto_Coleta::get();
        return response(array(
                'error' => false,
                'pontos' =>$pontos->toArray(),
               ),200);
    }
    public function show($id)
    {
        $pontos = Ponto_Coleta::find($id);
        return response(array(
                'error' => false,
                'pontos' =>$pontos,
               ),200);
    }
}
