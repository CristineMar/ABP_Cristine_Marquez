@extends('plantilla.index')

@section('title', 'Cicles')

@section('contents')

    @include('partials.mensajeError')

    <div class="card m-3">
        <div class="card-body">
            <h5 class="card-title">Cicles</h5>
            <form action="{{ action([App\Http\Controllers\CiclesController::class, 'store']) }}" method="POST">
                @csrf
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-1">
                        <label for="sigles" class="col-form-label">Sigles</label>
                    </div>
                    <div class="col-10">
                        <input type="text" id="sigles" class="form-control" name="sigles"
                            value="{{ old('sigles') == $cicle->sigles ? old('sigles') : $cicle->sigles }}">
                    </div>
                </div>
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-1">
                        <label for="nom" class="col-form-label">Nom</label>
                    </div>
                    <div class="col-10">
                        <input type="text" id="nom" class="form-control" name="nom"
                            value="{{ old('nom') == $cicle->nom ? old('nom') : $cicle->nom }}">
                    </div>
                </div>
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-1">
                        <label for="descripcio" class="col-form-label">Descripcio</label>
                    </div>
                    <div class="col-10">
                        <input type="text" id="descripcio" class="form-control" name="descripcio"
                            value="{{ old('descripcio') == $cicle->descripcio ? old('descripcio') : $cicle->descripcio }}">
                    </div>
                </div>
                <div class="row g-3 align-items-center mb-2">
                    <div class="col-1">
                        <label class="form-check-label" for="actiu">Actiu</label>
                    </div>
                    <div class="col-auto">
                        @if (old('actiu') == 'actiu')
                            <input type="checkbox" class="form-check-input" id="actiu" value="actiu" name="actiu" checked>
                        @else
                            <input type="checkbox" class="form-check-input" id="actiu" value="actiu" name="actiu">
                        @endif

                    </div>
                </div>

                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                    <button class="btn btn-success me-md-2" type="submit">
                        <i class="fas fa-check"></i>
                        Aceptar</button>
                    <button class="btn btn-danger" type="cancel">
                        <i class="fas fa-times"></i>
                        Cancelar
                    </button>
                </div>
            </form>
        </div>
    </div>

@endsection
