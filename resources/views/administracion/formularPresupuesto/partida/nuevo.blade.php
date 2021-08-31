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
    <form action="{{ URL::to('administracion/formularPresupuesto/partida/guardar') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_tab_formular_accion_especifica" value="{{ $id_tab_formular_accion_especifica }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('administracion/formularPresupuesto/partida/lista').'/'. $id_tab_formular_accion_especifica }}">
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
                            <label for="tipo_ingreso">Tipo Ingreso</label>
                            <select class="custom-select {!! $errors->has('tipo_ingreso') ? 'is-invalid' : '' !!}" name="tipo_ingreso" id="tipo_ingreso" {{ $errors->has('tipo_ingreso') ? 'aria-describedby="tipo_ingreso-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_tipo_ingreso as $tipo_ingreso)
                                <option value="{{ $tipo_ingreso->id }}" {{ $tipo_ingreso->id == old('tipo_ingreso') ? 'selected' : '' }}>{{ $tipo_ingreso->nu_tipo_ingreso }}-{{ $tipo_ingreso->de_tipo_ingreso }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_ingreso') )
                                <div id="tipo_ingreso-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_ingreso') }}</div>
                            @endif
                        </div>        
                        
                        <div class="form-group">
                            <label for="ambito">Ambito</label>
                            <select class="custom-select {!! $errors->has('ambito') ? 'is-invalid' : '' !!}" name="ambito" id="ambito" {{ $errors->has('ambito') ? 'aria-describedby="ambito-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_ambito as $ambito)
                                <option value="{{ $ambito->id }}" {{ $ambito->id == old('ambito') ? 'selected' : '' }}>{{ $ambito->nu_ambito }}-{{ $ambito->de_ambito }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('ambito') )
                                <div id="ambito-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ambito') }}</div>
                            @endif
                        </div>                         
                        
                        <div class="form-group">
                            <label for="aplicacion">Aplicacion</label>
                            <select class="custom-select {!! $errors->has('aplicacion') ? 'is-invalid' : '' !!}" name="aplicacion" id="aplicacion" {{ $errors->has('aplicacion') ? 'aria-describedby="aplicacion-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_aplicacion as $aplicacion)
                                    <option value="{{ $aplicacion->id }}" {{ $aplicacion->id == old('aplicacion') ? 'selected' : '' }}>{{ $aplicacion->nu_aplicacion }}-{{ $aplicacion->de_aplicacion }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('aplicacion') )
                                <div id="aplicacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('aplicacion') }}</div>
                            @endif
                        </div>    
                        
                        <div class="form-group">
                            <label for="clasificacion_economica">Clasificación Economica</label>
                            <select class="custom-select {!! $errors->has('clasificacion_economica') ? 'is-invalid' : '' !!}" name="clasificacion_economica" id="clasificacion_economica" {{ $errors->has('clasificacion_economica') ? 'aria-describedby="clasificacion_economica-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_clasificacion_economica as $clasificacion_economica)
                                    <option value="{{ $clasificacion_economica->id }}" {{ $clasificacion_economica->id == old('clasificacion_economica') ? 'selected' : '' }}>{{ $clasificacion_economica->tx_sigla }}-{{ $clasificacion_economica->de_clasificacion_economica }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('clasificacion_economica') )
                                <div id="clasificacion_economica-error" class="invalid-feedback animated fadeIn">{{ $errors->first('clasificacion_economica') }}</div>
                            @endif
                        </div>   
                        
                        <div class="form-group">
                            <label for="area_estrategica">Area Estrategica</label>
                            <select class="custom-select {!! $errors->has('area_estrategica') ? 'is-invalid' : '' !!}" name="area_estrategica" id="area_estrategica" {{ $errors->has('area_estrategica') ? 'aria-describedby="area_estrategica-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_area_estrategica as $area_estrategica)
                                    <option value="{{ $area_estrategica->id }}" {{ $area_estrategica->id == old('area_estrategica') ? 'selected' : '' }}>{{ $area_estrategica->tx_sigla }}-{{ $area_estrategica->de_area_estrategica }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('area_estrategica') )
                                <div id="area_estrategica-error" class="invalid-feedback animated fadeIn">{{ $errors->first('area_estrategica') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="tipo_gasto">Tipo Gasto</label>
                            <select class="custom-select {!! $errors->has('tipo_gasto') ? 'is-invalid' : '' !!}" name="tipo_gasto" id="tipo_gasto" {{ $errors->has('tipo_gasto') ? 'aria-describedby="tipo_gasto-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_tipo_gasto as $tipo_gasto)
                                    <option value="{{ $tipo_gasto->id }}" {{ $tipo_gasto->id == old('tipo_gasto') ? 'selected' : '' }}>{{ $tipo_gasto->tx_sigla }}-{{ $tipo_gasto->de_tipo_gasto }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_gasto') )
                                <div id="tipo_gasto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_gasto') }}</div>
                            @endif
                        </div>                        
                        
                        <div class="form-group">
                            <label for="partida">Partida</label>
                            <select class="custom-select {!! $errors->has('partida') ? 'is-invalid' : '' !!}" name="partida" id="partida" {{ $errors->has('partida') ? 'aria-describedby="partida-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_catalogo_partida as $partida)
                                    <option value="{{ $partida->id }}" {{ $partida->id == old('partida') ? 'selected' : '' }}>{{ $partida->co_partida }}-{{ $partida->de_partida }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('partida') )
                                <div id="partida-error" class="invalid-feedback animated fadeIn">{{ $errors->first('partida') }}</div>
                            @endif
                        </div>                                     
                        
                        <div class="form-group">
                            <label for="monto">Monto</label>
                            <input type="text" class="form-control {!! $errors->has('monto') ? 'is-invalid' : '' !!}" id="monto" name="monto" placeholder="Monto..." value="{{ old('monto') }}" {{ $errors->has('monto') ? 'aria-describedby="monto-error" aria-invalid="true"' : '' }}>
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