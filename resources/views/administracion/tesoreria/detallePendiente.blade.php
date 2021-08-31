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
        $('#pagar').on('show.bs.modal', function (event) {
            $("#pagarForm").attr('action','{{ url('/administracion/tesoreria/guardar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var monto_pendiente = button.data('monto_pendiente');
            var monto_pagado = button.data('monto_pagado');
            var modal = $(this);
            modal.find('.modal-content #id_tab_liquidacion').val(item_id);
            modal.find('.modal-content #monto_pendiente').val(monto_pendiente);
            modal.find('.modal-content #monto_pagado').val(monto_pagado);



            @if( !empty( old('banco')) )

  
            $.post("{{ URL::to('administracion/movimientoFinanciero/cuentaBancaria') }}", {banco: {{  old('banco') }},_token: '{{ csrf_token() }}' }, function(data){
                 $("#cuenta_bancaria").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#cuenta_bancaria").append('<option value="' + f.id + '" {{ ' + f.id + ' == old("cuenta_bancaria")?"":"selected" }}>' + f.nu_cuenta_bancaria+' - ' + f.de_cuenta_bancaria+'</option>');
                    });
                
               });

            @endif          


        });   
            
        
$("#banco").change(function () {
         
$("#banco option:selected").each(function () {
banco=$(this).val();    
$.post("{{ URL::to('administracion/movimientoFinanciero/cuentaBancaria') }}", {banco: banco,_token: '{{ csrf_token() }}' }, function(data){
                 $("#cuenta_bancaria").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#cuenta_bancaria").append('<option value="' + f.id + '">' + f.nu_cuenta_bancaria+' - ' + f.de_cuenta_bancaria+'</option>');
                    });
                
               });
});
        });

        jQuery(function(){ Dashmix.helpers([ 'flatpickr', 'select2','table-tools-checkable']); });

    </script>
    @if (count($errors) > 0)
        @if (session()->has('msg_alerta'))
        <script>
            jQuery('#pagar').modal('show');
            $("#pagar").find('input[name="id_tab_liquidacion"]').val("{{old('id_tab_liquidacion')}}");
            $("#pagar").find('input[name="monto_pendiente"]').val("{{old('monto_pendiente')}}");
            $("#pagar").find('input[name="monto_pagado"]').val("{{old('monto_pagado')}}");
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
    <form action="{{ URL::to('administracion/tesoreria/guardar') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="solicitud" value="{{ $id }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('administracion/tesoreria/pendiente') }}">
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

                        <!--<h2 class="content-heading pt-0">Pagos</h2>-->



                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Pagos</h3>
                                </div>
                                <div class="block-content">
                                                                       
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-animated-slideup-pendiente">Pagos Pendientes</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideup-realizado">Pagos Realizados</a>
                    </li>      
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-pendiente" role="tabpanel">       
                   
                      <input type="hidden" id="id_liquidacion" name="id_liquidacion" value="">

            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Nº</th>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Fecha Emisión</th>
                        <th>Monto a Pagar </th>
                        <th>Monto Pagado </th>
                        <th class="font-w600 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tab_liquidacion as $key => $value)
                    <tr>
                        <td class="font-w600">{{ $value->nu_liquidacion }}</td>
                        <td class="font-w600">{{ $value->fe_pago }}</td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->mo_pago }}</em></td>
                        <td class="font-w600">{{ $value->mo_pagado }}</td>
                        <td class="text-center">
                            <div class="btn-group">
                            <button type="button" class="btn btn-primary" id="pago" data-toggle="modal" title="Presione para Pagar" data-target="#pagar" data-item_id="{{ $value->id }}" data-monto_pendiente="{{ $value->mo_pendiente }}" data-monto_pagado="{{ $value->mo_pagado }}">
                                <i class="fa fa-fw fa-money-bill-alt"></i> Pagar
                            </button>  
                            </div>
                        </td>
                    </tr>
                @endforeach                       
                </tbody>
                    </table>                        
 

                    </div>
                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-realizado" role="tabpanel">

            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Nº transacción</th>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Banco</th>
                        <th>Cuenta Bancaria</th>
                        <th>Fecha </th>
                        <th>Monto</th>
                        <th class="font-w600 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tab_pago as $key => $value)
                    <tr>
                        <td class="font-w600">{{ $value->nu_pago }}</td>
                        <td class="font-w600">{{ $value->de_banco }}</td>
                        <td class="font-w600">{{ $value->nu_cuenta_bancaria }}-{{ $value->de_cuenta_bancaria }}</td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->fe_pago }}</em></td>
                        <td class="font-w600">{{ $value->mo_pago }}</td>
                        <td class="text-center">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver Documento" onclick="window.open('{{ url('/proceso/reporte/ver').'/'. $value->id }}/' + (new Date().getTime()), '_blank')">
                            <i class="fa fa-print"></i>
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
            </div>
        </div>

    </form>
    </div>
    <!-- END New Post -->
</div>
<!-- END Page Content -->

<!-- Pop In Block Modal -->
<div class="modal fade" id="pagar" tabindex="-1" role="dialog" aria-labelledby="pagar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

        <form action="{{ URL::to('administracion/tesoreria/guardar') }}" method="POST" id="pagarForm">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="solicitud" value="{{ $id }}">
            <input type="hidden" name="id_tab_liquidacion" id="id_tab_liquidacion" value="{{ old('id_tab_liquidacion') }}">            
            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Tesoreria</h3>
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
                            
                        @if( $errors->has('de_alert_form') )  
                        <script>
                            jQuery(function(){ Dashmix.helpers('notify', {type: 'danger', icon: 'fa fa-times-circle mr-1', align: 'center', message: 'Hay problemas con su validacion!'}); });
                        </script>                        
                        <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                        <div class="flex-fill mr-3">
                            <p class="mb-0">{{ $errors->first('de_alert_form') }}</p>
                        </div>
                    </div>
                        @endif                            

                            <div class="block block-themed block-rounded block-bordered">
                                    <div class="block-header bg-primary border-bottom">
                                        <h3 class="block-title">Datos del Pago</h3>
                                    </div>
                                    <div class="block-content">
                                        
                        <div class="form-group">
                            <label for="numero_solicitud" class="col-12">Nº Solicitud</label>
                            <div class="col-6">
                            <input type="text" class="form-control {!! $errors->has('numero_solicitud') ? 'is-invalid' : '' !!}" readonly id="numero_solicitud" name="numero_solicitud"  value="{{ $tab_solicitud->nu_solicitud }}">
                        </div>                                         
                        </div>                                        

                        <div class="form-group">
                            <label for="fe_pago" class="col-12">Fecha de Pago</label>
                            <div class="col-6">           
                             <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fe_pago') ? 'is-invalid' : '' !!}" id="fe_transaccion" name="fe_pago" placeholder="Fecha de Pago..." locale="es" data-date-format="d-m-Y" value="{{ old('fe_pago') }}" {{ $errors->has('fe_pago') ? 'aria-describedby="fe_pago-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('fe_pago') )
                                <div id="fe_pago-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fe_pago') }}</div>
                            @endif   
                                </div>
                            </div> 
                                        
                            <div class="form-group">
                            <label for="forma_pago" class="col-12">Forma de Pago</label>
                            <div class="col-10">
                            <select class="custom-select {!! $errors->has('forma_pago') ? 'is-invalid' : '' !!}" name="forma_pago" id="forma_pago" {{ $errors->has('forma_pago') ? 'aria-describedby="forma_pago-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_forma_pago as $forma_pago)
                                <option value="{{ $forma_pago->id }}" {{ $forma_pago->id == old('forma_pago') ? 'selected' : '' }}>{{ $forma_pago->de_forma_pago }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('forma_pago') )
                                <div id="forma_pago-error" class="invalid-feedback animated fadeIn">El campo forma de pago es obligatorio</div>
                            @endif
                           </div> 
                            </div>

                            <div class="form-group">
                            <label for="banco" class="col-12">Banco</label>
                            <div class="col-10">
                            <select class="custom-select {!! $errors->has('banco') ? 'is-invalid' : '' !!}" name="banco" id="banco" {{ $errors->has('banco') ? 'aria-describedby="banco-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_banco as $banco)
                                <option value="{{ $banco->id }}" {{ $banco->id == old('banco') ? 'selected' : '' }}>{{ $banco->de_banco }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('banco') )
                                <div id="banco-error" class="invalid-feedback animated fadeIn">El campo banco es obligatorio</div>
                            @endif
                           </div> 
                            </div>

                            <div class="form-group">
                            <label for="cuenta_bancaria" class="col-12">Cuenta Bancaria</label>
                            <div class="col-10">
                            <select class="custom-select {!! $errors->has('cuenta_bancaria') ? 'is-invalid' : '' !!}" name="cuenta_bancaria" id="cuenta_bancaria" {{ $errors->has('cuenta_bancaria') ? 'aria-describedby="cuenta_bancaria-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                            </select>
                            @if( $errors->has('cuenta_bancaria') )
                                <div id="cuenta_bancaria-error" class="invalid-feedback animated fadeIn">El campo cuenta bancaria es obligatorio</div>
                            @endif
                           </div> 
                            </div>
                                        
                        <div class="form-group">
                            <label for="monto" class="col-12">Monto a Pagar</label>
                            <div class="col-6">
                                <input type="text" class="form-control {!! $errors->has('monto') ? 'is-invalid' : '' !!}" id="monto" name="monto" placeholder="Monto ..." value="{{ old('monto') }}" {{ $errors->has('monto') ? 'aria-describedby="monto-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('monto') )
                                    <div id="monto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto') }}</div>
                                @endif
                            </div>
                        </div>
                                 
                        <div class="form-group">
                            <label for="numero_transaccion" class="col-12">Nro. Transaccion</label>
                            <div class="col-6">
                                <input type="text" class="form-control {!! $errors->has('numero_transaccion') ? 'is-invalid' : '' !!}" id="numero_transaccion" name="numero_transaccion" placeholder="numero transaccion..." value="{{ old('numero_transaccion') }}" {{ $errors->has('numero_transaccion') ? 'aria-describedby="numero_transaccion-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('numero_transaccion') )
                                    <div id="numero_transaccion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('numero_transaccion') }}</div>
                                @endif
                            </div>
                        </div>

                                    <div class="form-group">
                                        <label for="monto_pendiente" class="col-12">Monto Pendiente</label>
                                        <div class="col-6">
                                        <input type="text" class="form-control {!! $errors->has('monto_pendiente') ? 'is-invalid' : '' !!}" readonly id="monto_pendiente" name="monto_pendiente"  value="{{ old('monto_pendiente') }}">
                                    </div> 
                                    </div>
                                        
                                    <div class="form-group">
                                        <label for="monto_pagado" class="col-12">Monto Pagado</label>
                                        <div class="col-6">
                                        <input type="text" class="form-control {!! $errors->has('monto_pagado') ? 'is-invalid' : '' !!}" readonly id="monto_pagado" name="monto_pagado"  value="{{ old('monto_pagado') }}" {{ $errors->has('monto_pagado') ? 'aria-describedby="monto_pagado-error" aria-invalid="true"' : '' }}>
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
                        <i class="fa far fa-money-bill-alt mr-1"></i> Pagar
                    </button>
                </div>
            </div>

        </form>
        
        </div>
    </div>
</div>
<!-- END Pop In Block Modal -->
@endsection