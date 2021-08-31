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

    </script>

@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('solicitud/compra/orden/guardar') }}" method="POST">
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

                                    <div class="form-group">
                                        <label for="orden_preimpresa">Orden Pre-Impresa</label>
                                        <input type="text" class="form-control {!! $errors->has('orden_preimpresa') ? 'is-invalid' : '' !!}" readonly id="orden_preimpresa" name="orden_preimpresa" placeholder="Orden Pre-Impresa..." value="{{ empty(old('orden_preimpresa'))? $data->nu_orden_pre_impresa : old('orden_preimpresa') }}" {{ $errors->has('orden_preimpresa') ? 'aria-describedby="orden_preimpresa-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('orden_preimpresa') )
                                            <div id="orden_preimpresa-error" class="invalid-feedback animated fadeIn">{{ $errors->first('orden_preimpresa') }}</div>
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

                                    <div class="form-group">
                                        <label for="garantia">Garantia</label>
                                        <input type="text" class="form-control {!! $errors->has('garantia') ? 'is-invalid' : '' !!}" readonly id="garantia" name="garantia" placeholder="Garantia..." value="{{ empty(old('garantia'))? $data->de_garantia : old('garantia') }}" {{ $errors->has('garantia') ? 'aria-describedby="garantia-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('garantia') )
                                            <div id="garantia-error" class="invalid-feedback animated fadeIn">{{ $errors->first('garantia') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="observacion">Observacion</label>
                                        <textarea class="form-control {!! $errors->has('observacion') ? 'is-invalid' : '' !!}" readonly id="observacion" name="observacion" rows="3" placeholder="Observaciones.." {{ $errors->has('observacion') ? 'aria-describedby="observacion-error" aria-invalid="true"' : '' }}>{{ empty(old('observacion'))? $data->de_observacion : old('observacion') }}</textarea>
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
                                            <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_compra') ? 'is-invalid' : '' !!}" readonly id="fecha_compra" name="fecha_compra" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_compra'))? $data->fe_compra : old('fecha_compra') }}" {{ $errors->has('fecha_compra') ? 'aria-describedby="fecha_compra-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_compra') )
                                                <div id="fecha_compra-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_compra') }}</div>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="iva">IVA</label>
                                        <input type="text" class="form-control {!! $errors->has('iva') ? 'is-invalid' : '' !!}" readonly id="iva" name="iva" placeholder="IVA..." value="{{ empty(old('iva'))? $data->nu_iva_factura : old('iva') }}" {{ $errors->has('iva') ? 'aria-describedby="iva-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('iva') )
                                            <div id="iva-error" class="invalid-feedback animated fadeIn">{{ $errors->first('iva') }}</div>
                                        @endif
                                    </div>

                                    <div class="form-group">
                                        <label for="ejecutor_entrega">Entregar En</label>
                                        <input type="text" class="form-control {!! $errors->has('ejecutor_entrega') ? 'is-invalid' : '' !!}" readonly id="ejecutor_entrega" name="ejecutor_entrega" placeholder="Ejecutor Entrega..." value="{{ $data->nu_ejecutor }} - {{ $data->de_ejecutor }}" {{ $errors->has('ejecutor_entrega') ? 'aria-describedby="ejecutor_entrega-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('ejecutor_entrega') )
                                            <div id="ejecutor_entrega-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ejecutor_entrega') }}</div>
                                        @endif
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
                        <i class="fa fa-fw fa-print mr-1"></i> Generar Orden de Compra
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