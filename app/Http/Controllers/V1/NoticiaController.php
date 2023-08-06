<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\NoticiaResource;
use App\Models\Noticia;
use App\Models\NoticiasTipo;
use Illuminate\Http\Request;
use App\Http\Resources\V1\NoticiaCollection;

class NoticiaController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    private $cantidadNoticias = 20;
    public function index(){
        //retorna todas las noticias paginadas de a 20
        //link demo http://localhost:8000/api/v1/noticias?page=2

        // $noticias = Noticia::BuscarNoticias(isset($request->buscar) ? $request->buscar : '');

        //dd($noticias->lastPage()); última página de los resultados

        //si no se quiere la paginación, borrar paginate para que solo quede: return new NoticiaCollection(Noticia::latest());
        return new NoticiaCollection(Noticia::BuscarNoticias('', $this->cantidadNoticias));
    }

    public function cantidadNoticias(Request $request){
        $busqueda = isset($request->buscar) ? $request->buscar : '';
        $cantidad = isset($request->cantidad) ? $request->cantidad : $this->cantidadNoticias;

        $noticias = Noticia::BuscarNoticias($busqueda, $cantidad);

        return new NoticiaCollection($noticias);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Noticia $noticia)
    {
        return new NoticiaResource($noticia);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Noticia $noticia)
    {
        $noticia->titulo = $request->titulo;
        //$noticia->fecha = $request->noticia->fecha;
        $noticia->descripcion = $request->descripcion;

        $noticia->save();

        NoticiasTipo::where('noticia_id', $noticia->id)->delete();
        foreach($request->noticiaTipo as $tipo){
            $noticiaTipo = [
                "tipo_usuario_id" => $tipo,
                "noticia_id" => $noticia->id
            ];

            NoticiasTipo::create($noticiaTipo);
        }

        //dd($request->noticiaTipo);

        return response()->json([
            "mensaje" => "cambios guardados"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Noticia $noticia)
    {
        //
    }
}
