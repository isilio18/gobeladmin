@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->

    <link rel="stylesheet" id="css-main" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/datatables/buttons-bs4/buttons.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/js/plugins/dropzone/dist/min/dropzone.min.css') }}">
@endsection

@section('js_after')
    <!-- Page JS Plugins -->

    <script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>

    
    <script src="{{ asset('assets/js/plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/datatables/buttons/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/pwstrength-bootstrap/pwstrength-bootstrap.min.js') }}"></script>  
<script>jQuery(function(){ Dashmix.helpers(['maxlength', 'select2', 'rangeslider', 'masked-inputs', 'pw-strength']); });</script>
    <!-- Page JS Code -->

    <script>

        jQuery(function(){ Dashmix.helpers([ 'flatpickr', 'select2']); });

    </script>

    @if (count($errors) > 0)

    @endif
@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('administracion/pagoNomina/guardarEditar') }}" method="POST" enctype="multipart/form-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="solicitud" value="{{ $solicitud }}">
        <input type="hidden" name="ruta" value="{{ $ruta }}">
        <input type="hidden" name="id_tab_pago_nomina" value="{{ $data->id }}">
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
                        @if( session()->has('de_alert_form') )
                        <div class="alert alert-danger d-flex align-items-center justify-content-between" role="alert">
                            <div class="flex-fill mr-3">
                                <p class="mb-0">{{ session('de_alert_form')}}</p>
                            </div>
                        </div>
                        @endif

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Datos de la nomina</h3><div id="resultado"></div>
                                </div>
                                <div class="block-content">

                                    <div class="form-group">
                                        <label for="monto_cargado">Monto Cargado</label>
                                        <input type="text" class="form-control {!! $errors->has('monto_cargado') ? 'is-invalid' : '' !!}" readonly id="monto_cargado" name="monto_cargado"  value="{{ number_format($monto_cargado, 2, ',','.')}}">
                                    </div>                                    
                                    
                                    <div class="form-group">
                                        <label for="fecha_pago">Diferencia</label>
                                        <input type="text" class="form-control {!! $errors->has('fecha_pago') ? 'is-invalid' : '' !!}" readonly id="fecha_pago" name="fecha_pago"  value="{{ $data->fe_pago  }}">
                                    </div>                                    
                                                                       
                                    
                                <div class="form-group">
                                    <label for="tx_concepto">Concepto</label>
                                    <textarea class="js-maxlength form-control {!! $errors->has('tx_concepto') ? 'is-invalid' : '' !!}" readonly id="tx_concepto" name="tx_concepto" rows="3"  maxlength="100" placeholder="Concepto.." data-always-show="true" >{{ $data->tx_concepto }}</textarea>
                                    <div class="form-text text-muted font-size-sm font-italic">Breve concepto de la nomina.</div>
                                </div>      
                                    
                                    <div class="form-group">
                                        <label for="monto">Monto</label>
                                        <input type="text" class="form-control {!! $errors->has('monto') ? 'is-invalid' : '' !!}" readonly id="monto" name="monto"  value="{{ number_format($monto, 2, ',','.')}}">
                                    </div>       
                                    
                                    <div class="form-group">
                                        <label for="diferencia">Diferencia</label>
                                        <input type="text" class="form-control {!! $errors->has('diferencia') ? 'is-invalid' : '' !!}" readonly id="diferencia" name="diferencia"  value="{{ number_format($diferencia, 2, ',','.')}}">
                                    </div>                                      

                                </div>

                            </div>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Archivo .Txt(Debe coincidir el total del archivo con el monto cargado para avanzar en el proceso)</h3>
                                </div>
                                <div class="block-content">

                        <div class="form-group">
                            <label>Archivo txt de la nomina</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input {!! $errors->has('archivo') ? 'is-invalid' : '' !!}{!! $errors->has('extension') ? 'is-invalid' : '' !!}{!! $errors->has('nu_cedula') ? 'is-invalid' : '' !!}{!! $errors->has('tx_cedula') ? 'is-invalid' : '' !!}{!! $errors->has('nu_cuenta_bancaria') ? 'is-invalid' : '' !!}" data-toggle="custom-file-input" id="archivo" name="archivo" {{ $errors->has('archivo') ? 'aria-describedby="archivo-error" aria-invalid="true"' : '' }}{{ $errors->has('extension') ? 'aria-describedby="extension-error" aria-invalid="true"' : '' }}>
                                <label class="custom-file-label" for="archivo">Seleccione el archivo</label>
                                @if( $errors->has('archivo') )
                                    <div id="archivo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('archivo') }}</div>
                                @endif
                                @if( $errors->has('extension') )
                                    <div id="extension-error" class="invalid-feedback animated fadeIn">La extension del archivo es invalida</div>
                                @endif 
                                @if (count($errors) > 0)
                                @if (session()->has('msg_alerta'))
                                @if( $errors->has('nu_cedula') )
                                    <div id="extension-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_cedula') }}</div>
                                @endif
                                @if( $errors->has('tx_cedula') )
                                    <div id="extension-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tx_cedula') }}</div>
                                @endif   
                                @if( $errors->has('nu_cuenta_bancaria') )
                                    <div id="extension-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_cuenta_bancaria') }}</div>
                                @endif                                
                                     @endif
                                @endif                                  
                                
                            </div>
                        </div>

                                </div>
                            </div>
                        
                            <table class="table table-bordered table-striped table-vcenter">
                                <thead class="thead-light">
                                    <tr>
                                    <!--    <th class="text-center" style="width: 100px;">ID</th> -->
                                        <th>Cantidad</th>
                                        <th>Banco</th>
                                        <th>Monto</th>
                                    </tr>
                                </thead>
                                <tbody>
                                @foreach($tab_archivo_pago_nomina as $key => $value)
                                    <tr>
                                        <td class="d-none d-sm-table-cell">{{ $value->cantidad }}</td>
                                        <td class="d-none d-sm-table-cell">{{ $value->de_banco }}</td>
                                        <td class="d-none d-sm-table-cell">{{ $value->mo_pago }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>                         

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