@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->
    {{--<link rel="stylesheet" id="css-main" href="{{ asset('css/bootstrap-select.min.css') }}">--}}
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
    {{--<script src="{{ asset('js/bootstrap-select.min.js') }}"></script>--}}
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <!-- Page JS Code -->

    <script>
        $('#borrar').on('show.bs.modal', function (event) {
            $("#borrarForm").attr('action','{{ url('/solicitud/compra/requisicion/detalle/'.$id.'/borrar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
        });

        jQuery(function(){ Dashmix.helpers([ 'select2']); });

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
    <form action="{{ URL::to('solicitud/compra/requisicion/guardar') }}" method="POST">
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

                        <h2 class="content-heading pt-0">Datos de la Requisicion</h2>

                        <div class="form-group">
                            <label for="ejecutor">Unidad Solicitante</label>
                            <select class="custom-select {!! $errors->has('ejecutor') ? 'is-invalid' : '' !!}" name="ejecutor" id="ejecutor" {{ $errors->has('ejecutor') ? 'aria-describedby="ejecutor-error" aria-invalid="true"' : '' }}>
                                @foreach($tab_ejecutor as $ejecutor)
                                    <option value="{{ $ejecutor->id }}" {{ $ejecutor->id == old('ejecutor') ? 'selected' : '' }}>{{ $ejecutor->nu_ejecutor }} - {{ $ejecutor->de_ejecutor }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('ejecutor') )
                                <div id="ejecutor-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ejecutor') }}</div>
                            @endif
                        </div>

                        <div class="form-group">
                            <label for="concepto">Concepto</label>
                            <input type="text" class="form-control {!! $errors->has('concepto') ? 'is-invalid' : '' !!}" id="concepto" name="concepto" placeholder="Concepto..." value="{{ old('concepto') }}" {{ $errors->has('concepto') ? 'aria-describedby="concepto-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('concepto') )
                                <div id="concepto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('concepto') }}</div>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="observacion">Observaciones</label>
                            <textarea class="form-control {!! $errors->has('observacion') ? 'is-invalid' : '' !!}" id="observacion" name="observacion" rows="3" placeholder="Observaciones.." {{ $errors->has('observacion') ? 'aria-describedby="observacion-error" aria-invalid="true"' : '' }}>{{ old('observacion') }}</textarea>
                            <div class="form-text text-muted font-size-sm font-italic">Breve Observación de la Requisicion.</div>
                            @if( $errors->has('observacion') )
                                <div id="observacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('observacion') }}</div>
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
                                        <th>Producto</th>
                                        <th class="font-w600 text-center">Cantidad</th>
                                        <th class="font-w600 text-center">Unidad de Medida</th>
                                        <th class="font-w600 text-center">Especificaciones</th>
                                        <th class="font-w600 text-center">Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($tab_requisicion_detalle as $key => $value)
                                    <tr>
                                        <td class="d-none d-sm-table-cell">{{ $value->nu_producto }} - {{ $value->de_producto }}</td>
                                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->nu_cantidad }}</em></td>
                                        <td class="d-none d-sm-table-cell">{{ $value->de_unidad_medida }}</td>
                                        <td class="d-none d-sm-table-cell">{{ $value->de_especificacion }}</td>
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

        <form action="{{ URL::to('solicitud/compra/requisicion/detalle/guardar') }}" method="POST">
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
                                    @foreach($tab_producto as $producto)
                                        <option value="{{ $producto->id }}" {{ $producto->id == old('producto') ? 'selected' : '' }}>{{ $producto->nu_producto }} - {{ $producto->de_producto }}</option>
                                    @endforeach
                                </select>
                                @if( $errors->has('producto') )
                                    <div id="producto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('producto') }}</div>
                                @endif
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
                            <label for="unidad" class="col-12">Unidad de Medida</label>
                            <div class="col-12">
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
                                <textarea class="form-control {!! $errors->has('especificacion') ? 'is-invalid' : '' !!}" id="especificacion" name="especificacion" rows="3" placeholder="Especificacion.." {{ $errors->has('especificacion') ? 'aria-describedby="especificacion-error" aria-invalid="true"' : '' }}>{{ old('especificacion') }}</textarea>
                                <div class="form-text text-muted font-size-sm font-italic">Datos del Materiales / Bienes / Servicio Seleccionado.</div>
                                @if( $errors->has('especificacion') )
                                    <div id="especificacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('especificacion') }}</div>
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