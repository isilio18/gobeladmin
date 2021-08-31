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
    $(function () {
    

$("#ejecutor").change(function () {
         
$("#ejecutor option:selected").each(function () {
ejecutor=$(this).val();    
$.post("{{ URL::to('administracion/crearPartida/proyecto_ac') }}", {ejecutor: ejecutor,_token: '{{ csrf_token() }}' }, function(data){
                 $("#proyecto_ac").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#proyecto_ac").append('<option value="' + f.id + '">' + f.nu_presupuesto + ' - '+ f.de_presupuesto + '</option>');
                    });
                
               });
               $("#accion_especifica").html('<option value="0"> Seleccione...</option>');
               $("#partida_gasto").html('<option value="0"> Seleccione...</option>');
});
        });     
        
$("#proyecto_ac").change(function () {
         
$("#proyecto_ac option:selected").each(function () {
proyecto_ac=$(this).val();    
$.post("{{ URL::to('administracion/crearPartida/proyecto_ae') }}", {proyecto_ac: proyecto_ac,_token: '{{ csrf_token() }}' }, function(data){
                 $("#accion_especifica").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#accion_especifica").append('<option value="' + f.id + '">' + f.nu_accion_especifica + ' - '+ f.de_accion_especifica + '</option>');
                    });
                
               });
              $("#partida_gasto").html('<option value="0"> Seleccione...</option>');          
});
        });     
        
$("#accion_especifica").change(function () {
         
$("#accion_especifica option:selected").each(function () {
accion_especifica=$(this).val();    
$.post("{{ URL::to('administracion/crearPartida/partida_gasto') }}", {accion_especifica: accion_especifica,solicitud:'{{ $solicitud }}',_token: '{{ csrf_token() }}' }, function(data){
                 $("#partida_gasto").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#partida_gasto").append('<option value="' + f.id + '">' + f.nu_partida + ' - '+ f.de_partida + '</option>');
                    });
                
               });
                        
});
        });      
        
$("#fuente_financiamiento").change(function () {
         
$("#fuente_financiamiento option:selected").each(function () {
fuente_financiamiento=$(this).val();    
$.post("{{ URL::to('administracion/crearPartida/nu_financiamiento') }}", {fuente_financiamiento: fuente_financiamiento,_token: '{{ csrf_token() }}' }, function(data){
                 $("#nu_financiamiento").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#nu_financiamiento").append('<option value="' + f.id + '">' + f.nu_financiamiento+'</option>');
                    });
                
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
            $("#borrarForm").attr('action','{{ url('/administracion/crearPartida/eliminar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
    });
    </script>
    @if (count($errors) > 0)
        @if (session()->has('msg_alerta'))
        <script>
            jQuery('#modal-partida').modal('show');
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
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-partida" title="Agregar Partida" href="javascript:void(0)">
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
                        <th>Nro. Partida</th>
                        <th>Descripcion</th>
                        <th class="d-none d-md-table-cell text-center" style="width: 100px;">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tab_creacion_partida as $key => $value)
                    <tr>
                        <!--  <td class="font-w600">{{ $value->id }}</td> -->
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->nu_partida }}</em></td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->de_partida }}</em></td>
                        <td class="text-center">
                            <div class="btn-group">
                             @if ($value->in_procesado == false)                                
                                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" title="Borrar" data-target="#borrar" data-item_id="{{ $value->id }}" >
                                    <i class="fa fa-times"></i>
                                </button>
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

            {{ $tab_creacion_partida->appends(Request::only(['perPage','q']))->render() }}         

        </div>
    </div>
    <!-- END Partial Table -->
</div>
<!-- END Page Content -->
<!-- Pop In Block Modal -->
<div class="modal fade" id="modal-partida" tabindex="-1" role="dialog" aria-labelledby="modal-partida" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

        <form action="{{ URL::to('administracion/crearPartida/guardar') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="solicitud" value="{{ $solicitud }}">
            <input type="hidden" name="ruta" value="{{ $ruta }}">

            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Nueva Partida Desagregada</h3>
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
                            <label for="fuente_financiamiento" class="col-12">Fuente Financiamiento</label>
                            <div class="col-12">
                            <select class="custom-select {!! $errors->has('fuente_financiamiento') ? 'is-invalid' : '' !!}" name="fuente_financiamiento" id="fuente_financiamiento" {{ $errors->has('fuente_financiamiento') ? 'aria-describedby="fuente_financiamiento-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_fuente_financiamiento as $fuente_financiamiento)
                                    <option value="{{ $fuente_financiamiento->id }}" {{ $fuente_financiamiento->id == old('fuente_financiamiento') ? 'selected' : '' }}>{{ $fuente_financiamiento->de_fuente_financiamiento }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('fuente_financiamiento') )
                                <div id="fuente_financiamiento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fuente_financiamiento') }}</div>
                            @endif
                            </div>
                        </div>      

                        <div class="form-group">
                            <label for="nu_financiamiento" class="col-12">Numero Financiamiento</label>
                            <div class="col-12">
                            <select class="custom-select {!! $errors->has('nu_financiamiento') ? 'is-invalid' : '' !!}" name="nu_financiamiento" id="nu_financiamiento" {{ $errors->has('nu_financiamiento') ? 'aria-describedby="nu_financiamiento-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                            </select>
                            @if( $errors->has('nu_financiamiento') )
                                <div id="nu_financiamiento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_financiamiento') }}</div>
                            @endif
                           </div> 
                        </div>                        

                        <div class="form-group">
                            <label for="ejecutor" class="col-12">Ente Ejecutor</label>
                            <div class="col-12">
                            <select class="custom-select {!! $errors->has('ejecutor') ? 'is-invalid' : '' !!}" name="ejecutor" id="ejecutor" {{ $errors->has('ejecutor') ? 'aria-describedby="ejecutor-error" aria-invalid="true"' : '' }}>
                                <option value="" >Seleccione...</option>
                                @foreach($tab_ejecutor as $ejecutor)
                                    <option value="{{ $ejecutor->id }}" >{{ $ejecutor->nu_ejecutor }} - {{ $ejecutor->de_ejecutor }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('ejecutor') )
                                <div id="ejecutor-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ejecutor') }}</div>
                            @endif
                        </div> 
                        </div>
                        
                        <div class="form-group">
                            <label for="proyecto_ac" class="col-12">Proyecto / Ac</label>
                            <div class="col-12">
                                <select class="js-select2 form-control {!! $errors->has('proyecto_ac') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione..." name="proyecto_ac" id="proyecto_ac" {{ $errors->has('proyecto_ac') ? 'aria-describedby="proyecto_ac-error" aria-invalid="true"' : '' }}>
                                    <option value="" >Seleccione...</option>
                                </select>
                                @if( $errors->has('proyecto_ac') )
                                    <div id="proyecto_ac-error" class="invalid-feedback animated fadeIn">{{ $errors->first('proyecto_ac') }}</div>
                                @endif
                            </div>                                    
                            </div>   
                        
                        <div class="form-group">
                            <label for="accion_especifica" class="col-12">Accion Especifica</label>
                            <div class="col-12">
                                <select class="js-select2 form-control {!! $errors->has('accion_especifica') ? 'is-invalid' : '' !!}" style="width: 100%;" data-placeholder="Seleccione..." name="accion_especifica" id="accion_especifica" {{ $errors->has('accion_especifica') ? 'aria-describedby="accion_especifica-error" aria-invalid="true"' : '' }}>
                                    <option value="" >Seleccione...</option>
                                </select>
                                @if( $errors->has('accion_especifica') )
                                    <div id="accion_especifica-error" class="invalid-feedback animated fadeIn">{{ $errors->first('accion_especifica') }}</div>
                                @endif
                            </div>
                        </div>      
                        
                        <div class="form-group">
                            <label for="tipo_ingreso" class="col-12">Tipo Ingreso</label>
                            <div class="col-12">
                            <select class="custom-select {!! $errors->has('tipo_ingreso') ? 'is-invalid' : '' !!}" name="tipo_ingreso" id="tipo_ingreso" {{ $errors->has('tipo_ingreso') ? 'aria-describedby="tipo_ingreso-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_tipo_ingreso as $tipo_ingreso)
                                <option value="{{ $tipo_ingreso->id }}" {{ $tipo_ingreso->id == old('tipo_ingreso') ? 'selected' : '' }}>{{ $tipo_ingreso->nu_tipo_ingreso }}-{{ $tipo_ingreso->de_tipo_ingreso }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_ingreso') )
                                <div id="tipo_ingreso-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_ingreso') }}</div>
                            @endif
                            </div>
                        </div>                        

                        <div class="form-group">
                            <label for="ambito" class="col-12">Ambito</label>
                            <div class="col-12">
                            <select class="custom-select {!! $errors->has('ambito') ? 'is-invalid' : '' !!}" name="ambito" id="ambito" {{ $errors->has('ambito') ? 'aria-describedby="ambito-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_ambito as $ambito)
                                <option value="{{ $ambito->id }}" {{ $ambito->id == old('ambito') ? 'selected' : '' }}>{{ $ambito->nu_ambito }}-{{ $ambito->de_ambito }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('ambito') )
                                <div id="ambito-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ambito') }}</div>
                            @endif
                            </div>
                        </div>  
                        
                        <div class="form-group">
                            <label for="aplicacion" class="col-12">Aplicacion</label>
                            <div class="col-12">
                            <select class="custom-select {!! $errors->has('aplicacion') ? 'is-invalid' : '' !!}" name="aplicacion" id="aplicacion" {{ $errors->has('aplicacion') ? 'aria-describedby="aplicacion-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_aplicacion as $aplicacion)
                                    <option value="{{ $aplicacion->id }}" {{ $aplicacion->id == old('aplicacion') ? 'selected' : '' }}>{{ $aplicacion->nu_aplicacion }}-{{ $aplicacion->de_aplicacion }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('aplicacion') )
                                <div id="aplicacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('aplicacion') }}</div>
                            @endif
                            </div>
                        </div> 
                        
                        <div class="form-group">
                            <label for="clasificacion_economica" class="col-12">Clasificación Economica</label>
                            <div class="col-12">
                            <select class="custom-select {!! $errors->has('clasificacion_economica') ? 'is-invalid' : '' !!}" name="clasificacion_economica" id="clasificacion_economica" {{ $errors->has('clasificacion_economica') ? 'aria-describedby="clasificacion_economica-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_clasificacion_economica as $clasificacion_economica)
                                    <option value="{{ $clasificacion_economica->id }}" {{ $clasificacion_economica->id == old('clasificacion_economica') ? 'selected' : '' }}>{{ $clasificacion_economica->tx_sigla }}-{{ $clasificacion_economica->de_clasificacion_economica }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('clasificacion_economica') )
                                <div id="clasificacion_economica-error" class="invalid-feedback animated fadeIn">{{ $errors->first('clasificacion_economica') }}</div>
                            @endif
                            </div>
                        </div> 

                        <div class="form-group">
                            <label for="area_estrategica" class="col-12">Area Estrategica</label>
                            <div class="col-12">
                            <select class="custom-select {!! $errors->has('area_estrategica') ? 'is-invalid' : '' !!}" name="area_estrategica" id="area_estrategica" {{ $errors->has('area_estrategica') ? 'aria-describedby="area_estrategica-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_area_estrategica as $area_estrategica)
                                    <option value="{{ $area_estrategica->id }}" {{ $area_estrategica->id == old('area_estrategica') ? 'selected' : '' }}>{{ $area_estrategica->tx_sigla }}-{{ $area_estrategica->de_area_estrategica }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('area_estrategica') )
                                <div id="area_estrategica-error" class="invalid-feedback animated fadeIn">{{ $errors->first('area_estrategica') }}</div>
                            @endif
                            </div>
                        </div>           
                        
                        <div class="form-group">
                            <label for="tipo_gasto" class="col-12">Tipo Gasto</label>
                            <div class="col-12">
                            <select class="custom-select {!! $errors->has('tipo_gasto') ? 'is-invalid' : '' !!}" name="tipo_gasto" id="tipo_gasto" {{ $errors->has('tipo_gasto') ? 'aria-describedby="tipo_gasto-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_tipo_gasto as $tipo_gasto)
                                    <option value="{{ $tipo_gasto->id }}" {{ $tipo_gasto->id == old('tipo_gasto') ? 'selected' : '' }}>{{ $tipo_gasto->tx_sigla }}-{{ $tipo_gasto->de_tipo_gasto }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_gasto') )
                                <div id="tipo_gasto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_gasto') }}</div>
                            @endif
                            </div>
                        </div>                        
                        
                        <div class="form-group">
                            <label for="partida_gasto" class="col-12">Partida</label>
                            <div class="col-12">
                            <select class="js-select2 form-control {!! $errors->has('partida_gasto') ? 'is-invalid' : '' !!}" style="width: 100%;" name="partida_gasto" id="partida_gasto" {{ $errors->has('partida_gasto') ? 'aria-describedby="partida_gasto-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                            </select>
                            @if( $errors->has('partida_gasto') )
                                <div id="partida_gasto-error" class="invalid-feedback animated fadeIn">El campo partida es obligatorio</div>
                            @endif
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="desagregado" class="col-12">Desagregado</label>
                            <div class="col-8">
                                <input type="text" class="form-control {!! $errors->has('desagregado') ? 'is-invalid' : '' !!}" id="desagregado" name="desagregado" placeholder="Desagregado..." value="{{ old('desagregado') }}" {{ $errors->has('desagregado') ? 'aria-describedby="desagregado-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('desagregado') )
                                    <div id="desagregado-error" class="invalid-feedback animated fadeIn">{{ $errors->first('desagregado') }}</div>
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