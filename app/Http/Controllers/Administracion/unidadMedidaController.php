<?php

namespace gobela\Http\Controllers\Administracion;
//*******agregar esta linea******//
use gobela\Models\Administracion\tab_unidad_medida;
use View;
use Validator;
use Response;
use DB;
use Session;
use Redirect;
//*******************************//
use Illuminate\Http\Request;

use gobela\Http\Requests;
use gobela\Http\Controllers\Controller;

class unidadMedidaController extends Controller
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

        $tab_unidad_medida = tab_unidad_medida::select( 'id', 'de_unidad_medida', 'in_activo', 'created_at', 'updated_at')
        //->where('in_activo', '=', true)
        ->search($q, $sortBy)
        ->orderBy($sortBy, $orderBy)
        ->paginate($perPage);

        return View::make('administracion.unidadMedida.lista')->with([
          'tab_unidad_medida' => $tab_unidad_medida,
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
     * @return \Illuminate\Http\Response
     */
    public function nuevo()
    {
        $data = array( "id" => null);

        return View::make('administracion.unidadMedida.nuevo')->with([
            'data'  => $data
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function editar($id)
    {
        $data = tab_unidad_medida::select( 'id', 'de_unidad_medida', 'in_activo', 'created_at', 'updated_at')
        ->where('id', '=', $id)
        ->first();

        return View::make('administracion.unidadMedida.editar')->with([
            'data'  => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function guardar(Request $request, $id = NULL)
    {
        DB::beginTransaction();

        if($id!=''||$id!=null){

            $validador = Validator::make( $request->all(), tab_unidad_medida::$validarEditar);
            if ($validador->fails()) {
                return Redirect::back()->withErrors( $validador)->withInput( $request->all());
            }

            try {

                $tabla = tab_unidad_medida::find($id);
                $tabla->de_unidad_medida = $request->descripcion; 
                $tabla->save();

                DB::commit();

                Session::flash('msg_side_overlay', 'Registro Editado con Exito!');
                return Redirect::to('/administracion/unidadMedida/lista');

            }catch (\Illuminate\Database\QueryException $e)
            {
                DB::rollback();
                return Redirect::back()->withErrors([
                    'da_alert_form' => $e->getMessage()
                ])->withInput( $request->all());
            }

        }else{

            $validador = Validator::make( $request->all(), tab_unidad_medida::$validarCrear);
            if ($validador->fails()) {
                return Redirect::back()->withErrors( $validador)->withInput( $request->all());
            }

            try {

                $tabla = new tab_unidad_medida;
                $tabla->de_unidad_medida = $request->descripcion;
                $tabla->in_activo = true;
                $tabla->save();

                DB::commit();

                Session::flash('msg_side_overlay', 'Registro creado con Exito!');
                return Redirect::to('/administracion/unidadMedida/lista');

            }catch (\Illuminate\Database\QueryException $e)
            {
                DB::rollback();
                return Redirect::back()->withErrors([
                    'da_alert_form' => $e->getMessage()
                ])->withInput( $request->all());
            }

        }
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deshabilitar( $id)
    {
      DB::beginTransaction();
      try {

        $tabla = tab_unidad_medida::find( $id);
        $tabla->in_activo = false;
        $tabla->save();

        DB::commit();

        Session::flash('msg_side_overlay', 'Registro despublicado con Exito!');
        return Redirect::to('/administracion/unidadMedida/lista');

      }catch (\Illuminate\Database\QueryException $e)
      {
        DB::rollback();
        return Redirect::back()->withErrors([
            'da_alert_form' => $e->getMessage()
        ])->withInput( $request->all());
      }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function habilitar( $id)
    {
      DB::beginTransaction();
      try {

        $tabla = tab_unidad_medida::find( $id);
        $tabla->in_activo = true;
        $tabla->save();

        DB::commit();

        Session::flash('msg_side_overlay', 'Registro publicado con Exito!');
        return Redirect::to('/administracion/unidadMedida/lista');

      }catch (\Illuminate\Database\QueryException $e)
      {
        DB::rollback();
        return Redirect::back()->withErrors([
            'da_alert_form' => $e->getMessage()
        ])->withInput( $request->all());
      }
    }
}
