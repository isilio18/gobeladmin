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
        
        jQuery(function(){ Dashmix.helpers([ 'flatpickr', 'select2','table-tools-checkable']); });

    </script>
@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('administracion/creditoAdicional/guardar') }}" method="POST">
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
                                                                       
                                <div class="form-group form-row">
                                    <div class="col-4">
                                        <label for="fecha_credito">Fecha Credito</label>
                                        <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fecha_credito') ? 'is-invalid' : '' !!}" id="fecha_credito" name="fecha_credito" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ old('fecha_credito') }}" {{ $errors->has('fecha_credito') ? 'aria-describedby="fecha_credito-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('fecha_credito') )
                                            <div id="fecha_credito-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_credito') }}</div>
                                        @endif
                                    </div>
                                </div> 
                                   
                                <div class="form-group">
                                    <label for="tx_descripcion">Descripcion</label>
                                    <textarea class="js-maxlength form-control {!! $errors->has('tx_descripcion') ? 'is-invalid' : '' !!}" id="tx_descripcion" name="tx_descripcion" rows="3"  maxlength="100" placeholder="Descripcion.." data-always-show="true"  {{ $errors->has('tx_descripcion') ? 'aria-describedby="tx_descripcion-error" aria-invalid="true"' : '' }}>{{ old('tx_descripcion') }}</textarea>
                                    <div class="form-text text-muted font-size-sm font-italic">Breve descripcion del credito adicional.</div>
                                    @if( $errors->has('tx_descripcion') )
                                        <div id="tx_descripcion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tx_descripcion') }}</div>
                                    @endif
                                </div>          
                                    
                                <div class="form-group">
                                    <label for="tx_justificacion">Justificacion</label>
                                    <textarea class="js-maxlength form-control {!! $errors->has('tx_justificacion') ? 'is-invalid' : '' !!}" id="tx_justificacion" name="tx_justificacion" rows="3"  maxlength="100" placeholder="Justificacion.." data-always-show="true"  {{ $errors->has('tx_justificacion') ? 'aria-describedby="tx_justificacion-error" aria-invalid="true"' : '' }}>{{ old('tx_justificacion') }}</textarea>
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
                                            <option value="{{ $fuente_financiamiento->id }}" {{ $fuente_financiamiento->id == old('fuente_financiamiento') ? 'selected' : '' }}>{{ $fuente_financiamiento->de_fuente_financiamiento }}</option>
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
                                    </select>
                                    @if( $errors->has('nu_financiamiento') )
                                        <div id="nu_financiamiento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_financiamiento') }}</div>
                                    @endif
                                </div>  
                                    
                                <div class="form-group form-row">
                                    <div class="col-4">
                                        <label for="fecha_oficio">Fecha Oficio</label>
                                        <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fecha_oficio') ? 'is-invalid' : '' !!}" id="fecha_oficio" name="fecha_oficio" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ old('fecha_oficio') }}" {{ $errors->has('fecha_oficio') ? 'aria-describedby="fecha_oficio-error" aria-invalid="true"' : '' }}>
                                        @if( $errors->has('fecha_oficio') )
                                            <div id="fecha_oficio-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_oficio') }}</div>
                                        @endif
                                    </div>
                                </div>   
                                    
                                <div class="form-group">
                                    <label for="articulo_ley">Articulo / Ley</label>
                                    <input type="text" class="form-control {!! $errors->has('articulo_ley') ? 'is-invalid' : '' !!}" id="articulo_ley" name="articulo_ley" placeholder="..." value="{{ old('articulo_ley') }}" {{ $errors->has('articulo_ley') ? 'aria-describedby="articulo_ley-error" aria-invalid="true"' : '' }}>
                                    @if( $errors->has('articulo_ley') )
                                        <div id="articulo_ley-error" class="invalid-feedback animated fadeIn">{{ $errors->first('articulo_ley') }}</div>
                                    @endif
                                </div> 

                                <div class="form-group">
                                    <label for="tipo_credito">Tipo Credito Adicional</label>
                                    <select class="custom-select {!! $errors->has('tipo_credito') ? 'is-invalid' : '' !!}" name="tipo_credito" id="tipo_credito" {{ $errors->has('tipo_credito') ? 'aria-describedby="tipo_credito-error" aria-invalid="true"' : '' }}>
                                        <option value="0" >Seleccione...</option>
                                        @foreach($tab_tipo_credito_adicional as $tipo_credito_adicional)
                                            <option value="{{ $tipo_credito_adicional->id }}" {{ $tipo_credito_adicional->id == old('tipo_credito') ? 'selected' : '' }}>{{ $tipo_credito_adicional->de_tipo_credito_adicional }}</option>
                                        @endforeach
                                    </select>
                                    @if( $errors->has('tipo_credito') )
                                        <div id="tipo_credito-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_credito') }}</div>
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