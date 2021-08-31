@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">    
<link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
<script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.print.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.html5.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.flash.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/datatables/buttons/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/be_tables_datatables.min.js') }}"></script>
    <!-- Page JS Code -->

@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('administracion/retencion/concepto/guardar') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="id_tab_retencion" value="{{ $tab_retencion->id }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('/administracion/retencion/concepto/lista').'/'. $tab_retencion->id }}">
                    <i class="fa fa-arrow-left mr-1"></i> Volver
                </a>
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">{{ $tab_retencion->de_retencion }}</li>
                    <li class="breadcrumb-item">Concepto</li>
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
                        
                        <div class="form-group form-row">
                            <div class="col-2">
                                <label for="tipo_documento">Tipo</label>
                                <select class="custom-select {!! $errors->has('tipo_documento') ? 'is-invalid' : '' !!}" name="tipo_documento" id="tipo_documento" {{ $errors->has('tipo_documento') ? 'aria-describedby="tipo_documento-error" aria-invalid="true"' : '' }}>
                                    <option value="" >Seleccione...</option>
                                    @foreach($tab_documento as $documento)
                                    <option value="{{ $documento->id }}" {{ $documento->id == old('tipo_documento') ? 'selected' : '' }}>{{ $documento->de_inicial }}</option>
                                    @endforeach
                                </select>
                                @if( $errors->has('tipo_documento') )
                                    <div id="tipo_documento-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_documento') }}</div>
                                @endif
                            </div>

                        </div>             
                        
                            <div class="form-group form-row">
                            <label for="ramos">Ramo</label>
                            <select class="custom-select {!! $errors->has('ramos') ? 'is-invalid' : '' !!}" name="ramos" id="ramos" {{ $errors->has('ramos') ? 'aria-describedby="ramos-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_ramo as $ramos)
                                <option value="{{ $ramos->id }}" {{ $ramos->id == old('ramos') ? 'selected' : '' }}>{{ $ramos->de_ramo }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('ramos') )
                                <div id="ramos-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ramos') }}</div>
                            @endif
                           </div>                        
                    
                         <div class="form-group form-row">
                             <div class="col-4">
                            <label for="porcentaje_retencion">Porcentaje Retencion</label>
                            <input type="text" class="form-control {!! $errors->has('porcentaje_retencion') ? 'is-invalid' : '' !!}" id="porcentaje_retencion" name="porcentaje_retencion" placeholder="% Retencion..." value="{{ old('porcentaje_retencion') }}" {{ $errors->has('porcentaje_retencion') ? 'aria-describedby="porcentaje_retencion-error" aria-invalid="true"' : '' }}>
                            
                            @if( $errors->has('porcentaje_retencion') )
                                <div id="porcentaje_retencion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('porcentaje_retencion') }}</div>
                            @endif
                        </div>
                             </div>
                        
                         <div class="form-group form-row">
                            <label for="monto_minimo">Monto Minimo</label>
                            <input type="text" class="form-control {!! $errors->has('monto_minimo') ? 'is-invalid' : '' !!}" id="monto_minimo" name="monto_minimo" placeholder="Monto Minimo..." value="{{ old('monto_minimo') }}" {{ $errors->has('monto_minimo') ? 'aria-describedby="monto_minimo-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('monto_minimo') )
                                <div id="monto_minimo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('monto_minimo') }}</div>
                            @endif
                        </div>      
                        
                        <div class="form-group form-row">
                            <label for="concepto">Concepto</label>
                            <textarea class="js-maxlength form-control {!! $errors->has('concepto') ? 'is-invalid' : '' !!}" id="concepto" name="concepto" rows="3"  maxlength="100" placeholder="Concepto.." data-always-show="true" {{ $errors->has('concepto') ? 'aria-describedby="concepto-error" aria-invalid="true"' : '' }}>{{ old('concepto') }}</textarea>
                            <div class="form-text text-muted font-size-sm font-italic">Breve Descripcion del Concepto.</div>
                            @if( $errors->has('concepto') )
                                <div id="concepto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('concepto') }}</div>
                            @endif
                        </div>                         

                        <div class="form-group form-row">
                            <label for="numero_concepto">Nº Concepto</label>
                            <input type="text" class="form-control {!! $errors->has('numero_concepto') ? 'is-invalid' : '' !!}" id="numero_concepto" name="numero_concepto" placeholder="Nº Concepto..." value="{{ old('numero_concepto') }}" {{ $errors->has('numero_concepto') ? 'aria-describedby="numero_concepto-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('numero_concepto') )
                                <div id="numero_concepto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('numero_concepto') }}</div>
                            @endif
                        </div>      
                        
                        <div class="form-group form-row">
                            <label for="sustraendo">Sustraendo</label>
                            <input type="text" class="form-control {!! $errors->has('sustraendo') ? 'is-invalid' : '' !!}" id="sustraendo" name="sustraendo" placeholder="Sustraendo..." value="{{ old('sustraendo') }}" {{ $errors->has('sustraendo') ? 'aria-describedby="sustraendo-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('sustraendo') )
                                <div id="sustraendo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('sustraendo') }}</div>
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