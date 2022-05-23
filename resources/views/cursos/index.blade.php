@extends('plantilla.index')

@section('title', 'Cursos')

@section('contents')
    <strong>Database Connected: </strong>
    <?php
    try {
        \DB::connection()->getPDO();
        echo \DB::connection()->getDatabaseName();
    } catch (\Exception $e) {
        echo 'None';
    }
    ?>
    @include('partials.mensajeError')

    <div class="card m-3">
        <div class="card-body">
            <h5 class="card-title">Buscar</h5>

            <form action="{{ action([App\Http\Controllers\CursosController::class, 'index']) }}">
                @csrf
                <div class="row g-3 align-items-center">
                    <div class="col-1">
                        <label for="cicle" class="col-form-label">Cicle</label>
                    </div>
                    <div class="col-9">
                        <select id="cicle" name="cicle" class="form-select" aria-label="Tots els cicles">
                            <option value="Tots els cicles">Tots els cicles</option>
                            @foreach ($cicles as $cicle)
                                <option value="{{ $cicle->id }}"
                                    {{ old('cicle') == $cicle->descripcio ? 'selected' : '' }}>
                                    {{ $cicle->descripcio }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-1">

                        <div class="form-check">
                            @if (old('actiu') == 'actiu')
                            <input type="checkbox" class="form-check-input" id="actiu" value="actiu" name="actiu" checked>
                        @else
                            <input type="checkbox" class="form-check-input" id="actiu" value="actiu" name="actiu">
                        @endif
                            <label class="form-check-label" for="actiu">Actiu</label>
                        </div>
                    </div>
                    <div class="col-1">
                        <button type="submit" class="btn btn-secondary float-right">
                            <i class="fas fa-search"></i>
                            Buscar
                        </button>
                    </div>
                </div>

            </form>
        </div>
    </div>

    <div class="card m-3">
        <div class="card-body">
            <h5 class="card-title">
                Cursos
            </h5>

            @if (count($cursos) == 0)

                <div class="alert alert-light text-center" role="alert">
                    No hi ha cap curs, per la cerca realitzada
                </div>
            @else
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Sigles</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Cicle</th>
                            <th scope="col">Actiu</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($cursos as $curso)
                            <tr class="table-active">
                                <td class="col-1">
                                    {{ $curso->sigles }}
                                </td>
                                <td class="col-auto">
                                    {{ $curso->nom }}
                                </td>
                                <td>{{ $curso->cicles->descripcio }}</td>
                                <td class="col-1">
                                    @if ($curso->actiu)
                                        <input class="form-check-input" type="checkbox" value="" id="actiu" value="actiu"
                                            checked disabled>
                                    @else
                                        <input class="form-check-input" type="checkbox" value="" id="actiu" value="actiu"
                                            disabled>
                                    @endif
                                </td>
                                <td class="col-auto ">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <form id=myForm action="{{ action([App\Http\Controllers\CursosController::class, 'edit'], ['curso' => $curso->id]) }}"
                                            method="get">
                                            @csrf
                                            <button class="btn btn-secondary btn-sm" type="submit">
                                                <i class="fas fa-edit"></i>
                                                Editar
                                            </button>
                                        </form>

                                        <button class="btn btn-danger ml-1 btn-sm" type="button" data-bs-toggle="modal"
                                            data-bs-target="#deleteModal" data-bs-siglas="{{ $curso->sigles }}"
                                            data-bs-action="{{ action([App\Http\Controllers\CursosController::class, "destroy"], ['curso' => $curso->id]) }}">
                                            <i class="fas fa-trash"></i>
                                            Esborrar
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
            {{ $cursos->links() }}
        </div>
    </div>
    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
        <a class="btn btn-primary me-md-2" href="{{ action([App\Http\Controllers\CursosController::class, 'create']) }}">
            <i class="fas fa-plus-circle"></i>
            Nou curs
        </a>
    </div>


    <!--Modal-->
    <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModal" aria-hidden="true">

        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Esborrar Curs</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="cicle_id" id="cicle_id" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">
                        <i class="fas fa-times"></i>
                        Tancar
                    </button>
                    <form id="myForm" name="myForm" action="" method="POST">
                        @csrf
                        @method('DELETE')
                        <button id="deleteBtn" type="submit" class="btn btn-danger btn-sm">
                            <i class="fas fa-trash"></i>
                            Esborrar
                        </button>
                    </form>
                </div>

            </div>
        </div>

    </div>



@endsection

@push('scripts')
  <!--load custom js modal -->
  <script type="text/javascript" src="{{asset('js\modal.js') }}"></script>
@endpush
