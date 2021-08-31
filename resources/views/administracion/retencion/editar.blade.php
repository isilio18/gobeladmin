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
<script>
$(function( $ ){  
    var table_pagar = $('.tabla_cuenta_pagar').DataTable();
   table_pagar.columns([0]).visible(false);
   
    var table_tercero = $('.tabla_deposito_tercero').DataTable();
   table_tercero.columns([0]).visible(false);   
    
    $('.btn-cpp').on('click', function(e) {

    jQuery('#modal-cuenta-pagar').modal('show');

    });
    
    $('.btn-ddt').on('click', function(e) {

    jQuery('#modal-deposito-tercero').modal('show');

    });    
    
    $('.tabla_cuenta_pagar').on('click ','tbody tr', function(e) {
    var table = $('.tabla_cuenta_pagar').DataTable();
    var data = table.row( this ).data();
    $("#id_tab_cuenta_contable_retencion_por_pagar").val(data[0]);
    $("#nu_cuenta_contable_retencion_por_pagar").val(data[1]+' - '+data[2]);
    jQuery('#modal-cuenta-pagar').modal('hide');
    });   
    
    $('.tabla_deposito_tercero').on('click ','tbody tr', function(e) {
    var table = $('.tabla_deposito_tercero').DataTable();
    var data = table.row( this ).data();
    $("#id_tab_cuenta_contable_deposito_tercero").val(data[0]);
    $("#nu_cuenta_contable_deposito_tercero").val(data[1]+' - '+data[2]);
    jQuery('#modal-deposito-tercero').modal('hide');
    });    

});    

</script>
    <!-- Page JS Code -->

@endsection

@section('content')

<!-- Page Content -->
<div class="content content-full content-boxed">
    <!-- Partial Table -->
    <div class="block block-rounded block-bordered">
    <!-- New Post -->
    <form action="{{ URL::to('administracion/retencion/guardar').'/'.$data->id }}" method="POST">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="block">
            <div class="block-header block-header-default">
                <a class="btn btn-light" href="{{ URL::to('administracion/retencion/lista') }}">
                    <i class="fa fa-arrow-left mr-1"></i> Volver
                </a>
        <div class="d-flex flex-column flex-sm-row justify-content-sm-between align-items-sm-center">
            <nav class="flex-sm-00-auto ml-sm-3" aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item">Retenciones</li>
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
                        
                            <div class="form-group">
                            <label for="tipo_retencion">Tipo de Retencion</label>
                            <select class="custom-select {!! $errors->has('tipo_retencion') ? 'is-invalid' : '' !!}" name="tipo_retencion" id="tipo_retencion" {{ $errors->has('tipo_retencion') ? 'aria-describedby="tipo_retencion-error" aria-invalid="true"' : '' }}>
                                <option value="0" >Seleccione...</option>
                                @foreach($tab_tipo_retencion as $tipo_retencion)
                                <option value="{{ $tipo_retencion->id }}" {{ $tipo_retencion->id == $data->id_tab_tipo_retencion ? 'selected' : '' }}>{{ $tipo_retencion->de_tipo_retencion }}</option>
                                @endforeach
                            </select>
                            @if( $errors->has('tipo_retencion') )
                                <div id="tipo_retencion-error" class="invalid-feedback animated fadeIn">El Campo tipo de retencion es obligatorio</div>
                            @endif
                           </div>                      
                    

                        <div class="form-group">
                            <label for="descripcion">Descripcion</label>
                            <input type="text" class="form-control {!! $errors->has('descripcion') ? 'is-invalid' : '' !!}" id="descripcion" name="descripcion" placeholder="Descripcion..." value="{{ empty(old('descripcion'))? $data->de_retencion : old('descripcion') }}" {{ $errors->has('descripcion') ? 'aria-describedby="descripcion-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('descripcion') )
                                <div id="descripcion-error" class="invalid-feedback animated fadeIn">{{ $errors->first('descripcion') }}</div>
                            @endif
                        </div> 

                        <input type="hidden" id="id_tab_cuenta_contable_retencion_por_pagar" name="id_tab_cuenta_contable_retencion_por_pagar" value="{{ empty(old('id_tab_cuenta_contable_retencion_por_pagar'))? $data->id_tab_cuenta_contable_retencion : old('id_tab_cuenta_contable_retencion_por_pagar') }}">
                                  
                        <div class="form-group">
                            <label for="nu_cuenta_contable_retencion_por_pagar">Cuenta Contable Retencion</label>
                            <div class="input-group">                            
                            <input type="text" class="form-control {!! $errors->has('nu_cuenta_contable_retencion_por_pagar') ? 'is-invalid' : '' !!}" readonly id="nu_cuenta_contable_retencion_por_pagar" name="nu_cuenta_contable_retencion_por_pagar" placeholder="Cuenta contable por pagar..." value="{{ empty(old('nu_cuenta_contable_retencion_por_pagar'))? $data->de_cuenta_contable_retencion : old('nu_cuenta_contable_retencion_por_pagar') }}" {{ $errors->has('nu_cuenta_contable_retencion_por_pagar') ? 'aria-describedby="nu_cuenta_contable_retencion_por_pagar-error" aria-invalid="true"' : '' }}>
                            <span class="input-group-text btn-cpp">
                                <i class="fa fa-search"></i>
                            </span>  
                            @if( $errors->has('nu_cuenta_contable_retencion_por_pagar') )
                                <div id="nu_cuenta_contable_retencion_por_pagar-error" class="invalid-feedback animated fadeIn">La cuenta contable por pagar es obligatorio</div>
                            @endif                            
                        </div>                            
                        </div>       
                        
                        <input type="hidden" id="id_tab_cuenta_contable_deposito_tercero" name="id_tab_cuenta_contable_deposito_tercero" value="{{ empty(old('id_tab_cuenta_contable_deposito_tercero'))? $data->id_tab_cuenta_contable_deposito_tercero : old('id_tab_cuenta_contable_deposito_tercero') }}">
                                  
                        <div class="form-group">
                            <label for="nu_cuenta_contable_deposito_tercero">Cuenta Contable Deposito tercero</label>
                            <div class="input-group">                            
                            <input type="text" class="form-control {!! $errors->has('nu_cuenta_contable_deposito_tercero') ? 'is-invalid' : '' !!}" readonly id="nu_cuenta_contable_deposito_tercero" name="nu_cuenta_contable_deposito_tercero" placeholder="Cuenta contable deposito tercero..." value="{{ empty(old('nu_cuenta_contable_deposito_tercero'))? $data->de_cuenta_contable_deposito_tercero : old('nu_cuenta_contable_deposito_tercero') }}" {{ $errors->has('nu_cuenta_contable_deposito_tercero') ? 'aria-describedby="nu_cuenta_contable_deposito_tercero-error" aria-invalid="true"' : '' }}>
                            <span class="input-group-text btn-ddt">
                                <i class="fa fa-search"></i>
                            </span>  
                            @if( $errors->has('nu_cuenta_contable_deposito_tercero') )
                                <div id="nu_cuenta_contable_deposito_tercero-error" class="invalid-feedback animated fadeIn">La cuenta contable deposito tercero es obligatorio</div>
                            @endif                            
                        </div>                            
                        </div>  

                        <div class="form-group">
                            <label for="nu_concepto_nomina">Concepto Nomina (Opcional)</label>
                            <input type="text" class="form-control {!! $errors->has('nu_concepto_nomina') ? 'is-invalid' : '' !!}" id="nu_concepto_nomina" name="nu_concepto_nomina" placeholder="..." value="{{ empty(old('nu_concepto_nomina'))? $data->nu_concepto_nomina : old('nu_concepto_nomina') }}" {{ $errors->has('nu_concepto_nomina') ? 'aria-describedby="nu_concepto_nomina-error" aria-invalid="true"' : '' }}>
                            @if( $errors->has('nu_concepto_nomina') )
                                <div id="nu_concepto_nomina-error" class="invalid-feedback animated fadeIn">{{ $errors->first('nu_concepto_nomina') }}</div>
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
<!-- Pop In Block Modal -->
<div class="modal fade" id="modal-cuenta-pagar" tabindex="-1" role="dialog" aria-labelledby="modal-cuenta-pagar" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Cuentas Contables Retenciones</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">

                <div class="row justify-content-center push">
                    <div class="col-md-12">


    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Cuentas contables <small>Lista</small></h3>
        </div>
        <div class="block-content block-content-full">
            <table  class="tabla_cuenta_pagar table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                <thead>
                    <tr>
                        
                        <th class="d-none d-sm-table-cell">Id</th>
                        <th class="d-none d-sm-table-cell">Cuenta Contable</th>
                        <th class="d-none d-sm-table-cell" style="width: 40%;">Descripcion</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">nivel</th>
                        <th style="width: 15%;">Anexo</th>
                        <th class="d-none d-md-table-cell text-center" style="width: 100px;">Acciones</th>                        
                    </tr>
                </thead>
                <tbody>
                @foreach($tab_cuenta_contable_retencion as $key => $value)                    
                                        <tr>
                        <td class="font-w600">{{ $value->id }}</td>
                        <td class="font-w600">{{ $value->nu_cuenta_contable }}</td>
                        <td class="font-w600">{{ $value->de_cuenta_contable }}</td>
                        <td class="d-none d-sm-table-cell">
                          {{ $value->nu_nivel }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                           {{ $value->nu_anexo_contable }}
                        </td>
                        <td>
                        <button type="button" class="btn btn-primary btn-agregar-ddt" title="Agregar" href="javascript:void(0)">
                            <i class="fa fa-fw fa-search-plus"></i>
                        </button>
                        </td                        
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
</div>
<!-- END Pop In Block Modal -->
<!-- Pop In Block Modal -->
<div class="modal fade" id="modal-deposito-tercero" tabindex="-1" role="dialog" aria-labelledby="modal-deposito-tercero" aria-hidden="true">
    <div class="modal-dialog modal-dialog-popin modal-lg" role="document">
        <div class="modal-content">

            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="block block-themed block-transparent mb-0">
                <div class="block-header bg-primary-dark">
                    <h3 class="block-title">Cuentas Contables Deposito tercero</h3>
                    <div class="block-options">
                        <button type="button" class="btn-block-option" data-dismiss="modal" aria-label="Close">
                            <i class="fa fa-fw fa-times"></i>
                        </button>
                    </div>
                </div>
                <div class="block-content">

                <div class="row justify-content-center push">
                    <div class="col-md-12">


    <div class="block block-rounded">
        <div class="block-header block-header-default">
            <h3 class="block-title">Cuentas contables <small>Lista</small></h3>
        </div>
        <div class="block-content block-content-full">
            <table  class="tabla_deposito_tercero table-bordered table-striped table-vcenter js-dataTable-full-pagination">
                <thead>
                    <tr>
                        
                        <th class="d-none d-sm-table-cell">Id</th>
                        <th class="d-none d-sm-table-cell">Cuenta Contable</th>
                        <th class="d-none d-sm-table-cell" style="width: 40%;">Descripcion</th>
                        <th class="d-none d-sm-table-cell" style="width: 15%;">nivel</th>
                        <th style="width: 15%;">Anexo</th>
                        <th class="d-none d-md-table-cell text-center" style="width: 100px;">Acciones</th>                        
                    </tr>
                </thead>
                <tbody>
                @foreach($tab_cuenta_contable_tercero as $key => $value)                    
                                        <tr>
                        <td class="font-w600">{{ $value->id }}</td>
                        <td class="font-w600">{{ $value->nu_cuenta_contable }}</td>
                        <td class="font-w600">{{ $value->de_cuenta_contable }}</td>
                        <td class="d-none d-sm-table-cell">
                          {{ $value->nu_nivel }}
                        </td>
                        <td class="d-none d-sm-table-cell">
                           {{ $value->nu_anexo_contable }}
                        </td>
                        <td>
                        <button type="button" class="btn btn-primary btn-agregar-ddt" title="Agregar" href="javascript:void(0)">
                            <i class="fa fa-fw fa-search-plus"></i>
                        </button>
                        </td                        
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
</div>
<!-- END Pop In Block Modal -->
@endsection