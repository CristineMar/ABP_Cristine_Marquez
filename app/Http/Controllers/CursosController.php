<?php

namespace App\Http\Controllers;

use App\Models\Cicles;
use App\Models\Cursos;
use App\Clases\Utilitat;
use Illuminate\Http\Request;
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

        return view('cursos.index', compact('cursos', 'cicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cicles = Cicles::where('actiu', '=', true)
            ->orderBy('nom', 'asc')
            ->get();

        $insert = true;


        return view('cursos.curs', compact('cicles', 'insert'));
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
            $response = redirect()->action([CursosController::class, 'index']);
        } catch (QueryException $ex) {
            $mensaje = Utilitat::errorMessage($ex);
            $request->session()->flash("error", $mensaje);
            $response = redirect()->action([CursosController::class, 'create'])->withInput();
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cursos  $cursos
     * @return \Illuminate\Http\Response
     */
    public function show(Cursos $cursos)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cursos  $cursos
     * @return \Illuminate\Http\Response
     */
    public function edit(Cursos $curso)
    {
        //Cridar a la vista curs que està dintre de la carpeta cursos.
        //Enviarem el cicles actius de la base de dades ordenats per nom,
        //el curs que volem modificar i un booleà a false per indicar que estem fent un insert.

        $cicles = Cicles::where('actiu', '=', true)
            ->orderBy('nom', 'asc')
            ->get();

        $cursos = Cicles::where('id', '=', $curso)
            ->get();

        $insert = false;

        return view('cursos.curs', compact('cicles', 'curso', 'insert'));
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
            $response = redirect()->action([CursosController::class, 'index']);
        } catch (QueryException $ex) {
            $mensaje = Utilitat::errorMessage($ex);
            $request->session()->flash("error", $mensaje);
            $response = redirect()->action([CursosController::class, 'edit'], ['curso' => $curso])->withInput();
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cursos  $cursos
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cursos $curso)
    {
        try {
            $curso->delete();
            $request->session()->flash("error", "Eliminat correctament");
        } catch (QueryException $ex) {
            $mensaje = Utilitat::errorMessage($ex);
            $request->session()->flash("error", $mensaje);
        }

        return redirect()->action([CursosController::class, 'index']);
    }
}
