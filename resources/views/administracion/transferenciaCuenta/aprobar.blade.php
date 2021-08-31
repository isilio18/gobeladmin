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
  .retencion{
    display: none;
    
  }
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
    $(function () {
    

$("#banco_debito").change(function () {
         
$("#banco_debito option:selected").each(function () {
banco=$(this).val(); 
$("#saldo_disponible").val(0);
$.post("{{ URL::to('administracion/transferenciaCuenta/cuentaBancaria') }}", {banco: banco,_token: '{{ csrf_token() }}' }, function(data){
                 $("#cuenta_bancaria_debito").html('<option value="0" data-mo_disponible="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#cuenta_bancaria_debito").append('<option value="' + f.id + '" data-mo_disponible="' + f.mo_disponible + '">' + f.nu_cuenta_bancaria+' - ' + f.de_cuenta_bancaria+'</option>');
                    });
                    $('select').formSelect();
                
               });
});
        });
             
$("#banco_credito").change(function () {
         
$("#banco_credito option:selected").each(function () {
banco=$(this).val();  
$("#saldo").val(0);
$.post("{{ URL::to('administracion/transferenciaCuenta/cuentaBancaria') }}", {banco: banco,_token: '{{ csrf_token() }}' }, function(data){
                 $("#cuenta_bancaria_credito").html('<option value="0" data-mo_saldo="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#cuenta_bancaria_credito").append('<option value="' + f.id + '" data-mo_saldo="' + f.mo_disponible + '">' + f.nu_cuenta_bancaria+' - ' + f.de_cuenta_bancaria+'</option>');
                    });
                    $('select').formSelect();
                
               });
});
        });    
        
$("#cuenta_bancaria_debito").change(function () {
         
$("#cuenta_bancaria_debito option:selected").each(function () {
mo_disponible=$(this).attr('data-mo_disponible');    
$("#saldo_disponible").val(mo_disponible);
});
        });      
        
$("#cuenta_bancaria_credito").change(function () {
         
$("#cuenta_bancaria_credito option:selected").each(function () {
mo_saldo=$(this).attr('data-mo_saldo');    
$("#saldo").val(mo_saldo);
});
        });
        
if ($("#in_fondo_tercero").val()==1) 
{
$(".retencion").slideDown(500);
}         

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
        $('#avanzar').on('show.bs.modal', function (event) {
            $("#avanzarForm").attr('action','{{ url('/administracion/transferenciaCuenta/aprobar') }}');
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

                        <h2 class="content-heading pt-0">Datos de la Transferencia</h2>
                        
                        <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Cuenta Bancaria Debito</h3>
                                </div>  
                            <div class="block-content">                            

                            <div class="form-group">
                            <label for="banco_debito">Banco</label>
                            <input type="text" class="form-control {!! $errors->has('banco_debito') ? 'is-invalid' : '' !!}" readonly value="{{ $data->de_banco_debito }}">
                            </div>
                                
                            <div class="form-group">
                            <label for="cuenta_bancaria_debito">Cuenta Bancaria</label>
                            <input type="text" class="form-control {!! $errors->has('banco_debito') ? 'is-invalid' : '' !!}" readonly value="{{ $data->nu_cuenta_bancaria_debito }} - {{ $data->de_cuenta_bancaria_debito }}">
                           </div>  

                            <div class="form-group">
                                <label for="saldo_disponible">Saldo Disponible</label>
                                <input type="text" class="form-control {!! $errors->has('saldo_disponible') ? 'is-invalid' : '' !!}" readonly id="saldo_disponible" name="saldo_disponible" placeholder="Saldo disponible..." value="{{ empty(old('saldo_disponible'))? $data->saldo_disponible_debito : old('saldo_disponible') }}" {{ $errors->has('saldo_disponible') ? 'aria-describedby="saldo_disponible-error" aria-invalid="true"' : '' }}>
                            </div>  
                                
                        <div class="form-group">
                            <label for="fecha_transferencia"">Fecha Transferencia</label>        
                             <input type="text" class="form-control {!! $errors->has('fecha_transferencia') ? 'is-invalid' : '' !!}" readonly id="fecha_transferencia" name="fecha_transferencia" placeholder="Fecha Transferencia..." locale="es" data-date-format="d-m-Y" value="{{ empty(old('fecha_transferencia'))? $data->fe_transferencia : old('fecha_transferencia') }}" {{ $errors->has('fecha_transferencia') ? 'aria-describedby="fecha_transferencia-error" aria-invalid="true"' : '' }}>

                            </div>                                 
                                
                            <div class="form-group">
                                <label for="monto_transferencia">Monto Transferencia</label>
                                <input type="text" class="form-control {!! $errors->has('monto_transferencia') ? 'is-invalid' : '' !!}" readonly id="monto_transferencia" name="monto_transferencia" placeholder="Monto Transferencia..." value="{{ empty(old('monto_transferencia'))? $data->mo_transferencia : old('monto_transferencia') }}" {{ $errors->has('monto_transferencia') ? 'aria-describedby="monto_transferencia-error" aria-invalid="true"' : '' }}>
                            </div>      
                                
                        <div class="form-group">
                            <label for="tx_observacion">Observacion</label>
                            <textarea class="js-maxlength form-control {!! $errors->has('tx_observacion') ? 'is-invalid' : '' !!}" readonly id="tx_observacion" name="tx_observacion" rows="3"  maxlength="100" placeholder="Observaciones.." data-always-show="true"  {{ $errors->has('tx_observacion') ? 'aria-describedby="tx_observacion-error" aria-invalid="true"' : '' }}>{{ empty(old('tx_observacion'))? $data->tx_observacion : old('tx_observacion') }}</textarea>
                            <div class="form-text text-muted font-size-sm font-italic">Breve Observación de la Transferencia.</div>
                        </div>                                     
                                
                            </div>
                            </div>
                        
                        <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Cuenta Bancaria Credito</h3>
                                </div>  
                            <div class="block-content">                            

                            <div class="form-group">
                            <label for="banco_credito">Banco</label>
                            <input type="text" class="form-control {!! $errors->has('banco_credito') ? 'is-invalid' : '' !!}" readonly value="{{ $data->de_banco_credito }}">
   
                            </div>
                                
                            <div class="form-group">
                            <label for="cuenta_bancaria_credito">Cuenta Bancaria</label>
                            <input type="text" class="form-control {!! $errors->has('cuenta_bancaria_credito') ? 'is-invalid' : '' !!}" readonly value="{{ $data->nu_cuenta_bancaria_credito }} - {{ $data->de_cuenta_bancaria_credito }}">
                           </div>  

                            <div class="form-group">
                                <label for="saldo">Saldo</label>
                                <input type="text" class="form-control {!! $errors->has('saldo') ? 'is-invalid' : '' !!}" readonly id="saldo" name="saldo" placeholder="Saldo..." value="{{ empty(old('saldo'))? $data->saldo_disponible_credito : old('saldo') }}" {{ $errors->has('saldo') ? 'aria-describedby="saldo-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('saldo') )
                                    <div id="saldo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('saldo') }}</div>
                                @endif
                            </div>  
                            
                            <input type="hidden" id="in_fondo_tercero" name="in_fondo_tercero" value="{{ $data->id_tab_retencion>0? 1 : old('in_fondo_tercero') }}"">                                
                                
                            <div class="form-group retencion">
                            <label for="id_tab_retencion">Fondo Tercero</label>
                                <input type="text" class="form-control {!! $errors->has('id_tab_retencion') ? 'is-invalid' : '' !!}" readonly id="id_tab_retencion" name="id_tab_retencion" placeholder="Fondo Tercero..." value="{{ empty(old('id_tab_retencion'))? $data->de_retencion : old('id_tab_retencion') }}" {{ $errors->has('id_tab_retencion') ? 'aria-describedby="id_tab_retencion-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('id_tab_retencion') )
                                    <div id="id_tab_retencion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('id_tab_retencion') }}</div>
                                @endif
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
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" title="Enviar Tramite" data-target="#avanzar" data-item_id="{{ $data->id }}" >
                    <i class="fa fa-vote-yea"></i>Aprobar
                </button>                    
                </div>
            </div>
        </div>
    </div>
    <!-- END New Post -->
</div>

<!-- END Page Content -->
@endsection