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
    <form action="{{ URL::to('administracion/ordenPago/guardar') }}" method="POST">
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

                        <h2 class="content-heading pt-0">Orden de Pago Nº {{ $data->nu_orden_pago }}</h2>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Datos de la orden de pago</h3><div id="resultado"></div>
                                </div>
                                <div class="block-content">

                                    <div class="form-group form-row">
                                        <div class="col-4">
                                            <label for="fecha_pago">Fecha de Pago</label>
                                            <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fecha_pago') ? 'is-invalid' : '' !!}" id="fecha_pago" name="fecha_pago" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_pago'))? $data->fe_pago : old('fecha_pago') }}" {{ $errors->has('fecha_pago') ? 'aria-describedby="fecha_compra-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_pago') )
                                                <div id="fecha_pago-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_pago') }}</div>
                                            @endif
                                        </div>
                                    </div>                                    
                                    
                                <div class="form-group">
                                    <label for="tx_concepto">Concepto</label>
                                    <textarea class="js-maxlength form-control {!! $errors->has('tx_concepto') ? 'is-invalid' : '' !!}" id="tx_concepto" name="tx_concepto" rows="3"  maxlength="100" placeholder="Concepto.." data-always-show="true" {{ $errors->has('tx_concepto') ? 'aria-describedby="tx_concepto-error" aria-invalid="true"' : '' }}>{{ empty(old('tx_concepto'))? $data->de_concepto_pago : old('tx_concepto') }}</textarea>
                                    <div class="form-text text-muted font-size-sm font-italic">Breve concepto de la orden de pago.</div>
                                    @if( $errors->has('tx_concepto') )
                                        <div id="tx_concepto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tx_concepto') }}</div>
                                    @endif
                                </div>  
                                    
                                    <div class="form-group">
                                        <label for="tipo_orden_pago">Tipo</label>
                                        <select class="custom-select {!! $errors->has('tipo_orden_pago') ? 'is-invalid' : '' !!}" name="tipo_orden_pago" id="tipo_orden_pago" {{ $errors->has('tipo_orden_pago') ? 'aria-describedby="tipo_orden_pago-error" aria-invalid="true"' : '' }}>
                                            <option value="" >Seleccione...</option>
                                            @foreach($tab_tipo_orden_pago as $tipo_orden_pago)
                                                <option value="{{ $tipo_orden_pago->id }}" {{ $tipo_orden_pago->id == $data->id_tab_tipo_orden_pago ? 'selected' : '' }}>{{ $tipo_orden_pago->de_tipo_orden_pago }}</option>
                                            @endforeach
                                        </select>
                                        @if( $errors->has('tipo_orden_pago') )
                                            <div id="tipo_orden_pago-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_orden_pago') }}</div>
                                        @endif
                                    </div>     
                                    
                                    <div class="form-group">
                                        <label for="monto">Monto</label>
                                        <input type="text" class="form-control {!! $errors->has('monto') ? 'is-invalid' : '' !!}" readonly id="monto" name="monto" placeholder="Monto..." value="{{ empty(old('monto'))? $data->mo_pago : old('monto') }}" {{ $errors->has('monto') ? 'aria-describedby="monto-error" aria-invalid="true"' : '' }}>
                                    </div>                                    

                                </div>

                            </div>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Detalle del concepto </h3>
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
                                                </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($tab_asignar_partida as $key => $value)
                                                <tr>
                                                    <td class="d-none d-sm-table-cell">{{ $value->de_concepto }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->co_partida }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->de_partida }}</td>
                                                    <td class="d-none d-sm-table-cell">{{ $value->mo_presupuesto }}</td>
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
                        <i class="fa fa-fw fa-save mr-1"></i> Generar
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