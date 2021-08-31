@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">    
<link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/dropzone/dist/min/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">


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

$("#tab_estado").change(function () {
         
$("#tab_estado option:selected").each(function () {
estado=$(this).val();    
$.post("{{ URL::to('administracion/proveedor/municipio') }}", {estado: estado,_token: '{{ csrf_token() }}' }, function(data){
                 $("#tab_municipio").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#tab_municipio").append('<option value="' + f.id + '">' + f.de_municipio+'</option>');
                    });
                    $('select').formSelect();
                
               });
});
        });

    });
</script>
    <!-- Page JS Code -->

@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('administracion/proveedor/guardar') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="block">
            <div class="block-header block-header-default">
                
                <a class="btn btn-light" href="{{ URL::to('administracion/proveedor/lista') }}">
                    <i class="fa fa-arrow-left mr-1"></i> Volver
                </a>                 
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Proveedor</li>
                    <li class="breadcrumb-item active" aria-current="page">Nuevo</li>
                </ol>
            </nav>
        </div>              
                
                 
                {{--<div class="block-options">
                    <div class="custom-control custom-switch custom-control-success">
                        <input type="checkbox" class="custom-control-input" id="dm-post-edit-active" name="dm-post-edit-active" checked>
                        <label class="custom-control-label" for="dm-post-edit-active">Set post as active</label>
                    </div>
                </div>--}}
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



            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-animated-slideup-provedor">Proveedor</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideup-representante">Representante Legal</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideup-datos">Datos Basicos</a>
                    </li>                        
                    
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-provedor" role="tabpanel">       

                            <div class="input-group">
                                <div class="input-group-prepend">
                                    
                            <div class="form-group">
                            <label for="tipo_documento">Tipo Documento</label>
                            <select class="custom-select {!! $errors->has('tipo_documento') ? 'is-invalid' : '' !!}" name="tipo_documento" id="tipo_documento" {{ $errors->has('tipo_documento') ? 'aria-describedby="tipo_documento-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_documento as $tipo_documento)
                                <option value="{{ $tipo_documento->id }}" {{ $tipo_documento->id == old('tipo_documento') ? 'selected' : '' }}>{{ $tipo_documento->de_inicial }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_documento') )
                                <div id="tipo_documento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_documento') }}</div>
                            @endif
                           </div>

                        <div class="form-group">
                            <label for="codigo">Documento</label>
                            <input type="text" class="form-control {!! $errors->has('codigo') ? 'is-invalid' : '' !!}" id="codigo" name="codigo" placeholder="Documento..." value="{{ old('codigo') }}" {{ $errors->has('codigo') ? 'aria-describedby="codigo-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('codigo') )
                                <div id="codigo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('codigo') }}</div>
                            @endif
                        </div>                                
                                
                            </div>      
                                 </div>  
 
                        <div class="form-group">
                            <label for="descripcion">Nombre o Razon Social</label>
                            <input type="text" class="form-control {!! $errors->has('descripcion') ? 'is-invalid' : '' !!}" id="descripcion" name="descripcion" placeholder="Descripcion..." value="{{ old('descripcion') }}" {{ $errors->has('descripcion') ? 'aria-describedby="descripcion-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('descripcion') )
                                <div id="descripcion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('descripcion') }}</div>
                            @endif
                        </div>          
                        
                        <div class="form-group">
                            <label for="siglas">Siglas</label>
                            <input type="text" class="form-control {!! $errors->has('siglas') ? 'is-invalid' : '' !!}" id="siglas" name="siglas" placeholder="Siglas..." value="{{ old('siglas') }}" {{ $errors->has('siglas') ? 'aria-describedby="siglas-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('siglas') )
                                <div id="siglas-error" class="invalid-feedback animated fadeIn">{{ $errors->first('siglas') }}</div>
                            @endif
                        </div>     
                        
                        <div class="form-group">
                            <label for="direccion">Direccion</label>
                            <input type="text" class="form-control {!! $errors->has('direccion') ? 'is-invalid' : '' !!}" id="direccion" name="direccion" placeholder="Direccion..." value="{{ old('direccion') }}" {{ $errors->has('direccion') ? 'aria-describedby="direccion-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('siglas') )
                                <div id="direccion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('direccion') }}</div>
                            @endif
                        </div>                         
                    
                        <div class="form-group">
                            <label for="email">Correo</label>
                            <input type="text" class="form-control {!! $errors->has('email') ? 'is-invalid' : '' !!}" id="email" name="email" placeholder="Correo..." value="{{ old('email') }}" {{ $errors->has('email') ? 'aria-describedby="email-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('email') )
                                <div id="email-error" class="invalid-feedback animated fadeIn">{{ $errors->first('email') }}</div>
                            @endif
                        </div>      
                        
                        <div class="form-group">
                            <label for="web">Pagina Web</label>
                            <input type="text" class="form-control {!! $errors->has('web') ? 'is-invalid' : '' !!}" id="web" name="web" placeholder="Web..." value="{{ old('web') }}" {{ $errors->has('web') ? 'aria-describedby="web-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('email') )
                                <div id="web-error" class="invalid-feedback animated fadeIn">{{ $errors->first('web') }}</div>
                            @endif
                        </div>          
                        
                        <div class="form-group">
                            <label for="fe_registro">Fecha Registro</label>
                             <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fe_registro') ? 'is-invalid' : '' !!}" id="fe_registro" name="fe_registro" placeholder="Fecha Registro..." locale="es" data-date-format="d-m-Y" value="{{ old('fe_registro') }}" {{ $errors->has('fe_registro') ? 'aria-describedby="fe_registro-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('fe_registro') )
                                <div id="fe_registro-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fe_registro') }}</div>
                            @endif
                        </div>      
                        
                        <div class="form-group">
                            <label for="fe_vencimiento">Fecha Vencimiento</label>
                             <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fe_vencimiento') ? 'is-invalid' : '' !!}" id="fe_vencimiento" name="fe_vencimiento" placeholder="Fecha Vencimiento..." locale="es" data-date-format="d-m-Y" value="{{ old('fe_vencimiento') }}" {{ $errors->has('fe_vencimiento') ? 'aria-describedby="fe_vencimiento-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('fe_vencimiento') )
                                <div id="fe_vencimiento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fe_vencimiento') }}</div>
                            @endif
                        </div>  

                            <div class="form-group">
                            <label for="tab_estado">Estado</label>
                            <select class="custom-select {!! $errors->has('tab_estado') ? 'is-invalid' : '' !!}" name="tab_estado" id="tab_estado" {{ $errors->has('tab_estado') ? 'aria-describedby="tab_estado-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_estado as $estado)
                                <option value="{{ $estado->id }}" {{ $estado->id == old('tab_estado') ? 'selected' : '' }}>{{ $estado->de_estado }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tab_estado') )
                                <div id="tab_estado-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tab_estado') }}</div>
                            @endif
                           </div>  
                        
                            <div class="form-group">
                            <label for="tab_municipio">Municipio</label>
                            <select class="custom-select {!! $errors->has('tab_municipio') ? 'is-invalid' : '' !!}" name="tab_municipio" id="tab_municipio" {{ $errors->has('tab_municipio') ? 'aria-describedby="tab_municipio-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                            </select>
                            @if( $errors->has('tab_municipio') )
                                <div id="tab_municipio-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tab_municipio') }}</div>
                            @endif
                           </div>                         

                    </div>
                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-representante" role="tabpanel">

                        <div class="form-group">
                            <label for="cedula_representante">Cedula</label>
                            <input type="text" class="form-control {!! $errors->has('cedula_representante') ? 'is-invalid' : '' !!}" id="cedula_representante" name="cedula_representante" placeholder="Cedula..." value="{{ old('cedula_representante') }}" {{ $errors->has('cedula_representante') ? 'aria-describedby="cedula_representante-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('cedula_representante') )
                                <div id="cedula_representante-error" class="invalid-feedback animated fadeIn">{{ $errors->first('cedula_representante') }}</div>
                            @endif
                        </div>     

                        <div class="form-group">
                            <label for="nombre_representante">Nombre y Apellido</label>
                            <input type="text" class="form-control {!! $errors->has('nombre_representante') ? 'is-invalid' : '' !!}" id="nombre_representante" name="nombre_representante" placeholder="Nombre ..." value="{{ old('nombre_representante') }}" {{ $errors->has('nombre_representante') ? 'aria-describedby="nombre_representante-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('nombre_representante') )
                                <div id="nombre_representante-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nombre_representante') }}</div>
                            @endif
                        </div>       
                        
                        <div class="form-group">
                            <label for="telefono_representante">Telefono</label>
                            <input type="text" class="form-control {!! $errors->has('telefono_representante') ? 'is-invalid' : '' !!}" id="telefono_representante" name="telefono_representante" placeholder="Telefono ..." value="{{ old('telefono_representante') }}" {{ $errors->has('telefono_representante') ? 'aria-describedby="telefono_representante-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('telefono_representante') )
                                <div id="telefono_representante-error" class="invalid-feedback animated fadeIn">{{ $errors->first('telefono_representante') }}</div>
                            @endif
                        </div>                          
                        
                    </div>
                    
                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-datos" role="tabpanel">

                        <div class="form-group">
                            <label for="cuenta_bancaria">Cuenta Bancaria</label>
                            <input type="text" class="form-control {!! $errors->has('cuenta_bancaria') ? 'is-invalid' : '' !!}" id="cuenta_bancaria" name="cuenta_bancaria" placeholder="Cuenta Bancaria..." value="{{ old('cuenta_bancaria') }}" {{ $errors->has('cuenta_bancaria') ? 'aria-describedby="cuenta_bancaria-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('cuenta_bancaria') )
                                <div id="cuenta_bancaria-error" class="invalid-feedback animated fadeIn">{{ $errors->first('cuenta_bancaria') }}</div>
                            @endif
                        </div>  
                        
                            <div class="form-group">
                            <label for="tipo_proveedor">Tipo Proveedor</label>
                            <select class="custom-select {!! $errors->has('tipo_proveedor') ? 'is-invalid' : '' !!}" name="tipo_proveedor" id="tipo_proveedor" {{ $errors->has('tipo_proveedor') ? 'aria-describedby="tipo_proveedor-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_tipo_proveedor as $tipo_proveedor)
                                <option value="{{ $tipo_proveedor->id }}" {{ $tipo_proveedor->id == old('tipo_proveedor') ? 'selected' : '' }}>{{ $tipo_proveedor->de_tipo_proveedor }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_proveedor') )
                                <div id="tipo_proveedor-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_proveedor') }}</div>
                            @endif
                           </div>        
                        
                            <div class="form-group">
                            <label for="tipo_residencia_proveedor">Residencia Proveedor</label>
                            <select class="custom-select {!! $errors->has('tipo_residencia_proveedor') ? 'is-invalid' : '' !!}" name="tipo_residencia_proveedor" id="tipo_residencia_proveedor" {{ $errors->has('tipo_residencia_proveedor') ? 'aria-describedby="tipo_residencia_proveedor-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_tipo_residencia_proveedor as $tipo_residencia_proveedor)
                                <option value="{{ $tipo_residencia_proveedor->id }}" {{ $tipo_residencia_proveedor->id == old('tipo_residencia_proveedor') ? 'selected' : '' }}>{{ $tipo_residencia_proveedor->de_tipo_residencia_proveedor }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_residencia_proveedor') )
                                <div id="tipo_residencia_proveedor-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_residencia_proveedor') }}</div>
                            @endif
                           </div>  
                        
                            <div class="form-group">
                            <label for="clasificacion_proveedor">Clasificacion Proveedor</label>
                            <select class="custom-select {!! $errors->has('clasificacion_proveedor') ? 'is-invalid' : '' !!}" name="clasificacion_proveedor" id="clasificacion_proveedor" {{ $errors->has('clasificacion_proveedor') ? 'aria-describedby="clasificacion_proveedor-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_clasificacion_proveedor as $clasificacion_proveedor)
                                <option value="{{ $clasificacion_proveedor->id }}" {{ $clasificacion_proveedor->id == old('clasificacion_proveedor') ? 'selected' : '' }}>{{ $clasificacion_proveedor->de_clasificacion_proveedor }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('clasificacion_proveedor') )
                                <div id="clasificacion_proveedor-error" class="invalid-feedback animated fadeIn">{{ $errors->first('clasificacion_proveedor') }}</div>
                            @endif
                           </div>               
                        
                            <div class="form-group">
                            <label for="iva_retencion">Iva Retencion</label>
                            <select class="custom-select {!! $errors->has('iva_retencion') ? 'is-invalid' : '' !!}" name="iva_retencion" id="iva_retencion" {{ $errors->has('iva_retencion') ? 'aria-describedby="iva_retencion-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_iva_retencion as $iva_retencion)
                                <option value="{{ $iva_retencion->id }}" {{ $iva_retencion->id == old('iva_retencion') ? 'selected' : '' }}>{{ $iva_retencion->nu_iva_retencion }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('iva_retencion') )
                                <div id="iva_retencion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('iva_retencion') }}</div>
                            @endif
                           </div>         
                        
                        <div class="form-group">
                            <label for="tx_observacion">Observaciones</label>
                            <textarea class="js-maxlength form-control {!! $errors->has('tx_observacion') ? 'is-invalid' : '' !!}" id="tx_observacion" name="tx_observacion" rows="3"  maxlength="100" placeholder="Observaciones.." data-always-show="true" {{ $errors->has('tx_observacion') ? 'aria-describedby="tx_observacion-error" aria-invalid="true"' : '' }}>{{ old('tx_observacion') }}</textarea>
                            <div class="form-text text-muted font-size-sm font-italic">Breve Observación del Proveedor.</div>
                            @if( $errors->has('tx_observacion') )
                                <div id="tx_observacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tx_observacion') }}</div>
                            @endif
                        </div>                                            
                        
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