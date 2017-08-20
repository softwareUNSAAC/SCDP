<?php

class CampeonatoController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		$todocampeonato = Campeonato::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->paginate(3);

        return View::make('user_com_organizing.campeonato.listar')->with('todocampeonato',$todocampeonato);
	}

    public function detalle($codcampeonato)
    {
        $equipos = Equipo::where('codCampeonato','=',$codcampeonato)->get();
        $campeonato = Campeonato::where("codCampeonato",'=',$codcampeonato)->where('codCom_Org','=',Session::get('user_idcom_orgdor'))->first();
        $Actividades = Actividad::where('codCampeonato','=',$codcampeonato)->get();
        $configuracion=Configuracion::where('codCampeonato','=',$codcampeonato)->get();
        $todoReunion=DB::table('treunion')
            ->join('tfecha', 'treunion.idFecha', '=', 'tfecha.idFecha')
            ->join('trueda', 'tfecha.codRueda', '=', 'trueda.codRueda')
            ->join('tcampeonato', 'trueda.codCampeonato', '=', 'tcampeonato.codCampeonato')
            ->select('treunion.codReunion', 'treunion.fecha')
            ->where( 'tcampeonato.codCampeonato', '=', $codcampeonato)
            ->get();



        return View::make('user_com_organizing.campeonato.detail')
            ->with('campeonato',$campeonato)
            ->with('Actividades',$Actividades)
            ->with('equipos',$equipos)
            ->with('configuracion', $configuracion)
            ->with('todoReunion', $todoReunion);
    }


    public function detalleequipojugador($codequipo,$codcampeonato)
    {
        $equipo = Equipo::where('codEquipo','=',$codequipo)->first();
        $jugadoresdelequipo = Jugador::where('codEquipo','=',$codequipo)->get();
        return View::make('user_com_organizing.campeonato.equipojugador.detail')
            ->with('equipo',$equipo)
            ->with('codcampeonato',$codcampeonato)
            ->with('jugadoresdelequipo',$jugadoresdelequipo);
    }

    public function detallejugador($codequipo,$codcampeonato,$idjugador)
    {

        $jugador = Jugador::where('codJugador','=',$idjugador)->first();
        return View::make('user_com_organizing.campeonato.equipojugador.jugador.detail')
            ->with('codequipo',$codequipo)
            ->with('codcampeonato',$codcampeonato)
            ->with('jugador',$jugador);
    }



	public function  actividad($codcampeonato)
    {
        $campeonato = Campeonato::where('codCampeonato','=',$codcampeonato)->first();
        return  View::make('user_com_organizing.campeonato.actividad')
        ->with('codcampeonato',$codcampeonato)
        ->with('campeonato',$campeonato);

    }
    public function crearcodactividad($id)
    {
        $users = DB::table('tactividad')->count();
        $users++;
        return  "ACT0".$id."0".$users;
    }
    public function addacti($id)
    {

        $acti1=new Actividad();
        $acti1->codActividad=$this->crearcodactividad($id);
        $acti1->actividad=Input::get('actividad');
        $acti1->fechaInicio=Input::get('fechaI');
        $acti1->fechaFin=Input::get('fechaf');
        $acti1->observaciones=Input::get('observacion');;
        $acti1->codCampeonato=$id;
        $acti1->save();
        return Redirect::to('campeonato/detail/'.$id);
    }
    public function crearcoodconfig($id)
    {
        $users = DB::table('tconfiguracion')->count();
        $users++;
        return  "COF0".$id."0".$users;
    }

    public function  configuracion($codcampeonato)
    {
        $campeonato = Campeonato::where('codCampeonato','=',$codcampeonato)->first();
        return  View::make('user_com_organizing.campeonato.configuraciones')->with('campeonato',$campeonato);

    }

    public function addconfig($id)
    {
        $users = Comision::where('codCom_Org', '=', Session::get('user_idcom_orgdor'))->first();

        $user = substr($users->codCom_Org, 3, 7);
        $tmp = substr($user, 0, 1);

        while ($tmp == "0") {

            $user = substr($user, 1, strlen($user) - 1);
            $tmp = substr($user, 0, 1);
        }

        $numero = (int)$user;
        $cadena = "COF" . $numero;
        $NRO = Configuracion::where('codCampeonato', '=', $id)->count();
        $NRO++;


//
        $configguracion2 = new Configuracion;
        $configguracion2->descripcion="maximo nro de dptacademicos por equipo";
        $configguracion2->idConfiguracion = $cadena . $NRO;
        $configguracion2->variable="maximodp";
        $configguracion2->valor=Input::get('maximo');
        $configguracion2->codCampeonato=$id;
        $configguracion2->save();
        $NRO++;

        $configguracion3 = new Configuracion;
        $configguracion3->idConfiguracion = $cadena . $NRO;
        $configguracion3->descripcion="maximo nro de lugadores libres";
        $configguracion3->variable="maximoL";
        $configguracion3->valor=Input::get('maximoL');
        $configguracion3->codCampeonato=$id;
        $configguracion3->save();
        $NRO++;

        $configguracion4 = new Configuracion;
        $configguracion4->idConfiguracion = $cadena . $NRO;
        $configguracion4->descripcion="duracion de tiempos";
        $configguracion4->valor=Input::get('duracion');
        $configguracion4->variable="duracion";
        $configguracion4->codCampeonato=$id;
        $configguracion4->save();
        $NRO++;

        $configguracion5 = new Configuracion;
        $configguracion5->idConfiguracion = $cadena . $NRO;
        $configguracion5->descripcion="tiempo de descanso";
        $configguracion5->valor=Input::get('descanso');
        $configguracion5->variable="descanso";
        $configguracion5->codCampeonato=$id;
        $configguracion5->save();
        $NRO++;

        $configguracion6 = new Configuracion;
        $configguracion6->idConfiguracion = $cadena . $NRO;
        $configguracion6->descripcion="maximo de juagadores menores de 25 años";
        $configguracion6->valor=Input::get('maximoM');
        $configguracion6->variable="maximoM";
        $configguracion6->codCampeonato=$id;
        $configguracion6->save();
        $NRO++;

        return Redirect::to('campeonato/detail/'.$id);
    }

    public function  configuracionD($codcampeonato)
    {
        $campeonato = Campeonato::where('codCampeonato','=',$codcampeonato)->first();
       return  View::make('user_com_organizing.campeonato.configuracionesD')
       ->with('codcampeonato',$codcampeonato)
       ->with('campeonato',$campeonato);

    }

    public function addconfigD($id)
    {
        $all=Input::all();


        $configguracion1 = new Configuracion;
        $configguracion1->idConfiguracion=$this->crearcoodconfig($id);
        $configguracion1->descripcion=Input::get('descripcion');
        $configguracion1->valor=Input::get('valor');
        $configguracion1->codCampeonato=$id;
        $configguracion1->save();

        return Redirect::to('campeonato/detail/'.$id);
    }
    public function insertarcampeonato()
    {

    $integrantesall = IntegrantesCO::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->get();

    $campeonatoA = Campeonato::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->get();

    $campeonato=null;
    foreach ( $campeonatoA as $ca )
        $campeonato=$ca;

    return View::make('user_com_organizing.campeonato.insertar')->with('campeonato',$campeonato)->with('integrantesall',$integrantesall);
}
	public function store()
	{

        $input = Input::all();
       // $campeonatoA = Campeonato::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->first();
        $campeonatoA = Campeonato::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->get();

        $campeonato=null;
        foreach ( $campeonatoA as $ca )
            $campeonato=$ca;
        $flag=1;
        if(!$campeonatoA)
            $flag=-1;
        $flag=strcmp(Input::get('Codigo'),$campeonato->codCampeonato);
        if($flag!=0) {
            $campeonato = new Campeonato;
            $hoy = getdate();
            $dia = $hoy['mday'];
            $mes = $hoy['mon'];
            $anio = $hoy['year'];
            $fecha = $anio . "-" . $mes . "-" . $dia;
            $cadena = "";
            if ($mes > 6)
                $cadena = "II";
            else
                $cadena = "I";
            $aca = $anio . " " . $cadena;
            $campeonato->codCampeonato = Input::get('Codigo');
            $campeonato->nombre = Input::get('Nombre');
            $campeonato->anioAcademico = $aca;
            $campeonato->fechaCreacion = Input::get('Fecha');
            $campeonato->habilitar = "habilitado"; //esta parte ami parecer tiene que ser un combobox en la vista
            $campeonato->codCom_Org = Session::get('user_idcom_orgdor');
            $campeonato->save();


            $regla = [  'Nombre'=>'required','Rol'=>'required'];
            $validacion = Validator::make($input,$regla);
            if($validacion->fails())
            {
                return Redirect::back()->withErrors($validacion);
            }
            else {
                //verificamos que el docente exista

                $rol = Input::get('Rol');
                $dni=Input::get('dni');
                $idcom_orgdor = Session::get('user_idcom_orgdor');
                if ($data = IntegrantesCO::where('codCom_Org', '=', $idcom_orgdor)->where('rol','=',$rol)->first())
                {
                    $error = ['wilson' => 'El '.$rol.' es '.$data->nombre.' '.$data->apellidos.' nose aceptan dos '.$rol.'s'];
                    return Redirect::back()->withInput()->withErrors($error);
                }
                else
                {
                    if ($data = IntegrantesCO::where('codCom_Org', '=', $idcom_orgdor)->where('dni','=',$dni)->first())
                    {
                        $error = ['wilson' => 'la persona ya  '.$rol.' por favor ingrese otra persona'];
                        return Redirect::back()->withInput()->withErrors($error);
                    }
                    else
                    {

                        $newIntegrante = new IntegrantesCO();
                        $newIntegrante->dni=Input::get('dni');
                        $newIntegrante->rol = Input::get('Rol');
                        $newIntegrante->codCom_Org = $idcom_orgdor;
                        $newIntegrante->nombre = Input::get('nombre');;
                        $newIntegrante->apellidos = Input::get('apellidos');;
                        $newIntegrante->save();
                        $success = ['wilson' => 'campeonato creado y Integrante Agregado Satisfactoriamente'];

                        return Redirect::back()->withInput()->withErrors($success);
                    }
                }
            }

        }

        else{

            $regla = [  'nombre'=>'required','Rol'=>'required'];
            $validacion = Validator::make($input,$regla);
            if($validacion->fails())
            {
                return Redirect::back()->withErrors($validacion);
            }
            else {
                //verificamos que el docente exista

                $rol = Input::get('Rol');
                $dni=Input::get('dni');

                $idcom_orgdor = Session::get('user_idcom_orgdor');
                $nro=3;
                $nrointegrantess = IntegrantesCO::where('codCom_Org','=',$idcom_orgdor)->where('rol','=',$rol)->count();
                $aux=0;
                if($rol=="otros"){
                    $nro=$nrointegrantess;
                    if($nro==3)
                        $aux=1;
                }


                if (($data = IntegrantesCO::where('codCom_Org', '=', $idcom_orgdor)->where('rol','=',$rol)->first())&&$nro==3)
                {

                    $error = ['wilson' => 'El '.$rol.' es '.$data->nombre.' '.$data->apellidos.' nose aceptan mas '.$rol.'s'];
                    return Redirect::back()->withInput()->withErrors($error);
                }
                else
                {
                    if ($data = IntegrantesCO::where('codCom_Org', '=', $idcom_orgdor)->where('dni','=',$dni)->first())
                    {
                        $error = ['wilson' => 'la persona ya  '.$rol.' por favor ingrese otra persona'];
                        return Redirect::back()->withInput()->withErrors($error);
                    }
                    else
                    {

                        $newIntegrante = new IntegrantesCO();
                        $newIntegrante->dni=Input::get('dni');
                        $newIntegrante->rol = Input::get('Rol');
                        $newIntegrante->codCom_Org = $idcom_orgdor;
                        $newIntegrante->nombre = Input::get('nombre');;
                        $newIntegrante->apellidos = Input::get('apellidos');;
                        $newIntegrante->save();

                        $success = ['wilson' => 'Integrante Agregado Satisfactoriamente d'];
                        $nrointegrantess = IntegrantesCO::where('codCom_Org','=',$idcom_orgdor)->count();

                        if($nrointegrantess>4){
                            print "locsd";
                            $success = ['wilson' => 'campeonato creado satisfactoriamente'];
                            return Redirect::to('campeonato/listar')->withErrors($success);
                        }
                        else
                            return Redirect::to('campeonato/insertar')->withErrors($success);
                    }
                }
            }
        }

	}

	public function editarcampeonato($id)
	{
        $campeonato = Campeonato::where("codCampeonato",'=',$id)->where('codCom_Org','=',Session::get('user_idcom_orgdor'))->first();
		return View::make('user_com_organizing.campeonato.editar')->with('campeonato',$campeonato);
	}


	public function update($id)
	{
		//$todocampeonato = Campeonato::all();
		$entra = Input::all();
		$campeonato = DB::table('tcampeonato')
            ->where('codCampeonato', $id)
            ->update(array(
		'nombre' => $entra['Nombre'],
		'fechaCreacion' => $entra['Fecha']
		));
        return Redirect::to('campeonato/listar');
	}

	public function delete($id)
	{
		
		$campeonato = DB::table('tcampeonato')
            ->where('codcampeonato', $id)
            ->delete();
        return Redirect::to('campeonato/listar');
	}

    public function find()
	{
		$Docentestodo=docente::all();

        if(isset($_GET["buscar"]))
        {

        	$buscar = htmlspecialchars(Input::get("buscar"));
        	$fila = docente::select(DB::raw('*'))->where('nombres', 'like', '%'.$buscar.'%')->orwhere('apellidos', 'like', '%'.$buscar.'%')->get();
        	return View::make('docente.listar')->with('Busqueda',$fila);
		
        }

        return View::make('docente.listar')->with('Docentestodo',$Docentestodo);
	}

    //====== equipo =====
    public function detalleEquipo($codcampeonato,$codequipo)
    {
        $delegadosEquipo=DB::table('tequipo')
            ->join('tdelegando', 'tequipo.codEquipo', '=', 'tdelegando.codEquipo')
            ->join('tdocente', 'tdelegando.codDocente', '=', 'tdocente.codDocente')
            ->select('tdelegando.dni','tdocente.codDocente', 'tdocente.nombre','tdocente.apellidoP','tdocente.apellidoM','tdelegando.rol','tdelegando.estado')
            ->where( 'tequipo.codEquipo', '=', $codequipo)->where( 'tequipo.codCampeonato', '=', $codcampeonato)
            ->get();

        $jugadoresEquipo=DB::table('tequipo')
            ->join('tjugador', 'tequipo.codEquipo', '=', 'tjugador.codEquipo')
            ->join('tdocente', 'tjugador.codDocente', '=', 'tdocente.codDocente')
            ->select('tjugador.dni','tdocente.codDocente', 'tdocente.nombre','tdocente.apellidoP','tdocente.apellidoM','tequipo.estado')
            ->where( 'tequipo.codEquipo', '=', $codequipo)->where( 'tequipo.codCampeonato', '=', $codcampeonato)
            ->get();

        return View::make('user_com_organizing.equipo.detail')->with('delegadosEquipo', $delegadosEquipo)
            ->with('jugadoresEquipo', $jugadoresEquipo)
            ->with('codcampeonato',$codcampeonato)
            ->with('codequipo',$codequipo);
    }

    public function editJugador($codcampeonato,$codequipo,$dni)
    {
        $ediJ=Jugador::find($dni);
        $habilitado="";
        if('habilitado'==Input::get('habilitado'))
        {
            $habilitado="habilitado";

        }
        else
        {
            $habilitado="desabilitado";
        }
        if('desabilitado'==Input::get('desabilitado'))
        {
            $habilitado="desabilitado";
        }
        $ediJ->estado=$habilitado;
        $ediJ->save();


        return Redirect::to('campeonato/detail/'.$codcampeonato.'/equipodetalle/'.$codequipo.'#jugadores');
    }


    public function editDelegado($codcampeonato,$codequipo,$dni)
    {
        $ediJ=Delegado::find($dni);
        $habilitado="";
        if('habilitado'==Input::get('habilitado'))
        {
            $habilitado="habilitado";

        }
        else
        {
            $habilitado="desabilitado";
        }
        if('desabilitado'==Input::get('desabilitado'))
        {
            $habilitado="desabilitado";
        }
        $ediJ->estado=$habilitado;
        $ediJ->save();


        return Redirect::to('campeonato/detail/'.$codcampeonato.'/equipodetalle/'.$codequipo.'#delegados');
    }




}
