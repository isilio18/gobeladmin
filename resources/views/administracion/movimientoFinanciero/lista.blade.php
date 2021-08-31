@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">    
<link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/dropzone/dist/min/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
<style type="text/css">
#picker-container .flatpickr-calendar {
  top: 60px !important;
  left: 0 !important;
};
 </style>
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
<script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/pwstrength-bootstrap/pwstrength-bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script>jQuery(function(){ Dashmix.helpers(['flatpickr', 'datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs', 'pw-strength']); });</script>
<script type="text/javascript">
$('#modal-movimiento').on('show.bs.modal', function (e) {
  var taskFlatpickrConfig = {
      appendTo: document.getElementById('picker-container')
  };

	var fe_transaccion = flatpickr("#fe_transaccion", taskFlatpickrConfig);
});
    $(function () {
    

$("#banco").change(function () {
         
$("#banco option:selected").each(function () {
banco=$(this).val();    
$.post("{{ URL::to('administracion/movimientoFinanciero/cuentaBancaria') }}", {banco: banco,_token: '{{ csrf_token() }}' }, function(data){
                 $("#cuenta_bancaria").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#cuenta_bancaria").append('<option value="' + f.id + '">' + f.nu_cuenta_bancaria+' - ' + f.de_cuenta_bancaria+'</option>');
                    });
                    $('select').formSelect();
                
               });
});
        });
        
$("#tipo_documento").change(function () {
         
$("#tipo_documento option:selected").each(function () {
tipo_documento=$(this).val();    
$.post("{{ URL::to('administracion/movimientoFinanciero/subtipoDocumento') }}", {tipo_documento: tipo_documento,_token: '{{ csrf_token() }}' }, function(data){
                 $("#subtipo_documento").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#subtipo_documento").append('<option value="' + f.id + '">' + f.nu_subtipo_documento_financiero+' - ' + f.de_subtipo_documento_financiero+'</option>');
                    });
                    $('select').formSelect();
                
               });
});
        });        

    });
</script>
    <!-- Page JS Code -->
    <script>
        $('.pagination').addClass('justify-content-end');
        $('.pagination li').addClass('page-item');
        $('.pagination li a').addClass('page-link');
        $('.pagination span').addClass('page-link');
    </script>

    <script>
        $('#borrar').on('show.bs.modal', function (event) {
            $("#borrarForm").attr('action','{{ url('/administracion/movimientoFinanciero/eliminar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
    });
    </script>
    @if (count($errors) > 0)
        @if (session()->has('msg_alerta'))
        <script>
            jQuery('#modal-movimiento').modal('show');
        </script>
        @endif
    @endif
@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
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
            <div class="block-options">
            <div class="btn-group btn-group-sm pr-2">
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-movimiento" title="Agregar Movimiento" href="javascript:void(0)">
                    <i class="fa fa-fw fa-search-plus"></i> Agregar
                </button>
            </div>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                    <i class="si si-refresh"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            
        <form action="{{ URL::to('proceso/ruta/lista').'/'.$solicitud }}" method="get">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <label>
                        <select name="perPage" class="custom-select" value="{{ $perPage }}">
                            @foreach(['5','10','20'] as $page)
                            <option @if($page == $perPage) selected @endif value="{{ $page }}">{{ $page }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="q" name="q" value="{{ $q }}" placeholder="Buscar...">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text">
                                <i class="fa fa-fw fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
        
            <table class="table table-bordered table-striped table-vcenter">
                <thead class="thead-light">
                    <tr>
                        <!--   <th class="text-center" style="width: 100px;">ID</th> -->
                        <th>Nro. Documento</th>
                        <th>Banco</th>
                        <th>Cuenta Bancaria</th>
                        <th>Fecha</th>
                        <th>Nro. Transaccion</th>
                        <th>Monto</th>
                        <th>Descripcion</th>
                        <th class="d-none d-md-table-cell text-center" style="width: 100px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tab_movimiento_financiero as $key => $value)
                    <tr>
                        <!--  <td class="font-w600">{{ $value->id }}</td> -->
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->nu_documento }}</em></td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->de_banco }}</em></td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->nu_cuenta_bancaria }} - {{ $value->de_cuenta_bancaria }}</em></td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->fe_transaccion }}</em></td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->nu_transaccion }}</em></td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->mo_transaccion }}</em></td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->de_movimiento }}</em></td>
                        <td class="text-center">
                            <div class="btn-group">
                             @if ($value->in_activo == true)                                
                                <a href="{{ url('/administracion/movimientoFinanciero/anular').'/'. $value->id }}">
                                    <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Anular">
                                        <i class="fa fa-search-minus"></i>
                                    </button>
                                </a>
                             @endif
                                <!--
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" title="Borrar" data-target="#borrar" data-item_id="{{ $value->id }}" >
                                    <i class="fa fa-times"></i>
                                </button>
                                -->
                            </div>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $tab_movimiento_financiero->appends(Request::only(['perPage','q']))->render() }}         

        </div>
    </div>
    <!-- END Partial Table -->
</div>
<!-- END Page Content -->
<!-- Pop In Block Modal -->
<div class="modal fade" id="modal-movimiento" tabindex="-1" role="dialog" aria-labelledby="modal-movimiento" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

        <form action="{{ URL::to('administracion/movimientoFinanciero/guardar') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="solicitud" value="{{ $solicitud }}">
            <input type="hidden" name="ruta" value="{{ $ruta }}">

            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Transcripcion de Movimiento Financiero</h3>
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
                            <label for="numero_transaccion" class="col-12">Nro. Transaccion</label>
                            <div class="col-6">
                                <input type="text" class="form-control {!! $errors->has('numero_transaccion') ? 'is-invalid' : '' !!}" id="numero_transaccion" name="numero_transaccion" placeholder="numero transaccion..." value="{{ old('numero_transaccion') }}" {{ $errors->has('numero_transaccion') ? 'aria-describedby="numero_transaccion-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('numero_transaccion') )
                                    <div id="numero_transaccion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('numero_transaccion') }}</div>
                                @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="fe_transaccion" class="col-12">Fecha Transaccion</label>
                            <div class="col-6">           
                                <div id="picker-container"> 
                             <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fe_transaccion') ? 'is-invalid' : '' !!}" id="fe_transaccion" name="fe_transaccion" placeholder="Fecha Transaccion..." locale="es" data-date-format="d-m-Y" value="{{ old('fe_transaccion') }}" {{ $errors->has('fe_transaccion') ? 'aria-describedby="fe_transaccion-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('fe_transaccion') )
                                <div id="fe_transaccion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fe_transaccion') }}</div>
                            @endif
                        </div>    
                                </div>
                            </div> 
                        
                        <div class="form-group">
                            <label for="monto" class="col-12">Monto</label>
                            <div class="col-6">
                                <input type="text" class="form-control {!! $errors->has('monto') ? 'is-invalid' : '' !!}" id="monto" name="monto" placeholder="Monto ..." value="{{ old('monto') }}" {{ $errors->has('monto') ? 'aria-describedby="monto-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('monto') )
                                    <div id="monto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto') }}</div>
                                @endif
                            </div>
                        </div>      
                        
                            <div class="form-group">
                            <label for="tipo_movimiento" class="col-12">Tipo Movimiento</label>
                            <div class="col-10">
                            <select class="custom-select {!! $errors->has('tipo_movimiento') ? 'is-invalid' : '' !!}" name="tipo_movimiento" id="tipo_movimiento" {{ $errors->has('tipo_movimiento') ? 'aria-describedby="tipo_movimiento-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_tipo_movimiento_financiero as $tipo_movimiento)
                                <option value="{{ $tipo_movimiento->id }}" {{ $tipo_movimiento->id == old('tipo_movimiento') ? 'selected' : '' }}>{{ $tipo_movimiento->nu_tipo_movimiento }} - {{ $tipo_movimiento->de_tipo_movimiento }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_movimiento') )
                                <div id="tipo_movimiento-error" class="invalid-feedback animated fadeIn">El campo tipo movimiento es obligatorio</div>
                            @endif
                           </div>    
                            </div>               
                        
                            <div class="form-group">
                            <label for="tipo_documento" class="col-12">Tipo Documento</label>
                            <div class="col-10">
                            <select class="custom-select {!! $errors->has('tipo_documento') ? 'is-invalid' : '' !!}" name="tipo_documento" id="tipo_documento" {{ $errors->has('tipo_documento') ? 'aria-describedby="tipo_documento-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_tipo_documento_financiero as $tipo_documento)
                                <option value="{{ $tipo_documento->id }}" {{ $tipo_documento->id == old('tipo_documento') ? 'selected' : '' }}>{{ $tipo_documento->nu_tipo_documento_financiero }} - {{ $tipo_documento->de_tipo_documento_financiero }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_documento') )
                                <div id="tipo_documento-error" class="invalid-feedback animated fadeIn">El campo tipo documento es obligatorio</div>
                            @endif
                           </div>    
                            </div>  
                        
                            <div class="form-group">
                            <label for="subtipo_documento" class="col-12">Sub-Tipo Documento</label>
                            <div class="col-10">
                            <select class="custom-select {!! $errors->has('subtipo_documento') ? 'is-invalid' : '' !!}" name="subtipo_documento" id="subtipo_documento" {{ $errors->has('subtipo_documento') ? 'aria-describedby="subtipo_documento-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                            </select>
                            @if( $errors->has('subtipo_documento') )
                                <div id="subtipo_documento-error" class="invalid-feedback animated fadeIn">El campo sub-tipo documento es obligatorio</div>
                            @endif
                           </div>   
                           </div>    
                        
                        <div class="form-group">
                            <label for="descripcion" class="col-12">Descripcion</label>
                            <div class="col-10">
                            <textarea class="js-maxlength form-control {!! $errors->has('descripcion') ? 'is-invalid' : '' !!}" id="descripcion" name="descripcion" rows="3"  maxlength="100" placeholder="Descripcion.." data-always-show="true" {{ $errors->has('descripcion') ? 'aria-describedby="descripcion-error" aria-invalid="true"' : '' }}>{{ old('descripcion') }}</textarea>
                            <div class="form-text text-muted font-size-sm font-italic">Breve Descripcion del Movimiento Financiero.</div>
                            @if( $errors->has('descripcion') )
                                <div id="descripcion-error" class="invalid-feedback animated fadeIn">El campo descripcion es obligatorio</div>
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