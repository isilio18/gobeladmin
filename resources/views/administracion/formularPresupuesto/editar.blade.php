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
    <form action="{{ URL::to('administracion/formularPresupuesto/guardar').'/'.$data->id }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('administracion/formularPresupuesto/lista') }}">
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
                            <label for="tipo_presupuesto">Tipo Presupuesto</label>
                            <select class="custom-select {!! $errors->has('tipo_presupuesto') ? 'is-invalid' : '' !!}" name="tipo_presupuesto" id="tipo_presupuesto" {{ $errors->has('tipo_presupuesto') ? 'aria-describedby="tipo_presupuesto-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_tipo_presupuesto as $tipo_presupuesto)
                                <option value="{{ $tipo_presupuesto->id }}" {{ $tipo_presupuesto->id == $data->id_tab_tipo_presupuesto ? 'selected' : '' }}>{{ $tipo_presupuesto->de_tipo_presupuesto }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_presupuesto') )
                                <div id="tipo_presupuesto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_presupuesto') }}</div>
                            @endif
                        </div>        
                        
                        <div class="form-group">
                            <label for="ejecutor">Ejecutor</label>
                            <select class="custom-select {!! $errors->has('ejecutor') ? 'is-invalid' : '' !!}" name="ejecutor" id="ejecutor" {{ $errors->has('ejecutor') ? 'aria-describedby="ejecutor-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_ejecutor as $ejecutor)
                                <option value="{{ $ejecutor->id }}" {{ $ejecutor->id == $data->id_tab_ejecutor ? 'selected' : '' }}>{{ $ejecutor->de_ejecutor }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('ejecutor') )
                                <div id="ejecutor-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ejecutor') }}</div>
                            @endif
                        </div> 
                        
                        <div class="form-group">
                            <label for="sector_presupuesto">Sector Presupuesto</label>
                            <select class="custom-select {!! $errors->has('sector_presupuesto') ? 'is-invalid' : '' !!}" name="sector_presupuesto" id="sector_presupuesto" {{ $errors->has('sector_presupuesto') ? 'aria-describedby="tipo_presupuesto-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_sector_presupuesto as $sector_presupuesto)
                                    <option value="{{ $sector_presupuesto->id }}" {{ $sector_presupuesto->id == $data->id_tab_sector_presupuesto ? 'selected' : '' }}>{{ $sector_presupuesto->nu_sector_presupuesto }}-{{ $sector_presupuesto->de_sector_presupuesto }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('sector_presupuesto') )
                                <div id="sector_presupuesto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('sector_presupuesto') }}</div>
                            @endif
                        </div>                         
                        <div class="form-group">
                            <label for="codigo">Codigo</label>
                            <input type="text" class="form-control {!! $errors->has('codigo') ? 'is-invalid' : '' !!}" id="codigo" name="codigo" placeholder="Codigo..." value="{{ empty(old('codigo'))? $data->nu_presupuesto : old('codigo') }}" {{ $errors->has('codigo') ? 'aria-describedby="codigo-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('codigo') )
                                <div id="codigo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('codigo') }}</div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <input type="text" class="form-control {!! $errors->has('descripcion') ? 'is-invalid' : '' !!}" id="descripcion" name="descripcion" placeholder="Descripcion..." value="{{ empty(old('descripcion'))? $data->de_presupuesto : old('descripcion') }}" {{ $errors->has('descripcion') ? 'aria-describedby="descripcion-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('descripcion') )
                                <div id="descripcion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('descripcion') }}</div>
                            @endif
                        </div>        
                        
                        <div class="form-group">
                            <label for="monto">Monto Presupuestado</label>
                            <input type="number" class="form-control {!! $errors->has('monto') ? 'is-invalid' : '' !!}" id="monto" name="monto" placeholder="Monto..." value="{{ empty(old('monto'))? $data->mo_presupuesto : old('monto') }}" {{ $errors->has('monto') ? 'aria-describedby="monto-error" aria-invalid="true"' : '' }}>
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