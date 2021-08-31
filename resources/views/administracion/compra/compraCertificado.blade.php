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

        $('#comprometer').on('show.bs.modal', function (event) {
            $("#comprometerForm").attr('action','{{ url('/solicitud/compra/presupuesto/comprometer') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
        });

        $('#descomprometer').on('show.bs.modal', function (event) {
            $("#descomprometerForm").attr('action','{{ url('/solicitud/compra/presupuesto/descomprometer') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
        });

        $('#editarPartida').on('show.bs.modal', function (event) {
            $("#editarPartidaForm").attr('action','{{ url('/solicitud/compra/partida/detalle/editar') }}');
            var button = $(event.relatedTarget);
            var compra_detalle = button.data('detalle_id');
            var id_tab_ejecutor = button.data('ejecutor_id');
            var catalogo_id = button.data('catalogo_id');
            var ente_ejecutor = button.data('de_ente_ejecutor');
            var presupuesto_egreso_id = button.data('presupuesto_egreso_id');
            var accion_especifica_id = button.data('accion_especifica_id');
            var partida_egreso_id = button.data('partida_egreso_id');
            var mo_disponible_id = button.data('mo_disponible_id');
            var modal = $(this);
            modal.find('.modal-content #compra_detalle').val(compra_detalle);
            modal.find('.modal-content #ejecutor').val(id_tab_ejecutor);
            modal.find('.modal-content #partida_general').val(catalogo_id);
            modal.find('.modal-content #ente_ejecutor').val(ente_ejecutor);
            modal.find('.modal-content #monto_disponible').val(mo_disponible_id);

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
                    if( f.id == presupuesto_egreso_id){ opcion = 'selected="selected"';} else{ opcion = ''; }
                    @if( !empty( old('proyecto_ac')) )
                    if( f.id == {{ intval( old('proyecto_ac')) }}){ opcion = 'selected="selected"';} else{ opcion = ''; }
                    @endif
                    $("#proyecto_ac").append('<option value="' + f.id + '" '+opcion+'>' + f.nu_presupuesto + ' - '+ f.de_presupuesto + '</option>');
                });

                $.post("{{ URL::to('solicitud/compra/partida/proyacae') }}", { proyecto_ac: presupuesto_egreso_id, _token: '{{ csrf_token() }}' }, function(data){
                    $("#accion_especifica").html('<option value="0"> Seleccione Uno...</option>');
                    $.each(data.data, function(i,f) {
                        if( f.id == accion_especifica_id){ opcion = 'selected="selected"';} else{ opcion = ''; }
                        $("#accion_especifica").append('<option value="' + f.id + '" '+opcion+'>' + f.nu_accion_especifica+ ' - ' + f.de_accion_especifica+'</option>');
                    });                                
                });

                $.post("{{ URL::to('solicitud/compra/partida/vigente') }}", { accion_especifica: accion_especifica_id, _token: '{{ csrf_token() }}' }, function(data){
                    $("#partida").html('<option value="0"> Seleccione Uno...</option>');
                    $.each(data.data, function(i,f) {
                        if( f.id == partida_egreso_id){ opcion = 'selected="selected"';} else{ opcion = ''; }
                        $("#partida").append('<option value="' + f.id + '" data-mo_disponible="' + f.mo_disponible+ '" '+opcion+'>' + f.nu_partida+ ' - ' + f.de_partida+'</option>');
                    });                                
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
            jQuery('#editarPartida').modal('show');
        </script>
        @endif
    @endif
@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full">
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

                        <h2 class="content-heading pt-0">Comprometer Presupuesto</h2>

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
                                        <input type="text" class="form-control {!! $errors->has('monto') ? 'is-invalid' : '' !!}" readonly id="monto" name="monto" placeholder="Monto Previsto..." value="{{ $data->mo_presupuesto }}" {{ $errors->has('monto') ? 'aria-describedby="monto-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('monto') )
                                            <div id="monto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="ejecutor">Ejecutor</label>
                                        <input type="text" class="form-control {!! $errors->has('ejecutor') ? 'is-invalid' : '' !!}" readonly id="ejecutor" name="ejecutor" placeholder="Ejecutor..." value="{{ $data->nu_ejecutor }} - {{ $data->de_ejecutor }}" {{ $errors->has('ejecutor') ? 'aria-describedby="ejecutor-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('ejecutor') )
                                            <div id="ejecutor-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ejecutor') }}</div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Datos de las Partidas</h3>
                                </div>
                                <div class="block-content">

                                    <div class="form-group">

                                        <div class="btn-group btn-group-sm pr-2">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#comprometer" data-item_id="{{ $id }}">
                                                <i class="fa fa-fw fa-folder-plus"></i> Comprometer
                                            </button>
                                        </div>
                                        <div class="btn-group btn-group-sm pr-2">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#descomprometer" data-item_id="{{ $id }}">
                                                <i class="fa fa-fw fa-folder-minus"></i> Descomprometer
                                            </button>
                                        </div>
                                        <div class="btn-group btn-group-sm pr-2">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-producto" title="Agregar Materiales / Bienes / Servicios" href="javascript:void(0)">
                                                <i class="fa fa-fw fa-calculator"></i> Ver Resumen
                                            </button>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <table class="table table-bordered table-striped table-vcenter">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Material</th>
                                                    <th>Cod. Partida</th>
                                                    <th>Partida</th>
                                                    <th class="font-w600 text-center">Monto</th>
                                                    <th class="font-w600 text-center">Estatus</th>
                                                    <th class="font-w600 text-center">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tab_asignar_partida_detalle as $key => $value)
                                                <tr>
                                                    <td class="d-none d-sm-table-cell">{{ $value->nu_producto }} - {{ $value->de_producto }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->co_partida }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->de_partida }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->mo_gasto }}</td>
                                                    <td class="d-none d-sm-table-cell">
                                                    @if( $value->in_comprometer == true )
                                                        <span class="nav-main-link-badge badge badge-pill badge-success">COMPROMETIDO</span>
                                                    @else
                                                        N/A
                                                    @endif
                                                    </td>
                                                    <td class="d-none d-sm-table-cell">
                                                        @if( $value->in_comprometer == false )
                                                        <div class="btn-group btn-group-sm pr-2">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" title="Presione para Cambiar Partida" data-target="#editarPartida" data-detalle_id="{{ $value->id }}" data-ejecutor_id="{{ $value->id_tab_ejecutor }}" data-catalogo_id="{{ $value->id_tab_catalogo_partida }}" data-de_ente_ejecutor="{{ $value->nu_ejecutor }}-{{ $value->de_ejecutor }}" data-presupuesto_egreso_id="{{ $value->id_tab_presupuesto_egreso }}" data-accion_especifica_id="{{ $value->id_tab_accion_especifica }}" data-partida_egreso_id="{{ $value->id_tab_partida_egreso }}" data-mo_disponible_id="{{ $value->mo_disponible }}">
                                                                <i class="fa fa-fw fa-edit"></i> Cambiar Partida
                                                            </button>
                                                        </div>
                                                        @else
                                                            <div class="btn-group btn-group-sm pr-2">
                                                                <button type="button" class="btn btn-primary" disabled="">
                                                                    <i class="fa fa-fw fa-edit"></i> Cambiar Partida
                                                                </button>
                                                            </div>
                                                        @endif
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

    </form>
    </div>
    <!-- END New Post -->
</div>
<!-- END Page Content -->

<!-- Pop Out Block Modal -->
<div class="modal fade" id="comprometer" tabindex="-1" role="dialog" aria-labelledby="comprometer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
            <form action="#" method="post" id="comprometerForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="ruta" value="{{ $ruta }}">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="comprometer">Aviso</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <p>¿Estás seguro de que quieres comprometer el Presupuesto?</p>
                </div>
                <input type="hidden" name="solicitud" id="registro_id" value="">
                <div class="block-content block-content-full text-right bg-light">
                    <button type="submit" class="btn btn-sm btn-primary">Si</button>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">No</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Pop Out Block Modal -->
<div class="modal fade" id="descomprometer" tabindex="-1" role="dialog" aria-labelledby="descomprometer" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popout" role="document">
        <div class="modal-content">
            <div class="block block-themed block-transparent mb-0">
            <form action="#" method="post" id="descomprometerForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="ruta" value="{{ $ruta }}">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title" id="descomprometer">Aviso</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">
                    <p>¿Estás seguro de que quieres descomprometer el Presupuesto?</p>
                </div>
                <input type="hidden" name="solicitud" id="registro_id" value="">
                <div class="block-content block-content-full text-right bg-light">
                    <button type="submit" class="btn btn-sm btn-primary">Si</button>
                    <button type="button" class="btn btn-sm btn-light" data-dismiss="modal">No</button>
                </div>
            </form>
            </div>
        </div>
    </div>
</div>

<!-- Pop In Block Modal -->
<div class="modal fade" id="editarPartida" tabindex="-1" role="dialog" aria-labelledby="editarPartida" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

        <form action="{{ URL::to('solicitud/compra/contrato/detalle/guardar') }}" method="POST" id="editarPartidaForm">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="solicitud" value="{{ $id }}">
            <input type="hidden" name="ruta" value="{{ $ruta }}">
            <input type="hidden" name="compra_detalle" id="compra_detalle" value="{{ old('compra_detalle') }}">
            <input type="hidden" name="ejecutor" id="ejecutor" value="{{ old('ejecutor') }}">

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