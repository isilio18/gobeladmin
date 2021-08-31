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
$.post("{{ URL::to('administracion/transferenciaCuenta/cuentaBancaria') }}", {banco: banco,_token: '{{ csrf_token() }}' }, function(data){
                 $("#cuenta_bancaria_debito").html('<option value="0" data-mo_disponible="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#cuenta_bancaria_debito").append('<option value="' + f.id + '" data-mo_disponible="' + f.mo_disponible + '">' + f.nu_cuenta_bancaria+' - ' + f.de_cuenta_bancaria+'</option>');
                    });
                
               });
});
        });
             
$("#banco_credito").change(function () {
         
$("#banco_credito option:selected").each(function () {
banco=$(this).val();    
$.post("{{ URL::to('administracion/transferenciaCuenta/cuentaBancaria') }}", {banco: banco,_token: '{{ csrf_token() }}' }, function(data){
                 $("#cuenta_bancaria_credito").html('<option value="0" data-mo_saldo="0" data-fondo_tercero="false"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#cuenta_bancaria_credito").append('<option value="' + f.id + '" data-mo_saldo="' + f.mo_disponible + '" data-fondo_tercero="' + f.in_fondo_tercero + '">' + f.nu_cuenta_bancaria+' - ' + f.de_cuenta_bancaria+'</option>');
                    });
                
               });
               
$("#id_tab_retencion").val(0);
$("#in_fondo_tercero").val(0);
$("#saldo").val(0);
$(".retencion").slideUp(500);               
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
fondo_tercero=$(this).attr('data-fondo_tercero');
$("#saldo").val(mo_saldo);
});

      if (fondo_tercero=='true') 
      {
        $(".retencion").slideDown(500);
        $("#in_fondo_tercero").val(1);
      }else{

        $(".retencion").slideUp(500);  
        $("#in_fondo_tercero").val(0);
        $("#id_tab_retencion").val(0);
        
       
      }


        });  
        
if ($("#in_fondo_tercero").val()==1) 
{
$(".retencion").slideDown(500);
} 

if ($("#banco_debito").val()>0) 
{

banco=$("#banco_debito").val();    
cuenta_bancaria_debito=$("#cuenta_bancaria_debito").val(); 
$.post("{{ URL::to('administracion/transferenciaCuenta/cuentaBancaria') }}", {banco: banco,_token: '{{ csrf_token() }}' }, function(data){
                 $("#cuenta_bancaria_debito").html('<option value="0" data-mo_disponible="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#cuenta_bancaria_debito").append('<option value="' + f.id + '" {{'+ f.id + '=='+cuenta_bancaria_debito+'?"":"selected" }} data-mo_disponible="' + f.mo_disponible + '">' + f.nu_cuenta_bancaria+' - ' + f.de_cuenta_bancaria+'</option>');
                    });
                
               });
               
} 


if ($("#banco_credito").val()>0) 
{

banco=$("#banco_credito").val();    
cuenta_bancaria_debito=$("#cuenta_bancaria_credito").val(); 
$.post("{{ URL::to('administracion/transferenciaCuenta/cuentaBancaria') }}", {banco: banco,_token: '{{ csrf_token() }}' }, function(data){
                 $("#cuenta_bancaria_credito").html('<option value="0" data-mo_disponible="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#cuenta_bancaria_credito").append('<option value="' + f.id + '" {{'+ f.id + '=='+cuenta_bancaria_debito+'?"":"selected" }} data-mo_disponible="' + f.mo_disponible + '">' + f.nu_cuenta_bancaria+' - ' + f.de_cuenta_bancaria+'</option>');
                    });
                
               });
               
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
        $('#borrar').on('show.bs.modal', function (event) {
            $("#borrarForm").attr('action','{{ url('/administracion/transferenciaCuenta/eliminar') }}');
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
    <form action="{{ URL::to('administracion/transferenciaCuenta/guardarAgregar') }}" method="POST">
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
                            <select class="custom-select {!! $errors->has('banco_debito') ? 'is-invalid' : '' !!}" name="banco_debito" id="banco_debito" {{ $errors->has('banco_debito') ? 'aria-describedby="banco_debito-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_banco as $banco)
                                <option value="{{ $banco->id }}" {{ $banco->id == old('banco_debito') ? 'selected' : '' }}>{{ $banco->de_banco }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('banco_debito') )
                                <div id="banco_debito-error" class="invalid-feedback animated fadeIn">El campo banco debito es obligatorio</div>
                            @endif
   
                            </div>
                                
                            <div class="form-group">
                            <label for="cuenta_bancaria_debito">Cuenta Bancaria</label>
                            <select class="custom-select {!! $errors->has('cuenta_bancaria_debito') ? 'is-invalid' : '' !!}" name="cuenta_bancaria_debito" id="cuenta_bancaria_debito" {{ $errors->has('cuenta_bancaria_debito') ? 'aria-describedby="cuenta_bancaria_debito-error" aria-invalid="true"' : '' }}>
                                <option value="{{ old('cuenta_bancaria_debito')?old('cuenta_bancaria_debito'):0 }}" >Seleccione...</option>
                            </select>
                            @if( $errors->has('cuenta_bancaria_debito') )
                                <div id="cuenta_bancaria_debito-error" class="invalid-feedback animated fadeIn">El campo cuenta bancaria es obligatorio</div>
                            @endif
                           </div>  

                            <div class="form-group">
                                <label for="saldo_disponible">Saldo Disponible</label>
                                <input type="text" class="form-control {!! $errors->has('saldo_disponible') ? 'is-invalid' : '' !!}" readonly id="saldo_disponible" name="saldo_disponible" placeholder="Saldo disponible..." value="{{ old('saldo_disponible') }}" {{ $errors->has('saldo_disponible') ? 'aria-describedby="saldo_disponible-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('saldo_disponible') )
                                    <div id="saldo_disponible-error" class="invalid-feedback animated fadeIn">{{ $errors->first('saldo_disponible') }}</div>
                                @endif
                            </div>  
                                
                        <div class="form-group">
                            <label for="fecha_transferencia"">Fecha Transferencia</label>        
                             <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fecha_transferencia') ? 'is-invalid' : '' !!}" id="fecha_transferencia" name="fecha_transferencia" placeholder="Fecha Transferencia..." locale="es" data-date-format="d-m-Y" value="{{ old('fecha_transferencia') }}" {{ $errors->has('fecha_transferencia') ? 'aria-describedby="fecha_transferencia-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('fecha_transferencia') )
                                <div id="fecha_transferencia-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_transferencia') }}</div>
                            @endif 
                            </div>                                 
                                
                            <div class="form-group">
                                <label for="monto_transferencia">Monto Transferencia</label>
                                <input type="text" class="form-control {!! $errors->has('monto_transferencia') ? 'is-invalid' : '' !!}" id="monto_transferencia" name="monto_transferencia" placeholder="Monto Transferencia..." value="{{ old('monto_transferencia') }}" {{ $errors->has('monto_transferencia') ? 'aria-describedby="monto_transferencia-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('monto_transferencia') )
                                    <div id="monto_transferencia-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto_transferencia') }}</div>
                                @endif
                            </div>     
                                
                        <div class="form-group">
                            <label for="tx_observacion">Observacion</label>
                            <textarea class="js-maxlength form-control {!! $errors->has('tx_observacion') ? 'is-invalid' : '' !!}" id="tx_observacion" name="tx_observacion" rows="3"  maxlength="100" placeholder="Observaciones.." data-always-show="true" {{ $errors->has('tx_observacion') ? 'aria-describedby="tx_observacion-error" aria-invalid="true"' : '' }}>{{ old('tx_observacion') }}</textarea>
                            <div class="form-text text-muted font-size-sm font-italic">Breve Observación de la Transferencia.</div>
                            @if( $errors->has('tx_observacion') )
                                <div id="tx_observacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tx_observacion') }}</div>
                            @endif
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
                            <select class="custom-select {!! $errors->has('banco_credito') ? 'is-invalid' : '' !!}" name="banco_credito" id="banco_credito" {{ $errors->has('banco_credito') ? 'aria-describedby="banco_credito-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_banco as $banco)
                                <option value="{{ $banco->id }}" {{ $banco->id == old('banco_credito') ? 'selected' : '' }}>{{ $banco->de_banco }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('banco_debito') )
                                <div id="banco_credito-error" class="invalid-feedback animated fadeIn">El campo banco credito es obligatorio</div>
                            @endif
   
                            </div>
                                
                            <div class="form-group">
                            <label for="cuenta_bancaria_credito">Cuenta Bancaria</label>
                            <select class="custom-select {!! $errors->has('cuenta_bancaria_credito') ? 'is-invalid' : '' !!}" name="cuenta_bancaria_credito" id="cuenta_bancaria_credito" {{ $errors->has('cuenta_bancaria_credito') ? 'aria-describedby="cuenta_bancaria_credito-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                            </select>
                            @if( $errors->has('cuenta_bancaria_credito') )
                                <div id="cuenta_bancaria_credito-error" class="invalid-feedback animated fadeIn">El campo cuenta bancaria es obligatorio</div>
                            @endif
                           </div>  

                            <div class="form-group">
                                <label for="saldo">Saldo</label>
                                <input type="text" class="form-control {!! $errors->has('saldo') ? 'is-invalid' : '' !!}" readonly id="saldo" name="saldo" placeholder="Saldo..." value="{{ old('saldo') }}" {{ $errors->has('saldo') ? 'aria-describedby="saldo-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('saldo') )
                                    <div id="saldo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('saldo') }}</div>
                                @endif
                            </div>  
                                
                            <input type="hidden" id="in_fondo_tercero" name="in_fondo_tercero" value="{{ old('in_fondo_tercero') }}">                                
                                
                            <div class="form-group retencion">
                            <label for="id_tab_retencion">Fondo Tercero</label>
                            <select class="custom-select {!! $errors->first('error')=='id_tab_retencion' ? 'is-invalid' : '' !!}" name="id_tab_retencion" id="id_tab_retencion" {{ $errors->first('error')=='id_tab_retencion' ? 'aria-describedby="id_tab_retencion-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_retencion as $retencion)
                                <option value="{{ $retencion->id }}" {{ $retencion->id == old('id_tab_retencion') ? 'selected' : '' }}>{{ $retencion->de_retencion }}</option>
                                @endforeach
                            </select>
                            @if( $errors->first('error')=='id_tab_retencion' )
                                <div id="id_tab_retencion-error" class="invalid-feedback animated fadeIn">El campo fondo tercero es obligatorio</div>
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
@endsection