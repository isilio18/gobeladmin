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

        jQuery(function(){ Dashmix.helpers([ 'flatpickr', 'select2','table-tools-checkable']); });

    </script>

@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('administracion/tesoreria/guardar') }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="solicitud" value="{{ $id }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('administracion/tesoreria/procesado') }}">
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

                        <!--<h2 class="content-heading pt-0">Pagos</h2>-->



                            <div class="block block-themed block-rounded block-bordered">
                                <div class="block-header bg-primary-light border-bottom">
                                    <h3 class="block-title">Pagos Realizados</h3>
                                </div>
                                <div class="block-content">
                                                                       
            <div class="block block-rounded">

                <div class="block-content tab-content overflow-hidden">



            <table class="table table-bordered table-striped table-vcenter">
                <thead>
                    <tr>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Nº transacción</th>
                        <th class="d-none d-sm-table-cell" style="width: 20%;">Banco</th>
                        <th>Cuenta Bancaria</th>
                        <th>Fecha </th>
                        <th>Monto</th>
                        <th class="font-w600 text-center">Acción</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tab_pago as $key => $value)
                    <tr>
                        <td class="font-w600">{{ $value->nu_pago }}</td>
                        <td class="font-w600">{{ $value->de_banco }}</td>
                        <td class="font-w600">{{ $value->nu_cuenta_bancaria }}-{{ $value->de_cuenta_bancaria }}</td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->fe_pago }}</em></td>
                        <td class="font-w600">{{ $value->mo_pago }}</td>
                        <td class="text-center">
                        <button type="button" class="btn btn-sm btn-primary" data-toggle="tooltip" title="Ver Documento" onclick="window.open('{{ url('/proceso/reporte/ver').'/'. $value->id }}/' + (new Date().getTime()), '_blank')">
                            <i class="fa fa-print"></i>
                        </button>
                        </td>
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
        </div>

    </form>
    </div>
    <!-- END New Post -->
</div>
<!-- END Page Content -->
@endsection