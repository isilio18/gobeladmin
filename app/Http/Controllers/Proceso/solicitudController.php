<?php

namespace App\Http\Controllers\Proceso;
//*******agregar esta linea******//
use App\Models\Proceso\tab_solicitud;
use App\Models\Configuracion\tab_solicitud_usuario;
use App\Models\Configuracion\tab_solicitud as tab_tipo_solicitud;
use App\Models\Proceso\tab_ruta;
use App\Models\Configuracion\tab_ruta as tab_configuracion_ruta;
use App\Models\Configuracion\tab_proceso_usuario;
use App\Models\Configuracion\tab_estatus;
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

class solicitudController extends Controller
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
    public function lista( Request $request)
    {
        $sortBy = 'id';
        $orderBy = 'desc';
        $perPage = 5;
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

        $proceso = tab_proceso_usuario::getListaProcesoAsignado(Auth::user()->id);
        $tramite = tab_solicitud_usuario::getListaTramiteAsignado(Auth::user()->id);

        $tab_solicitud = tab_solicitud::select( 'proceso.tab_solicitud.id', 'de_solicitud', 'nu_identificador',
        'nu_solicitud', 'nb_usuario',
        'id_tab_ejercicio_fiscal', DB::raw("to_char(proceso.tab_solicitud.created_at, 'dd/mm/YYYY hh12:mi AM') as fe_creado"),
        'de_proceso')
        ->join('proceso.tab_ruta as t01', 'proceso.tab_solicitud.id', '=', 't01.id_tab_solicitud')
        ->join('configuracion.tab_proceso as t02', 't02.id', '=', 't01.id_tab_proceso')
        ->join('autenticacion.tab_usuario as t03', 't03.id', '=', 't01.id_tab_usuario')
        ->join('configuracion.tab_solicitud as t04', 't04.id', '=', 'proceso.tab_solicitud.id_tab_tipo_solicitud')
        ->where('in_actual', '=', true)
        ->where('proceso.tab_solicitud.in_activo', '=', true)
        ->where('t01.id_tab_estatus', '=', 1)
        ->where('id_tab_ejercicio_fiscal', '=', Session::get('ejercicio'))
        ->whereIn('t01.id_tab_proceso', $proceso)
        ->whereIn('proceso.tab_solicitud.id_tab_tipo_solicitud', $tramite)
        ->where('t01.nu_orden', '=', 1)
        ->search($q, $sortBy)
        ->orderBy($sortBy, $orderBy)
        ->paginate($perPage);

        return View::make('proceso.solicitud.lista')->with([
          'tab_solicitud' => $tab_solicitud,
          'orderBy' => $orderBy,
          'sortBy' => $sortBy,
          'perPage' => $perPage,
          'columnas' => $columnas,
          'q' => $q
        ]);
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function pendiente( Request $request)
    {
        $sortBy = 'id';
        $orderBy = 'desc';
        $perPage = 5;
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

        $proceso = tab_proceso_usuario::getListaProcesoAsignado(Auth::user()->id);
        $tramite = tab_solicitud_usuario::getListaTramiteAsignado(Auth::user()->id);

        $tab_solicitud = tab_solicitud::select( 'proceso.tab_solicitud.id', 'de_solicitud', 'nu_identificador',
        'nu_solicitud', 'nb_usuario',
        'id_tab_ejercicio_fiscal', DB::raw("to_char(proceso.tab_solicitud.created_at, 'dd/mm/YYYY hh12:mi AM') as fe_creado"),
        'de_proceso')
        ->join('proceso.tab_ruta as t01', 'proceso.tab_solicitud.id', '=', 't01.id_tab_solicitud')
        ->join('configuracion.tab_proceso as t02', 't02.id', '=', 't01.id_tab_proceso')
        ->join('autenticacion.tab_usuario as t03', 't03.id', '=', 't01.id_tab_usuario')
        ->join('configuracion.tab_solicitud as t04', 't04.id', '=', 'proceso.tab_solicitud.id_tab_tipo_solicitud')
        ->where('in_actual', '=', true)
        ->where('proceso.tab_solicitud.in_activo', '=', true)
        ->where('t01.id_tab_estatus', '=', 1)
        ->where('id_tab_ejercicio_fiscal', '=', Session::get('ejercicio'))
        ->whereIn('t01.id_tab_proceso', $proceso)
        ->whereIn('proceso.tab_solicitud.id_tab_tipo_solicitud', $tramite)
        ->where('t01.nu_orden', '>', 1)
        ->search($q, $sortBy)
        ->orderBy($sortBy, $orderBy)
        ->paginate($perPage);

        return View::make('proceso.solicitud.pendiente')->with([
          'tab_solicitud' => $tab_solicitud,
          'orderBy' => $orderBy,
          'sortBy' => $sortBy,
          'perPage' => $perPage,
          'columnas' => $columnas,
          'q' => $q
        ]);
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function completo( Request $request)
    {
        $sortBy = 'id';
        $orderBy = 'desc';
        $perPage = 5;
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

        $proceso = tab_proceso_usuario::getListaProcesoAsignado(Auth::user()->id);
        $tramite = tab_solicitud_usuario::getListaTramiteAsignado(Auth::user()->id);

        $tab_solicitud = tab_solicitud::select( 'proceso.tab_solicitud.id', 'de_solicitud', 'nu_identificador',
        'nu_solicitud', 'nb_usuario',
        'id_tab_ejercicio_fiscal', DB::raw("to_char(proceso.tab_solicitud.created_at, 'dd/mm/YYYY hh12:mi AM') as fe_creado"),
        'de_proceso')
        ->join('proceso.tab_ruta as t01', 'proceso.tab_solicitud.id', '=', 't01.id_tab_solicitud')
        ->join('configuracion.tab_proceso as t02', 't02.id', '=', 't01.id_tab_proceso')
        ->join('autenticacion.tab_usuario as t03', 't03.id', '=', 't01.id_tab_usuario')
        ->join('configuracion.tab_solicitud as t04', 't04.id', '=', 'proceso.tab_solicitud.id_tab_tipo_solicitud')
        ->where('in_actual', '=', true)
        ->where('proceso.tab_solicitud.in_activo', '=', true)
        ->where('t01.id_tab_estatus', '=', 2)
        ->where('id_tab_ejercicio_fiscal', '=', Session::get('ejercicio'))
        ->whereIn('t01.id_tab_proceso', $proceso)
        ->whereIn('proceso.tab_solicitud.id_tab_tipo_solicitud', $tramite)
        ->where('t01.nu_orden', '>', 1)
        ->search($q, $sortBy)
        ->orderBy($sortBy, $orderBy)
        ->paginate($perPage);

        return View::make('proceso.solicitud.completo')->with([
          'tab_solicitud' => $tab_solicitud,
          'orderBy' => $orderBy,
          'sortBy' => $sortBy,
          'perPage' => $perPage,
          'columnas' => $columnas,
          'q' => $q
        ]);
    }

    /**
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function todo( Request $request)
    {
        $sortBy = 'id';
        $orderBy = 'desc';
        $perPage = 5;
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

        $proceso = tab_proceso_usuario::getListaProcesoAsignado(Auth::user()->id);
        $tramite = tab_solicitud_usuario::getListaTramiteAsignado(Auth::user()->id);

        $tab_solicitud = tab_solicitud::select( 'proceso.tab_solicitud.id', 'de_solicitud', 'nu_identificador',
        'nu_solicitud', 'nb_usuario',
        'id_tab_ejercicio_fiscal', DB::raw("to_char(proceso.tab_solicitud.created_at, 'dd/mm/YYYY hh12:mi AM') as fe_creado"),
        'de_proceso')
        ->join('proceso.tab_ruta as t01', 'proceso.tab_solicitud.id', '=', 't01.id_tab_solicitud')
        ->join('configuracion.tab_proceso as t02', 't02.id', '=', 't01.id_tab_proceso')
        ->join('autenticacion.tab_usuario as t03', 't03.id', '=', 't01.id_tab_usuario')
        ->join('configuracion.tab_solicitud as t04', 't04.id', '=', 'proceso.tab_solicitud.id_tab_tipo_solicitud')
        //->where('in_actual', '=', true)
        ->where('proceso.tab_solicitud.in_activo', '=', true)
        //->where('t01.id_tab_estatus', '=', 2)
        ->whereIn('t01.id_tab_proceso', $proceso)
        ->where('id_tab_ejercicio_fiscal', '=', Session::get('ejercicio'))
        ->whereIn('proceso.tab_solicitud.id_tab_tipo_solicitud', $tramite)
        ->where('t01.nu_orden', '=', 1)
        ->search($q, $sortBy)
        ->orderBy($sortBy, $orderBy)
        ->paginate($perPage);

        return View::make('proceso.solicitud.todo')->with([
          'tab_solicitud' => $tab_solicitud,
          'orderBy' => $orderBy,
          'sortBy' => $sortBy,
          'perPage' => $perPage,
          'columnas' => $columnas,
          'q' => $q
        ]);
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function nuevo()
    {

        $tab_solicitud_usuario = tab_solicitud_usuario::select( 'id_tab_solicitud as id', 'nu_identificador', 'de_solicitud')
        ->join('configuracion.tab_solicitud as t01','t01.id','=','configuracion.tab_solicitud_usuario.id_tab_solicitud')
        ->where('configuracion.tab_solicitud_usuario.in_activo', '=', true)
        ->where('id_tab_usuario', '=', Auth::user()->id)
        ->where('in_ver', '=', true)
        ->orderby( DB::raw('nu_identificador::int'),'ASC')
        ->get();

        return View::make('proceso.solicitud.nuevo')->with([
            'tab_solicitud_usuario' => $tab_solicitud_usuario
        ]);
    }

        /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function guardar( Request $request, $id = NULL )
    {
        DB::beginTransaction();

        if($id!=''||$id!=null){
  
            try {

                $validator= Validator::make($request->all(), tab_solicitud::$validarEditar);

                if ($validator->fails()){
                    return Redirect::back()->withErrors( $validator)->withInput( $request->all());
                }

                $tab_solicitud = tab_solicitud::find($id);
                $tab_solicitud->id_tab_tipo_solicitud = $request->solicitud;
                $tab_solicitud->id_tab_usuario = Auth::user()->id; 
                $tab_solicitud->de_observacion = $request->observacion; 
                //$tab_solicitud->id_tab_estatus = 1;
                $tab_solicitud->id_tab_proceso = tab_tipo_solicitud::getProceso($request->solicitud);
                //$tab_solicitud->id_tab_ejercicio_fiscal = Session::get('ejercicio');
                $tab_solicitud->save();

                DB::commit();
                
                Session::flash('msg_side_overlay', 'Registro Editado con Exito!');
                return Redirect::to('/proceso/solicitud/lista');

            }catch (\Illuminate\Database\QueryException $e){
                DB::rollback();
                return Redirect::back()->withErrors([
                    'da_alert_form' => $e->getMessage()
                ])->withInput( $request->all());
            }
  
        }else{
  
            try {

                $validator = Validator::make($request->all(), tab_solicitud::$validarCrear);

                if ($validator->fails()){
                    return Redirect::back()->withErrors( $validator)->withInput( $request->all());
                }

                if (tab_configuracion_ruta::getVerificaRuta( $request->solicitud)==null){
                    return Redirect::back()->withErrors([
                        'da_alert_form' => 'No se genero la solicitud debido a que el proceso no tiene ruta asignada.'
                    ])->withInput( $request->all());
                }

                $tab_solicitud = new tab_solicitud;
                $tab_solicitud->id_tab_tipo_solicitud = $request->solicitud;
                $tab_solicitud->id_tab_usuario = Auth::user()->id; 
                $tab_solicitud->de_observacion = $request->observacion; 
                $tab_solicitud->id_tab_estatus = 1;
                $tab_solicitud->id_tab_proceso = tab_tipo_solicitud::getProceso($request->solicitud);
                $tab_solicitud->id_tab_ejercicio_fiscal = Session::get('ejercicio');
                $tab_solicitud->in_activo = true;
                $tab_solicitud->save();

                self::crearRuta($tab_solicitud);

                DB::commit();

                $serial = tab_solicitud::findOrFail($tab_solicitud->id);

                Session::flash('msg_side_overlay', 'Tramite registrado exitosamente! Numero de Proceso: '.$serial->nu_solicitud );
                return Redirect::to('/proceso/solicitud/lista');

            }catch (\Illuminate\Database\QueryException $e){
                DB::rollback();
                return Redirect::back()->withErrors([
                    'da_alert_form' => $e->getMessage()
                ])->withInput( $request->all());
            }
        }
    }

    protected function crearRuta($tab_solicitud){

        $tab_ruta = new tab_ruta;
        $tab_ruta->id_tab_solicitud = $tab_solicitud->id;
        $tab_ruta->id_tab_tipo_solicitud = $tab_solicitud->id_tab_tipo_solicitud;
        $tab_ruta->id_tab_usuario = Auth::user()->id;
        if($tab_solicitud->de_observacion!=''){
            $tab_ruta->de_observacion = $tab_solicitud->de_observacion;
        }
        $tab_ruta->de_observacion = $tab_solicitud->de_observacion; 
        $tab_ruta->id_tab_estatus = 1;
        $tab_ruta->nu_orden = 1;
        $tab_ruta->id_tab_proceso = tab_configuracion_ruta::getVerificaRuta($tab_solicitud->id_tab_tipo_solicitud);
        $tab_ruta->in_actual = true;
        $tab_ruta->in_activo = true;
        $tab_ruta->save();

    }

    /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function avanzar( Request $request)
    {
        DB::beginTransaction();
        try {

            $in_datos_config = tab_configuracion_ruta::getInCargarDatos( $request->id);
            $in_datos_ruta = tab_ruta::getValidarCargarDatos( $request->id);

            if($in_datos_config==true){
                if($in_datos_ruta==true){

                    $tab_ruta = tab_ruta::find( tab_ruta::getRuta($request->id));
                    $tab_ruta->id_tab_estatus = 2;
                    $tab_ruta->in_definitivo = true;
                    $tab_ruta->id_tab_usuario = Auth::user()->id;
                    $tab_ruta->save();                 

                }else{

                    return Redirect::back()->withErrors([
                        'da_alert_form' => 'No es posible enviar la solicitud, ya que se debe cargar los datos!'
                    ])->withInput( $request->all());

                }
            }else{

                $tab_ruta = tab_ruta::find( tab_ruta::getRuta($request->id));
                $tab_ruta->id_tab_estatus = 2;
                $tab_ruta->in_definitivo = true;
                $tab_ruta->id_tab_usuario = Auth::user()->id;
                $tab_ruta->save();

            }

            DB::commit();

            Session::flash('msg_side_overlay', 'La solicitud se envio exitosamente!');
            return Redirect::to('/proceso/solicitud/lista');

        }catch (\Illuminate\Database\QueryException $e)
        {
            DB::rollback();
            return Redirect::back()->withErrors([
                'da_alert_form' => $e->getMessage()
            ])->withInput( $request->all());
        }
    }
}
