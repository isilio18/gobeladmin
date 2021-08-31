@extends('layouts.auth')

@section('css_before')
    <!-- Page JS Plugins CSS -->

@endsection

@section('js_after')
    <!-- Page JS Plugins -->

    <!-- Page JS Code -->

@endsection

@section('content')

<!-- Page Content -->
<div class="bg-image" style="background-image: url('{{ asset('/assets/media/photos/photo21@2x.jpg') }}');">
    <div class="row no-gutters justify-content-center bg-black-75">
        <div class="hero-static col-sm-8 col-md-6 col-xl-4 d-flex align-items-center p-2 px-sm-0">
            <!-- Reminder Block -->
            <div class="block block-transparent block-rounded w-100 mb-0 overflow-hidden">
                <div class="block-content block-content-full px-lg-5 px-xl-6 py-4 py-md-5 py-lg-6 bg-white">
                    <!-- Header -->
                    <div class="mb-2 text-center">
                        <a class="link-fx font-w700 font-size-h1" href="javascript:void(0)">
                            <span class="text-dark">GOBEL</span><span class="text-primary"> Salud</span>
                        </a>
                        <p class="text-uppercase font-w700 font-size-sm text-muted">Selección de Periodo</p>
                    </div>
                    <!-- END Header -->

                    <!-- Reminder Form -->
                    <!-- jQuery Validation (.js-validation-reminder class is initialized in js/pages/op_auth_reminder.min.js which was auto compiled from _es6/pages/op_auth_reminder.js) -->
                    <!-- For more info and examples you can check out https://github.com/jzaefferer/jquery-validation -->
                    <form class="js-validation-reminder" action="{{ url('/ejercicio') }}" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <div class="form-group">
                            <div class="input-group">
                                <select class="custom-select {!! $errors->has('ejercicio') ? 'is-invalid' : '' !!}" name="ejercicio" id="ejercicio" {{ $errors->has('ejercicio') ? 'aria-describedby="ejercicio-error" aria-invalid="true"' : '' }}>
                                    <option value="" >Seleccione...</option>
                                    @foreach($tab_ejercicio_fiscal as $ejercicio)
                                        <option value="{{ $ejercicio->id }}" {{ $ejercicio->id == old('ejercicio') ? 'selected' : '' }}>{{ $ejercicio->id }}</option>
                                    @endforeach
                                </select>
                                <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fa fa-calendar-alt"></i>
                                    </span>
                                </div>
                                @if( $errors->has('ejercicio') )
                                    <div id="ejercicio-error" class="invalid-feedback animated fadeIn">{{ $errors->first('ejercicio') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-group text-center">
                            <button type="submit" class="btn btn-block btn-hero-lg btn-hero-primary">
                                <i class="fa fa-fw fa-calendar-check mr-1"></i> Aceptar
                            </button>
                        </div>
                    </form>
                    <!-- END Reminder Form -->
                </div>
            </div>
            <!-- END Reminder Block -->
        </div>
    </div>
</div>
<!-- END Page Content -->

@endsection