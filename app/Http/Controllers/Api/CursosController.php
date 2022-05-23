<?php

namespace App\Http\Controllers\Api;

use App\Models\Cicles;
use App\Models\Cursos;
use App\Clases\Utilitat;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\CursosResource;
use Illuminate\Database\QueryException;

class CursosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $actiu = $request->input('actiu');
        $cicle = $request->input('cicle');

        $cicles = Cicles::all();

        if ($actiu == 'actiu') {
            if (($cicle != '' || $cicle != null) && $cicle != 'Tots els cicles') {
                $cursos = Cursos::where('actiu', '=', true)
                ->where('cicles_id', '=', $cicle)
                    ->orderBy('nom', 'asc')
                    ->paginate(6)
                    ->withQueryString();
            } elseif ($cicle == 'Tots els cicles') {
                $cursos = Cursos::where('actiu', '=', true)
                /* ->where('cicles_id', '=', $cicle) */
                ->orderBy('nom', 'asc')
                ->paginate(6)
                    ->withQueryString();
            }
        } else {
            if (($cicle != '' || $cicle != null) && $cicle != 'Tots els cicles') {
                $cursos = Cursos::where('actiu', '=', false)
                ->where('cicles_id', '=', $cicle)
                    ->orderBy('nom', 'asc')
                    ->paginate(6)
                    ->withQueryString();
            } elseif ($cicle == 'Tots els cicles') {
                $cursos = Cursos::where('actiu', '=', false)
                ->orderBy('nom', 'asc')
                ->paginate(6)
                    ->withQueryString();
            } else {
                $cursos = Cursos::orderBy('nom', 'asc')
                ->paginate(6)
                    ->withQueryString();
            }
        }
        $request->session()->flashInput($request->input());

        /* return view('cursos.index', compact('cursos', 'cicles')); */
        return CursosResource::collection($cursos);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cursos = new Cursos();

        $cursos->sigles = $request->input('sigles');
        $cursos->nom = $request->input('nom');
        $cursos->cicles_id = $request->input('descripcio');
        $cursos->actiu = ($request->input('actiu') == 'actiu');

        try {
            $cursos->save();
            $response = (new CursosController($cursos))
                ->response()
                ->setStatusCode(201);
        } catch (QueryException $ex) {
            $mensaje = Utilitat::errorMessage($ex);
            $response = \response()
                ->json(["error" => $mensaje], 400);
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cursos  $cursos
     * @return \Illuminate\Http\Response
     */
    public function show(Cursos $curso)
    {
        $curso = Cursos::with('cursos')->find($curso->id);
        return new CursosController($curso);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cursos  $cursos
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cursos $curso)
    {
        $curso->sigles = $request->input('sigles');
        $curso->nom = $request->input('nom');
        $curso->cicles_id = $request->input('descripcio');
        $curso->actiu = ($request->input('actiu') == 'actiu');

        try {
            $curso->save();
            $response = (new CursosController($curso))
                ->response()
                ->setStatusCode(201);
        } catch (QueryException $ex) {
            $mensaje = Utilitat::errorMessage($ex);
            $response = \response()
                ->json(["error" => $mensaje], 400);
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cursos  $cursos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Cursos $curso)
    {
        try {
            $curso->delete();
            $response = \response()->json(['mensaje', 'Eliminat correctament'], 200);
        } catch (QueryException $ex) {
            $mensaje = Utilitat::errorMessage($ex);
            $response = \response()
                ->json(["error" => $mensaje], 400);
        }

        return $response;
    }
}
