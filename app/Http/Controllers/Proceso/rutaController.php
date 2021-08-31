<?php

namespace App\Http\Controllers\Proceso;
//*******agregar esta linea******//
use App\Models\Proceso\tab_ruta;
use App\Models\Configuracion\tab_ruta as tab_configuracion_ruta;
use App\Models\Configuracion\tab_estatus;
use App\Models\Proceso\tab_solicitud;
use App\Models\Configuracion\tab_solicitud as tab_tipo_solicitud;
use View;
use Validator;
use Response;
use DB;
use Session;
use Redirect;
use Auth;
//*******************************//
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Container\Container;

class rutaController extends Controller
{
    public function __construct()
    {
      $this->middleware('auth');
    }

        /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function lista( Request $request, $id)
    {
        $sortBy = 'id';
        $orderBy = 'desc';
        $perPage = 10;
        $q = null;
        $columnas = [
          ['valor'=>'bnumberdialed', 'texto'=>'Número de Origen'],
          ['valor'=>'bnumberdialed', 'texto'=>'Número de Destino']
        ];

        if ($request->has('orderBy')){
            $orderBy = $request->query('orderBy');
        }
        if ($request->has('sortBy')){
            $sortBy = $request->query('sortBy');
        } 
        if ($request->has('perPage')){
            $perPage = $request->query('perPage');
        } 
        if ($request->has('q')){
            $q = $request->query('q');
        }

        $tab_solicitud = tab_solicitud::select( 'id', 'nu_solicitud','id_tab_tipo_solicitud')
        ->where('id', '=', $id)
        ->first();               
        
        $tab_tipo_solicitud = tab_tipo_solicitud::select( 'id', 'de_solicitud')
        ->where('id', '=', $tab_solicitud->id_tab_tipo_solicitud)
        ->first();        
        
        $tab_ruta = tab_ruta::select( 'proceso.tab_ruta.id', 'proceso.tab_ruta.id_tab_solicitud', 'id_tab_tipo_solicitud', 'id_tab_usuario', 
        'de_observacion', 'id_tab_estatus', 'nu_orden', 'proceso.tab_ruta.id_tab_proceso', 'in_actual', 
        'proceso.tab_ruta.in_activo', 'proceso.tab_ruta.created_at', 'proceso.tab_ruta.updated_at', 
        DB::raw("to_char(proceso.tab_ruta.created_at, 'dd/mm/YYYY hh12:mi AM') as fe_creado"),
        DB::raw("proceso.sp_verificar_anexo(proceso.tab_ruta.id) as in_anexo"), 'proceso.tab_ruta.in_reporte')
        ->join('configuracion.tab_proceso as t01', 'proceso.tab_ruta.id_tab_proceso', '=', 't01.id')
        ->with(['estatus', 'proceso', 'usuario'])
        ->where('proceso.tab_ruta.id_tab_solicitud', '=', $id)
        //->search($q, $sortBy)
        ->orderBy($sortBy, $orderBy)
        ->paginate($perPage);

        $ubicacion = tab_ruta::select( 'nu_orden')
        ->where('id_tab_solicitud', '=', $id)
        ->where('in_activo', '=', true)
        ->where('in_actual', '=', true)
        ->first();

        if( $ubicacion->nu_orden > 1){

            return View::make('proceso.ruta.pendiente')->with([
                'tab_ruta' => $tab_ruta,
                'tab_tipo_solicitud' => $tab_tipo_solicitud,
                'tab_solicitud' => $tab_solicitud,                
                'orderBy' => $orderBy,
                'sortBy' => $sortBy,
                'perPage' => $perPage,
                'columnas' => $columnas,
                'q' => $q,
                'id' => $id
              ]);

        }else{

            return View::make('proceso.ruta.lista')->with([
                'tab_ruta' => $tab_ruta,
                'tab_tipo_solicitud' => $tab_tipo_solicitud,
                'tab_solicitud' => $tab_solicitud,                  
                'orderBy' => $orderBy,
                'sortBy' => $sortBy,
                'perPage' => $perPage,
                'columnas' => $columnas,
                'q' => $q,
                'id' => $id
              ]);

        }

    }

            /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function listaVer( Request $request, $id)
    {
        $sortBy = 'id';
        $orderBy = 'desc';
        $perPage = 10;
        $q = null;
        $columnas = [
          ['valor'=>'bnumberdialed', 'texto'=>'Número de Origen'],
          ['valor'=>'bnumberdialed', 'texto'=>'Número de Destino']
        ];

        if ($request->has('orderBy')){
            $orderBy = $request->query('orderBy');
        }
        if ($request->has('sortBy')){
            $sortBy = $request->query('sortBy');
        } 
        if ($request->has('perPage')){
            $perPage = $request->query('perPage');
        } 
        if ($request->has('q')){
            $q = $request->query('q');
        }

        $tab_solicitud = tab_solicitud::select( 'id', 'nu_solicitud','id_tab_tipo_solicitud')
        ->where('id', '=', $id)
        ->first();               
        
        $tab_tipo_solicitud = tab_tipo_solicitud::select( 'id', 'de_solicitud')
        ->where('id', '=', $tab_solicitud->id_tab_tipo_solicitud)
        ->first();        
        
        $tab_ruta = tab_ruta::select( 'proceso.tab_ruta.id', 'proceso.tab_ruta.id_tab_solicitud', 'id_tab_tipo_solicitud', 'id_tab_usuario', 
        'de_observacion', 'id_tab_estatus', 'nu_orden', 'proceso.tab_ruta.id_tab_proceso', 'in_actual', 
        'proceso.tab_ruta.in_activo', 'proceso.tab_ruta.created_at', 'proceso.tab_ruta.updated_at', 
        DB::raw("to_char(proceso.tab_ruta.created_at, 'dd/mm/YYYY hh12:mi AM') as fe_creado"),
        DB::raw("proceso.sp_verificar_anexo(proceso.tab_ruta.id) as in_anexo"), 'proceso.tab_ruta.in_reporte')
        ->join('configuracion.tab_proceso as t01', 'proceso.tab_ruta.id_tab_proceso', '=', 't01.id')
        ->with(['estatus', 'proceso', 'usuario'])
        ->where('proceso.tab_ruta.id_tab_solicitud', '=', $id)
        //->search($q, $sortBy)
        ->orderBy($sortBy, $orderBy)
        ->paginate($perPage);

        return View::make('proceso.ruta.listaVer')->with([
            'tab_ruta' => $tab_ruta,
            'tab_tipo_solicitud' => $tab_tipo_solicitud,
            'tab_solicitud' => $tab_solicitud,              
            'orderBy' => $orderBy,
            'sortBy' => $sortBy,
            'perPage' => $perPage,
            'columnas' => $columnas,
            'q' => $q,
            'id' => $id
        ]);

    }

        /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function enviar( $id)
    {
 
        $data = tab_ruta::select( 'proceso.tab_ruta.id', 'id_tab_solicitud', 'id_tab_tipo_solicitud', 'id_tab_usuario', 
        'de_observacion', 'id_tab_estatus', 'nu_orden', 'proceso.tab_ruta.id_tab_proceso', 'in_actual', 'de_proceso', 'de_solicitud',
        'proceso.tab_ruta.in_activo', 'proceso.tab_ruta.created_at', 'proceso.tab_ruta.updated_at', DB::raw("to_char(proceso.tab_ruta.created_at, 'dd/mm/YYYY hh12:mi AM') as fe_creado"))
        ->join('configuracion.tab_proceso as t01', 'proceso.tab_ruta.id_tab_proceso', '=', 't01.id')
        ->join('configuracion.tab_solicitud as t02', 'proceso.tab_ruta.id_tab_tipo_solicitud', '=', 't02.id')
        ->where('id_tab_solicitud', '=', $id)
        ->where('proceso.tab_ruta.in_activo', '=', true)
        ->where('in_actual', '=', true)
        ->first();

        $tab_estatus = tab_estatus::orderBy('id','asc')
        ->whereIn('id',  [ 2, 3])
        ->get();

        return View::make('proceso.ruta.enviar')->with([
            'data' => $data,
            'tab_estatus' => $tab_estatus
        ]);
    }

        /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function procesar( Request $request)
    {
        DB::beginTransaction();
        try {

            $in_datos_config = tab_configuracion_ruta::getInCargarDatos( $request->solicitud);
            $in_datos_ruta = tab_ruta::getValidarCargarDatos( $request->solicitud);

            if($in_datos_config==true){
                if($in_datos_ruta==true){

                    $tab_ruta = tab_ruta::find( tab_ruta::getRuta($request->solicitud));
                    $tab_ruta->id_tab_estatus = $request->estatus;
                    $tab_ruta->de_observacion = $request->observacion;
                    $tab_ruta->in_definitivo = true;
                    $tab_ruta->id_tab_usuario = Auth::user()->id;
                    $tab_ruta->save();

                    DB::commit();

                    Session::flash('msg_side_overlay', 'La solicitud se proceso exitosamente!');
                    return Redirect::to('/proceso/solicitud/pendiente');

                }else{

                    return Redirect::back()->withErrors([
                        'da_alert_form' => 'No es posible procesar la solicitud, ya que se debe cargar los datos!'
                    ])->withInput( $request->all());

                }
            }else{

                $tab_ruta = tab_ruta::find( tab_ruta::getRuta($request->solicitud));
                $tab_ruta->id_tab_estatus = $request->estatus;
                $tab_ruta->de_observacion = $request->observacion;
                $tab_ruta->in_definitivo = true;
                $tab_ruta->id_tab_usuario = Auth::user()->id;
                $tab_ruta->save();

                DB::commit();

                Session::flash('msg_side_overlay', 'La solicitud se proceso exitosamente!');
                return Redirect::to('/proceso/solicitud/pendiente');

            }

        }catch (\Illuminate\Database\QueryException $e)
        {
            DB::rollback();
            return Redirect::back()->withErrors([
                'da_alert_form' => $e->getMessage()
            ])->withInput( $request->all());
        }
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function datos( Request $request, $id)
    {
        $tab_ruta = tab_ruta::select( 'id', 'id_tab_solicitud', 'id_tab_tipo_solicitud', 'id_tab_usuario', 
        'de_observacion', 'id_tab_estatus', 'nu_orden', 'id_tab_proceso', 'in_actual', 
        'in_activo', 'created_at', 'updated_at', DB::raw("to_char(created_at, 'dd/mm/YYYY hh12:mi AM') as fe_creado"))
        ->where('id_tab_solicitud', '=', $id)
        ->where('in_activo', '=', true)
        ->where('in_actual', '=', true)
        ->first();

        $data = tab_ruta::select( 'id', 'id_tab_solicitud', 'id_tab_tipo_solicitud', 'id_tab_usuario', 
        'de_observacion', 'id_tab_estatus', 'nu_orden', 'id_tab_proceso', 'in_actual', 
        'in_activo', 'created_at', 'updated_at')
        ->where('id', '=', $tab_ruta->id)
        ->first();

        $tab_configuracion_ruta = tab_configuracion_ruta::select( 'id_tab_proceso', 'id_tab_solicitud', 'nu_orden', 'in_datos', 'nb_controlador', 
        'nb_accion', 'nb_reporte', 'de_variable', DB::raw('de_variable||nb_controlador as de_controlador'))
        ->join('configuracion.tab_entorno as t01', 'configuracion.tab_ruta.id_tab_entorno', '=', 't01.id')
        ->where('id_tab_solicitud', '=', $data->id_tab_tipo_solicitud)
        ->where('id_tab_proceso', '=', $data->id_tab_proceso)
        ->first();

        $namespace = self::getAppNamespace();

        $entorno = $namespace.$tab_configuracion_ruta->de_controlador;

        return (new  $entorno)->{$tab_configuracion_ruta->nb_accion}( $request, $id, $tab_ruta->id);

    }

    protected function getAppNamespace()
    {
        return Container::getInstance()->getNamespace()."Http\Controllers";
    }
}
