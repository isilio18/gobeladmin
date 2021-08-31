<?php

namespace App\Http\Controllers\Proceso;
//*******agregar esta linea******//
use App\Models\Proceso\tab_documento;
use App\Models\Proceso\tab_ruta;
use View;
use Validator;
use Response;
use DB;
use Session;
use Storage;
use File;
use Illuminate\Http\Response as ResposeFile;
use Redirect;
//*******************************//
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class documentoController extends Controller
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
        $perPage = 100;
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

        $tab_ruta = tab_ruta::select( 'id', 'id_tab_solicitud', 'id_tab_tipo_solicitud', 'id_tab_usuario', 
        'de_observacion', 'id_tab_estatus', 'nu_orden', 'id_tab_proceso', 'in_actual', 
        'in_activo', 'created_at', 'updated_at', DB::raw("to_char(created_at, 'dd/mm/YYYY hh12:mi AM') as fe_creado"))
        ->where('id_tab_solicitud', '=', $id)
        ->where('in_activo', '=', true)
        ->where('in_actual', '=', true)
        ->first();

        $tab_documento = tab_documento::select( 'id', 'id_tab_ruta', 'id_tab_solicitud', 'de_documento', 'nb_archivo', 
        'mime', 'de_extension', 'in_activo', 'created_at', 'updated_at')
        ->where('id_tab_ruta', '=', $tab_ruta->id)
        ->where('in_activo', '=', true)
        //->search($q, $sortBy)
        ->orderBy($sortBy, $orderBy)
        ->paginate($perPage);

        return View::make('proceso.documento.lista')->with([
          'tab_documento' => $tab_documento,
          'orderBy' => $orderBy,
          'sortBy' => $sortBy,
          'perPage' => $perPage,
          'columnas' => $columnas,
          'q' => $q,
          'id' => $id,
          'ruta' => $tab_ruta->id
        ]);
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function nuevo( Request $request, $id)
    {
        $tab_ruta = tab_ruta::select( 'id', 'id_tab_solicitud')
        ->where('id', '=', $id)
        ->first();

        return View::make('proceso.documento.nuevo')->with([
            'ruta' => $id,
            'id' => $tab_ruta->id_tab_solicitud
        ]);
    }

        /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function editar($id)
    {
        $data = tab_documento::select( 'id', 'id_tab_ruta', 'id_tab_solicitud', 'de_documento', 'nb_archivo', 
        'mime', 'de_extension', 'in_activo', 'created_at', 'updated_at')
        ->where('id', '=', $id)
        ->first();

        return View::make('proceso.documento.editar')->with([
            'data' => $data
        ]);
    }

        /**
    * Update the specified resource in storage.
    *
    * @param  int  $id
    * @return Response
    */
    public function guardar( Request $request, $id = NULL)
    {
        DB::beginTransaction();

        if($id!=''||$id!=null){
  
            try {

                $validator= Validator::make($request->all(), tab_documento::$validarEditar);

                if ($validator->fails()){
                    return Redirect::back()->withErrors( $validator)->withInput( $request->all());
                }

                $extension = strtolower(File::extension(basename($request->file('archivo')->getClientOriginalName())));

                $tab_documento = tab_documento::find($id);
                $tab_documento->de_documento = $request->descripcion;
                $tab_documento->nb_archivo = $request->file('archivo')->getClientOriginalName();
                $tab_documento->de_extension = $extension;
                $tab_documento->mime = $request->file('archivo')->getMimeType();
                $tab_documento->save();
                
                $directorio = '/App/documento';
                $disk = Storage::disk('ftp');
                $disk->makeDirectory($directorio);

                $disk->put($directorio.'/'.$tab_documento->id.'.'.$extension, file_get_contents($request->file('archivo')->getRealPath()));

                DB::commit();

                Session::flash('msg_side_overlay', 'Registro Editado con Exito!');
                return Redirect::to('/proceso/documento/lista'.'/'.$request->solicitud);

            }catch (\Illuminate\Database\QueryException $e){

                DB::rollback();
                return Redirect::back()->withErrors([
                    'da_alert_form' => $e->getMessage()
                ])->withInput( $request->all());

            }
  
        }else{
  
            try {

                $validator = Validator::make($request->all(), tab_documento::$validarCrear);

                if ($validator->fails()){
                    return Redirect::back()->withErrors( $validator)->withInput( $request->all());
                }
    
                $extension = strtolower(File::extension(basename($request->file('archivo')->getClientOriginalName())));

                $tab_documento = new tab_documento;
                $tab_documento->id_tab_ruta = $request->ruta;
                $tab_documento->id_tab_solicitud = $request->solicitud;
                $tab_documento->de_documento = $request->descripcion;
                $tab_documento->nb_archivo = $request->file('archivo')->getClientOriginalName();
                $tab_documento->de_extension = $extension;
                $tab_documento->mime = $request->file('archivo')->getMimeType();
                $tab_documento->in_activo = true;
                $tab_documento->save();

                $directorio = '/App/documento';
                $disk = Storage::disk('ftp');
                $disk->makeDirectory($directorio);

                $disk->put($directorio.'/'.$tab_documento->id.'.'.$extension, file_get_contents($request->file('archivo')->getRealPath()));

                DB::commit();

                Session::flash('msg_side_overlay', 'Registro Guardado con Exito!');
                return Redirect::to('/proceso/documento/lista'.'/'.$request->solicitud);

            }catch (\Illuminate\Database\QueryException $e){

                DB::rollback();
                return Redirect::back()->withErrors([
                    'da_alert_form' => $e->getMessage()
                ])->withInput( $request->all());

            }
        }
    }

        /**
    * Show the form for creating a new resource.
    *
    * @return Response
    */
    public function eliminar( Request $request, $id)
    {
        DB::beginTransaction();
        try {
            $tab_documento = tab_documento::find( $request->id);
            //$tab_documento->delete();
            $tab_documento->in_activo = false;
            $tab_documento->save();

            $adjuntos = tab_documento::where('id', '=', $request->id)->first();

            $directorio = '/App/documento';
            $disk = Storage::disk('ftp');
            $disk->delete($directorio.'/'.$adjuntos->id.'.'.$adjuntos->de_extension);

            DB::commit();

            Session::flash('msg_side_overlay', 'Registro Borrado con Exito!');
            return Redirect::to('/proceso/documento/lista'.'/'.$id);

        }catch (\Illuminate\Database\QueryException $e)
        {
            DB::rollback();
            return Redirect::back()->withErrors([
                'da_alert_form' => $e->getMessage()
            ])->withInput( $request->all());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verAnexo($id, $t)
    {
	    $adjuntos = tab_documento::where('id', '=', $id)->first();

		$directorio = '/App/documento/'.$id.'.'.$adjuntos->de_extension;
		$archivo = Storage::disk('ftp')->get($directorio);

        return (new ResposeFile($archivo, 200))->header('Content-Type', ''.$adjuntos->mime.'');
        
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
        $perPage = 100;
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

        $data = tab_ruta::select( 'id_tab_solicitud')
        ->where('id', '=', $id)
        ->first();

        $tab_documento = tab_documento::select( 'id', 'id_tab_ruta', 'id_tab_solicitud', 'de_documento', 'nb_archivo', 
        'mime', 'de_extension', 'in_activo', 'created_at', 'updated_at')
        ->where('id_tab_ruta', '=', $id)
        ->where('in_activo', '=', true)
        //->search($q, $sortBy)
        ->orderBy($sortBy, $orderBy)
        ->paginate($perPage);

        return View::make('proceso.documento.listaVer')->with([
          'tab_documento' => $tab_documento,
          'orderBy' => $orderBy,
          'sortBy' => $sortBy,
          'perPage' => $perPage,
          'columnas' => $columnas,
          'q' => $q,
          'id' => $data->id_tab_solicitud,
          'ruta' => $id
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function verReporte($id, $t)
    {
		$directorio = '/App/reporte/'.$id.'.pdf';
		$archivo = Storage::disk('ftp')->get($directorio);

        return (new ResposeFile($archivo, 200))->header('Content-Type', 'application/pdf');
        
    }
}
