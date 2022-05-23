@extends('plantilla.index')

@section('title', 'Cicles')

@section('contents')
    @include('partials.mensajeError')

    <cicles-component></cicles-component>

{{--     <div class="card m-3">
        <div class="card-body">
            <h5 class="card-title">Buscar</h5>

            <form action="{{ action([App\Http\Controllers\CiclesController::class, 'index']) }}" method="POST">
                @csrf
                <div class="row g-3 align-items-center">
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
    </div> --}}




@endsection
