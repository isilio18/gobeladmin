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
    <form action="{{ URL::to('administracion/cuentaBancaria/guardar') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('administracion/cuentaBancaria/lista') }}">
                    <i class="fa fa-arrow-left mr-1"></i> Volver
                </a>
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Cuenta Bancaria</li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                </ol>
            </nav>
        </div>                
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
                            <label for="tipo_cuenta">Tipo de Cuenta</label>
                            <select class="custom-select {!! $errors->has('tipo_cuenta') ? 'is-invalid' : '' !!}" name="tipo_cuenta" id="tipo_cuenta" {{ $errors->has('tipo_cuenta') ? 'aria-describedby="tipo_cuenta-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_tipo_cuenta_bancaria as $tipo_cuenta)
                                <option value="{{ $tipo_cuenta->id }}" {{ $tipo_cuenta->id == old('tipo_cuenta') ? 'selected' : '' }}>{{ $tipo_cuenta->de_tipo_cuenta_bancaria }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_cuenta') )
                                <div id="tipo_cuenta-error" class="invalid-feedback animated fadeIn">El Campo tipo de cuenta es obligatorio</div>
                            @endif
                           </div>    
                        
                            <div class="form-group">
                            <label for="banco">Banco</label>
                            <select class="custom-select {!! $errors->has('banco') ? 'is-invalid' : '' !!}" name="banco" id="banco" {{ $errors->has('banco') ? 'aria-describedby="banco-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_banco as $banco)
                                <option value="{{ $banco->id }}" {{ $banco->id == old('banco') ? 'selected' : '' }}>{{ $banco->de_banco }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('banco') )
                                <div id="banco-error" class="invalid-feedback animated fadeIn">El campo banco es obligatorio</div>
                            @endif
                           </div>      
                        
                        <div class="form-group">
                            <label for="numero_cuenta_bancaria">Numero de Cuenta</label>
                            <input type="text" class="form-control {!! $errors->has('numero_cuenta_bancaria') ? 'is-invalid' : '' !!}" id="numero_cuenta_bancaria" name="numero_cuenta_bancaria" placeholder="Nuemro de cuenta..." value="{{ old('numero_cuenta_bancaria') }}" {{ $errors->has('numero_cuenta_bancaria') ? 'aria-describedby="numero_cuenta_bancaria-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('numero_cuenta_bancaria') )
                                <div id="numero_cuenta_bancaria-error" class="invalid-feedback animated fadeIn">{{ $errors->first('numero_cuenta_bancaria') }}</div>
                            @endif
                        </div>                        

                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <input type="text" class="form-control {!! $errors->has('descripcion') ? 'is-invalid' : '' !!}" id="descripcion" name="descripcion" placeholder="Descripcion..." value="{{ old('descripcion') }}" {{ $errors->has('descripcion') ? 'aria-describedby="descripcion-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('descripcion') )
                                <div id="descripcion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('descripcion') }}</div>
                            @endif
                        </div>
                        
                        <div class="form-group">
                            <label for="numero_contrato">Numero de Contrato</label>
                            <input type="text" class="form-control {!! $errors->has('numero_contrato') ? 'is-invalid' : '' !!}" id="numero_contrato" name="numero_contrato" placeholder="Nuemro de contrato..." value="{{ old('numero_contrato') }}" {{ $errors->has('numero_contrato') ? 'aria-describedby="numero_contrato-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('numero_contrato') )
                                <div id="numero_contrato-error" class="invalid-feedback animated fadeIn">{{ $errors->first('numero_contrato') }}</div>
                            @endif
                        </div>     
                        
                        <div class="form-group">
                            <label>Opción de cuenta</label>
                            <div class="custom-control custom-checkbox custom-control-primary mb-1">
                                <input type="checkbox" class="custom-control-input" id="fondo_tercero" name="fondo_tercero" @if (old('fondo_tercero')) checked @endif >
                                <label class="custom-control-label" for="fondo_tercero">¿Fondos de Terceros?</label>
                            </div>
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