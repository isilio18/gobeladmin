@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->
    {{--<link rel="stylesheet" id="css-main" href="{{ asset('css/bootstrap-select.min.css') }}">--}}
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
    {{--<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>--}}
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    {{--<script src="{{ asset('assets/js/plugins/flatpickr/l10n/es.js') }}"></script>--}}
    
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
    <!-- Page JS Code -->

    <script>
        $('#borrar').on('show.bs.modal', function (event) {
            $("#borrarForm").attr('action','{{ url('/solicitud/compra/partida/detalle/'.$id.'/borrar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
        });

        $('#agregarPartida').on('show.bs.modal', function (event) {
            $("#agregarPartidaForm").attr('action','{{ url('/solicitud/compra/partida/detalle/guardar') }}');
            var button = $(event.relatedTarget);
            var compra_detalle_id = button.data('compra_detalle_id');
            var catalogo_id = button.data('catalogo_id');
            var monto_contrato = button.data('monto_contrato');
            var producto_id = button.data('producto_id');
            //var proveedor_id = button.data('proveedor_id');
            var ejecutor = $.trim($("#ejecutor").children("option:selected").text());
            var id_tab_ejecutor = $("#ejecutor").val();
            var id_fuente_financiamiento = $("#fuente_financiamiento").val();
            var modal = $(this);
            @if( !empty( old('compra_detalle')) ) 
            var compra_detalle_id = {{ intval( old('compra_detalle')) }} 
            @endif
            modal.find('.modal-content #compra_detalle').val(compra_detalle_id);
            modal.find('.modal-content #ente_ejecutor').val(ejecutor);
            modal.find('.modal-content #ejecutor').val(id_tab_ejecutor);
            modal.find('.modal-content #partida_general').val(catalogo_id);
            modal.find('.modal-content #monto_contrato').val(monto_contrato);
            modal.find('.modal-content #fuente_financiamiento').val(id_fuente_financiamiento);
            modal.find('.modal-content #producto').val(producto_id);
            //modal.find('.modal-content #proveedor').val(proveedor_id);

            $("#partida_general").html('<option value="">Seleccione...</option>');
            $.get("{{ URL::to('solicitud/compra/partida/catalogo') }}", function(data){
                var opcion;
                $.each(data.data, function(i,f) {
                    if( f.id == catalogo_id){ opcion = 'selected="selected"';} else{ opcion = ''; }
                    @if( !empty( old('partida_general')) )
                    if( f.id == {{ intval( old('partida_general')) }}){ opcion = 'selected="selected"';} else{ opcion = ''; }
                    @endif
                    $("#partida_general").append('<option value="' + f.id + '" '+opcion+'>' + f.co_partida + ' - '+ f.de_partida + '</option>');
                });
            });

            $("#proyecto_ac").html('<option value="">Seleccione...</option>');
            $.post("{{ URL::to('solicitud/compra/partida/proyac') }}", { ejecutor: id_tab_ejecutor, _token: '{{ csrf_token() }}' }, function(data){
                var opcion;
                $.each(data.data, function(i,f) {
                    if( f.id == {{ intval( old('proyecto_ac')) }}){ opcion = 'selected="selected"';} else{ opcion = ''; }
                    $("#proyecto_ac").append('<option value="' + f.id + '" '+opcion+'>' + f.nu_presupuesto + ' - '+ f.de_presupuesto + '</option>');
                });
            });

            $("#accion_especifica").html('<option value="">Seleccione...</option>');
            $("#proyecto_ac").change(function () {
         
                $("#proyecto_ac option:selected").each(function () {
                    proyecto_ac=$(this).val();    
                    $.post("{{ URL::to('solicitud/compra/partida/proyacae') }}", { proyecto_ac: proyecto_ac, _token: '{{ csrf_token() }}' }, function(data){
                    $("#accion_especifica").html('<option value="0"> Seleccione Uno...</option>');
                        $.each(data.data, function(i,f) {
                            $("#accion_especifica").append('<option value="' + f.id + '">' + f.nu_accion_especifica+ ' - ' + f.de_accion_especifica+'</option>');
                        });                                
                    });
                });
            });

            @if( !empty( old('proyecto_ac')) )

                $("#accion_especifica").html('<option value="0"> Seleccione Uno...</option>');
                $.post("{{ URL::to('solicitud/compra/partida/proyacae') }}", { proyecto_ac: {{  old('proyecto_ac') }}, _token: '{{ csrf_token() }}' }, function(data){
                    var opcion;
                    $.each(data.data, function(i,f) {
                        if( f.id == {{ intval( old('accion_especifica')) }}){ opcion = 'selected="selected"';} else{ opcion = ''; }
                        $("#accion_especifica").append('<option value="' + f.id + '" '+opcion+'>' + f.nu_accion_especifica+ ' - ' + f.de_accion_especifica+'</option>');
                    });
                });

            @endif

            $("#partida").html('<option value="">Seleccione...</option>');
            $("#accion_especifica").change(function () {
         
                $("#accion_especifica option:selected").each(function () {
                    accion_especifica=$(this).val();    
                    $.post("{{ URL::to('solicitud/compra/partida/vigente') }}", { accion_especifica: accion_especifica, _token: '{{ csrf_token() }}' }, function(data){
                    $("#partida").html('<option value="0"> Seleccione Uno...</option>');
                        $.each(data.data, function(i,f) {
                            $("#partida").append('<option value="' + f.id + '" data-mo_disponible="' + f.mo_disponible+ '" >' + f.nu_partida+ ' - ' + f.de_partida+'</option>');
                        });                                
                    });
                });
            });

            $("#partida").change(function (e) {
            var mo_pago = null;
			$("select[name='partida'] option:selected").each(function() {
                mo_disponible = parseFloat($(this).attr('data-mo_disponible'));
            });
            if(isNaN(mo_disponible)){
                mo_disponible = 0;
            }
            $("#monto_disponible").val(mo_disponible.toFixed(2));
        });

        });

        jQuery(function(){ Dashmix.helpers([ 'flatpickr', 'select2']); });

    </script>

    @if (count($errors) > 0)
        @if (session()->has('msg_alerta'))
        <script>
            jQuery('#agregarPartida').modal('show');
        </script>
        @endif
    @endif
@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('solicitud/compra/partida/guardar') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="solicitud" value="{{ $id }}">
        <input type="hidden" name="ruta" value="{{ $ruta }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('proceso/ruta/lista').'/'.$id }}">
                    <i class="fa fa-arrow-left mr-1"></i> Volver
                </a>
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

                        <h2 class="content-heading pt-0">Asignar Presupuesto</h2>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Datos del Proveedor</h3><div id="resultado"></div>
                                </div>
                                <div class="block-content">

                                    <input type="hidden" name="proveedor" value="{{ $data->id_tab_proveedor }}">

                                    <div class="form-group form-row">
                                        <div class="col-2">
                                            <label for="tipo_documento">Tipo</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control {!! $errors->has('tipo_documento') ? 'is-invalid' : '' !!}" readonly id="tipo_documento" name="tipo_documento" placeholder="Tipo..." value="{{ $data->de_inicial }}" {{ $errors->has('tipo_documento') ? 'aria-describedby="tipo_documento-error" aria-invalid="true"' : '' }}>
                                                @if( $errors->has('tipo_documento') )
                                                    <div id="tipo_documento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_documento') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-4">
                                            <label for="documento">Documento</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control {!! $errors->has('documento') ? 'is-invalid' : '' !!}" readonly id="documento" name="documento" placeholder="Documento..." value="{{ $data->nu_documento }}" {{ $errors->has('documento') ? 'aria-describedby="documento-error" aria-invalid="true"' : '' }}>
                                                @if( $errors->has('documento') )
                                                    <div id="documento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('documento') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="razon_social">Razon Social</label>
                                        <input type="text" class="form-control {!! $errors->has('razon_social') ? 'is-invalid' : '' !!}" readonly id="razon_social" name="razon_social" placeholder="Razon Social..." value="{{ $data->de_proveedor }}" {{ $errors->has('razon_social') ? 'aria-describedby="razon_social-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('razon_social') )
                                            <div id="razon_social-error" class="invalid-feedback animated fadeIn">{{ $errors->first('razon_social') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="direccion">Direccion</label>
                                        <input type="text" class="form-control {!! $errors->has('direccion') ? 'is-invalid' : '' !!}" readonly id="direccion" name="direccion" placeholder="Direccion..." value="{{ $data->tx_direccion }}" {{ $errors->has('direccion') ? 'aria-describedby="direccion-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('direccion') )
                                            <div id="direccion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('direccion') }}</div>
                                        @endif
                                    </div>

                                </div>

                            </div>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Datos del Contrato</h3>
                                </div>
                                <div class="block-content">

                                    <div class="form-group">
                                        <label for="monto">Monto Previsto</label>
                                        <input type="text" class="form-control {!! $errors->has('monto') ? 'is-invalid' : '' !!}" readonly id="monto" name="monto" placeholder="Monto Previsto..." value="{{ $data->mo_contrato }}" {{ $errors->has('monto') ? 'aria-describedby="monto-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('monto') )
                                            <div id="monto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto') }}</div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Datos del Ente Ejecutor / Fuente Financiamiento</h3>
                                </div>
                                <div class="block-content">

                                    <div class="form-group">
                                        <label for="ejecutor">Ente Ejecutor</label>
                                        <select class="custom-select {!! $errors->has('ejecutor') ? 'is-invalid' : '' !!}" name="ejecutor" id="ejecutor" {{ $errors->has('ejecutor') ? 'aria-describedby="ejecutor-error" aria-invalid="true"' : '' }}>
                                            <option value="" >Seleccione...</option>
                                            @foreach($tab_ejecutor as $ejecutor)
                                                <option value="{{ $ejecutor->id }}" {{ $ejecutor->id == $data->id_tab_ejecutor ? 'selected' : '' }}>{{ $ejecutor->nu_ejecutor }} - {{ $ejecutor->de_ejecutor }}</option>
                                            @endforeach
                                        </select>
                                        @if( $errors->has('ejecutor') )
                                            <div id="ejecutor-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ejecutor') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="fuente_financiamiento">Fuente de Financiamiento</label>
                                        <select class="custom-select {!! $errors->has('fuente_financiamiento') ? 'is-invalid' : '' !!}" name="fuente_financiamiento" id="fuente_financiamiento" {{ $errors->has('fuente_financiamiento') ? 'aria-describedby="fuente_financiamiento-error" aria-invalid="true"' : '' }}>
                                            <option value="" >Seleccione...</option>
                                            @foreach($tab_fuente_financiamiento as $fuente_financiamiento)
                                                <option value="{{ $fuente_financiamiento->id }}" {{ $fuente_financiamiento->id == $data->id_tab_fuente_financiamiento ? 'selected' : '' }}>{{ $fuente_financiamiento->de_fuente_financiamiento }}</option>
                                            @endforeach
                                        </select>
                                        @if( $errors->has('fuente_financiamiento') )
                                            <div id="fuente_financiamiento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fuente_financiamiento') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <table class="table table-bordered table-striped table-vcenter">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Descripcion</th>
                                                    <th>Cod. Partida</th>
                                                    <th>Partida</th>
                                                    <th class="font-w600 text-center">Monto</th>
                                                    <th class="font-w600 text-center">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tab_compra_detalle as $key => $value)
                                                <tr>
                                                    <td class="d-none d-sm-table-cell">{{ $value->nu_producto }} - {{ $value->de_producto }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->co_partida }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->de_partida }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->mo_precio_total }}</td>
                                                    <td class="d-none d-sm-table-cell">
                                                        <div class="btn-group btn-group-sm pr-2">
                                                        @if( empty( $value->id_tab_asignar_partida_detalle) )
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" title="Presione para Agregar Partida" data-target="#agregarPartida" data-compra_detalle_id="{{ $value->id }}" data-catalogo_id="{{ $value->id_tab_catalogo_partida }}" data-monto_contrato="{{ $data->mo_contrato }}" data-proveedor_id="{{ $data->id_tab_proveedor }}" data-producto_id="{{ $value->id_tab_producto }}">
                                                                <i class="fa fa-fw fa-folder-plus"></i> Agregar Partida
                                                            </button>
                                                        @else
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" title="Presione para Quitar Partida" data-target="#borrar" data-item_id="{{ $value->id_tab_asignar_partida_detalle }}" @if( empty( $value->id_tab_asignar_partida_detalle) ) disabled @endif >
                                                                <i class="fa fa-fw fa-folder-minus"></i> Quitar Partida
                                                            </button>
                                                        @endif
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

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

<!-- Pop In Block Modal -->
<div class="modal fade" id="agregarPartida" tabindex="-1" role="dialog" aria-labelledby="agregarPartida" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

        <form action="{{ URL::to('solicitud/compra/contrato/detalle/guardar') }}" method="POST" id="agregarPartidaForm">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="solicitud" value="{{ $id }}">
            <input type="hidden" name="ruta" value="{{ $ruta }}">
            <input type="hidden" name="compra_detalle" id="compra_detalle" value="{{ old('compra_detalle') }}">
            <input type="hidden" name="ejecutor" id="ejecutor" value="{{ old('ejecutor') }}">
            <input type="hidden" name="monto_contrato" id="monto_contrato" value="{{ old('monto_contrato') }}">
            <input type="hidden" name="proveedor" id="proveedor" value="{{ $data->id_tab_proveedor }}">
            <input type="hidden" name="fuente_financiamiento" id="fuente_financiamiento" value="{{ old('fuente_financiamiento') }}">
            <input type="hidden" name="producto" id="producto" value="{{ old('producto') }}">

            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Presupuesto</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">

                <div class="row justify-content-center push">
                    <div class="col-md-12">


                        <div class="modal-body">

                            <div class="block block-themed block-rounded block-bordered">
                                    <div class="block-header bg-primary border-bottom">
                                        <h3 class="block-title">Datos del Presupuesto</h3>
                                    </div>
                                    <div class="block-content">

                            <div class="form-group">
                                <label for="ente_ejecutor" class="col-12">Ente Ejecutor</label>
                                <div class="col-12">
                                    <input type="text" class="form-control {!! $errors->has('ente_ejecutor') ? 'is-invalid' : '' !!}" readonly id="ente_ejecutor" name="ente_ejecutor" placeholder="Ente Ejecutor..." value="{{ old('ente_ejecutor') }}" {{ $errors->has('ente_ejecutor') ? 'aria-describedby="ente_ejecutor-error" aria-invalid="true"' : '' }}>
                                    @if( $errors->has('ente_ejecutor') )
                                        <div id="ente_ejecutor-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ente_ejecutor') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="partida_general" class="col-12">Partida General</label>
                                <div class="col-12">
                                    <select class="js-select2 form-control {!! $errors->has('partida_general') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione Uno..." name="partida_general" id="partida_general" {{ $errors->has('partida_general') ? 'aria-describedby="partida_general-error" aria-invalid="true"' : '' }}>
                                        <option value="" >Seleccione...</option>
                                    </select>
                                    @if( $errors->has('partida_general') )
                                        <div id="partida_general-error" class="invalid-feedback animated fadeIn">{{ $errors->first('partida_general') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="proyecto_ac" class="col-12">Proyecto / Ac</label>
                                <div class="col-12">
                                    <select class="js-select2 form-control {!! $errors->has('proyecto_ac') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione Uno..." name="proyecto_ac" id="proyecto_ac" {{ $errors->has('proyecto_ac') ? 'aria-describedby="proyecto_ac-error" aria-invalid="true"' : '' }}>
                                        <option value="" >Seleccione...</option>
                                    </select>
                                    @if( $errors->has('proyecto_ac') )
                                        <div id="proyecto_ac-error" class="invalid-feedback animated fadeIn">{{ $errors->first('proyecto_ac') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="accion_especifica" class="col-12">Accion Especifica</label>
                                <div class="col-12">
                                    <select class="js-select2 form-control {!! $errors->has('accion_especifica') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione Uno..." name="accion_especifica" id="accion_especifica" {{ $errors->has('accion_especifica') ? 'aria-describedby="accion_especifica-error" aria-invalid="true"' : '' }}>
                                        <option value="" >Seleccione...</option>
                                    </select>
                                    @if( $errors->has('accion_especifica') )
                                        <div id="accion_especifica-error" class="invalid-feedback animated fadeIn">{{ $errors->first('accion_especifica') }}</div>
                                    @endif
                                </div>
                            </div>

                            </div>
                            </div>

                            <div class="block block-themed block-rounded block-bordered">
                                    <div class="block-header bg-primary border-bottom">
                                        <h3 class="block-title">Datos de la Partida</h3>
                                    </div>
                                    <div class="block-content">

                                        <div class="form-group">
                                            <label for="partida" class="col-12">Partida</label>
                                            <div class="col-12">
                                                <select class="js-select2 form-control {!! $errors->has('partida') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione Uno..." name="partida" id="partida" {{ $errors->has('partida') ? 'aria-describedby="partida-error" aria-invalid="true"' : '' }}>
                                                    <option value="" >Seleccione...</option>
                                                </select>
                                                @if( $errors->has('partida') )
                                                    <div id="partida-error" class="invalid-feedback animated fadeIn">{{ $errors->first('partida') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label for="monto_disponible" class="col-12">Monto Disponible</label>
                                            <div class="col-12">
                                                <input type="text" class="form-control {!! $errors->has('monto_disponible') ? 'is-invalid' : '' !!}" readonly id="monto_disponible" name="monto_disponible" placeholder="Monto Disponible..." value="{{ old('monto_disponible') }}" {{ $errors->has('monto_disponible') ? 'aria-describedby="monto_disponible-error" aria-invalid="true"' : '' }}>
                                                @if( $errors->has('monto_disponible') )
                                                    <div id="monto_disponible-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto_disponible') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                            </div>

                        </div>

                    </div>
                </div>

                </div>
                <div class="block-content block-content-full text-right bg-light">
                    <button type="submit" class="btn btn-alt-primary">
                        <i class="fa far fa-plus-square mr-1"></i> Agregar
                    </button>
                </div>
            </div>

        </form>
        
        </div>
    </div>
</div>
<!-- END Pop In Block Modal -->

@endsection