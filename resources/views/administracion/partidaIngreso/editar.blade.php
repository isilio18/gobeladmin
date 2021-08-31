@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->

@endsection

@section('js_after')
    <!-- Page JS Plugins -->

    <!-- Page JS Code -->

@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
        <form action="{{ URL::to('administracion/partidaIngreso/guardar').'/'.$data->id }}" method="POST">    
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('administracion/partidaIngreso/lista') }}">
                    <i class="fa fa-arrow-left mr-1"></i> Volver
                </a>
                {{--<div class="block-options">
                    <div class="custom-control custom-switch custom-control-success">
                        <input type="checkbox" class="custom-control-input" id="dm-post-edit-active" name="dm-post-edit-active" checked>
                        <label class="custom-control-label" for="dm-post-edit-active">Set post as active</label>
                    </div>
                </div>--}}
            </div>
            <div class="block-content">
                <div class="row justify-content-center push">
                    <div class="col-md-10">

                        {{--
                        @if (count($errors) > 0)
                            <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                                <div class="flex-fill mr-3">
                                    <p class="mb-0">Hay problemas con su validacion!</p>
                                </div>
                                <div class="flex-00-auto">
                                    <i class="fa fa-fw fa-times-circle"></i>
                                </div>
                            </div>
                        @endif
                        --}}
                        @if( $errors->has('da_alert_form') )
                        <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                            <div class="flex-fill mr-3">
                                <p class="mb-0">{{ $errors->first('da_alert_form') }}</p>
                            </div>
                        </div>
                        @endif

                        <div class="form-group">
                            <label for="aplicacion">Aplicacion</label>
                            <select class="custom-select {!! $errors->has('aplicacion') ? 'is-invalid' : '' !!}" name="aplicacion" id="aplicacion" {{ $errors->has('aplicacion') ? 'aria-describedby="aplicacion-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_aplicacion as $aplicacion)
                                    <option value="{{ $aplicacion->id }}" {{ $aplicacion->id == $data->id_tab_aplicacion ? 'selected' : '' }}>{{ $aplicacion->nu_aplicacion }}-{{ $aplicacion->de_aplicacion }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('aplicacion') )
                                <div id="aplicacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('aplicacion') }}</div>
                            @endif
                        </div>        
                        
                        <div class="form-group">
                            <label for="partida">Partida</label>
                            <select class="custom-select {!! $errors->has('partida') ? 'is-invalid' : '' !!}" name="partida" id="partida" {{ $errors->has('partida') ? 'aria-describedby="partida-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_catalogo_partida as $partida)
                                    <option value="{{ $partida->id }}" {{ $partida->id == $data->id_tab_catalogo_partida ? 'selected' : '' }}>{{ $partida->co_partida }}-{{ $partida->de_partida }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('partida') )
                                <div id="partida-error" class="invalid-feedback animated fadeIn">{{ $errors->first('partida') }}</div>
                            @endif
                        </div>                                     
                        
                        <div class="form-group">
                            <label for="monto">Monto Inicial</label>
                            <input type="text" class="form-control {!! $errors->has('monto') ? 'is-invalid' : '' !!}" id="monto" name="monto" placeholder="Monto..." value="{{ empty(old('monto'))? $data->mo_inicial : old('monto') }}" {{ $errors->has('monto') ? 'aria-describedby="monto-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('monto') )
                                <div id="monto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto') }}</div>
                            @endif
                        </div>                           
                        
                    </div>
                </div>
            </div>
        </div>
        <div class="block-content bg-body-light">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                    <button type="submit" class="btn btn-alt-primary">
                        <i class="fa fa-fw fa-save mr-1"></i> Guardar
                    </button>
                </div>
            </div>
        </div>
    </form>
    </div>
    <!-- END New Post -->
</div>
<!-- END Page Content -->

@endsection