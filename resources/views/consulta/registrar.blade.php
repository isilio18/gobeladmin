@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" id="css-main" href="{{ asset('css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" id="css-main" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
    <script src="{{ asset('js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
    <!-- Page JS Code -->

    <script>
        jQuery(function(){ Dashmix.helpers([ 'flatpickr', 'select2']); });
    </script>
    
<script type="text/javascript">
$(function () {
             

    });
</script>    
    
@endsection

@section('content')


<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('registrarConsulta') }}"  method="POST">
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

                        <div class="form-group form-row">
                            <div class="col-8">
                                <label for="fecha">Fecha</label>
                                <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha') ? 'is-invalid' : '' !!}" id="fecha" name="fecha" placeholder="d-m-Y HH:MM" data-date-format="Y-m-d H:i" data-enable-time="true" value="{{ empty(old('fecha'))? date('Y-m-d H:i') : old('fecha') }}" {{ $errors->has('fecha') ? 'aria-describedby="fecha-error" aria-invalid="true"' : '' }}>
                                @if( $errors->has('fecha') )
                                    <div id="fecha-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha') }}</div>
                                @endif
                            </div>

                        </div>                        

                        <div class="form-group form-row">
                            <label for="cedula">Cedula</label>
                            <input type="text" class="form-control {!! $errors->has('cedula') ? 'is-invalid' : '' !!}" id="cedula" name="cedula" placeholder="Cedula..." value="{{ old('cedula') }}" {{ $errors->has('cedula') ? 'aria-describedby="cedula-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('cedula') )
                                <div id="cedula-error" class="invalid-feedback animated fadeIn">{{ $errors->first('cedula') }}</div>
                            @endif
                        </div>
                     
                        
                        <div class="form-group form-row">
                            <label for="nombre">Persona</label>
                            <input type="text" class="form-control {!! $errors->has('nombre') ? 'is-invalid' : '' !!}" id="nombre" name="nombre" placeholder="Nombres y Apellidos..." value="{{ old('nombre') }}" {{ $errors->has('nombre') ? 'aria-describedby="nombre-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('nombre') )
                                <div id="nombre-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nombre') }}</div>
                            @endif
                        </div>
                        
 
                        
                <div class="row">
                    <div class="col-md-3">
                        <div class="form-group form-row">
                            <label for="edad">Edad</label>
                            <input type="text" class="form-control {!! $errors->has('edad') ? 'is-invalid' : '' !!}" id="edad" name="edad" placeholder="Edad..." value="{{ old('edad') }}" {{ $errors->has('edad') ? 'aria-describedby="edad-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('edad') )
                                <div id="edad-error" class="invalid-feedback animated fadeIn">{{ $errors->first('edad') }}</div>
                            @endif
                        </div>
                    </div>

                    <div class="col-md-3">
                        <div class="form-group form-row">
                            <label for="sexo">Sexo</label>
                            <input type="text" class="form-control {!! $errors->has('sexo') ? 'is-invalid' : '' !!}" id="sexo" name="sexo" placeholder="Sexo..." value="{{ old('sexo') }}" {{ $errors->has('sexo') ? 'aria-describedby="sexo-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('sexo') )
                                <div id="sexo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('sexo') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-row">
                            <label for="peso">Peso</label>
                            <input type="text" class="form-control {!! $errors->has('peso') ? 'is-invalid' : '' !!}" id="peso" name="peso" placeholder="Peso..." value="{{ old('peso') }}" {{ $errors->has('peso') ? 'aria-describedby="peso-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('edad') )
                                <div id="peso-error" class="invalid-feedback animated fadeIn">{{ $errors->first('peso') }}</div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="form-group form-row">
                            <label for="talla">Talla</label>
                            <input type="text" class="form-control {!! $errors->has('talla') ? 'is-invalid' : '' !!}" id="talla" name="talla" placeholder="Talla..." value="{{ old('talla') }}" {{ $errors->has('talla') ? 'aria-describedby="talla-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('talla') )
                                <div id="talla-error" class="invalid-feedback animated fadeIn">{{ $errors->first('talla') }}</div>
                            @endif
                        </div>
                    </div>                    
                </div>                        
                        
                        <div class="form-group form-row">
                            <label for="telefono">Telefono</label>
                            <input type="text" class="form-control {!! $errors->has('telefono') ? 'is-invalid' : '' !!}" id="telefono" name="telefono" placeholder="Telefono..." value="{{ old('telefono') }}" {{ $errors->has('telefono') ? 'aria-describedby="telefono-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('telefono') )
                                <div id="telefono-error" class="invalid-feedback animated fadeIn">{{ $errors->first('telefono') }}</div>
                            @endif
                        </div>  
                        
                        <div class="form-group form-row">
                            <label for="direccion">Direccion</label>
                            <input type="text" class="form-control {!! $errors->has('direccion') ? 'is-invalid' : '' !!}" id="direccion" name="direccion" placeholder="Direccion..." value="{{ old('direccion') }}" {{ $errors->has('direccion') ? 'aria-describedby="direccion-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('direccion') )
                                <div id="direccion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('direccion') }}</div>
                            @endif
                        </div>                          
                        
                        <div class="form-group form-row">
                            <label for="municipio">Municipio</label>
                            <input type="text" class="form-control {!! $errors->has('municipio') ? 'is-invalid' : '' !!}" id="municipio" name="municipio" placeholder="Municipio..." value="{{ old('municipio') }}" {{ $errors->has('municipio') ? 'aria-describedby="municipio-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('municipio') )
                                <div id="municipio-error" class="invalid-feedback animated fadeIn">{{ $errors->first('municipio') }}</div>
                            @endif
                        </div>  
                        
                        <div class="form-group form-row">
                            <label for="parroquia">Parroquia</label>
                            <input type="text" class="form-control {!! $errors->has('parroquia') ? 'is-invalid' : '' !!}" id="parroquia" name="parroquia" placeholder="Parroquia..." value="{{ old('parroquia') }}" {{ $errors->has('parroquia') ? 'aria-describedby="parroquia-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('parroquia') )
                                <div id="parroquia-error" class="invalid-feedback animated fadeIn">{{ $errors->first('parroquia') }}</div>
                            @endif
                        </div>    
                        
                        <div class="form-group form-row">
                            <label for="correo">Correo</label>
                            <input type="text" class="form-control {!! $errors->has('correo') ? 'is-invalid' : '' !!}" id="correo" name="correo" placeholder="Correo..." value="{{ old('correo') }}" {{ $errors->has('correo') ? 'aria-describedby="correo-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('correo') )
                                <div id="correo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('correo') }}</div>
                            @endif
                        </div>
                <label for="correo">Antecedentes Patologicos de Paciente</label>   
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="diabetes" id="diabetes" @if ( old('diabetes')) checked @endif>
                                <label for="daily" title="Diariamente">
                                    Diabetes
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="obesidad" id="obesidad" @if ( old('obesidad')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Obesidad
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="cancer" id="cancer" @if ( old('cancer')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Cáncer
                                </label>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="hipertencion" id="hipertencion" @if ( old('hipertencion')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Hipertensión
                                </label>
                            </div>
                        </div>
                    </div>    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="hepatitis" id="hepatitis" @if ( old('hepatitis')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Hepatitis
                                </label>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="asmatico" id="asmatico" @if ( old('asmatico')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Asma
                                </label>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="tiroide" id="tiroide" @if ( old('tiroide')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Tiroide
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="cardiopata" id="cardiopata" @if ( old('cardiopata')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Cardiopatía
                                </label>
                            </div>
                        </div>
                    </div>                       
                    <div class="col-md-6">
                        <div class="form-group form-row">
                            <input type="text" class="form-control {!! $errors->has('otros') ? 'is-invalid' : '' !!}" id="otros" name="otros" placeholder="Otros..." value="{{ old('otros') }}" {{ $errors->has('otros') ? 'aria-describedby="otros-error" aria-invalid="true"' : '' }}>
                        </div>
                    </div>                     
                    
                </div>                        

                <label for="correo">Antecedentes Patologicos de Familiares</label>   
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="diabetesf" id="diabetesf" @if ( old('diabetesf')) checked @endif>
                                <label for="daily" title="Diariamente">
                                    Diabetes
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="obesidadf" id="obesidadf" @if ( old('obesidadf')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Obesidad
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="cancerf" id="cancerf" @if ( old('cancerf')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Cáncer
                                </label>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="hipertencionf" id="hipertencionf" @if ( old('hipertencionf')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Hipertensión
                                </label>
                            </div>
                        </div>
                    </div>    
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="hepatitisf" id="hepatitisf" @if ( old('hepatitisf')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Hepatitis
                                </label>
                            </div>
                        </div>
                    </div>  
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="asmaticof" id="asmaticof" @if ( old('asmaticof')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Asma
                                </label>
                            </div>
                        </div>
                    </div> 
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="tiroidef" id="tiroidef" @if ( old('tiroidef')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Tiroide
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="cardiopataf" id="cardiopataf" @if ( old('cardiopataf')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Cardiopatía
                                </label>
                            </div>
                        </div>
                    </div>                      
                    <div class="col-md-6">
                        <div class="form-group form-row">
                            <input type="text" class="form-control {!! $errors->has('otrosf') ? 'is-invalid' : '' !!}" id="otrosf" name="otrosf" placeholder="Otros..." value="{{ old('otrosf') }}" {{ $errors->has('otrosf') ? 'aria-describedby="otrosf-error" aria-invalid="true"' : '' }}>
                        </div>
                    </div>                   
                </div>
                 <div class="row">
                     <div class="col-md-4">
                        <div class="form-group">
                            <label class="d-block">Es alergico algun medicamento</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="example-radios-inline1" name="in_alergico" value="1">
                                <label class="form-check-label" for="example-radios-inline1">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="example-radios-inline2" name="in_alergico"  value="2">
                                <label class="form-check-label" for="example-radios-inline2">no</label>
                            </div>
                            </div>
                         </div>
                        <div class="col-md-6">
                        <div class="form-group form-row">
                            <input type="text" class="form-control {!! $errors->has('alergico') ? 'is-invalid' : '' !!}" id="alergico" name="alergico" placeholder="..." value="{{ old('alergico') }}" {{ $errors->has('alergico') ? 'aria-describedby="alergico-error" aria-invalid="true"' : '' }}>
                        </div>
                        </div>
                                         
                </div>      
                
                <label for="correo">Habitos Tóxicos</label>   
                <div class="row">
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="tabaco" id="tabaco" @if ( old('tabaco')) checked @endif>
                                <label for="daily" title="Diariamente">
                                    Tabaco
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="alcohol" id="obesidad" @if ( old('alcohol')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Alcohol
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <div class="checkbox">
                                <input type="checkbox" name="droga" id="droga" @if ( old('droga')) checked @endif>
                                <label for="monthly" title="Mensual">
                                    Droga
                                </label>
                            </div>
                        </div>
                    </div>                    
                    <div class="col-md-6">
                        <div class="form-group form-row">
                            <input type="text" class="form-control {!! $errors->has('otrosh') ? 'is-invalid' : '' !!}" id="otrosh" name="otrosh" placeholder="Otros..." value="{{ old('otrosh') }}" {{ $errors->has('otrosh') ? 'aria-describedby="otrosh-error" aria-invalid="true"' : '' }}>
                        </div>
                    </div>                     
                    
                </div>  
                
                <label for="vacunacion">Vacunación</label>
                                 <div class="row">
                     <div class="col-md-2">
                        <div class="form-group">
                            <label class="d-block">Covid-19</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="example-radios-inline1" name="covid" value="1">
                                <label class="form-check-label" for="example-radios-inline1">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="example-radios-inline2" name="covid"  value="2">
                                <label class="form-check-label" for="example-radios-inline2">no</label>
                            </div>
                            </div>
                         </div>
                        <div class="col-md-3">
                        <div class="form-group form-row">
                        <label for="fecha">Fecha Covid</label>
                        <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_covid') ? 'is-invalid' : '' !!}" id="fecha_covid" name="fecha_covid" placeholder="d-m-Y HH:MM" data-date-format="Y-m-d H:i" data-enable-time="true" value="{{ old('fecha_covid') }}" {{ $errors->has('fecha_covid') ? 'aria-describedby="fecha_covid-error" aria-invalid="true"' : '' }}>
                        </div>
                        </div>
                     <div class="col-md-2"></div>
                         
                         <div class="col-md-2">
                        <div class="form-group">
                            <label class="d-block">Vacuna</label>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="example-radios-inline1" name="vacuna" value="1">
                                <label class="form-check-label" for="example-radios-inline1">Si</label>
                            </div>
                            <div class="form-check form-check-inline">
                                <input class="form-check-input" type="radio" id="example-radios-inline2" name="vacuna"  value="2">
                                <label class="form-check-label" for="example-radios-inline2">no</label>
                            </div>
                            </div>
                         </div>
                        <div class="col-md-3">
                        <div class="form-group form-row">
                        <label for="fecha">Fecha Vacuna</label>
                        <input type="text" class="js-flatpickr form-control {!! $errors->has('fecha_vacuna') ? 'is-invalid' : '' !!}" id="fecha_vacuna" name="fecha_vacuna" placeholder="d-m-Y HH:MM" data-date-format="Y-m-d H:i" data-enable-time="true" value="{{ old('fecha_vacuna') }}" {{ $errors->has('fecha_vacuna') ? 'aria-describedby="fecha_vacuna-error" aria-invalid="true"' : '' }}>
                        </div>
                        </div>                                         
                </div>
                

                
                        <div class="form-group form-row">
                            <label for="informe">Motivo de la Consulta</label>
                            <textarea class="form-control {!! $errors->has('informe') ? 'is-invalid' : '' !!}" id="informe" name="informe" rows="3" placeholder="Motivo.." {{ $errors->has('informe') ? 'aria-describedby="informe-error" aria-invalid="true"' : '' }}>{{ old('informe') }}</textarea>
                            @if( $errors->has('informe') )
                                <div id="informe-error" class="invalid-feedback animated fadeIn">{{ $errors->first('informe') }}</div>
                            @endif
                        </div>
                
                        <div class="form-group form-row">
                            <label for="diagnostico">Posible Diagnostico</label>
                            <textarea class="form-control {!! $errors->has('diagnostico') ? 'is-invalid' : '' !!}" id="diagnostico" name="diagnostico" rows="3" placeholder="Posible diagnostico.." {{ $errors->has('diagnostico') ? 'aria-describedby="diagnostico-error" aria-invalid="true"' : '' }}>{{ old('diagnostico') }}</textarea>
                            @if( $errors->has('diagnostico') )
                                <div id="diagnostico-error" class="invalid-feedback animated fadeIn">{{ $errors->first('diagnostico') }}</div>
                            @endif
                        </div>                 

                        <div class="form-group form-row">
                            <label for="tratamiento">Tratamiento y Posologia</label>
                            <textarea class="form-control {!! $errors->has('tratamiento') ? 'is-invalid' : '' !!}" id="tratamiento" name="tratamiento" rows="3" placeholder="..." {{ $errors->has('tratamiento') ? 'aria-describedby="tratamiento-error" aria-invalid="true"' : '' }}>{{ old('tratamiento') }}</textarea>
                            @if( $errors->has('tratamiento') )
                                <div id="tratamiento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tratamiento') }}</div>
                            @endif
                        </div> 
                
                        <div class="form-group form-row">
                            <label for="medico">Medico</label>
                            <input type="text" class="form-control {!! $errors->has('medico') ? 'is-invalid' : '' !!}" id="medico" name="medico" placeholder="Medico..." value="{{ old('medico') }}" {{ $errors->has('medico') ? 'aria-describedby="medico-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('medico') )
                                <div id="medico-error" class="invalid-feedback animated fadeIn">{{ $errors->first('medico') }}</div>
                            @endif
                        </div>                
                
                        <div class="form-group form-row">
                            <label for="especialidad">Especialidad</label>
                            <input type="text" class="form-control {!! $errors->has('especialidad') ? 'is-invalid' : '' !!}" id="especialidad" name="especialidad" placeholder="Especialidad..." value="{{ old('especialidad') }}" {{ $errors->has('especialidad') ? 'aria-describedby="especialidad-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('especialidad') )
                                <div id="especialidad-error" class="invalid-feedback animated fadeIn">{{ $errors->first('especialidad') }}</div>
                            @endif
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