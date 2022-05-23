@extends('plantilla.index')

@section('title', 'Curs')

@section('contents')

    @include('partials.mensajeError')

    <div class="card m-3">
        <div class="card-body">
            <h5 class="card-title">Curs</h5>

            @if ($insert == true)
                <form action="{{ action([App\Http\Controllers\CursosController::class, 'store']) }}" method="POST">
                @else
                    <form
                        action="{{ action([App\Http\Controllers\CursosController::class, 'update'], ['curso' => $curso->id]) }}"
                        method="POST">
                        @method('PUT')
            @endif
            @csrf
            <div class="row g-3 align-items-center mb-2">
                <div class="col-1">
                    <label for="sigles" class="col-form-label">Sigles</label>
                </div>
                <div class="col-10">
                    <input type="text" id="sigles" class="form-control" name="sigles"
                        value="{{ $insert == true ? old('sigles') : $curso->sigles }}">
                </div>
            </div>
            <div class="row g-3 align-items-center mb-2">
                <div class="col-1">
                    <label for="nom" class="col-form-label">Nom</label>
                </div>
                <div class="col-10">
                    <input type="text" id="nom" class="form-control" name="nom"
                        value="{{ $insert == true ? old('nom') : $curso->sigles }}">
                </div>
            </div>
            <div class="row g-3 align-items-center mb-2">
                <div class="col-1">
                    <label for="cicle" class="col-form-label">Cicles</label>
                </div>
                <div class="col-10">
                    <select id="descripcio" class="form-select" aria-label="Tots els crusos" name="descripcio">

                        @if ($insert == true)
                            @foreach ($cicles as $cicle)
                                <option value="{{ $cicle->id }}"
                                    {{ old('descripcio') == $cicle->descripcio ? 'selected' : '' }}>
                                    {{ $cicle->descripcio }}
                                </option>
                            @endforeach
                        @else
                            <option value="{{ $curso->descripcio }}" selected>{{ $curso->descripcio }}
                            </option>
                            @foreach ($cicles as $cicle)
                                <option value="{{ $cicle->id}}"
                                    {{ old('descripcio') == $curso->descripcio ? 'selected' : '' }}>
                                    {{ $cicle->descripcio }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
            </div>
            <div class="row g-3 align-items-center mb-2">
                <div class="col-1">
                    <label class="form-check-label" for="actiu">Actiu</label>
                </div>
                <div class="col-auto">
                    @if ($insert == true ? old('actiu') == 'actiu' : $curso->actiu == 1)
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
                <a class="btn btn-danger" type="button" href="{{ url('/cursos') }}">
                    <i class="fas fa-times"></i>
                    Cancelar
                </a>
            </div>
            </form>
        </div>
    </div>

@endsection
