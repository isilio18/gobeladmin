@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->

@endsection

@section('js_after')
    <!-- Page JS Plugins -->

    <!-- Page JS Code -->

@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('administracion/catalogoPartida/guardar') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('administracion/catalogoPartida/lista') }}">
                    <i class="fa fa-arrow-left mr-1"></i> Volver
                </a>
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
                        
                        <div class="form-group">
                            <label for="tipo_partida">Tipo Partida</label>
                            <select class="custom-select {!! $errors->has('tipo_partida') ? 'is-invalid' : '' !!}" name="tipo_partida" id="tipo_partida" {{ $errors->has('tipo_partida') ? 'aria-describedby="tipo_partida-error" aria-invalid="true"' : '' }}>
                                <option value="null" >Seleccione...</option>
                                @foreach($tab_tipo_partida as $tipo_partida)
                                    <option value="{{ $tipo_partida->id }}" {{ $tipo_partida->id == old('tipo_partida') ? 'selected' : '' }}>{{ $tipo_partida->de_tipo_partida }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_partida') )
                                <div id="tipo_partida-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tipo_partida') }}</div>
                            @endif
                        </div>  
                        
                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <input type="text" class="form-control {!! $errors->has('descripcion') ? 'is-invalid' : '' !!}" id="descripcion" name="descripcion" placeholder="Descripcion..." value="{{ old('descripcion') }}" {{ $errors->has('descripcion') ? 'aria-describedby="descripcion-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('descripcion') )
                                <div id="descripcion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('descripcion') }}</div>
                            @endif
                        </div>            
                        
                        <div class="form-group">
                            <label for="nu_nivel">Nivel</label>
                            <input type="number" class="form-control {!! $errors->has('nu_nivel') ? 'is-invalid' : '' !!}" id="nu_nivel" name="nu_nivel" placeholder="nivel..." value="{{ old('nu_nivel') }}" {{ $errors->has('nu_nivel') ? 'aria-describedby="nu_nivel-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('nu_nivel') )
                                <div id="nu_nivel-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_nivel') }}</div>
                            @endif
                        </div>                             
                        
                        <div class="form-group">
                            <label for="nu_pa">PA</label>
                            <input type="number" class="form-control {!! $errors->has('nu_pa') ? 'is-invalid' : '' !!}" id="nu_pa" name="nu_pa" placeholder="pa..." value="{{ old('nu_pa') }}" {{ $errors->has('nu_pa') ? 'aria-describedby="nu_pa-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('nu_pa') )
                                <div id="nu_pa-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_pa') }}</div>
                            @endif
                        </div>  
                        
                        <div class="form-group">
                            <label for="nu_ge">GE</label>
                            <input type="number" class="form-control {!! $errors->has('nu_ge') ? 'is-invalid' : '' !!}" id="nu_ge" name="nu_ge" placeholder="ge..." value="{{ old('nu_ge') }}" {{ $errors->has('nu_ge') ? 'aria-describedby="nu_ge-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('nu_ge') )
                                <div id="nu_ge-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_ge') }}</div>
                            @endif
                        </div>        
                        
                        <div class="form-group">
                            <label for="nu_es">ES</label>
                            <input type="number" class="form-control {!! $errors->has('nu_es') ? 'is-invalid' : '' !!}" id="nu_es" name="nu_es" placeholder="es..." value="{{ old('nu_es') }}" {{ $errors->has('nu_es') ? 'aria-describedby="nu_es-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('nu_es') )
                                <div id="nu_es-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_es') }}</div>
                            @endif
                        </div>        
                        
                        <div class="form-group">
                            <label for="nu_se">SE</label>
                            <input type="number" class="form-control {!! $errors->has('nu_se') ? 'is-invalid' : '' !!}" id="nu_se" name="nu_se" placeholder="se..." value="{{ old('nu_se') }}" {{ $errors->has('nu_se') ? 'aria-describedby="nu_se-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('nu_es') )
                                <div id="nu_se-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_se') }}</div>
                            @endif
                        </div>     
                        
                        <div class="form-group">
                            <label for="nu_sse">SSE</label>
                            <input type="number" class="form-control {!! $errors->has('nu_sse') ? 'is-invalid' : '' !!}" id="nu_sse" name="nu_sse" placeholder="sse..." value="{{ old('nu_sse') }}" {{ $errors->has('nu_sse') ? 'aria-describedby="nu_sse-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('nu_es') )
                                <div id="nu_sse-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_sse') }}</div>
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