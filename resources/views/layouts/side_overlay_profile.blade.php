<!-- Profile -->
<div class="tab-pane pull-x fade fade-up show active" id="so-profile" role="tabpanel">
    <form action="{{ url('/usuario/password') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="block mb-0">
            <!-- Personal -->
            <div class="block-content block-content-sm block-content-full bg-body">
                <span class="text-uppercase font-size-sm font-w700">Datos</span>
            </div>
            <div class="block-content block-content-full">

                @if (count($errors) > 0)
                    @if (session()->has('overlay_activo'))
                        @section('js_side_overlay')
                            <!-- Page JS Code -->
                            <script>
                                /*$("#page-container").addClass("side-overlay-o");*/
                                jQuery(function(){ Dashmix.layout('side_overlay_open'); });
                            </script>
                        @endsection
                    @endif
                    @section('js_notificacion')
                        <!-- Page JS Code -->
                        <script>
                            jQuery(function(){ Dashmix.helpers('notify', {type: 'danger', icon: 'fa fa-times-circle mr-1', align: 'center', message: 'Hay problemas con su validacion!'}); });
                        </script>
                    @endsection
                    <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                        <div class="flex-fill mr-3">
                            <p class="mb-0">Hay problemas con su validacion!</p>
                        </div>
                        <div class="flex-00-auto">
                            <i class="fa fa-fw fa-times-circle"></i>
                        </div>
                    </div>
                @endif

                @if( $errors->has('da_mensaje_side_overlay') )
                    <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                        <div class="flex-fill mr-3">
                            <p class="mb-0">{{ $errors->first('da_mensaje_side_overlay') }}</p>
                        </div>
                    </div>
                @endif

                @if (session()->has('msg_side_overlay'))
                    @section('js_notificacion')
                        <!-- Page JS Code -->
                        <script>
                            /*jQuery(function(){ Dashmix.helpers('notify', {type: 'success', icon: 'fa fa-check mr-1', align: 'center', message: '{{ session('msg_side_overlay') }}'}); });*/
                            jQuery('#toast-aviso').toast('show');
                        </script>
                    @endsection
                    <div class="alert alert-success d-flex align-items-center" role="alert">
                        <div class="flex-00-auto">
                            <i class="fa fa-fw fa-check"></i>
                        </div>
                        <div class="flex-fill ml-3">
                            <p class="mb-0">{{ session('msg_side_overlay') }}</p>
                        </div>
                    </div>
                @endif

                <div class="form-group">
                    <label>Usuario</label>
                    <input type="text" readonly class="form-control" id="staticEmail" value="{{ Auth::user()->da_login }}">
                </div>
                <div class="form-group">
                    <label for="nombre">Nombre</label>
                    <input type="text" class="form-control {!! $errors->has('nombre') ? 'is-invalid' : '' !!}" id="nombre" name="nombre" value="{{ Auth::user()->nb_usuario }}" {!! $errors->has('nombre') ? 'aria-describedby="nombre-error" aria-invalid="true"' : '' !!} placeholder="Nombre">
                    @if( $errors->has('nombre') )
                        <div id="nombre-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nombre') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="correo">Correo</label>
                    <input type="email" class="form-control {!! $errors->has('correo') ? 'is-invalid' : '' !!}" id="correo" name="correo" value="{{ Auth::user()->da_email }}" {!! $errors->has('correo') ? 'aria-describedby="correo-error" aria-invalid="true"' : '' !!} placeholder="Correo">
                    @if( $errors->has('correo') )
                        <div id="correo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('correo') }}</div>
                    @endif
                </div>
            </div>
            <!-- END Personal -->

            <!-- Password Update -->
            <div class="block-content block-content-sm block-content-full bg-body">
                <span class="text-uppercase font-size-sm font-w700">Actualizaci??n de contrase??a</span>
            </div>
            <div class="block-content block-content-full">
                <div class="form-group">
                    <label for="contrase??a_actual">Contrase??a Actual</label>
                    <input type="password" class="form-control {!! $errors->has('contrase??a_actual') ? 'is-invalid' : '' !!}" id="contrase??a_actual" name="contrase??a_actual" {!! $errors->has('contrase??a_actual') ? 'aria-describedby="contrase??a_actual-error" aria-invalid="true"' : '' !!} placeholder="Contrase??a Actual" value="{{ old('contrase??a_actual') }}">
                    @if( $errors->has('contrase??a_actual') )
                        <div id="contrase??a_actual-error" class="invalid-feedback animated fadeIn">{{ $errors->first('contrase??a_actual') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="contrase??a">Nueva Contrase??a</label>
                    <input type="password" class="form-control {!! $errors->has('contrase??a') ? 'is-invalid' : '' !!}" id="contrase??a" name="contrase??a" {!! $errors->has('contrase??a') ? 'aria-describedby="contrase??a-error" aria-invalid="true"' : '' !!} placeholder="Contrase??a Nueva" value="{{ old('contrase??a') }}">
                    @if( $errors->has('contrase??a') )
                        <div id="contrase??a-error" class="invalid-feedback animated fadeIn">{{ $errors->first('contrase??a') }}</div>
                    @endif
                </div>
                <div class="form-group">
                    <label for="contrase??a_confirmation">Confirmar Nueva Contrase??a</label>
                    <input type="password" class="form-control  {!! $errors->has('contrase??a_confirmation') ? 'is-invalid' : '' !!}" id="contrase??a_confirmation" name="contrase??a_confirmation" {!! $errors->has('contrase??a_confirmation') ? 'aria-describedby="contrase??a_confirmation-error" aria-invalid="true"' : '' !!} placeholder="Contrase??a Confirmaci??n" value="{{ old('contrase??a_confirmation') }}">
                    @if( $errors->has('contrase??a_confirmation') )
                        <div id="contrase??a_confirmation-error" class="invalid-feedback animated fadeIn">{{ $errors->first('contrase??a_confirmation') }}</div>
                    @endif
                </div>
            </div>
            <!-- END Password Update -->

            {{--
            <!-- Options -->
            <div class="block-content block-content-sm block-content-full bg-body">
                <span class="text-uppercase font-size-sm font-w700">Opciones</span>
            </div>
            <div class="block-content">
                <div class="custom-control custom-checkbox custom-control-primary mb-1">
                    <input type="checkbox" class="custom-control-input" id="so-settings-status" name="so-settings-status" value="1">
                    <label class="custom-control-label" for="so-settings-status">Estado en l??nea</label>
                </div>
                <p class="text-muted font-size-sm">
                    Haga que su estado en l??nea sea visible para otros usuarios de su aplicaci??n
                </p>
                <div class="custom-control custom-checkbox custom-control-primary mb-1">
                    <input type="checkbox" class="custom-control-input" id="so-settings-notifications" name="so-settings-notifications" value="1" checked>
                    <label class="custom-control-label" for="so-settings-notifications">Notificaciones</label>
                </div>
                <p class="text-muted font-size-sm">
                    Reciba notificaciones de escritorio sobre sus proyectos y ventas
                </p>
                <div class="custom-control custom-checkbox custom-control-primary mb-1">
                    <input type="checkbox" class="custom-control-input" id="so-settings-updates" name="so-settings-updates" value="1" checked>
                    <label class="custom-control-label" for="so-settings-updates">Actualizaci??n autom??tica</label>
                </div>
                <p class="text-muted font-size-sm">
                Si est?? habilitado, mantendremos todas sus aplicaciones y servidores actualizados con las funciones m??s recientes autom??ticamente
                </p>
            </div>
            <!-- END Options -->
            --}}

            <!-- Submit -->
            <div class="block-content row justify-content-center border-top">
                <div class="col-9">
                    <button type="submit" class="btn btn-block btn-hero-primary">
                        <i class="fa fa-fw fa-save mr-1"></i> Guardar
                    </button>
                </div>
            </div>
            <!-- END Submit -->
        </div>
    </form>
</div>
<!-- END Profile -->