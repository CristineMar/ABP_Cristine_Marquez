<?php

namespace App\Http\Controllers;

use App\Models\Cicles;
use App\Clases\Utilitat;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class CiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
/*         $actiu = $request->input('actiu');

        if ($actiu == 'actiu') {
            $cicles = Cicles::where('actiu', '=', true)
                ->orderBy('nom', 'asc')
                ->paginate(6)
                ->withQueryString();
        } else {
            $cicles = Cicles::paginate(6);
        }

        $request->session()->flashInput($request->input()); */

        return view('cicles.index_vue');
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


        return view('cicles.cicle', compact('cicles', 'insert'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cicles = new Cicles();

        $cicles->sigles = $request->input('sigles');
        $cicles->nom = $request->input('nom');
        $cicles->descripcio = $request->input('descripcio');
        $cicles->actiu = ($request->input('actiu') == 'actiu');

        try {
            $cicles->save();
            $response = redirect()->action([CiclesController::class, 'index']);
        } catch (QueryException $ex) {
            $mensaje = Utilitat::errorMessage($ex);
            $request->session()->flash("error", $mensaje);
            $response = redirect()->action([CiclesController::class, 'create'])->withInput();
        }

        return $response;
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Cicles  $cicles
     * @return \Illuminate\Http\Response
     */
    public function show(Cicles $cicles)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Cicles  $cicles
     * @return \Illuminate\Http\Response
     */
    public function edit(Cicles $cicles)
    {
        $cicles = Cicles::where('actiu', '=', true)
            ->orderBy('nom', 'asc')
            ->get();

        $cicle = Cicles::where('id', '=', $cicles)
            ->get();

        $insert = false;

        return view('cicles.cicle', compact('cicles', 'cicle', 'insert'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Cicles  $cicles
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cicles $cicles)
    {
        $cicles->sigles = $request->input('sigles');
        $cicles->nom = $request->input('nom');
        $cicles->descripcio = $request->input('descripcio');
        $cicles->actiu = ($request->input('actiu') == 'actiu');

        try {
            $cicles->save();
            $response = redirect()->action([CiclesController::class, 'index']);
        } catch (QueryException $ex) {
            $mensaje = Utilitat::errorMessage($ex);
            $request->session()->flash("error", $mensaje);
            $response = redirect()->action([CiclesController::class, 'edit'], ['curso' => $cicles])->withInput();
        }

        return $response;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Cicles  $cicles
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Cicles $cicles)
    {
        try {
/*             $cicles = Cicles::find($cicles); */
            $cicles->delete();
            $request->session()->flash("error", "Eliminat correctament");
        } catch (QueryException $ex) {
            $mensaje = Utilitat::errorMessage($ex);
            $request->session()->flash("error", $mensaje);
        }

        return redirect()->action([CiclesController::class, 'index']);
    }
}
