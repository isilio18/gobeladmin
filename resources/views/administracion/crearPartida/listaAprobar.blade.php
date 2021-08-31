@extends('layouts.dashboard')

@section('css_before')
    <!-- Page JS Plugins CSS -->
<link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}">    
<link rel="stylesheet" href="{{ asset('assets/js/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/select2/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/ion-rangeslider/css/ion.rangeSlider.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/dropzone/dist/min/dropzone.min.css') }}">
<link rel="stylesheet" href="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.css') }}">
<style type="text/css">
#picker-container .flatpickr-calendar {
  top: 60px !important;
  left: 0 !important;
};
 </style>
@endsection

@section('js_after')
    <!-- Page JS Plugins -->
<script src="{{ asset('assets/js/plugins/bootstrap-maxlength/bootstrap-maxlength.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/select2/js/select2.full.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/jquery.maskedinput/jquery.maskedinput.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/dropzone/dropzone.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/pwstrength-bootstrap/pwstrength-bootstrap.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/flatpickr/flatpickr.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('assets/js/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>
<script>jQuery(function(){ Dashmix.helpers(['flatpickr', 'datepicker', 'colorpicker', 'maxlength', 'select2', 'rangeslider', 'masked-inputs', 'pw-strength']); });</script>
<script type="text/javascript">
    $(function () {
           

    });
</script>
    <!-- Page JS Code -->
    <script>
        $('.pagination').addClass('justify-content-end');
        $('.pagination li').addClass('page-item');
        $('.pagination li a').addClass('page-link');
        $('.pagination span').addClass('page-link');
    </script>
    <script>
        $('#avanzar').on('show.bs.modal', function (event) {
            $("#avanzarForm").attr('action','{{ url('/administracion/crearPartida/aprobar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
        });
        
        $('#rechazar').on('show.bs.modal', function (event) {
            $("#rechazarForm").attr('action','{{ url('/administracion/crearPartida/rechazar') }}');
            var button = $(event.relatedTarget);
            var item_id = button.data('item_id');
            var modal = $(this);
            modal.find('.modal-content #registro_id').val(item_id);
        });        
        
    </script>
@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
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
            <div class="block-options">
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="fullscreen_toggle"></button>
                <button type="button" class="btn-block-option" data-toggle="block-option" data-action="state_toggle" data-action-mode="demo">
                    <i class="si si-refresh"></i>
                </button>
            </div>
        </div>
        <div class="block-content">
            
        <form action="{{ URL::to('proceso/ruta/lista').'/'.$solicitud }}" method="get">
            <div class="row">
                <div class="col-sm-12 col-md-6">
                    <label>
                        <select name="perPage" class="custom-select" value="{{ $perPage }}">
                            @foreach(['5','10','20'] as $page)
                            <option @if($page == $perPage) selected @endif value="{{ $page }}">{{ $page }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <div class="col-sm-12 col-md-6">
                    <div class="input-group">
                        <input type="text" class="form-control" id="q" name="q" value="{{ $q }}" placeholder="Buscar...">
                        <div class="input-group-append">
                            <button type="submit" class="input-group-text">
                                <i class="fa fa-fw fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
                </div>
        </form>
        
            <table class="table table-bordered table-striped table-vcenter">
                <thead class="thead-light">
                    <tr>
                        <!--   <th class="text-center" style="width: 100px;">ID</th> -->
                        <th>Nro. Partida</th>
                        <th>Descripcion</th>
                        <th class="d-none d-md-table-cell text-center" style="width: 100px;">Estatus</th>
                    </tr>
                </thead>
                <tbody>
                @foreach($tab_creacion_partida as $key => $value)
                    <tr>
                        <!--  <td class="font-w600">{{ $value->id }}</td> -->
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->nu_partida }}</em></td>
                        <td class="d-none d-sm-table-cell"><em class="text-muted">{{ $value->de_partida }}</em></td>

                             @if ($tab_ruta->id_tab_estatus == 1)                                
                                <td class="d-none d-sm-table-cell"><em class="text-muted">Pendiente</em></td>
                             @endif
                             @if ($tab_ruta->id_tab_estatus == 2)                                
                                <td class="d-none d-sm-table-cell"><em class="text-muted">Procesado</em></td>
                             @endif  
                             @if ($tab_ruta->id_tab_estatus == 3)                                
                                <td class="d-none d-sm-table-cell"><em class="text-muted">Rechazado</em></td>
                             @endif                               
                    </tr>
                @endforeach
                </tbody>
            </table>

            {{ $tab_creacion_partida->appends(Request::only(['perPage','q']))->render() }}         

        </div>
        @if ($tab_ruta->id_tab_estatus == 1) 
        <div class="block-content bg-body-light">
            <div class="row justify-content-center push">
                <div class="col-md-10">
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" title="Aprobar" data-target="#avanzar" data-item_id="{{ $solicitud }}" >
                   <i class="fa fa-vote-yea"></i>Aprobar
                </button>                
                
                <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" title="Rechazar" data-target="#rechazar" data-item_id="{{ $solicitud }}" >
                    <i class="fa fa-times"></i> Rechazar
                </button>                    
            </div>
                </div>
        </div>
        @endif        
    </div>
    
    <!-- END Partial Table -->
</div>
<!-- END Page Content -->
@endsection