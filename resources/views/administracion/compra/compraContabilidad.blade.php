@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->
    {{--<link rel="stylesheet" id="css-main" href="{{ asset('css/bootstrap-select.min.css') }}">--}}
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
    {{--<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>--}}
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    {{--<script src="{{ asset('assets/js/plugins/flatpickr/l10n/es.js') }}"></script>--}}
    <script src="{{ asset('js/jquery.numeric.js') }}"></script>
    <!-- Page JS Code -->
    <script>

        $('#borrar').on('show.bs.modal', function (event) {
            $("#borrarForm").attr('action','{{ url('/solicitud/compra/contabilidad/detalle/'.$id.'/borrar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
        });

        jQuery(function(){ Dashmix.helpers([ 'flatpickr', 'select2', 'table-tools-checkable']); });

        $(".numeric").numeric({ decimal : ".",  negative : false, scale: 3 });

        $("#producto").change(function (e) {

            var mo_valor_unitario = null;
            var mo_cant_requerida = null;
			$("select[name='producto'] option:selected").each(function() {
                mo_valor_unitario = parseFloat($(this).attr('data-valor_unitario'));
                mo_cant_requerida = parseFloat($(this).attr('data-cantidad_requerida'));
            });
            if(isNaN(mo_valor_unitario)){
                mo_valor_unitario = 0;
            }
            if(isNaN(mo_cant_requerida)){
                mo_cant_requerida = 0;
            }
            $("#valor_unitario").val(mo_valor_unitario.toFixed(2));
            $("#cant_requerida").val(mo_cant_requerida.toFixed(2));

        });

        function calcularRetencion(valor){
            $.post("{{ URL::to('solicitud/compra/contabilidad/retenciones') }}", { 
                //usuario: document.getElementById("cant_factura").value,
                cant_factura: valor,
                valor_unitario: document.getElementById("valor_unitario").value,
                porcentaje_iva_factura: document.getElementById("iva").value,
                porcentaje_iva_retencion: document.getElementById("iva_retencion").value,
                proveedor: document.getElementById("proveedor").value,
                ramo: document.getElementById("ramo").value,
                _token: '{{ csrf_token() }}' }, 
                function(data){

                    $("#monto_factura").val(data.data.monto_factura);
                    $("#base_imponible").val(data.data.base_imponible);
                    $("#iva_monto").val(data.data.monto_iva);
                    $("#iva_retencion_monto").val(data.data.monto_iva_retencion);
                    $("#total_pagar").val(data.data.total_pago);
                    $("#totalRetencion").html('<i class="fa fa-calculator ml-1 opacity-25"></i> Total Retenciones: ' + data.data.monto_retencion);
                    $("#ramo_detalle").val(document.getElementById("ramo").value);

                    /*console.log(data.data.tipo);*/
                    var retencion_data = '';
                    $.each(data.data.tipo, function(index, value){
                        /*console.log(value);*/
                        retencion_data += '<tr>';
                        retencion_data += '<td class="text-center"><div class="custom-control custom-checkbox custom-control-primary d-inline-block"><input type="checkbox" class="custom-control-input" id="retener['+value.id+']" name="retener['+value.id+']"><label class="custom-control-label" for="retener['+value.id+']"></label></div></td>';
                        retencion_data += '<td class="font-w600">'+value.de_retencion+'</td>';
                        retencion_data += '<td class="font-w600">'+value.porcentaje_retencion+'</td>';
                        retencion_data += '<td class="font-w600">'+value.mo_retencion+'</td>';
                        retencion_data += '</tr>';
                    });
                    $("#listaRetencion").html(retencion_data);

            });
        };

        /*$("#cant_factura").keyup(function(event){
            $("#plan").html('<option value="">Escoger...</option>');
            $.post("{{ URL::to('buscar/cupon') }}", { 
                cupon: $(this).val(),
                _token: '{{ csrf_token() }}' }, 
                function(data){
                    $("#plan").val(data.data.id_plan);
                    $("#de_plan").val(data.data.tsubscription_name);
            });
        });*/

    </script>

    @if (count($errors) > 0)
        @if (session()->has('msg_alerta'))
        <script>
            jQuery('#agregarFactura').modal('show');
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
    <form action="{{ URL::to('solicitud/compra/contabilidad/guardar') }}" method="POST">
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
                                            <input type="text" class="form-control {!! $errors->has('tipo_documento') ? 'is-invalid' : '' !!}" readonly id="tipo_documento" name="tipo_documento" placeholder="Tipo..." value="{{ empty(old('tipo_documento'))? $data->de_inicial : old('tipo_documento') }}" {{ $errors->has('tipo_documento') ? 'aria-describedby="tipo_documento-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('tipo_documento') )
                                                <div id="tipo_documento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_documento') }}</div>
                                            @endif
                                        </div>

                                        <div class="col-4">
                                            <label for="documento">Documento</label>
                                            <div class="input-group">
                                                <input type="text" class="form-control {!! $errors->has('documento') ? 'is-invalid' : '' !!}" readonly id="documento" name="documento" placeholder="Documento..." value="{{ empty(old('documento'))? $data->nu_documento : old('documento') }}" {{ $errors->has('documento') ? 'aria-describedby="documento-error" aria-invalid="true"' : '' }}>
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
                                        <input type="text" class="form-control {!! $errors->has('tipo_contrato') ? 'is-invalid' : '' !!}" readonly id="tipo_contrato" name="tipo_contrato" placeholder="Orden Pre-Impresa..." value="{{ $data->de_tipo_contrato }}" {{ $errors->has('tipo_contrato') ? 'aria-describedby="tipo_contrato-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('tipo_contrato') )
                                            <div id="tipo_contrato-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_contrato') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group form-row">
                                        <div class="col-4">
                                            <label for="fecha_inicio">Fecha Inicio</label>
                                            <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_inicio') ? 'is-invalid' : '' !!}" readonly id="fecha_inicio" name="fecha_inicio" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_inicio'))? $data->fe_ini : old('fecha_inicio') }}" {{ $errors->has('fecha_inicio') ? 'aria-describedby="fecha_inicio-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_inicio') )
                                                <div id="fecha_inicio-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_inicio') }}</div>
                                            @endif
                                        </div>

                                        <div class="col-4">
                                            <label for="fecha_fin">Fecha Fin</label>
                                            <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_fin') ? 'is-invalid' : '' !!}" readonly id="fecha_fin" name="fecha_fin" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_fin'))? $data->fe_fin : old('fecha_fin') }}" {{ $errors->has('fecha_fin') ? 'aria-describedby="fecha_fin-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_fin') )
                                                <div id="fecha_fin-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_fin') }}</div>
                                            @endif
                                        </div>

                                        <div class="col-4">
                                            <label for="fecha_entrega">Fecha Entrega</label>
                                            <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_entrega') ? 'is-invalid' : '' !!}" readonly id="fecha_entrega" name="fecha_entrega" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_entrega'))? $data->fe_entrega : old('fecha_entrega') }}" {{ $errors->has('fecha_entrega') ? 'aria-describedby="fecha_entrega-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_entrega') )
                                                <div id="fecha_entrega-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_entrega') }}</div>
                                            @endif
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <label for="monto_contrato">Monto Contrato</label>
                                        <input type="text" class="form-control {!! $errors->has('monto_contrato') ? 'is-invalid' : '' !!}" readonly id="monto_contrato" name="monto_contrato" placeholder="Monto Contrato..." value="{{ empty(old('monto_contrato'))? $data->mo_contrato : old('monto_contrato') }}" {{ $errors->has('monto_contrato') ? 'aria-describedby="monto_contrato-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('monto_contrato') )
                                            <div id="monto_contrato-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto_contrato') }}</div>
                                        @endif
                                    </div>

                                </div>
                            </div>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Ramo del Proveedor</h3>
                                </div>
                                <div class="block-content">

                                    <div class="form-group">
                                        <label for="ramo" class="col-12">Ramo</label>
                                        <div class="col-12">
                                            <select class="js-select2 form-control {!! $errors->has('ramo') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione Uno..." name="ramo" id="ramo" {{ $errors->has('ramo') ? 'aria-describedby="ramo-error" aria-invalid="true"' : '' }}>
                                                @foreach($tab_ramo_proveedor as $ramo)
                                                    <option value="{{ $ramo->id }}" {{ $ramo->id == old('ramo') ? 'selected' : '' }}>{{ $ramo->de_ramo }}</option>
                                                @endforeach
                                            </select>
                                            @if( $errors->has('ramo') )
                                                <div id="ramo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ramo') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Lista de Facturas</h3>
                                </div>
                                <div class="block-content">

                                    <div class="form-group">

                                        <div class="btn-group btn-group-sm pr-2">
                                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#agregarFactura" data-item_id="{{ $id }}">
                                                <i class="fa fa-fw fa-folder-plus"></i> Agregar
                                            </button>
                                        </div>

                                    </div>

                                    <div class="form-group">
                                        <table class="table table-bordered table-striped table-vcenter">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>N° Factura</th>
                                                    <th>Fecha Emisión</th>
                                                    <th>Base Imponible</th>
                                                    <th class="font-w600 text-center">Total Retenciones</th>
                                                    <th class="font-w600 text-center">Total Factura</th>
                                                    <th class="font-w600 text-center">Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tab_proceso_retencion_factura as $key => $value)
                                                <tr>
                                                    <td class="d-none d-sm-table-cell">{{ $value->nu_factura }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->fe_emision }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ number_format( $value->mo_base_imponible, 2, ',','.')}}</td>
                                                    <td class="d-none d-sm-table-cell">{{ number_format( $value->mo_retencion, 2, ',','.')}}</td>
                                                    <td class="d-none d-sm-table-cell">{{ number_format( $value->mo_total, 2, ',','.')}}</td>
                                                    <td class="text-center">
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
                        <i class="fa fa-fw fa-print mr-1"></i> Guardar
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
<div class="modal fade" id="agregarFactura" tabindex="-1" role="dialog" aria-labelledby="agregarFactura" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

            <form action="{{ URL::to('solicitud/compra/contabilidad/detalle/guardar') }}" method="POST" id="agregarFacturaForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="solicitud" value="{{ $id }}">
                <input type="hidden" name="ruta" value="{{ $ruta }}">
                <input type="hidden" name="proveedor" value="{{ $data->id_tab_proveedor }}">
                <input type="hidden" name="compra" value="{{ $data->id }}">
                <input type="hidden" name="ramo_detalle" id="ramo_detalle" value="{{ old('ramo_detalle') }}">

                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Factura</h3>
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
                                            <h3 class="block-title">Datos de la Factura</h3>
                                        </div>
                                        <div class="block-content">

                                            <div class="form-group">
                                                <label for="numero_factura">N° Factura</label>
                                                <input type="text" class="form-control {!! $errors->has('numero_factura') ? 'is-invalid' : '' !!}" id="numero_factura" name="numero_factura" placeholder="Numero Factura..." value="{{ old('numero_factura') }}" {{ $errors->has('numero_factura') ? 'aria-describedby="numero_factura-error" aria-invalid="true"' : '' }}>
                                                @if( $errors->has('numero_factura') )
                                                    <div id="numero_factura-error" class="invalid-feedback animated fadeIn">{{ $errors->first('numero_factura') }}</div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="numero_control">N° Control</label>
                                                <input type="text" class="form-control {!! $errors->has('numero_control') ? 'is-invalid' : '' !!}" id="numero_control" name="numero_control" placeholder="Numero Control..." value="{{ old('numero_control') }}" {{ $errors->has('numero_control') ? 'aria-describedby="numero_control-error" aria-invalid="true"' : '' }}>
                                                @if( $errors->has('numero_control') )
                                                    <div id="numero_control-error" class="invalid-feedback animated fadeIn">{{ $errors->first('numero_control') }}</div>
                                                @endif
                                            </div>

                                            <div class="form-group form-row">
                                                <div class="col-4">
                                                    <label for="fecha_emision">Fecha Emisión</label>
                                                    <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_emision') ? 'is-invalid' : '' !!}" id="fecha_emision" name="fecha_emision" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ old('fecha_emision') }}" {{ $errors->has('fecha_emision') ? 'aria-describedby="fecha_emision-error" aria-invalid="true"' : '' }}>
                                                    @if( $errors->has('fecha_emision') )
                                                        <div id="fecha_emision-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_emision') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group form-row">
                                                <label for="producto" class="col-12">Producto</label>
                                                <div class="col-12">
                                                    <select class="form-control {!! $errors->has('producto') ? 'is-invalid' : '' !!}" name="producto" id="producto" {{ $errors->has('producto') ? 'aria-describedby="producto-error" aria-invalid="true"' : '' }}>
                                                        <option value="">Seleccione...</option>
                                                        @foreach($tab_compra_detalle as $compra_detalle)
                                                            <option value="{{ $compra_detalle->id }}" data-cantidad_requerida="{{ $compra_detalle->nu_cantidad }}" data-valor_unitario="{{ $compra_detalle->mo_precio_unitario }}" {{ $compra_detalle->id == old('producto') ? 'selected' : '' }}>{{ $compra_detalle->nu_producto }} - {{ $compra_detalle->de_producto }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if( $errors->has('producto') )
                                                        <div id="producto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('producto') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group form-row">
                                                <div class="col-3">
                                                    <label for="cant_requerida">Cant. Requerida</label>
                                                    <input type="text" class="form-control {!! $errors->has('cant_requerida') ? 'is-invalid' : '' !!}" readonly id="cant_requerida" name="cant_requerida" placeholder="Cant. Requerida..." value="{{ old('cant_requerida') }}" {{ $errors->has('cant_requerida') ? 'aria-describedby="cant_requerida-error" aria-invalid="true"' : '' }}>
                                                    @if( $errors->has('cant_requerida') )
                                                        <div id="cant_requerida-error" class="invalid-feedback animated fadeIn">{{ $errors->first('cant_requerida') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-3">
                                                    <label for="valor_unitario">Valor Unitario</label>
                                                    <input type="text" class="form-control {!! $errors->has('valor_unitario') ? 'is-invalid' : '' !!}" readonly id="valor_unitario" name="valor_unitario" placeholder="Valor Unitario..." value="{{ old('valor_unitario') }}" {{ $errors->has('valor_unitario') ? 'aria-describedby="valor_unitario-error" aria-invalid="true"' : '' }}>
                                                    @if( $errors->has('valor_unitario') )
                                                        <div id="valor_unitario-error" class="invalid-feedback animated fadeIn">{{ $errors->first('valor_unitario') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-3">
                                                    <label for="cant_factura">Cant. Factura</label>
                                                    <input type="text" class="form-control numeric {!! $errors->has('cant_factura') ? 'is-invalid' : '' !!}" id="cant_factura" name="cant_factura" placeholder="Cant. Factura..." value="{{ old('cant_factura') }}" onkeyup="calcularRetencion(this.value);" {{ $errors->has('cant_factura') ? 'aria-describedby="cant_factura-error" aria-invalid="true"' : '' }}>
                                                    @if( $errors->has('cant_factura') )
                                                        <div id="cant_factura-error" class="invalid-feedback animated fadeIn">{{ $errors->first('cant_factura') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-3">
                                                    <label for="monto_factura">Monto Total</label>
                                                    <input type="text" class="form-control {!! $errors->has('monto_factura') ? 'is-invalid' : '' !!}" readonly id="monto_factura" name="monto_factura" placeholder="Monto Total..." value="{{ old('monto_factura') }}" {{ $errors->has('monto_factura') ? 'aria-describedby="monto_factura-error" aria-invalid="true"' : '' }}>
                                                    @if( $errors->has('monto_factura') )
                                                        <div id="monto_factura-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto_factura') }}</div>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="form-group form-row">
                                                <div class="col-12">
                                                    <label for="base_imponible">Base Imponible</label>
                                                    <div class="input-group">
                                                        <input type="text" class="form-control {!! $errors->has('base_imponible') ? 'is-invalid' : '' !!}" readonly id="base_imponible" name="base_imponible" placeholder="Base Imponible..." value="{{ old('base_imponible') }}" {{ $errors->has('base_imponible') ? 'aria-describedby="base_imponible-error" aria-invalid="true"' : '' }}>
                                                        {{--<div class="input-group-append">
                                                            <button type="button" class="btn btn-primary" data-toggle="modal" title="Presione para Agregar Factura" data-target="#agregarProducto" data-ramo_id="9999">
                                                                <i class="fa fa-fw fa-folder-plus"></i> Agregar Factura
                                                            </button>
                                                        </div>--}}
                                                    </div>
                                                    @if( $errors->has('base_imponible') )
                                                        <div id="base_imponible-error" class="invalid-feedback animated fadeIn">{{ $errors->first('base_imponible') }}</div>
                                                    @endif
                                                </div>

                                            </div>

                                            <div class="form-group form-row">
                                                <div class="col-4">
                                                    <label for="iva">IVA</label>
                                                    <input type="text" class="form-control {!! $errors->has('iva') ? 'is-invalid' : '' !!}" readonly id="iva" name="iva" placeholder="IVA" value="{{ empty(old('iva'))? $data->nu_iva_factura : old('iva') }}" {{ $errors->has('iva') ? 'aria-describedby="iva-error" aria-invalid="true"' : '' }}>
                                                    @if( $errors->has('iva') )
                                                        <div id="iva-error" class="invalid-feedback animated fadeIn">{{ $errors->first('iva') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-8">
                                                    <label for="iva_monto">Monto IVA</label>
                                                    <input type="text" class="form-control {!! $errors->has('iva_monto') ? 'is-invalid' : '' !!}" readonly id="iva_monto" name="iva_monto" placeholder="Monto IVA" value="{{ old('iva_monto') }}" {{ $errors->has('iva_monto') ? 'aria-describedby="iva_monto-error" aria-invalid="true"' : '' }}>
                                                    @if( $errors->has('iva_monto') )
                                                        <div id="iva_monto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('iva_monto') }}</div>
                                                    @endif
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="block block-themed block-rounded block-bordered">
                                        <div class="block-header bg-primary border-bottom">
                                            <h3 class="block-title">Retencion</h3>
                                        </div>

                                        <div class="block-content">

                                            <div class="form-group form-row">
                                                <div class="col-4">
                                                    <label for="iva_retencion">IVA</label>
                                                    <input type="text" class="form-control {!! $errors->has('iva_retencion') ? 'is-invalid' : '' !!}" readonly id="iva_retencion" name="iva_retencion" placeholder="IVA Retencion" value="{{ empty(old('iva_retencion'))? $data->nu_iva_retencion : old('iva_retencion') }}" {{ $errors->has('iva_retencion') ? 'aria-describedby="iva_retencion-error" aria-invalid="true"' : '' }}>
                                                    @if( $errors->has('iva_retencion') )
                                                        <div id="iva_retencion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('iva_retencion') }}</div>
                                                    @endif
                                                </div>

                                                <div class="col-8">
                                                    <label for="iva_retencion_monto">Monto IVA</label>
                                                    <input type="text" class="form-control {!! $errors->has('iva_retencion_monto') ? 'is-invalid' : '' !!}" readonly id="iva_retencion_monto" name="iva_retencion_monto" placeholder="Monto Retencion IVA" value="{{ old('iva_retencion_monto') }}" {{ $errors->has('iva_retencion_monto') ? 'aria-describedby="iva_retencion_monto-error" aria-invalid="true"' : '' }}>
                                                    @if( $errors->has('iva_retencion_monto') )
                                                        <div id="iva_retencion_monto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('iva_retencion_monto') }}</div>
                                                    @endif
                                                </div>

                                            </div>

                                        </div>
                                    </div>

                                    <div class="block block-themed block-rounded block-bordered">
                                        <div class="block-header bg-primary border-bottom">
                                            <h3 class="block-title">Detalle de Retencion</h3>
                                        </div>

                                        <div class="block-content">

                                            <table class="js-table-checkable table table-bordered table-striped table-vcenter">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center" style="width: 70px;">
                                                            <div class="custom-control custom-checkbox custom-control-primary d-inline-block">
                                                                <input type="checkbox" class="custom-control-input" id="check-all" name="check-all">
                                                                <label class="custom-control-label" for="check-all"></label>
                                                            </div>
                                                        </th>
                                                        <th>Tipo de Retencion</th>
                                                        <th>Porcentaje</th>
                                                        <th>Monto</th>
                                                    </tr>
                                                </thead>
                                                <tbody height="150px" id="listaRetencion">

                                                </tbody>
                                            </table>

                                            <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-left">
                                                <a class="font-w500" href="javascript:void(0)">
                                                    <div id="totalRetencion"><i class="fa fa-calculator ml-1 opacity-25"></i> Total Retenciones: 0.00</div>
                                                </a>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="block block-themed block-rounded block-bordered">
                                        <div class="block-header bg-primary border-bottom">
                                            <h3 class="block-title">Monto a Pagar</h3>
                                        </div>

                                        <div class="block-content">

                                            <div class="form-group">
                                                <label for="total_pagar">Total a Pagar</label>
                                                <input type="text" class="form-control {!! $errors->has('total_pagar') ? 'is-invalid' : '' !!}" readonly id="total_pagar" name="total_pagar" placeholder="Total a Pagar..." value="{{ old('total_pagar') }}" {{ $errors->has('total_pagar') ? 'aria-describedby="total_pagar-error" aria-invalid="true"' : '' }}>
                                                @if( $errors->has('total_pagar') )
                                                    <div id="total_pagar-error" class="invalid-feedback animated fadeIn">{{ $errors->first('total_pagar') }}</div>
                                                @endif
                                            </div>

                                            <div class="form-group">
                                                <label for="concepto">Concepto</label>
                                                <input type="text" class="form-control {!! $errors->has('concepto') ? 'is-invalid' : '' !!}" id="concepto" name="concepto" placeholder="Concepto..." value="{{ old('concepto') }}" {{ $errors->has('concepto') ? 'aria-describedby="concepto-error" aria-invalid="true"' : '' }}>
                                                @if( $errors->has('concepto') )
                                                    <div id="concepto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('concepto') }}</div>
                                                @endif
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


<!-- Pop In Block Modal -->
{{--<div class="modal fade" id="agregarProducto" tabindex="-1" role="dialog" aria-labelledby="agregarProducto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

            <form action="#" method="POST" id="agregarProductoForm">

                <div class="block block-themed block-transparent mb-0">
                    <div class="block-header bg-primary-dark">
                        <h3 class="block-title">Producto</h3>
                        <div class="block-options">
                            <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                                <i class="fa fa-fw fa-times"></i>
                            </button>
                        </div>
                    </div>

                    <div class="block-content">

                        <div class="form-group">
                            <label for="total_pagar">Total a Pagar</label>
                            <input type="text" class="form-control {!! $errors->has('total_pagar') ? 'is-invalid' : '' !!}" readonly id="total_pagar" name="total_pagar" placeholder="Total a Pagar..." value="{{ old('total_pagar') }}" {{ $errors->has('total_pagar') ? 'aria-describedby="total_pagar-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('total_pagar') )
                                <div id="total_pagar-error" class="invalid-feedback animated fadeIn">{{ $errors->first('total_pagar') }}</div>
                            @endif
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
</div>--}}

@endsection