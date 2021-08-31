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
            $("#borrarForm").attr('action','{{ url('/administracion/creditoAdicional/eliminar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
    });  
    
        $('#generarCreditoAdicional').on('show.bs.modal', function (event) {
            $("#generarCreditoAdicionalForm").attr('action','{{ url('/administracion/creditoAdicional/'.$ruta.'/generar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('id_tab_credito_adicional');
            var modal = $(this);
            modal.find('.modal-content #id_tab_credito_adicional').val(item_id);
    });    
        
        
$("#fuente_financiamiento").change(function () {
         
$("#fuente_financiamiento option:selected").each(function () {
fuente_financiamiento=$(this).val();    
$.post("{{ URL::to('administracion/creditoAdicional/nu_financiamiento') }}", {fuente_financiamiento: fuente_financiamiento,_token: '{{ csrf_token() }}' }, function(data){
                 $("#nu_financiamiento").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#nu_financiamiento").append('<option value="' + f.id + '">' + f.nu_financiamiento+'</option>');
                    });
                
               });
                        
});
        }); 
        
$("#ejecutor").change(function () {
         
$("#ejecutor option:selected").each(function () {
ejecutor=$(this).val();    
$.post("{{ URL::to('administracion/creditoAdicional/proyecto_ac') }}", {ejecutor: ejecutor,_token: '{{ csrf_token() }}' }, function(data){
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
$.post("{{ URL::to('administracion/creditoAdicional/proyecto_ae') }}", {proyecto_ac: proyecto_ac,_token: '{{ csrf_token() }}' }, function(data){
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
$.post("{{ URL::to('administracion/creditoAdicional/partida_gasto') }}", {accion_especifica: accion_especifica,solicitud:'{{ $solicitud }}',_token: '{{ csrf_token() }}' }, function(data){
                 $("#partida_gasto").html('<option value="0"> Seleccione...</option>');
                 $.each(data.data, function(i,f) {
                  $("#partida_gasto").append('<option value="' + f.id + '">' + f.nu_partida + ' - '+ f.de_partida + '</option>');
                    });
                
               });
                        
});
        });         
        
        jQuery(function(){ Dashmix.helpers([ 'flatpickr', 'select2','table-tools-checkable']); });

    </script>
    @if (count($errors) > 0)
        @if (session()->has('msg_alerta_ingreso'))
        <script>
            jQuery('#modal-ingreso').modal('show');
        </script>
        @endif
    @endif  
    @if (count($errors) > 0)
        @if (session()->has('msg_alerta_gasto'))
        <script>
            jQuery('#modal-gasto').modal('show');
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
    <form action="{{ URL::to('administracion/creditoAdicional/guardar').'/'.$data->id }}" method="POST">
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

                        <h2 class="content-heading pt-0">Credito Adicional</h2>



                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Datos del Movimiento</h3>
                                </div>
                                <div class="block-content">
                                    
                                    
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideup-datos">Datos</a>
                    </li>                    
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-animated-slideup-ingreso">Partidas de Ingreso</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideup-gasto">Partidas de Gasto</a>
                    </li>      
                </ul>
                <div class="block-content tab-content overflow-hidden">

                    <div class="tab-pane fade fade-up show" id="btabs-animated-slideup-datos" role="tabpanel">       
                   
                                @if ($data->in_procesado == true)
                                <div class="form-group">
                                    <label for="fecha_credito">Fecha Credito</label>
                                    <input type="text" class="form-control" readonly   value="{{  $data->fe_credito }}">
                                </div> 
                                
                                <div class="form-group">
                                    <label>Descripcion</label>
                                    <textarea class="js-maxlength form-control" readonly rows="3"  maxlength="100" placeholder="Descripcion.." data-always-show="true"  {{ $errors->has('tx_descripcion') ? 'aria-describedby="tx_descripcion-error" aria-invalid="true"' : '' }}>{{ empty(old('tx_descripcion'))? $data->de_credito : old('tx_descripcion') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Justificacion</label>
                                    <textarea class="js-maxlength form-control" readonly  rows="3"  maxlength="100" placeholder="Justificacion.." data-always-show="true"  {{ $errors->has('tx_justificacion') ? 'aria-describedby="tx_justificacion-error" aria-invalid="true"' : '' }}>{{ empty(old('tx_justificacion'))? $data->de_justificacion : old('tx_justificacion') }}</textarea>
                                </div>

                                <div class="form-group">
                                    <label>Fuente Financiamiento</label>
                                    <input type="text" class="form-control" readonly   value="{{  $data->de_fuente_financiamiento }}">
                                </div>

                                <div class="form-group">
                                    <label>Numero Financiamiento</label>
                                    <input type="text" class="form-control" readonly   value="{{  $data->nu_financiamiento }}">
                                </div>

                                <div class="form-group">
                                    <label>Fecha Oficio</label>
                                    <input type="text" class="form-control" readonly   value="{{  $data->fe_oficio }}">
                                </div>

                                <div class="form-group">
                                    <label>Articulo / Ley</label>
                                    <input type="text" class="form-control" readonly   value="{{  $data->de_articulo }}">
                                </div>

                                <div class="form-group">
                                    <label>Tipo Credito Adicional</label>
                                    <input type="text" class="form-control" readonly   value="{{  $data->de_tipo_credito_adicional }}">
                                </div>                                
                                
                                @else
                                <div class="form-group form-row">
                                    <div class="col-4">
                                        <label for="fecha_credito">Fecha Credito</label>
                                        <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fecha_credito') ? 'is-invalid' : '' !!}" id="fecha_credito" name="fecha_credito" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_credito'))? $data->fe_credito : old('fecha_credito') }}" {{ $errors->has('fecha_credito') ? 'aria-describedby="fecha_credito-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('fecha_credito') )
                                            <div id="fecha_credito-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_credito') }}</div>
                                        @endif
                                    </div>
                                </div> 
                                   
                                <div class="form-group">
                                    <label for="tx_descripcion">Descripcion</label>
                                    <textarea class="js-maxlength form-control {!! $errors->has('tx_descripcion') ? 'is-invalid' : '' !!}" id="tx_descripcion" name="tx_descripcion" rows="3"  maxlength="100" placeholder="Descripcion.." data-always-show="true"  {{ $errors->has('tx_descripcion') ? 'aria-describedby="tx_descripcion-error" aria-invalid="true"' : '' }}>{{ empty(old('tx_descripcion'))? $data->de_credito : old('tx_descripcion') }}</textarea>
                                    <div class="form-text text-muted font-size-sm font-italic">Breve descripcion del credito adicional.</div>
                                    @if( $errors->has('tx_descripcion') )
                                        <div id="tx_descripcion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tx_descripcion') }}</div>
                                    @endif
                                </div>          
                                    
                                <div class="form-group">
                                    <label for="tx_justificacion">Justificacion</label>
                                    <textarea class="js-maxlength form-control {!! $errors->has('tx_justificacion') ? 'is-invalid' : '' !!}" id="tx_justificacion" name="tx_justificacion" rows="3"  maxlength="100" placeholder="Justificacion.." data-always-show="true"  {{ $errors->has('tx_justificacion') ? 'aria-describedby="tx_justificacion-error" aria-invalid="true"' : '' }}>{{ empty(old('tx_justificacion'))? $data->de_justificacion : old('tx_justificacion') }}</textarea>
                                    <div class="form-text text-muted font-size-sm font-italic">Breve Justificacion del credito adicional.</div>
                                    @if( $errors->has('tx_justificacion') )
                                        <div id="tx_justificacion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tx_justificacion') }}</div>
                                    @endif
                                </div> 
                                    
                                <div class="form-group">
                                    <label for="fuente_financiamiento">Fuente Financiamiento</label>
                                    <select class="custom-select {!! $errors->has('fuente_financiamiento') ? 'is-invalid' : '' !!}" name="fuente_financiamiento" id="fuente_financiamiento" {{ $errors->has('fuente_financiamiento') ? 'aria-describedby="fuente_financiamiento-error" aria-invalid="true"' : '' }}>
                                        <option value="0" >Seleccione...</option>
                                        @foreach($tab_fuente_financiamiento as $fuente_financiamiento)
                                            <option value="{{ $fuente_financiamiento->id }}" {{ $fuente_financiamiento->id == $data->id_tab_fuente_financiamiento ? 'selected' : '' }}>{{ $fuente_financiamiento->de_fuente_financiamiento }}</option>
                                        @endforeach
                                    </select>
                                    @if( $errors->has('fuente_financiamiento') )
                                        <div id="fuente_financiamiento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fuente_financiamiento') }}</div>
                                    @endif
                                </div>      
                                    
                                <div class="form-group">
                                    <label for="nu_financiamiento">Numero Financiamiento</label>
                                    <select class="custom-select {!! $errors->has('nu_financiamiento') ? 'is-invalid' : '' !!}" name="nu_financiamiento" id="nu_financiamiento" {{ $errors->has('nu_financiamiento') ? 'aria-describedby="nu_financiamiento-error" aria-invalid="true"' : '' }}>
                                        <option value="0" >Seleccione...</option>
                                        @foreach($tab_nu_financiamiento as $nu_financiamiento)
                                            <option value="{{ $nu_financiamiento->id }}" {{ $nu_financiamiento->id == $data->id_tab_nu_financiamiento ? 'selected' : '' }}>{{ $nu_financiamiento->nu_financiamiento }}</option>
                                        @endforeach                                        
                                    </select>
                                    @if( $errors->has('nu_financiamiento') )
                                        <div id="nu_financiamiento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_financiamiento') }}</div>
                                    @endif
                                </div>  
                                    
                                <div class="form-group form-row">
                                    <div class="col-4">
                                        <label for="fecha_oficio">Fecha Oficio</label>
                                        <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fecha_oficio') ? 'is-invalid' : '' !!}" id="fecha_oficio" name="fecha_oficio" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_oficio'))? $data->fe_oficio : old('fecha_oficio') }}" {{ $errors->has('fecha_oficio') ? 'aria-describedby="fecha_oficio-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('fecha_oficio') )
                                            <div id="fecha_oficio-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_oficio') }}</div>
                                        @endif
                                    </div>
                                </div>   
                                    
                                <div class="form-group">
                                    <label for="articulo_ley">Articulo / Ley</label>
                                    <input type="text" class="form-control {!! $errors->has('articulo_ley') ? 'is-invalid' : '' !!}" id="articulo_ley" name="articulo_ley" placeholder="..." value="{{ empty(old('articulo_ley'))? $data->de_articulo : old('articulo_ley') }}" {{ $errors->has('articulo_ley') ? 'aria-describedby="articulo_ley-error" aria-invalid="true"' : '' }}>
                                    @if( $errors->has('articulo_ley') )
                                        <div id="articulo_ley-error" class="invalid-feedback animated fadeIn">{{ $errors->first('articulo_ley') }}</div>
                                    @endif
                                </div> 

                                <div class="form-group">
                                    <label for="tipo_credito">Tipo Credito Adicional</label>
                                    <select class="custom-select {!! $errors->has('tipo_credito') ? 'is-invalid' : '' !!}" name="tipo_credito" id="tipo_credito" {{ $errors->has('tipo_credito') ? 'aria-describedby="tipo_credito-error" aria-invalid="true"' : '' }}>
                                        <option value="0" >Seleccione...</option>
                                        @foreach($tab_tipo_credito_adicional as $tipo_credito_adicional)
                                            <option value="{{ $tipo_credito_adicional->id }}" {{ $tipo_credito_adicional->id == $data->id_tab_tipo_credito_adicional ? 'selected' : '' }}>{{ $tipo_credito_adicional->de_tipo_credito_adicional }}</option>
                                        @endforeach
                                    </select>
                                    @if( $errors->has('tipo_credito') )
                                        <div id="tipo_credito-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_credito') }}</div>
                                    @endif
                                </div>    
                        @endif
                     @if ($data->in_procesado != true)    
                    <div class="form-group">

                    <div class="block-content bg-body-light">
                        <div class="row justify-content-center push">
                            <div class="col-md-12">
                                <button type="submit" class="btn btn-alt-primary">
                                    <i class="fa fa-fw fa-save mr-1"></i> Guardar
                                </button>
                            </div>
                        </div>
                    </div>

                    </div>                         
                     @endif

                    </div>        
                                       
                    <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-ingreso" role="tabpanel">  
                     @if ($data->in_procesado != true)    
                    <div class="form-group">

                        <div class="btn-group btn-group-sm pr-2">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-ingreso" title="Agregar Partida / ingreso" href="javascript:void(0)">
                                <i class="fa fa-fw fa-search-plus"></i> Agregar
                            </button>
                        </div>

                    </div>                        
                     @endif  
                    <div class="form-group">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead class="thead-light">
                                <tr>
                                    <th>Codigo</th>
                                    <th>Denominación</th>
                                    <th class="font-w600 text-center">Monto</th>
                                    <th class="font-w600 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($tab_credito_adicional_ingreso as $key => $value)
                                <tr>
                                    <td class="d-none d-sm-table-cell">{{ $value->nu_partida }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $value->de_partida }}</td>
                                    <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->monto }}</em></td>
                                    @if ($data->in_procesado != true)
                                    <td class="d-none d-sm-table-cell">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" title="Borrar" data-target="#borrar" data-item_id="{{ $value->id }}" >
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>                        

                    <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-left">
                        <a class="font-w500" href="javascript:void(0)">
                            <div id="totalIngreso"><i class="fa fa-calculator ml-1 opacity-25"></i> Total Ingreso: {{ $mo_ingreso }}</div>
                        </a>
                    </div>                        
                        
                      </div>  
                    
                    <div class="tab-pane fade fade-up show" id="btabs-animated-slideup-gasto" role="tabpanel">  
                   @if ($data->in_procesado != true)   
                    <div class="form-group">

                        <div class="btn-group btn-group-sm pr-2">
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-gasto" title="Agregar Partida / gasto" href="javascript:void(0)">
                                <i class="fa fa-fw fa-search-plus"></i> Agregar
                            </button>
                        </div>

                    </div>                        
                    @endif   
                    <div class="form-group">
                        <table class="table table-bordered table-striped table-vcenter">
                            <thead class="thead-light">
                                <tr>
                                    <th>Ejecutor</th>
                                    <th>Codigo</th>
                                    <th>Denominación</th>
                                    <th class="font-w600 text-center">Monto</th>
                                    <th class="font-w600 text-center">Acción</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($tab_credito_adicional_gasto as $key => $value)
                                <tr>
                                    <td class="d-none d-sm-table-cell">{{ $value->nu_ejecutor }} - {{ $value->de_ejecutor }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $value->nu_partida }}</td>
                                    <td class="d-none d-sm-table-cell">{{ $value->de_partida }}</td>
                                    <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->monto }}</em></td>
                                    @if ($data->in_procesado != true)
                                    <td class="d-none d-sm-table-cell">
                                        <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" title="Borrar" data-target="#borrar" data-item_id="{{ $value->id }}" >
                                            <i class="fa fa-times"></i>
                                        </button>
                                    </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>                        

                    <div class="block-content block-content-full block-content-sm bg-body-light font-size-sm text-left">
                        <a class="font-w500" href="javascript:void(0)">
                            <div id="totalIngreso"><i class="fa fa-calculator ml-1 opacity-25"></i> Total Gasto: {{ $mo_gasto }}</div>
                        </a>
                    </div>                          
                        
                      </div>                     
                    
                        </div>
                    </div>                                    
      

                                </div>
                            </div>
                         @if ($mo_gasto <> $mo_ingreso)
                        <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                            <div class="flex-fill mr-3">
                                <p class="mb-0">Nota: Debe agregar y coincidir el total de las partidas de ingreso con el total de las partidas del gasto para poder generar el credito adicional</p>
                            </div>
                        </div>
                         @else
                         @if ($mo_gasto == 0 || $mo_ingreso ==0)
                        <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                            <div class="flex-fill mr-3">
                                <p class="mb-0">Nota: Debe agregar y coincidir el total de las partidas de ingreso con el total de las partidas del gasto para poder generar el credito adicional</p>
                            </div>
                        </div>                         
                     @endif
                     @endif
                     @if ($data->in_procesado == true)
                        <div class="alert alert-success d-flex align-items-center justify-content-between" role="alert">
                            <div class="flex-fill mr-3">
                                <p class="mb-0">Credito Adicional fue generado exitosamente! ya puede avanzar el tramite.</p>
                            </div>
                        </div>                      
                     @endif
                    </div>
                </div>
            </div>
        </div>
       
        <div class="block-content bg-body-light">
            <div class="row justify-content-center push">
                <div class="col-md-10">                   
                         @if ($mo_gasto == $mo_ingreso)
                         @if ($mo_gasto > 0)
                         @if ($data->in_procesado != true)                       
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#generarCreditoAdicional" title="Generar credito adicional" href="javascript:void(0)" data-id_tab_credito_adicional="{{ $data->id }}">
                            <i class="fa fa-fw fa-save mr-1"></i>  Generar Credito Adicional
                        </button>
                      @endif   
                     @endif
                     @endif                    

                </div>
            </div>
        </div>
    </form>
    </div>
    <!-- END New Post -->
</div>
<!-- END Page Content -->
<!-- Pop In Block Modal -->
<div class="modal fade" id="modal-ingreso" tabindex="-1" role="dialog" aria-labelledby="modal-ingreso" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

        <form action="{{ URL::to('administracion/creditoAdicional/guardarPartidaIngreso') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="solicitud" value="{{ $solicitud }}">
        <input type="hidden" name="ruta" value="{{ $ruta }}">

            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Partidas Ingreso</h3>
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
                            <label for="partida_ingreso" class="col-12">Partida</label>
                            <div class="col-12">
                            <select class="custom-select {!! $errors->has('partida_ingreso') ? 'is-invalid' : '' !!}" name="partida_ingreso" id="partida_ingreso" {{ $errors->has('partida_ingreso') ? 'aria-describedby="partida_ingreso-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_partida_ingreso as $partida_ingreso)
                                    <option value="{{ $partida_ingreso->id }}" {{ $partida_ingreso->id == old('partida_ingreso') ? 'selected' : '' }}>{{ $partida_ingreso->co_partida }} - {{ $partida_ingreso->de_partida }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('partida_ingreso') )
                                <div id="partida_ingreso-error" class="invalid-feedback animated fadeIn">El campo partida es obligatorio</div>
                            @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="monto_ingreso" class="col-12">Monto</label>
                            <div class="col-8">
                                <input type="text" class="form-control {!! $errors->has('monto_ingreso') ? 'is-invalid' : '' !!}" id="monto_ingreso" name="monto_ingreso" placeholder="monto..." value="{{ old('monto_ingreso') }}" {{ $errors->has('monto_ingreso') ? 'aria-describedby="monto_ingreso-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('monto_ingreso') )
                                    <div id="monto_ingreso-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto_ingreso') }}</div>
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

<!-- Pop In Block Modal -->
<div class="modal fade" id="modal-gasto" tabindex="-1" role="dialog" aria-labelledby="modal-gasto" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

        <form action="{{ URL::to('administracion/creditoAdicional/guardarPartidaGasto') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="solicitud" value="{{ $solicitud }}">
        <input type="hidden" name="ruta" value="{{ $ruta }}">

            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Partidas Gasto</h3>
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
                                <option value="{{ $ambito->id }}" {{ $ambito->id == $data->id_tab_ambito ? 'selected' : '' }}>{{ $ambito->nu_ambito }}-{{ $ambito->de_ambito }}</option>
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
                                    <option value="{{ $aplicacion->id }}" {{ $aplicacion->id == $data->id_tab_aplicacion ? 'selected' : '' }}>{{ $aplicacion->nu_aplicacion }}-{{ $aplicacion->de_aplicacion }}</option>
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
                                    <option value="{{ $clasificacion_economica->id }}" {{ $clasificacion_economica->id == $data->id_tab_clasificacion_economica ? 'selected' : '' }}>{{ $clasificacion_economica->tx_sigla }}-{{ $clasificacion_economica->de_clasificacion_economica }}</option>
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
                                    <option value="{{ $area_estrategica->id }}" {{ $area_estrategica->id == $data->id_tab_area_estrategica ? 'selected' : '' }}>{{ $area_estrategica->tx_sigla }}-{{ $area_estrategica->de_area_estrategica }}</option>
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
                                    <option value="{{ $tipo_gasto->id }}" {{ $tipo_gasto->id == $data->id_tab_tipo_gasto ? 'selected' : '' }}>{{ $tipo_gasto->tx_sigla }}-{{ $tipo_gasto->de_tipo_gasto }}</option>
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
                            <label for="monto_gasto" class="col-12">Monto</label>
                            <div class="col-8">
                                <input type="text" class="form-control {!! $errors->has('monto_gasto') ? 'is-invalid' : '' !!}" id="monto_gasto" name="monto_gasto" placeholder="monto..." value="{{ old('monto_gasto') }}" {{ $errors->has('monto_gasto') ? 'aria-describedby="monto_gasto-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('monto_gasto') )
                                    <div id="monto_gasto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto_gasto') }}</div>
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