@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->

    <link rel="stylesheet" id="css-main" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->

    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

    
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
    <!-- Page JS Code -->

    <script>
        $('#borrar').on('show.bs.modal', function (event) {
            $("#borrarForm").attr('action','{{ url('/administracion/asignarPartida/'.$ruta.'/borrar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
        });

        $('#agregarPartida').on('show.bs.modal', function (event) {
            $("#agregarPartidaForm").attr('action','{{ url('/administracion/asignarPartida/guardar') }}');
            var button = $(event.relatedTarget);
            var id_tab_asignar_partida = button.data('id_tab_asignar_partida');
            var ejecutor = $.trim($("#ejecutor").children("option:selected").text());
            var id_tab_ejecutor = $("#ejecutor").val();
            var id_fuente_financiamiento = $("#fuente_financiamiento").val();
            var modal = $(this);
//            modal.find('.modal-content #ente_ejecutor').val(ejecutor);
            modal.find('.modal-content #ejecutor').val(id_tab_ejecutor);
            modal.find('.modal-content #ejecutor').val(id_tab_ejecutor);
            modal.find('.modal-content #fuente_financiamiento').val(id_fuente_financiamiento);
            modal.find('.modal-content #id_tab_asignar_partida').val(id_tab_asignar_partida);

//            $("#partida_general").html('<option value="">Seleccione...</option>');
//            $.get("{{ URL::to('solicitud/compra/partida/catalogo') }}", function(data){
//                var opcion;
//                $.each(data.data, function(i,f) {
//                    if( f.id == {{ intval( old('partida_general')) }}){ opcion = 'selected="selected"';} else{ opcion = ''; }
//                    $("#partida_general").append('<option value="' + f.id + '" '+opcion+'>' + f.co_partida + ' - '+ f.de_partida + '</option>');
//                });
//            });
            $("#proyecto_ac").html('<option value="">Seleccione...</option>');
            $("#ejecutor").change(function () {
            $("#ejecutor option:selected").each(function () {                
            id_tab_ejecutor=$(this).val();
            
            $.post("{{ URL::to('administracion/asignarPartida/proyac') }}", { ejecutor: id_tab_ejecutor, _token: '{{ csrf_token() }}' }, function(data){
                var opcion;
                $.each(data.data, function(i,f) {
                    if( f.id == {{ intval( old('proyecto_ac')) }}){ opcion = 'selected="selected"';} else{ opcion = ''; }
                    $("#proyecto_ac").append('<option value="' + f.id + '" '+opcion+'>' + f.nu_presupuesto + ' - '+ f.de_presupuesto + '</option>');
                });
            });
            });
            });
            
            $("#accion_especifica").html('<option value="">Seleccione...</option>');
            $("#proyecto_ac").change(function () {
         
                $("#proyecto_ac option:selected").each(function () {
                    proyecto_ac=$(this).val();    
                    $.post("{{ URL::to('administracion/asignarPartida/proyacae') }}", { proyecto_ac: proyecto_ac, _token: '{{ csrf_token() }}' }, function(data){
                    $("#accion_especifica").html('<option value="0"> Seleccione Uno...</option>');
                        $.each(data.data, function(i,f) {
                            $("#accion_especifica").append('<option value="' + f.id + '">' + f.nu_accion_especifica+ ' - ' + f.de_accion_especifica+'</option>');
                        });                                
                    });
                });
            });

            @if( !empty( old('proyecto_ac')) )

                $("#accion_especifica").html('<option value="0"> Seleccione Uno...</option>');
                $.post("{{ URL::to('administracion/asignarPartida/proyacae') }}", { proyecto_ac: {{  old('proyecto_ac') }}, _token: '{{ csrf_token() }}' }, function(data){
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
                    $.post("{{ URL::to('administracion/asignarPartida/vigente') }}", { accion_especifica: accion_especifica, _token: '{{ csrf_token() }}' }, function(data){
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
            $("#agregarPartida").find('input[name="id_tab_asignar_partida"]').val("{{old('id_tab_asignar_partida')}}");
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
    <form action="{{ URL::to('administracion/asignarPartida/guardar') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="solicitud" value="{{ $id }}">
        <input type="hidden" name="ruta" value="{{ $ruta }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('proceso/ruta/lista').'/'.$id }}">
                    <i class="fa fa-arrow-left mr-1"></i> Volver
                </a>
            <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
                <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">{{$tab_tipo_solicitud->de_solicitud}}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $tab_solicitud->nu_solicitud }}</li>
                        <li class="breadcrumb-item active" aria-current="page">{{ $tab_proceso->de_proceso }}</li>
                    </ol>
                </nav>
            </div>                 
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
                                    <h3 class="block-title">Datos del Ente Ejecutor </h3>
                                </div>
                                <div class="block-content">
                                                                       

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
                                            @foreach($tab_asignar_partida as $key => $value)
                                                <tr>
                                                    <td class="d-none d-sm-table-cell">{{ $value->de_concepto }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->co_partida }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->de_partida }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->mo_presupuesto }}</td>
                                                    <td class="d-none d-sm-table-cell">
                                                        <div class="btn-group btn-group-sm pr-2">
                                                        @if( empty( $value->id_tab_asignar_partida_detalle) )
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" title="Presione para Agregar Partida" data-target="#agregarPartida" data-catalogo_id="{{ $value->id_tab_catalogo_partida }}" data-id_tab_asignar_partida="{{ $value->id }}">
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

    </form>
    </div>
    <!-- END New Post -->
</div>
<!-- END Page Content -->

<!-- Pop In Block Modal -->
<div class="modal fade" id="agregarPartida" tabindex="-1" role="dialog" aria-labelledby="agregarPartida" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

        <form action="{{ URL::to('administracion/asignarPartida/guardar') }}" method="POST" id="agregarPartidaForm">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="solicitud" value="{{ $id }}">
            <input type="hidden" name="ruta" value="{{ $ruta }}">
            <input type="hidden" name="id_tab_asignar_partida" id="id_tab_asignar_partida" value="">
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
                                        <label for="ejecutor">Ente Ejecutor</label>
                                        <div class="col-12">
                                        <select class="custom-select {!! $errors->has('ejecutor') ? 'is-invalid' : '' !!}" name="ejecutor" id="ejecutor" {{ $errors->has('ejecutor') ? 'aria-describedby="ejecutor-error" aria-invalid="true"' : '' }}>
                                            <option value="" >Seleccione...</option>
                                            @foreach($tab_ejecutor as $ejecutor)
                                                <option value="{{ $ejecutor->id }}" >{{ $ejecutor->nu_ejecutor }} - {{ $ejecutor->de_ejecutor }}</option>
                                            @endforeach
                                        </select>
                                        @if( $errors->has('ejecutor') )
                                            <div id="ejecutor-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ejecutor') }}</div>
                                        @endif
                                    </div>
                                        
<!--                            <div class="form-group">
                                <label for="partida_general" class="col-12">Partida General</label>
                                <div class="col-12">
                                    <select class="js-select2 form-control {!! $errors->has('partida_general') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione Uno..." name="partida_general" id="partida_general" {{ $errors->has('partida_general') ? 'aria-describedby="partida_general-error" aria-invalid="true"' : '' }}>
                                        <option value="" >Seleccione...</option>
                                    </select>
                                    @if( $errors->has('partida_general') )
                                        <div id="partida_general-error" class="invalid-feedback animated fadeIn">{{ $errors->first('partida_general') }}</div>
                                    @endif
                                </div>
                            </div>-->

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