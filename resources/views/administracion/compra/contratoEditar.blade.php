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
            $("#borrarForm").attr('action','{{ url('/solicitud/compra/contrato/detalle/'.$id.'/borrar') }}');
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

        });
    </script>

    @if (count($errors) > 0)
        @if (session()->has('msg_alerta'))
        <script>
            jQuery('#modal-producto').modal('show');
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
    <form action="{{ URL::to('solicitud/compra/contrato/guardar') }}" method="POST">
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

                        <h2 class="content-heading pt-0">Datos de la Compra</h2>

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
                                                <option value="{{ $documento->id }}" {{ $documento->id == $data->id_tab_documento ? 'selected' : '' }}>{{ $documento->de_inicial }}</option>
                                                @endforeach
                                            </select>
                                            @if( $errors->has('tipo_documento') )
                                                <div id="tipo_documento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_documento') }}</div>
                                            @endif
                                        </div>

                                        <div class="col-4">
                                            <label for="documento">Documento</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control {!! $errors->has('documento') ? 'is-invalid' : '' !!}" id="documento" name="documento" placeholder="Documento..." value="{{ empty(old('documento'))? $data->nu_documento : old('documento') }}" {{ $errors->has('documento') ? 'aria-describedby="documento-error" aria-invalid="true"' : '' }}>
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

                                    <input type="hidden" id="proveedor" name="proveedor" value="{{ empty(old('proveedor'))? $data->id_tab_proveedor : old('proveedor') }}">

                                    <div class="form-group">
                                        <label for="razon_social">Razon Social</label>
                                        <input type="text" class="form-control {!! $errors->has('razon_social') ? 'is-invalid' : '' !!}" readonly id="razon_social" name="razon_social" placeholder="Razon Social..." value="{{ empty(old('razon_social'))? $data->de_proveedor : old('razon_social') }}" {{ $errors->has('razon_social') ? 'aria-describedby="razon_social-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('razon_social') )
                                            <div id="razon_social-error" class="invalid-feedback animated fadeIn">{{ $errors->first('razon_social') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="direccion">Direccion</label>
                                        <input type="text" class="form-control {!! $errors->has('direccion') ? 'is-invalid' : '' !!}" readonly id="direccion" name="direccion" placeholder="Direccion..." value="{{ empty(old('direccion'))? $data->tx_direccion : old('direccion') }}" {{ $errors->has('direccion') ? 'aria-describedby="direccion-error" aria-invalid="true"' : '' }}>
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
                                        <label for="tipo_contrato">Tipo de Contrato</label>
                                        <select class="custom-select {!! $errors->has('tipo_contrato') ? 'is-invalid' : '' !!}" name="tipo_contrato" id="tipo_contrato" {{ $errors->has('tipo_contrato') ? 'aria-describedby="tipo_contrato-error" aria-invalid="true"' : '' }}>
                                            <option value="" >Seleccione...</option>
                                            @foreach($tab_tipo_contrato as $tipo_contrato)
                                                <option value="{{ $tipo_contrato->id }}" {{ $tipo_contrato->id == $data->id_tab_tipo_contrato ? 'selected' : '' }}>{{ $tipo_contrato->de_tipo_contrato }}</option>
                                            @endforeach
                                        </select>
                                        @if( $errors->has('tipo_contrato') )
                                            <div id="tipo_contrato-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_contrato') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="orden_preimpresa">Orden Pre-Impresa</label>
                                        <input type="text" class="form-control {!! $errors->has('orden_preimpresa') ? 'is-invalid' : '' !!}" id="orden_preimpresa" name="orden_preimpresa" placeholder="Orden Pre-Impresa..." value="{{ empty(old('orden_preimpresa'))? $data->nu_orden_pre_impresa : old('orden_preimpresa') }}" {{ $errors->has('orden_preimpresa') ? 'aria-describedby="orden_preimpresa-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('orden_preimpresa') )
                                            <div id="orden_preimpresa-error" class="invalid-feedback animated fadeIn">{{ $errors->first('orden_preimpresa') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group form-row">
                                        <div class="col-4">
                                            <label for="fecha_inicio">Fecha Inicio</label>
                                            <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_inicio') ? 'is-invalid' : '' !!}" id="fecha_inicio" name="fecha_inicio" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_inicio'))? $data->fe_ini : old('fecha_inicio') }}" {{ $errors->has('fecha_inicio') ? 'aria-describedby="fecha_inicio-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_inicio') )
                                                <div id="fecha_inicio-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_inicio') }}</div>
                                            @endif
                                        </div>

                                        <div class="col-4">
                                            <label for="fecha_fin">Fecha Fin</label>
                                            <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_fin') ? 'is-invalid' : '' !!}" id="fecha_fin" name="fecha_fin" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_fin'))? $data->fe_fin : old('fecha_fin') }}" {{ $errors->has('fecha_fin') ? 'aria-describedby="fecha_fin-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_fin') )
                                                <div id="fecha_fin-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_fin') }}</div>
                                            @endif
                                        </div>

                                        <div class="col-4">
                                            <label for="fecha_entrega">Fecha Entrega</label>
                                            <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_entrega') ? 'is-invalid' : '' !!}" id="fecha_entrega" name="fecha_entrega" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_entrega'))? $data->fe_entrega : old('fecha_entrega') }}" {{ $errors->has('fecha_entrega') ? 'aria-describedby="fecha_entrega-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_entrega') )
                                                <div id="fecha_entrega-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_entrega') }}</div>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label>Compromiso de Responsabilidad Social</label>
                                        <div class="custom-control custom-checkbox custom-control-primary mb-1">
                                            <input type="checkbox" class="custom-control-input" id="in_compromiso" name="in_compromiso" @if ($data->in_compromiso_rs) checked @endif >
                                            <label class="custom-control-label" for="in_compromiso"></label>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="monto_contrato">Monto Contrato</label>
                                        <input type="text" class="form-control {!! $errors->has('monto_contrato') ? 'is-invalid' : '' !!}" id="monto_contrato" name="monto_contrato" placeholder="Monto Contrato..." value="{{ empty(old('monto_contrato'))? $data->mo_contrato : old('monto_contrato') }}" {{ $errors->has('monto_contrato') ? 'aria-describedby="monto_contrato-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('monto_contrato') )
                                            <div id="monto_contrato-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto_contrato') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="garantia">Garantia</label>
                                        <input type="text" class="form-control {!! $errors->has('garantia') ? 'is-invalid' : '' !!}" id="garantia" name="garantia" placeholder="Garantia..." value="{{ empty(old('garantia'))? $data->de_garantia : old('garantia') }}" {{ $errors->has('garantia') ? 'aria-describedby="garantia-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('garantia') )
                                            <div id="garantia-error" class="invalid-feedback animated fadeIn">{{ $errors->first('garantia') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="observacion">Observacion</label>
                                        <textarea class="form-control {!! $errors->has('observacion') ? 'is-invalid' : '' !!}" id="observacion" name="observacion" rows="3" placeholder="Observaciones.." {{ $errors->has('observacion') ? 'aria-describedby="observacion-error" aria-invalid="true"' : '' }}>{{ empty(old('observacion'))? $data->de_observacion : old('observacion') }}</textarea>
                                        <div class="form-text text-muted font-size-sm font-italic">Breve Observación de la Observacion.</div>
                                        @if( $errors->has('observacion') )
                                            <div id="observacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('observacion') }}</div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Materiales</h3>
                                </div>
                                <div class="block-content">

                                    <div class="form-group form-row">
                                        <div class="col-4">
                                            <label for="fecha_compra">Fecha Compra</label>
                                            <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_compra') ? 'is-invalid' : '' !!}" id="fecha_compra" name="fecha_compra" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_compra'))? $data->fe_compra : old('fecha_compra') }}" {{ $errors->has('fecha_compra') ? 'aria-describedby="fecha_compra-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_compra') )
                                                <div id="fecha_compra-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_compra') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="iva">IVA</label>
                                        <select class="custom-select {!! $errors->has('iva') ? 'is-invalid' : '' !!}" name="iva" id="iva" {{ $errors->has('iva') ? 'aria-describedby="iva-error" aria-invalid="true"' : '' }}>
                                            <option value="" >Seleccione...</option>
                                            @foreach($tab_iva_factura as $iva_factura)
                                                <option value="{{ $iva_factura->id }}" {{ $iva_factura->id == $data->id_tab_iva_factura ? 'selected' : '' }}>{{ $iva_factura->nu_iva_factura }}</option>
                                            @endforeach
                                        </select>
                                        @if( $errors->has('iva') )
                                            <div id="iva-error" class="invalid-feedback animated fadeIn">{{ $errors->first('iva') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="ejecutor_entrega">Entregar En</label>
                                        <select class="custom-select {!! $errors->has('ejecutor_entrega') ? 'is-invalid' : '' !!}" name="ejecutor_entrega" id="ejecutor_entrega" {{ $errors->has('ejecutor_entrega') ? 'aria-describedby="ejecutor_entrega-error" aria-invalid="true"' : '' }}>
                                            <option value="" >Seleccione...</option>
                                            @foreach($tab_ejecutor as $ejecutor_entrega)
                                                <option value="{{ $ejecutor_entrega->id }}" {{ $ejecutor_entrega->id == $data->id_tab_ejecutor_entrega ? 'selected' : '' }}>{{ $ejecutor_entrega->nu_ejecutor }} - {{ $ejecutor_entrega->de_ejecutor }}</option>
                                            @endforeach
                                        </select>
                                        @if( $errors->has('ejecutor_entrega') )
                                            <div id="ejecutor_entrega-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ejecutor_entrega') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">

                                        <div class="btn-group btn-group-sm pr-2">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-producto" title="Agregar Materiales / Bienes / Servicios" href="javascript:void(0)">
                                                <i class="fa fa-fw fa-search-plus"></i> Agregar
                                            </button>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <table class="table table-bordered table-striped table-vcenter">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Codigo</th>
                                                    <th>Descripcion</th>
                                                    <th class="font-w600 text-center">Especificaciones</th>
                                                    <th class="font-w600 text-center">Cantidad</th>
                                                    <th class="font-w600 text-center">Precio Unitario</th>
                                                    <th class="font-w600 text-center">Monto</th>
                                                    <th class="font-w600 text-center">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tab_compra_detalle as $key => $value)
                                                <tr>
                                                    <td class="d-none d-sm-table-cell">{{ $value->nu_producto }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->de_producto }}</td>
                                                    <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->de_especificacion }}</em></td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->nu_cantidad }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->mo_precio_unitario }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->mo_precio_total }}</td>
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
<div class="modal fade" id="modal-producto" tabindex="-1" role="dialog" aria-labelledby="modal-producto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

        <form action="{{ URL::to('solicitud/compra/contrato/detalle/guardar') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="solicitud" value="{{ $id }}">
            <input type="hidden" name="ruta" value="{{ $ruta }}">

            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Materiales / Bienes / Servicios</h3>
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
                            <label for="producto" class="col-12">Producto</label>
                            <div class="col-12">
                                <select class="js-select2 form-control {!! $errors->has('producto') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione Uno..." name="producto" id="producto" {{ $errors->has('producto') ? 'aria-describedby="producto-error" aria-invalid="true"' : '' }}>
                                    <option value="" >Seleccione...</option>
                                    @foreach($tab_producto as $producto)
                                        <option value="{{ $producto->id }}" data-nu_producto="{{ $producto->nu_producto }}" data-de_producto="{{ $producto->de_producto }}" {{ $producto->id == old('producto') ? 'selected' : '' }}>{{ $producto->nu_producto }} - {{ $producto->de_producto }}</option>
                                    @endforeach
                                </select>
                                @if( $errors->has('producto') )
                                    <div id="producto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('producto') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="modal-body">
                            <table class="table table-hover table-bordered table-striped table-vcenter">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Producto</th>
                                        <th class="font-w600 text-center">Cantidad</th>
                                        <th class="font-w600 text-center">Unidad de Medida</th>
                                        <th class="font-w600 text-center">Especificaciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($tab_requisicion_detalle as $key => $value)
                                    <tr>
                                        <td class="d-none d-sm-table-cell">{{ $value->nu_producto }} - {{ $value->de_producto }}</td>
                                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->nu_cantidad }}</em></td>
                                        <td class="d-none d-sm-table-cell">{{ $value->de_unidad_medida }}</td>
                                        <td class="d-none d-sm-table-cell">{{ $value->de_especificacion }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                            <input type="hidden" name="id_tab_producto" id="id_tab_producto" value="">

                            <div class="form-group form-row">
                                <div class="col-2">
                                    <label for="cod_producto">Cod. Producto</label>
                                    <input type="text" class="form-control {!! $errors->has('cod_producto') ? 'is-invalid' : '' !!}" readonly id="cod_producto" name="cod_producto" placeholder="Cod..." value="{{ old('cod_producto') }}" {{ $errors->has('cod_producto') ? 'aria-describedby="cod_producto-error" aria-invalid="true"' : '' }}>
                                    @if( $errors->has('cod_producto') )
                                        <div id="cod_producto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('cod_producto') }}</div>
                                    @endif
                                </div>

                                <div class="col-10">
                                    <label for="desc_producto">Desc. Producto</label>
                                    <input type="text" class="form-control {!! $errors->has('desc_producto') ? 'is-invalid' : '' !!}" readonly id="desc_producto" name="desc_producto" placeholder="Desc..." value="{{ old('desc_producto') }}" {{ $errors->has('desc_producto') ? 'aria-describedby="desc_producto-error" aria-invalid="true"' : '' }}>
                                    @if( $errors->has('desc_producto') )
                                        <div id="desc_producto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('desc_producto') }}</div>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <div class="form-group">
                            <label for="cantidad" class="col-12">Cantidad</label>
                            <div class="col-4">
                                <input type="text" class="form-control {!! $errors->has('cantidad') ? 'is-invalid' : '' !!}" id="cantidad" name="cantidad" placeholder="Cantidad..." value="{{ old('cantidad') }}" {{ $errors->has('cantidad') ? 'aria-describedby="cantidad-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('cantidad') )
                                    <div id="cantidad-error" class="invalid-feedback animated fadeIn">{{ $errors->first('cantidad') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="excento_iva" class="col-12">Exento IVA</label>
                            <div class="col-4">
                                <div class="custom-control custom-checkbox custom-control-primary mb-1">
                                    <input type="checkbox" class="custom-control-input" id="excento_iva" name="excento_iva" @if ($data->in_excento_iva) checked @endif >
                                    <label class="custom-control-label" for="excento_iva"></label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="precio_unitario" class="col-12">Precio Unitario</label>
                            <div class="col-8">
                                <input type="text" class="form-control {!! $errors->has('precio_unitario') ? 'is-invalid' : '' !!}" id="precio_unitario" name="precio_unitario" placeholder="Precio Unitario..." value="{{ old('precio_unitario') }}" {{ $errors->has('precio_unitario') ? 'aria-describedby="precio_unitario-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('precio_unitario') )
                                    <div id="precio_unitario-error" class="invalid-feedback animated fadeIn">{{ $errors->first('precio_unitario') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="unidad" class="col-12">Unidad de Medida</label>
                            <div class="col-8">
                                <select class="js-select2 form-control {!! $errors->has('unidad') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione Uno..." name="unidad" id="unidad" {{ $errors->has('unidad') ? 'aria-describedby="unidad-error" aria-invalid="true"' : '' }}>
                                    @foreach($tab_unidad_medida as $unidad)
                                        <option value="{{ $unidad->id }}" {{ $unidad->id == old('unidad') ? 'selected' : '' }}>{{ $unidad->de_unidad_medida }}</option>
                                    @endforeach
                                </select>
                                @if( $errors->has('unidad') )
                                    <div id="unidad-error" class="invalid-feedback animated fadeIn">{{ $errors->first('unidad') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="especificacion" class="col-12">Especificaciones</label>
                            <div class="col-12">
                                <textarea class="form-control {!! $errors->has('especificacion') ? 'is-invalid' : '' !!}" id="especificacion" name="especificacion" rows="2" placeholder="Especificaciones..." {{ $errors->has('especificacion') ? 'aria-describedby="especificacion-error" aria-invalid="true"' : '' }}>{{ old('especificacion') }}</textarea>
                                <div class="form-text text-muted font-size-sm font-italic">Datos del Materiales / Bienes / Servicio Seleccionado.</div>
                                @if( $errors->has('especificacion') )
                                    <div id="especificacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('especificacion') }}</div>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="catalogo_partida" class="col-12">Partida</label>
                            <div class="col-12">
                                <select class="js-select2 form-control {!! $errors->has('catalogo_partida') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione Uno..." name="catalogo_partida" id="catalogo_partida" {{ $errors->has('catalogo_partida') ? 'aria-describedby="catalogo_partida-error" aria-invalid="true"' : '' }}>
                                    @foreach($tab_catalogo_partida as $catalogo_partida)
                                        <option value="{{ $catalogo_partida->id }}" {{ $catalogo_partida->id == old('catalogo_partida') ? 'selected' : '' }}>{{ $catalogo_partida->co_partida }} - {{ $catalogo_partida->de_partida }}</option>
                                    @endforeach
                                </select>
                                @if( $errors->has('catalogo_partida') )
                                    <div id="catalogo_partida-error" class="invalid-feedback animated fadeIn">{{ $errors->first('catalogo_partida') }}</div>
                                @endif
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