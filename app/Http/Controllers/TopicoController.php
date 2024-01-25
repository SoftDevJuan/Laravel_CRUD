<?php

namespace App\Http\Controllers;

use App\Models\Topico;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class TopicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vs_topicos = Topico::where('user_id', '>', 0)
        ->join('users', 'users.id', '=', 'topicos.user_id')
        ->select('users.name', 'users.email', 'topicos.*')
        ->get();
        $topico = $this->cargarDT($vs_topicos);
        return view('topicos.index')->with('topico', $topico);
    }



    public function cargarDT($consulta)
        {
        $topico = [];
        foreach ($consulta as $key => $value) {
        $ruta = "eliminar" . $value['id'];
        $eliminar = route('delete-topico', $value['id']);
        $actualizar = route('topicos.edit', $value['id']);
        $acciones = '
        <div class="btn-acciones">
        <div class="btn-circle">
        <a href="' . $actualizar . '" role="button" class="btn btn-success" title="Actualizar">
        <i class="far fa-edit">Actulizar</i>
        </a>
        <a href="#' . $ruta . '" role="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#' . $ruta . '" title="Eliminar">
        <i class="far fa-trash-alt">Eliminar</i>
        </a>
        </div>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="' . $ruta . '" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">¿Seguro que deseas eliminar este video?</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
        <p class="text-primary">
        <small>
        ' . $value['id'] . ', ' . $value['title'] . ' </small>
        </p>
        </div>
        <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <a href="' . $eliminar . '" type="button" class="btn btn-danger">Eliminar</a>
        </div>
        </div>
        </div>
        </div>
        ';
        $topico[$key] = array(
        $acciones,
        $value['topico_titulo'],
        $value['contenido'],
        $value['name'],
        $value['email']
        );
        }
        return $topico;
}



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    return view('topicos.create');

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validación de campos requeridos
    $this->validate($request, [
    'topico_titulo' => 'required|min:5',
    'contenido' => 'required',
    
    ]);
    $topico = new Topico();
    $user = Auth::user();
    $topico->user_id = $user->id;
    $topico->topico_titulo = $request->input('topico_titulo');
    $topico->contenido = $request->input('contenido');
    $topico->save();
    return redirect()->route('topicos.index')->with(array(
    'message' => 'El Topico se ha subido correctamente'
    ));
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $topico = Topico::findOrFail($id);
        return view('topicos.edit', array(
        'topico' => $topico
        ));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'topico_titulo' => 'required|min:5',
            'contenido' => 'required',
            ]);
            $user = Auth::user();
            $topico = Topico::findOrFail($id);
            $topico->user_id = $user->id;
            $topico->topico_titulo = $request->input('topico_titulo');
            $topico->contenido = $request->input('contenido');
            $topico->save();
            return redirect()->route('topicos.index')->with(array(
            'message' => 'El topico se ha actualizado correctamente'
            ));
            
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }


    public function delete_topico($id)
        {
            $topico  = Topico::find($id);
            if ($topico) {
            $topico->delete();
            
            return redirect()->route('topicos.index')->with(array(
            "message" => "El video se ha eliminado correctamente"
            ));
            } else {
            return redirect()->route('topicos.index')->with(array(
            "message" => "El video que trata de eliminar no existe"
            ));
            }
            }
            
        





}
