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
    <form action="{{ URL::to('administracion/pagoNomina/guardar').'/'.$data->id }}" method="POST" enctype="multipart/form-data">
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

                                    <div class="form-group form-row">
                                        <div class="col-4">
                                            <label for="fecha_pago">Fecha de Pago</label>
                                            <input type="text" class="js-flatpickr form-control bg-white {!! $errors->has('fecha_pago') ? 'is-invalid' : '' !!}" id="fecha_pago" name="fecha_pago" placeholder="d-m-Y" data-date-format="d-m-Y" value="{{ empty(old('fecha_pago'))? $data->fe_pago : old('fecha_pago') }}" {{ $errors->has('fecha_pago') ? 'aria-describedby="fecha_compra-error" aria-invalid="true"' : '' }}>
                                            @if( $errors->has('fecha_pago') )
                                                <div id="fecha_pago-error" class="invalid-feedback animated fadeIn">{{ $errors->first('fecha_pago') }}</div>
                                            @endif
                                        </div>
                                    </div>                                    
                                    
                                <div class="form-group">
                                    <label for="tx_concepto">Concepto</label>
                                    <textarea class="js-maxlength form-control {!! $errors->has('tx_concepto') ? 'is-invalid' : '' !!}" id="tx_concepto" name="tx_concepto" rows="3"  maxlength="100" placeholder="Concepto.." data-always-show="true" {{ $errors->has('tx_concepto') ? 'aria-describedby="tx_concepto-error" aria-invalid="true"' : '' }}>{{ empty(old('tx_concepto'))? $data->tx_concepto : old('tx_concepto') }}</textarea>
                                    <div class="form-text text-muted font-size-sm font-italic">Breve concepto de la nomina.</div>
                                    @if( $errors->has('tx_concepto') )
                                        <div id="tx_concepto-error" class="invalid-feedback animated fadeIn">{{ $errors->first('tx_concepto') }}</div>
                                    @endif
                                </div>                                     

                                </div>

                            </div>

                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Archivo de la nomina(xlsx)</h3>
                                </div>
                                <div class="block-content">

                        <div class="form-group">
                            <label>Archivo de la nomina</label>
                            <div class="custom-file">
                                <input type="file" class="custom-file-input {!! $errors->has('archivo') ? 'is-invalid' : '' !!}{!! $errors->has('extension') ? 'is-invalid' : '' !!}" data-toggle="custom-file-input" id="archivo" name="archivo" {{ $errors->has('archivo') ? 'aria-describedby="archivo-error" aria-invalid="true"' : '' }}{{ $errors->has('extension') ? 'aria-describedby="extension-error" aria-invalid="true"' : '' }}>
                                <label class="custom-file-label" for="archivo">Seleccione el archivo</label>
                                @if( $errors->has('archivo') )
                                    <div id="archivo-error" class="invalid-feedback animated fadeIn">{{ $errors->first('archivo') }}</div>
                                @endif
                                @if( $errors->has('extension') )
                                    <div id="extension-error" class="invalid-feedback animated fadeIn">La extension del archivo es invalida</div>
                                @endif                                
                            </div>
                        </div>

                                </div>
                            </div>
                        
            <div class="block block-rounded">
                <ul class="nav nav-tabs nav-tabs-block" data-toggle="tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" href="#btabs-animated-slideup-asignacion">Asignación</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideup-deduccion">Deducción</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#btabs-animated-slideup-aporte">Aporte</a>
                    </li>       
                </ul>
                <div class="block-content tab-content overflow-hidden">
                    <div class="tab-pane fade fade-up show active" id="btabs-animated-slideup-asignacion" role="tabpanel">       
                           
            <table class="table table-bordered table-striped table-vcenter">
                <thead class="thead-light">
                    <tr>
                    <!--    <th class="text-center" style="width: 100px;">ID</th> -->
                        <th>Concepto</th>
                        <th>N° concepto</th>
                        <th>Partida</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($detalle_asignacion as $key => $value)
                    <tr>
                        <td class="d-none d-sm-table-cell">{{ $value->tx_descripcion }}</td>
                        <td class="d-none d-sm-table-cell">{{ $value->nu_concepto_nomina }}</td>
                        <td class="d-none d-sm-table-cell">{{ $value->tx_partida }}</td>
                        <td class="d-none d-sm-table-cell">{{ $value->mo_pago }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>                         
                        
                    </div>
                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-deduccion" role="tabpanel">

            <table class="table table-bordered table-striped table-vcenter">
                <thead class="thead-light">
                    <tr>
                    <!--    <th class="text-center" style="width: 100px;">ID</th> -->
                        <th>Concepto</th>
                        <th>N° concepto</th>
                        <th>Partida</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($detalle_deduccion as $key => $value)
                    <tr>
                        <td class="d-none d-sm-table-cell">{{ $value->tx_descripcion }}</td>
                        <td class="d-none d-sm-table-cell">{{ $value->nu_concepto_nomina }}</td>
                        <td class="d-none d-sm-table-cell">{{ $value->tx_partida }}</td>
                        <td class="d-none d-sm-table-cell">{{ $value->mo_pago }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>                                               
                        
                    </div>
                    
                    <div class="tab-pane fade fade-up" id="btabs-animated-slideup-aporte" role="tabpanel">

            <table class="table table-bordered table-striped table-vcenter">
                <thead class="thead-light">
                    <tr>
                    <!--    <th class="text-center" style="width: 100px;">ID</th> -->
                        <th>Concepto</th>
                        <th>N° concepto</th>
                        <th>Partida</th>
                        <th>Monto</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($detalle_aporte as $key => $value)
                    <tr>
                        <td class="d-none d-sm-table-cell">{{ $value->tx_descripcion }}</td>
                        <td class="d-none d-sm-table-cell">{{ $value->nu_concepto_nomina }}</td>
                        <td class="d-none d-sm-table-cell">{{ $value->tx_partida }}</td>
                        <td class="d-none d-sm-table-cell">{{ $value->mo_pago }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>                                        
                        
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