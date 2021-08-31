@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->

@endsection

@section('js_after')
    <!-- Page JS Plugins -->

    <!-- Page JS Code -->
    <script>
    $("#solicitud").change(function () {
        $("#ruta").html('<option value="">Seleccione...</option>');
        $("#solicitud option:selected").each(function () {
            solicitud=$(this).val();    
            $.post("{{ URL::to('administracion/cuentaContableDocumento/ruta') }}", { solicitud: solicitud, _token: '{{ csrf_token() }}' }, function(data){
                $.each(data.data, function(i,f) {
                    $("#ruta").append('<option value="' + f.id + '" >' + f.de_proceso + '</option>');
                });                                
            });
        });
    });

    @if( !empty( $data->id_tab_solicitud) )

        $("#ruta").html('<option value=""> Seleccione...</option>');
        $.post("{{ URL::to('administracion/cuentaContableDocumento/ruta') }}", { solicitud: {{  $data->id_tab_solicitud }}, _token: '{{ csrf_token() }}' }, function(data){
            var opcion;
            $.each(data.data, function(i,f) {
                if( f.id == {{ intval( $data->id_tab_proceso) }}){ opcion = 'selected="selected"';} else{ opcion = ''; }
                $("#ruta").append('<option value="' + f.id + '" '+opcion+'>' + f.de_proceso + '</option>');
            });
        });

    @endif

    </script>

@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('administracion/cuentaContableDocumento/guardar').'/'.$data->id }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('administracion/cuentaContableDocumento/lista') }}">
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
                            <label for="solicitud">Tipo de Solicitud</label>
                            <select class="custom-select {!! $errors->has('solicitud') ? 'is-invalid' : '' !!}" name="solicitud" id="solicitud" {{ $errors->has('solicitud') ? 'aria-describedby="solicitud-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_solicitud as $solicitud)
                                <option value="{{ $solicitud->id }}" {{ $solicitud->id == $data->id_tab_solicitud ? 'selected' : '' }}>{{ $solicitud->de_solicitud }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('solicitud') )
                                <div id="solicitud-error" class="invalid-feedback animated fadeIn">{{ $errors->first('solicitud') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="ruta">Ruta</label>
                            <select class="custom-select {!! $errors->has('ruta') ? 'is-invalid' : '' !!}" name="ruta" id="ruta" {{ $errors->has('ruta') ? 'aria-describedby="ruta-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                            </select>
                            @if( $errors->has('ruta') )
                                <div id="ruta-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ruta') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <input type="text" class="form-control {!! $errors->has('descripcion') ? 'is-invalid' : '' !!}" id="descripcion" name="descripcion" placeholder="Descripcion..." value="{{ empty(old('descripcion'))? $data->de_cc_documento : old('descripcion') }}" {{ $errors->has('descripcion') ? 'aria-describedby="descripcion-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('descripcion') )
                                <div id="descripcion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('descripcion') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="siglas">Siglas</label>
                            <input type="text" class="form-control {!! $errors->has('siglas') ? 'is-invalid' : '' !!}" id="siglas" name="siglas" placeholder="Siglas..." value="{{ empty(old('siglas'))? $data->de_sigla : old('siglas') }}" {{ $errors->has('siglas') ? 'aria-describedby="siglas-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('siglas') )
                                <div id="siglas-error" class="invalid-feedback animated fadeIn">{{ $errors->first('siglas') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="cuenta_gasto">Cuenta de Gasto</label>
                            <select class="custom-select {!! $errors->has('cuenta_gasto') ? 'is-invalid' : '' !!}" name="cuenta_gasto" id="cuenta_gasto" {{ $errors->has('cuenta_gasto') ? 'aria-describedby="cuenta_gasto-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_cuenta_contable as $cuenta_gasto)
                                <option value="{{ $cuenta_gasto->id }}" {{ $cuenta_gasto->id == $data->id_cc_gasto_pago ? 'selected' : '' }}>{{ $cuenta_gasto->co_cuenta_contable }} - {{ $cuenta_gasto->de_cuenta_contable }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('cuenta_gasto') )
                                <div id="cuenta_gasto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('cuenta_gasto') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="cuenta_orden_pago">Cuenta Orden de Pago</label>
                            <select class="custom-select {!! $errors->has('cuenta_orden_pago') ? 'is-invalid' : '' !!}" name="cuenta_orden_pago" id="cuenta_orden_pago" {{ $errors->has('cuenta_orden_pago') ? 'aria-describedby="cuenta_orden_pago-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_cuenta_contable as $cuenta_orden_pago)
                                <option value="{{ $cuenta_orden_pago->id }}" {{ $cuenta_orden_pago->id == $data->id_cc_odp ? 'selected' : '' }}>{{ $cuenta_orden_pago->co_cuenta_contable }} - {{ $cuenta_orden_pago->de_cuenta_contable }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('cuenta_orden_pago') )
                                <div id="cuenta_orden_pago-error" class="invalid-feedback animated fadeIn">{{ $errors->first('cuenta_orden_pago') }}</div>
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