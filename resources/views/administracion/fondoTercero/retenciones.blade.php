@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->

    <link rel="stylesheet" id="css-main" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/dropzone/dist/min/dropzone.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->

    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

    
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/pwstrength-bootstrap/pwstrength-bootstrap.min.js') }}"></script>  
<script>jQuery(function(){ Dashmix.helpers(['maxlength', 'select2', 'rangeslider', 'masked-inputs', 'pw-strength']); });</script>
    <!-- Page JS Code -->

    <script>
        $('#borrar').on('show.bs.modal', function (event) {
            $("#borrarForm").attr('action','{{ url('/administracion/fondoTercero/retencion/'.$solicitud.'/'.$ruta.'/borrar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
        });

        jQuery(function(){ Dashmix.helpers([ 'flatpickr', 'select2']); });

        $(function( $ ){
            $('.btn-hapus').on('click', function(e) {

                $("#resultado").html(
                '<div class="d-flex align-items-center">'+
                    '<strong>Buscando Proveedor...</strong>'+
                    '<div class="spinner-grow ml-auto" role="status" aria-hidden="true"></div>'+
                '</div>');

                $.ajax({
                    url: '{{ url('administracion/proveedor/buscar') }}',
                    type: "POST",
                    data: {
                        _token: '{{ csrf_token() }}', 
                        tipo_documento:$("#tipo_documento").val(),
                        documento:$("#documento").val()
                    },
                    success: function(data, status, xhr){

                        if(data.data){
                            $("#resultado").html('');
                            $("#proveedor").val(data.data.id);
                            $("#razon_social").val(data.data.de_proveedor);
                            $("#direccion").val(data.data.tx_direccion);
                        }else{
                            $("#resultado").html(data.msg);
                            $("#proveedor").val('');
                            $("#razon_social").val('');
                            $("#direccion").val('');
                        }
                    }
                });

            });

            $("#producto").change(function (e) {

                var codigo = 0;
                var nu_producto = "";
                var de_producto = "";

                $("select[name='producto'] option:selected").each(function() {
                    codigo += parseFloat($(this).val());
                    nu_producto += $(this).attr('data-nu_producto');
                    de_producto += $(this).attr('data-de_producto');
                });

                $("#id_tab_producto").val(codigo);
                $("#cod_producto").val(nu_producto);
                $("#desc_producto").val(de_producto);
            
            });
            
$("#tipo_retencion").change(function () {
         
$("#tipo_retencion option:selected").each(function () {
tipo_retencion=$(this).val();    
$.post("{{ URL::to('administracion/fondoTercero/retencion') }}", {tipo_retencion: tipo_retencion,solicitud:'{{ $solicitud }}' ,_token: '{{ csrf_token() }}' }, function(data){
                 $("#retencion").html('<option value="" data-mo_disponible="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#retencion").append('<option value="' + f.id + '">' + f.de_retencion+'</option>');
                    });
                
               });
                        
});
        });            

        });
    </script>

    @if (count($errors) > 0)
        @if (session()->has('msg_alerta'))
        <script>
            jQuery('#modal-retenciones').modal('show');
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
    <form action="{{ URL::to('administracion/fondoTercero/guardar') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="solicitud" value="{{ $solicitud }}">
        <input type="hidden" name="ruta" value="{{ $ruta }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('proceso/ruta/lista').'/'.$solicitud }}">
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

                        <h2 class="content-heading pt-0">Datos del Pago</h2>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Datos del Proveedor</h3><div id="resultado"></div>
                                </div>
                                <div class="block-content">

                                    <div class="form-group form-row">
                                        <div class="col-2">
                                            <label for="tipo_documento">Tipo</label>
                                            <select class="custom-select {!! $errors->has('tipo_documento') ? 'is-invalid' : '' !!}" name="tipo_documento" id="tipo_documento" {{ $errors->has('tipo_documento') ? 'aria-describedby="tipo_documento-error" aria-invalid="true"' : '' }}>
                                                <option value="" >Seleccione...</option>
                                                @foreach($tab_documento as $documento)
                                                <option value="{{ $documento->id }}" {{ $documento->id == old('tipo_documento') ? 'selected' : '' }}>{{ $documento->de_inicial }}</option>
                                                @endforeach
                                            </select>
                                            @if( $errors->has('tipo_documento') )
                                                <div id="tipo_documento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_documento') }}</div>
                                            @endif
                                        </div>

                                        <div class="col-4">
                                            <label for="documento">Documento</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control {!! $errors->has('documento') ? 'is-invalid' : '' !!}" id="documento" name="documento" placeholder="Documento..." value="{{ old('documento') }}" {{ $errors->has('documento') ? 'aria-describedby="documento-error" aria-invalid="true"' : '' }}>
                                                <div class="input-group-append">
                                                    <span class="input-group-text btn-hapus">
                                                        <i class="fa fa-search"></i>
                                                    </span>
                                                </div>
                                                @if( $errors->has('documento') )
                                                    <div id="documento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('documento') }}</div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <input type="hidden" id="proveedor" name="proveedor" value="{{ old('proveedor') }}">

                                    <div class="form-group">
                                        <label for="razon_social">Razon Social</label>
                                        <input type="text" class="form-control {!! $errors->has('razon_social') ? 'is-invalid' : '' !!}" readonly id="razon_social" name="razon_social" placeholder="Razon Social..." value="{{ old('razon_social') }}" {{ $errors->has('razon_social') ? 'aria-describedby="razon_social-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('razon_social') )
                                            <div id="razon_social-error" class="invalid-feedback animated fadeIn">{{ $errors->first('razon_social') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="direccion">Direccion</label>
                                        <input type="text" class="form-control {!! $errors->has('direccion') ? 'is-invalid' : '' !!}" readonly id="direccion" name="direccion" placeholder="Direccion..." value="{{ old('direccion') }}" {{ $errors->has('direccion') ? 'aria-describedby="direccion-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('direccion') )
                                            <div id="direccion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('direccion') }}</div>
                                        @endif
                                    </div>
                                    
                                    <div class="form-group form-row">
                                        <div class="col-4">
                                            <label for="fecha_pago">Fecha de Pago</label>
                                            <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fecha_pago') ? 'is-invalid' : '' !!}" id="fecha_pago" name="fecha_pago" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ old('fecha_pago') }}" {{ $errors->has('fecha_pago') ? 'aria-describedby="fecha_compra-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_pago') )
                                                <div id="fecha_pago-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_pago') }}</div>
                                            @endif
                                        </div>
                                    </div>                                    
                                    
                                <div class="form-group">
                                    <label for="tx_observacion">Observacion</label>
                                    <textarea class="js-maxlength form-control {!! $errors->has('tx_observacion') ? 'is-invalid' : '' !!}" id="tx_observacion" name="tx_observacion" rows="3"  maxlength="100" placeholder="Observaciones.." data-always-show="true" {{ $errors->has('tx_observacion') ? 'aria-describedby="tx_observacion-error" aria-invalid="true"' : '' }}>{{ old('tx_observacion') }}</textarea>
                                    <div class="form-text text-muted font-size-sm font-italic">Breve Observación del Pago.</div>
                                    @if( $errors->has('tx_observacion') )
                                        <div id="tx_observacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tx_observacion') }}</div>
                                    @endif
                                </div>                                     

                                </div>

                            </div>

<!--                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Retenciones</h3>
                                </div>
                                <div class="block-content">


                                    <div class="form-group">

                                        <div class="btn-group btn-group-sm pr-2">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-retenciones" title="Agregar Retenciones" href="javascript:void(0)">
                                                <i class="fa fa-fw fa-search-plus"></i> Agregar
                                            </button>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <table class="table table-bordered table-striped table-vcenter">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th class="font-w600 text-center">Retencion</th>
                                                    <th class="font-w600 text-center">Fecha desde</th>
                                                    <th class="font-w600 text-center">Fecha hasta</th>
                                                    <th class="font-w600 text-center">Monto</th>
                                                    <th class="font-w600 text-center">Observacion</th>
                                                    <th class="font-w600 text-center">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tab_fondo_tercero_detalle as $key => $value)
                                                <tr>
                                                    <td class="d-none d-sm-table-cell">{{ $value->de_retencion }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->fe_desde }}</td>
                                                    <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->fe_hasta }}</em></td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->monto }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->tx_observacion }}</td>
                                                    <td class="d-none d-sm-table-cell">
                                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" title="Borrar" data-target="#borrar" data-item_id="{{ $value->id }}" >
                                                            <i class="fa fa-times"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>

                                </div>
                            </div>-->

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
<div class="modal fade" id="modal-retenciones" tabindex="-1" role="dialog" aria-labelledby="modal-retenciones" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

        <form action="{{ URL::to('administracion/fondoTercero/guardarRetencion') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="solicitud" value="{{ $solicitud }}">
        <input type="hidden" name="ruta" value="{{ $ruta }}">

            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Retenciones</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">

                <div class="row justify-content-center push">
                    <div class="col-md-12">

                    <div class="form-group">
                        <label for="tipo_retencion">Tipo de Retencion</label>
                        <select class="custom-select {!! $errors->has('tipo_retencion') ? 'is-invalid' : '' !!}" name="tipo_retencion" id="tipo_retencion" {{ $errors->has('tipo_retencion') ? 'aria-describedby="tipo_retencion-error" aria-invalid="true"' : '' }}>
                            <option value="0" >Seleccione...</option>
                            @foreach($tab_tipo_retencion as $tipo_retencion)
                                <option value="{{ $tipo_retencion->id }}" {{ $tipo_retencion->id == old('tipo_retencion') ? 'selected' : '' }}>{{ $tipo_retencion->de_tipo_retencion }}</option>
                            @endforeach
                        </select>
                        @if( $errors->has('tipo_retencion') )
                            <div id="tipo_retencion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_retencion') }}</div>
                        @endif
                    </div>
                        
                    <div class="form-group">
                    <label for="retencion">Retencion</label>
                    <select class="custom-select {!! $errors->has('retencion') ? 'is-invalid' : '' !!}" name="retencion" id="retencion" {{ $errors->has('retencion') ? 'aria-describedby="retencion-error" aria-invalid="true"' : '' }}>
                        <option value="" data-mo_disponible="0">Seleccione...</option>                              
                    </select>
                    @if( $errors->has('retencion') )
                        <div id="retencion-error" class="invalid-feedback animated fadeIn">El campo retencion es obligatorio</div>
                    @endif
                   </div>   
                        
                    <div class="form-group form-row">
                        <div class="col-4">
                            <label for="fecha_inicio">Fecha Inicio</label>
                            <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fecha_inicio') ? 'is-invalid' : '' !!}" id="fecha_inicio" name="fecha_inicio" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ old('fecha_inicio') }}" {{ $errors->has('fecha_inicio') ? 'aria-describedby="fecha_inicio-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('fecha_inicio') )
                                <div id="fecha_inicio-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_inicio') }}</div>
                            @endif
                        </div>
                    </div>      
                        
                    <div class="form-group form-row">
                        <div class="col-4">
                            <label for="fecha_fin">Fecha Fin</label>
                            <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fecha_fin') ? 'is-invalid' : '' !!}" id="fecha_fin" name="fecha_fin" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ old('fecha_fin') }}" {{ $errors->has('fecha_fin') ? 'aria-describedby="fecha_fin-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('fecha_fin') )
                                <div id="fecha_fin-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_fin') }}</div>
                            @endif
                        </div>
                    </div>     
                        
                    <div class="form-group form-row">
                        <div class="col-4">
                        <label for="monto">Monto Disponible</label>
                        <input type="text" class="form-control {!! $errors->has('monto') ? 'is-invalid' : '' !!}" readonly id="monto" name="monto" placeholder="Monto Disponible..." value="1" {{ $errors->has('monto') ? 'aria-describedby="monto-error" aria-invalid="true"' : '' }}>
                        @if( $errors->has('monto') )
                            <div id="monto-error" class="invalid-feedback animated fadeIn">El monto disponible debe ser mayor a 0</div>
                        @endif
                        </div>
                    </div>   
                        
                    <div class="form-group">
                        <label for="tx_observacion_retencion">Observacion</label>
                        <textarea class="js-maxlength form-control {!! $errors->has('tx_observacion_retencion') ? 'is-invalid' : '' !!}" id="tx_observacion_retencion" name="tx_observacion_retencion" rows="3"  maxlength="100" placeholder="Observaciones.." data-always-show="true"  {{ $errors->has('tx_observacion_retencion') ? 'aria-describedby="tx_observacion_retencion-error" aria-invalid="true"' : '' }}>{{ old('tx_observacion_retencion') }}</textarea>
                        <div class="form-text text-muted font-size-sm font-italic">Breve Observación de la Retencion.</div>
                        @if( $errors->has('tx_observacion_retencion') )
                            <div id="tx_observacion_retencion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tx_observacion_retencion') }}</div>
                        @endif
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