<?php

class PartidoController extends \BaseController {


public function partido_all()
	{
		$todoConclusion = Cambio::all();
		return View::make('partido.cambios')->with('todoConclusion', $todoConclusion);
	}

	public function cambio_post($codpartido)
	{



		$input = Input::all();

		$rules = array(


			'entra' => 'required',
			'sale' => 'required',

			
		);

		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator);
		}
		else
		{
            if(Input::get('entra')==Input::get('sale'))
            {
                $error['percy']='son el mismo juagador';
                return Redirect::back()->withInput()->withErrors($error);
            }
            else{

                    date_default_timezone_set('America/Lima');

                    $partido=Partido::find($codpartido)->horaInicio;
                    $hoyH = date("H:i:s");

                    $dteStart = new DateTime($hoyH);
                    $dteEnd   = new DateTime($partido);
                    $dteDiff  = $dteEnd->diff($dteStart);
                    $hora= (int)$dteDiff->format("%H");
                    $min= (int)$dteDiff->format("%I");
                    $h=(int)$hora;
                    $h=$h*60;
                    $min=$min+$h;
                    $category = new Cambio;

                    $category->codjugPart1 = Input::get('entra');
                    $category->codjugPart2= Input::get('sale');
                    $category->minuto =  $min;
                    $category->codpartido = $codpartido;
                    $category->save();

                    $J2=JugadorEnJuego::find(Input::get('sale'));

                    $J1=JugadorEnJuego::find(Input::get('entra'));
                    $J2->cambio='1';
                    $aux=$J1->condicionenpartido;
                    $aux1=$J1->escapitan;
                    $J1->condicionenpartido=$J2->condicionenpartido;
                    $J1->escapitan=$J2->escapitan;
                    $J2->condicionenpartido=$aux;
                    $J2->escapitan=$aux1;
                    $J1->save();


                    $J2->save();

                $error['percy']='se hizo el cambio normalmente';
                return Redirect::back()->withInput()->withErrors($error);

            }
		}
	}

	public function partido_get_edit($id)
	{
		$todoConclusion = Cambio::all();
		//$category = DB::select('select * from Tcambio where idcambio=? ',array($id));
		$category =  Cambio::find($id);

		return View::make('partido.cambios')->with('todoConclusion', $todoConclusion)->with('category', $category);
	}

	public function partido_post_edit($id)
	{
		$input = Input::all();

		$rules = array(

			
			'entra' => 'required',
			'sale' => 'required',
			'minuto' => 'required',
			'id_partido' => 'required'
			
		);

		$validator = Validator::make($input, $rules);

		if($validator->fails())
		{
			return Redirect::back()->withErrors($validator);
		}
		else
		{
			
				$category =  Cambio::find($id);
				$category->idjugadorenjuego1 = Input::get('entra');
				$category->idjugadorenjuego2 = Input::get('sale');
				$category->minuto = Input::get('minuto');
				$category->codpartido = Input::get('id_partido');
			$category->save();

			return Redirect::to('/partido/cambios/');
		}
	}

	public function partido_delete($id)
	{
		$category =  Cambio::find($id);
		$category->delete();
		return Redirect::to('/partido/cambios/');
	}





	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
		
		$todopartidos = Partido::all();
        return View::make('partido.listar')->with('todopartidos',$todopartidos);
	}

	public function nuevo()
	{
		
		//$todopartidos = Partido::all();
        return View::make('partido.nuevo');
	}

	public function insertarpartido()
	{
		//$todocampeonato = Campeonato::all();
        return View::make('partido.insertar');
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
	public function create()
	{
		//
	}
    public function planilla($codcampeonato,$idtorneo,$idfecha,$codpartido,$codequipo)
    {
        //$pdf=new PDF('P', 'mm', '200, 300');
        $fpdf = new PDF();
        $tabla= DB::select('call plantilla(?,?,?)',array($idtorneo,$codpartido,$codequipo));
        $columnas = ['NRO','nombre y apellidos','condicion','equipo'];
        $fpdf->AddPage();
        $fpdf->Cell(80);
        $fpdf->Cell(30,5,'planilla de jugadores',0,1,'C');
        $fpdf->SetFont('Arial','B',9);
        $fpdf->Ln(2);
        $fpdf->SetFont('Arial','B',16);

        $fpdf->planilla($columnas,$tabla);
        $fpdf->Output();
        exit;
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store()
	{
		$partido = new Partido;
		
                       
		$partido->codpartido = Input::get('Cod_partido');
		$partido->horainicio = Input::get('Hora_inicio');
		$partido->horafin = Input::get('Hora_final');
		$partido->tipopartido = Input::get('Tipo_partido');
		$partido->observacion= Input::get('Observacion');
		$partido->codprogramacion= Input::get('Cod_programacion');
		$partido->idarbitroporpartido= Input::get('Idarbitro');
		$partido->save();
		return Redirect::to('partido/');
		
	}
	


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function show($id)
	{
		//
	}


	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function editarpartido($id)
	{
		$partido = Partido::where('codpartido', '=', $id)->get();
		return View::make('partido.editar')->with('partidos',$partido);


	}
	


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function destroy($id)
	{
		//
	}

    public  function partido($codcampeonato,$codrueda,$idfecha,$codpartido)
    {
        //$todoConclusion = Cambio::all();
        //elementos
        $fecha=Fechas::find($idfecha);
        $partido=Partido::find($codpartido);
        $programacion=Programacion::find($partido->codProgramacion);
        $torneo = Torneo::where('codRueda','=',$codrueda)->first();
        $arbitros = Arbitro::all();
        $arbixPart=ArbitroPorPartido::where('codPartido','=',$codpartido)->count();
        $todosArbitros=ArbitroPorPartido::where('codPartido','=',$codpartido)->get();
        //end elementos
        $nroPartido=$programacion->nroPartido;
        $fixture=Fixture::where('codRueda','=',$torneo->codRueda)
            ->where('nroFecha','=',$fecha->nroFecha)
            ->where('nroPartido','=',$nroPartido)->first();
        //elementos
        $equipo1=Equipo::find($fixture->codEquipo1);
        $equipo2=Equipo::find($fixture->codEquipo2);
        $activarPlanilla=Planilla::where('codPartido','=',$codpartido)->first();

        $fechaactual=DB::select("select curdate() as fecha");
        $fechasiguiente=DB::select("select  adddate(curdate(),1) as fecha");
        $fechaAnterior=DB::select("select  subdate(curdate(),1) as fecha");
        $hora=DB::select("select  curtime() as hora");
        $horaAsistencia=DB::select("select  subtime(?,3000) as fecha",array($partido->horaInicio));

        foreach($fechaactual as $value)
        {$Factual=$value->fecha;}

        foreach($fechasiguiente as $value)
        {$Fsiguiente=$value->fecha;}

        foreach($hora as $value)
        {$horaA=$value->hora;}

        foreach($fechaAnterior as $value)
        {$Fantes=$value->fecha;}

        foreach($horaAsistencia as $value)
        {$HrAistencia=$value->fecha;}


  ///===== es la dia de programacion
        $HH=DB::select("select  if(?=?,1,0) as fecha",array($fecha->diaFecha,$Factual));
        foreach($HH as $value)
        { $esdiaProgramacion=$value->fecha;}
     //end fechaf
      // mañena es dia de programacion
        $HH=DB::select("select  if(?<?,1,0) as fecha",array($fecha->diaFecha,$Fsiguiente));
        foreach($HH as $value)
        {$manenaProgramacion=$value->fecha;}
       // ayer fue dia de programacion
        $HH=DB::select("select  if(?=?,1,0) as fecha",array($fecha->diaFecha,$Fantes));
        foreach($HH as $value)
        {$ayerFProgramacion=$value->fecha;}

        // si la  hora es mayor 23:50
        $HH=DB::select("select  if(?=?,1,0) as fecha",array(substr($horaA,0,5),"23:50"));
        foreach($HH as $value)
        {$esHora=$value->fecha;}
        // es hora de inicio
        $HH=DB::select("select  if(curtime()>=? and curtime()<?,1,0) as fecha",array($partido->horaInicio,"23:50:00"));
        foreach($HH as $value)
        {$HoraI=$value->fecha;}
        //hora de tomo asistencia 30 min
        $HH=DB::select("select  if(curtime()>=? and curtime()<=?,1,0) as fecha",array($HrAistencia,$partido->horaInicio));
        foreach($HH as $value)
        {$AH=$value->fecha;}
        $jugadoresequipo1="";
        $jugadoresequipo2="";

        $activarPlanilla=Planilla::where('codPartido','=',$codpartido)->first();
        if($activarPlanilla!="") {
            $Planilla1=Planilla::where('codPartido','=',$codpartido)->where('nroPlantilla','=',1)->first();
            $Planilla2=Planilla::where('codPartido','=',$codpartido)->where('nroPlantilla','=',2)->first();

            //$fixture->codEquipo1
            //$Jequipo1 = Jugador::where('codequipo', '=', $fixture->equipo1)->get();
            //$Jequipo2 = Jugador::where('codequipo', '=', $fixture->equipo2)->get();
            //$arbitros = Arbitro::all();
            //todos los jugadores de este partido  $torneo $idtorneo,$idfecha,$idfixture)
        }
        /*
        $Delanteros1 = '';
        $Mediocampistas1 = '';
        $Defensas1 = '';
        $Guardameta1 = '';
        $suplentes1 = '';
        $jugadoresdeunpartido2 = '';
        //recuperamos los arbitros del partido
        $arbitrosdelpartido = '';
        //verificamos si el partido ya se jugó
            //recuperar los datos del partido jugado
            $arbitrosdelpartido = ArbitroPorPartido::where('codPartido','=',$partido->codPartido)->first();

            //resuperamos todos los jugadores de este partido  ... un rato
/*
            $Delanteros1 = DB::table('tjugadorenjuego')
                ->join('tjugador','tjugadorenjuego.idjugador','=','tjugador.idjugador')
                ->join('tdocente','tdocente.coddocente','=','tjugador.coddocente')
                ->join('tequipo','tequipo.codequipo','=','tjugador.codequipo')
                ->where('tjugadorenjuego.codpartido','=',$partido->codpartido)
                ->where('tjugador.codequipo','=',$fixture->equipo1)
                ->where('tjugadorenjuego.condicionenpartido','=','delantero')
                ->get();
            $Mediocampistas1 = DB::table('tjugadorenjuego')
                ->join('tjugador','tjugadorenjuego.idjugador','=','tjugador.idjugador')
                ->join('tdocente','tdocente.coddocente','=','tjugador.coddocente')
                ->join('tequipo','tequipo.codequipo','=','tjugador.codequipo')
                ->where('tjugadorenjuego.codpartido','=',$partido->codpartido)
                ->where('tjugador.codequipo','=',$fixture->equipo1)
                ->where('tjugadorenjuego.condicionenpartido','=','mediocampista')
                ->get();
            $Defensas1 = DB::table('tjugadorenjuego')
                ->join('tjugador','tjugadorenjuego.idjugador','=','tjugador.idjugador')
                ->join('tdocente','tdocente.coddocente','=','tjugador.coddocente')
                ->join('tequipo','tequipo.codequipo','=','tjugador.codequipo')
                ->where('tjugadorenjuego.codpartido','=',$partido->codpartido)
                ->where('tjugador.codequipo','=',$fixture->equipo1)
                ->where('tjugadorenjuego.condicionenpartido','=','defensa')
                ->get();
            $Guardameta1 = DB::table('tjugadorenjuego')
            ->join('tjugador','tjugadorenjuego.idjugador','=','tjugador.idjugador')
            ->join('tdocente','tdocente.coddocente','=','tjugador.coddocente')
            ->join('tequipo','tequipo.codequipo','=','tjugador.codequipo')
            ->where('tjugadorenjuego.codpartido','=',$partido->codpartido)
            ->where('tjugador.codequipo','=',$fixture->equipo1)
            ->where('tjugadorenjuego.condicionenpartido','=','guardameta')
            ->get();
            $suplentes1 = DB::table('tjugadorenjuego')
                ->join('tjugador','tjugadorenjuego.idjugador','=','tjugador.idjugador')
                ->join('tdocente','tdocente.coddocente','=','tjugador.coddocente')
                ->join('tequipo','tequipo.codequipo','=','tjugador.codequipo')
                ->where('tjugadorenjuego.codpartido','=',$partido->codpartido)
                ->where('tjugador.codequipo','=',$fixture->equipo1)
                ->where('tjugadorenjuego.condicionenpartido','=','suplente')
                ->get();
            $jugadoresdeunpartido2 = DB::table('tjugadorenjuego')
                ->join('tjugador','tjugadorenjuego.idjugador','=','tjugador.idjugador')
                ->where('tjugadorenjuego.codpartido','=',$partido->codpartido)
                ->where('tjugador.codequipo','=',$fixture->equipo2)
                ->get();
   */


        $activarPlanilla=Planilla::where('codPartido','=',$codpartido)->first();



        return View::make('user_com_organizing.fecha.partido.index',compact('fixture'))
            ->with('idfecha',$idfecha)
            ->with('torneo',$torneo)
            ->with('programacion',$programacion)
            ->with('codcampeonato',$codcampeonato)
            ->with('arbitros',$arbitros)
            ->with('partido',$partido)
            ->with('arbixPart',$arbixPart)
            ->with('todosArbitros',$todosArbitros)
            ->with('equipo1',$equipo1)
            ->with('equipo2',$equipo2)//comienza las validaciones

            ->with('activarPlanilla',$activarPlanilla)
            ->with('esdiaProgramacion',$esdiaProgramacion)
            ->with('manenaProgramacion',$manenaProgramacion)
            ->with('ayerFProgramacion',$ayerFProgramacion)
            ->with('esHora',$esHora)
            ->with('HoraI',$HoraI)
            ->with('AH',$AH);
            //->with('todoConclusion', $todoConclusion);
    }


    public  function verPartido($codfixture,$codprogramacion)
    {
        //$todoConclusion = Cambio::all();
        //elementos
        $fixture=Fixture::find($codfixture);
        //equipo 1
        $codequipo1=$fixture->codEquipo1;
        //equipo 2
        $codequipo2=$fixture->codEquipo2;
        // partido
        $codpartido=$fixture->codPartido;


        $idfecha=Programacion::find($codprogramacion)->idFecha;

        $codcampeonato=Torneo::find($fixture->codRueda)->codCampeonato;

        $torneo=Torneo::find($fixture->codRueda);
        $jugador1=Jugador::where('codEquipo','=',$codequipo1)
            ->where('seleccionado','=','1')->where('estado','=','habilitado')->get();
        $jugador2=Jugador::where('codEquipo','=',$codequipo2)->where('seleccionado','=','1')
            ->where('estado','=','habilitado')->get();

        //arbitros
        $arbitros=Arbitro::where('codCampeonato','=',$codcampeonato)->get();

        $todosArbitros=ArbitroPorPartido::where('codPartido','=',$codpartido)->get();

        //datos que confirman jugadores
        //mostrar la lista de jugadores
        $flag=0;
        $nroPlantilla=Planilla::where('codPartido','=',$codpartido)->count();
        if($nroPlantilla==2)
            $flag=1;



        ///0======= en partido
        //jugadores de equipo1


        $Delanteros1 = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','delantero')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();


        $Mediocampistas1 = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','mediocampista')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();

        $Defensas1  = DB::table('tpartido')
        ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
        ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
        ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
        ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
        ->where('tjugadorjuego.condicionenpartido','=','defensa')
        ->where('tpartido.codPartido','=',$codpartido)
        ->where('tequipo.codEquipo','=',$codequipo1)
        ->get();



        $Guardameta1  = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','guardameta')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();

        $suplentes1  = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','suplente')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();

        //jugador del equipo 2
        $Delanteros2 = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','delantero')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();


        $Mediocampistas2 = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','mediocampista')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();

        $Defensas2  = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','defensa')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();



        $Guardameta2  = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','guardameta')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();

        $suplentes2  = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','suplente')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();

        //miembros de mesa
        $miembrosmesa=Mesa::where('codPartido','=',$codpartido)->get();

        $arbixPart=ArbitroPorPartido::where('codPartido','=',$codpartido)->get();

        // datos para terminar
        $nroJ1= Jugador::where('codEquipo','=',$codequipo1)->where('seleccionado','=','1')->count();
        $nroJ2=Jugador::where('codEquipo','=',$codequipo2)->where('seleccionado','=','1')->count();
        $aux=$nroJ1+$nroJ2;
        $nroA=$arbixPart=ArbitroPorPartido::where('codPartido','=',$codpartido)->count();
        $suma=$nroA;
        return View::make('user_com_organizing.fecha.partido.index',compact('fixture'))
            ->with('codprogramacion',$codprogramacion)
            ->with('codpartido',$codpartido)
            ->with('codequipo1',$codequipo1)
            ->with('codequipo2',$codequipo2)
            ->with('jugador1',$jugador1)
            ->with('jugador2',$jugador2)
            ->with('arbitros',$arbitros)
            //en partido
            ->with('Delanteros1',$Delanteros1)
            ->with('Mediocampistas1',$Mediocampistas1)
            ->with('Defensas1',$Defensas1)
            ->with('Guardameta1',$Guardameta1)
            ->with('suplentes1',$suplentes1)
            ->with('Delanteros2',$Delanteros2)
            ->with('Mediocampistas2',$Mediocampistas2)
            ->with('Defensas2',$Defensas2)
            ->with('Guardameta2',$Guardameta2)
            ->with('suplentes2',$suplentes2)

            ->with('arbixPart',$arbixPart)
            ->with('todosArbitros',$miembrosmesa)
            ->with('flag',$flag)
            ->with('codcampeonato',$codcampeonato)
            ->with('torneo',$torneo)
            ->with('idfecha',$idfecha)
            ->with('todosArbitros',$todosArbitros)
            ->with('codfixture',$codfixture)
            ->with('suma',$suma)
            ->with('aux',$aux);


        //->with('todoConclusion', $todoConclusion);
    }




    public  function arbitroadd()
    {
        $idfecha = Input::get('idfecha');
        $codcampeonato = Input::get('codcampeonato');
        $idtorneo = Input::get('idtorneo');
        $codpartido=Input::get('codpartido');
        $codprogramacion=Input::get('codprogramacion');
        $fixture=Fixture::where('codPartido','=',$codpartido)->first();


        $respuesta = ArbitroPorPartido::isertar(Input::all());



        return Redirect::to('verpartido/'.$fixture->codFixture.'/'.$codprogramacion)->withErrors($respuesta['mensaje']);
    }
    public function  crear($id,$nro)
    {

        $nro1=DB::table('tpartido')->count();

        return "PLA".$nro1.$nro;

    }
    public  function enviarP()
    {
        $idfecha = Input::get('idfecha');
        $codcampeonato = Input::get('codcampeonato');
        $idtorneo = Input::get('idtorneo');
        $codpartido = Input::get('codpartido');
        $codequipo1=Input::get('codequipo1');
        $codequipo2=Input::get('codequipo2');


        $plantilla1 = new Planilla();
        $plantilla1->codPantilla = $this->crear($codpartido, 1);
        $plantilla1->nroPlantilla = 1;
        $plantilla1->codPartido = $codpartido;
        $plantilla1->save();

        $plantilla2 = new Planilla();
        $plantilla2->codPantilla = $this->crear($codpartido, 2);
        $plantilla2->nroPlantilla = 2;
        $plantilla2->codPartido = $codpartido;
        $plantilla2->save();
        $nro=DB::table('tequipopartido')->count();
        $nro1=DB::table('tpartido')->count();
        $cod="EP0".$nro1.($nro+1);
        $equipo1Partido=new EquipoPartido();
        $equipo1Partido->codEquiPart=$cod;
        $equipo1Partido->puntaje=0;
        $equipo1Partido->observacion="";
        $equipo1Partido->reclamo="";
        $equipo1Partido->codPartido=$codpartido;
        $equipo1Partido->codEquipo=$codequipo1;
        $equipo1Partido->save();


        $nro=DB::table('tequipopartido')->count();
        $cod="EP0".$nro1.($nro+1);
        $equipo1Partido=new EquipoPartido();
        $equipo1Partido->codEquiPart=$cod;
        $equipo1Partido->puntaje=0;
        $equipo1Partido->observacion="";
        $equipo1Partido->reclamo="";
        $equipo1Partido->codEquipo=$codequipo2;
        $equipo1Partido->codPartido=$codpartido;
        $equipo1Partido->save();
        return Redirect::to('fechas/'.$codcampeonato.'/'.$idtorneo.'/'.$idfecha.'/'.$codpartido.'/partido.html');
    }



    public function jugadoradd()
    {
        $idfecha = Input::get('idfecha');
        $codcampeonato = Input::get('codcampeonato');
        $idtorneo = Input::get('idtorneo');
        $idfixture = Input::get('codfixture');

        $codequipo1=Input::get('codequipo1');
        $codprogramacion=Input::get('codprogramacion');


        $respuesta = JugadorEnJuego::isertar(Input::all());
        if($respuesta['error']==true)
        {
            return Redirect::to('verpartido/'.$idfixture.'/'.$codprogramacion)->withErrors($respuesta['mensaje']);
        }
         return Redirect::to('verpartido/'.$idfixture.'/'.$codprogramacion)->withErrors($respuesta['mensaje']);
    }

    public function jugadordelete($idfecha,$codcampeonato,$idtorneo,$idfixture,$idjugadorenjuego)
    {
        JugadorEnJuego::find($idjugadorenjuego)->delete();
        $respuesta['mensaje'] = 'Jugador eliminado correctamente de este partido';
        return Redirect::to('fechas/'.$idfecha.'/'.$codcampeonato.'/'.$idtorneo.'/'.$idfixture.'/partido.html')->withErrors($respuesta['mensaje']);
    }

    // para lod GOLES
    public function jugadorgollist($idfecha,$codcampeonato,$idtorneo,$idfixture,$idjugadorenjuego)
    {
        $golesdeljugadorenjuego = Gol::where('idjugadorenjuego','=',$idjugadorenjuego)->get();
        $jugadorenjuego = JugadorEnJuego::where('idjugadorenjuego','=',$idjugadorenjuego)->first();
        $jugador = Jugador::where('idjugador','=',$jugadorenjuego->idjugador)->first();
        return View::make('user_com_organizing.fecha.partido.insidencia.gol.list')
            ->with('idfecha',$idfecha)
            ->with('codcampeonato',$codcampeonato)
            ->with('idtorneo',$idtorneo)
            ->with('idfixture',$idfixture)
            ->with('idjugadorenjuego',$idjugadorenjuego)
            ->with('jugador',$jugador)
            ->with('golesdeljugadorenjuego',$golesdeljugadorenjuego);
    }

    public function jugadorgol_get($idfecha,$codcampeonato,$idtorneo,$idfixture,$idjugadorenjuego)
    {
        return View::make('user_com_organizing.fecha.partido.insidencia.gol.insert')
            ->with('idfecha',$idfecha)
            ->with('codcampeonato',$codcampeonato)
            ->with('idtorneo',$idtorneo)
            ->with('idfixture',$idfixture)
            ->with('idjugadorenjuego',$idjugadorenjuego);
    }

    public  function jugadorgol_post()
    {
        $idfecha = Input::get('idfecha');
        $codcampeonato = Input::get('codcampeonato');
        $idtorneo = Input::get('idtorneo');
        $idfixture = Input::get('idfixture');
        $idjugadorenjuego = Input::get('idjugadorenjuego');

        $newgol = new Gol();
        $newgol->minuto = Input::get('minuto');
        $newgol->idjugadorenjuego = $idjugadorenjuego;
        $newgol->save();
        $respuesta['mensaje'] = 'Gol agregado correctamente';
        return Redirect::to('fechas/'.$idfecha.'/'.$codcampeonato.'/'.$idtorneo.'/'.$idfixture.'/'.$idjugadorenjuego.'/goles.html')->withErrors($respuesta['mensaje']);
    }

    public function jugadorgoldelete($idfecha,$codcampeonato,$idtorneo,$idfixture,$idjugadorenjuego,$idgol)
    {
        Gol::find($idgol)->delete();
        $respuesta['mensaje'] = 'Gol eliminado correctamente';
        return Redirect::to('fechas/'.$idfecha.'/'.$codcampeonato.'/'.$idtorneo.'/'.$idfixture.'/'.$idjugadorenjuego.'/goles.html')->withErrors($respuesta['mensaje']);
    }
     //para las TARJETAS
    public function jugadortarjetalist($idfecha,$codcampeonato,$idtorneo,$idfixture,$idjugadorenjuego)
    {
        $tarjetasdeljugadorenjuego = Tarjeta::where('idjugadorenjuego','=',$idjugadorenjuego)->get();
        $jugadorenjuego = JugadorEnJuego::where('idjugadorenjuego','=',$idjugadorenjuego)->first();
        $jugador = Jugador::where('idjugador','=',$jugadorenjuego->idjugador)->first();
        return View::make('user_com_organizing.fecha.partido.insidencia.tarjeta.list')
            ->with('idfecha',$idfecha)
            ->with('codcampeonato',$codcampeonato)
            ->with('idtorneo',$idtorneo)
            ->with('idfixture',$idfixture)
            ->with('idjugadorenjuego',$idjugadorenjuego)
            ->with('jugador',$jugador)
            ->with('tarjetasdeljugadorenjuego',$tarjetasdeljugadorenjuego);
    }
    public function jugadortarjeta_get($idfecha,$codcampeonato,$idtorneo,$idfixture,$idjugadorenjuego)
    {
        return View::make('user_com_organizing.fecha.partido.insidencia.tarjeta.insert')
            ->with('idfecha',$idfecha)
            ->with('codcampeonato',$codcampeonato)
            ->with('idtorneo',$idtorneo)
            ->with('idfixture',$idfixture)
            ->with('idjugadorenjuego',$idjugadorenjuego);
    }

    public  function jugadortarjeta_post()
    {
        $idfecha = Input::get('idfecha');
        $codcampeonato = Input::get('codcampeonato');
        $idtorneo = Input::get('idtorneo');
        $idfixture = Input::get('idfixture');
        $idjugadorenjuego = Input::get('idjugadorenjuego');

        $newtarjeta = new Tarjeta();
        $newtarjeta->tipo = Input::get('tipo');
        $newtarjeta->minuto = Input::get('minuto');
        $newtarjeta->idjugadorenjuego = $idjugadorenjuego;
        $newtarjeta->save();
        $respuesta['mensaje'] = 'Tarjeta agregado correctamente';
        return Redirect::to('fechas/'.$idfecha.'/'.$codcampeonato.'/'.$idtorneo.'/'.$idfixture.'/'.$idjugadorenjuego.'/tarjeta.html')->withErrors($respuesta['mensaje']);
    }

    public function jugadortarjetadelete($idfecha,$codcampeonato,$idtorneo,$idfixture,$idjugadorenjuego,$idtarjeta)
    {
        Tarjeta::find($idtarjeta)->delete();
        $respuesta['mensaje'] = 'Tarjeta eliminado correctamente';
        return Redirect::to('fechas/'.$idfecha.'/'.$codcampeonato.'/'.$idtorneo.'/'.$idfixture.'/'.$idjugadorenjuego.'/tarjeta.html')->withErrors($respuesta['mensaje']);
    }

    
    public function jugadorinsidencia($idjugadorenjuego,$idfixture)
    {
      echo 'falta';
    }


    public function terminar($codpartido, $programacion){

	    $fixture=Fixture::where('codPartido','=',$codpartido)->first();
	    $par=Partido::find($codpartido);
	    $par->termino="0";
	    $par->save();

        return Redirect::to('/partidosprogramados/'.$fixture->codRueda);

    }


    public  function empezar($codpartido){

        $fixture=Fixture::where('codPartido','=',$codpartido)->first();
        $par=Partido::find($codpartido);
        $par->termino="1";
        $par->resultado="0";
        $par->save();

        return Redirect::to('/partidosprogramados/'.$fixture->codRueda);
    }




    ///  dentro del partido
    ///
    ///
    ///

    public  function incidencias($codfixture,$codprogramacion)
    {
        //$todoConclusion = Cambio::all();
        //elementos
        $fixture=Fixture::find($codfixture);
        //equipo 1
        $codequipo1=$fixture->codEquipo1;
        //equipo 2
        $codequipo2=$fixture->codEquipo2;
        // partido
        $codpartido=$fixture->codPartido;


        $idfecha=Programacion::find($codprogramacion)->idFecha;

        $codcampeonato=Torneo::find($fixture->codRueda)->codCampeonato;

        $torneo=Torneo::find($fixture->codRueda);
        $jugador1=Jugador::where('codEquipo','=',$codequipo1)
            ->where('seleccionado','=','1')->where('estado','=','habilitado')->get();
        $jugador2=Jugador::where('codEquipo','=',$codequipo2)->where('seleccionado','=','1')
            ->where('estado','=','habilitado')->get();

        //arbitros
        $arbitros=Arbitro::where('codCampeonato','=',$codcampeonato)->get();

        $todosArbitros=ArbitroPorPartido::where('codPartido','=',$codpartido)->get();

        //datos que confirman jugadores
        //mostrar la lista de jugadores
        $flag=0;
        $nroPlantilla=Planilla::where('codPartido','=',$codpartido)->count();
        if($nroPlantilla==2)
            $flag=1;



        ///0======= en partido
        //jugadores de equipo1

        $JugadoresP1 = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();
        $JugadoresP2 = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();



        $Jugadores1 = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','<>','suplente')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();

        $suplentes1 = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','suplente')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();


        $Jugadores2 = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','<>','suplente')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();

        $suplentes2 = DB::table('tpartido')
            ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
            ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','=','suplente')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();

        /// tarjetas
        $tarjetasJT1= DB::table('tpartido')
            ->join('ttarjeta','tpartido.codPartido','=','ttarjeta.codPartido')
            ->join('tjugadorjuego','ttarjeta.codjugPart','=','tjugadorjuego.codjugPart')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();


        $tarjetasJ1= DB::table('tpartido')
            ->join('ttarjeta','tpartido.codPartido','=','ttarjeta.codPartido')
            ->join('tjugadorjuego','ttarjeta.codjugPart','=','tjugadorjuego.codjugPart')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','<>','suplente')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();

        $tarjetasJT2= DB::table('tpartido')
            ->join('ttarjeta','tpartido.codPartido','=','ttarjeta.codPartido')
            ->join('tjugadorjuego','ttarjeta.codjugPart','=','tjugadorjuego.codjugPart')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();

        $tarjetasJ2= DB::table('tpartido')
            ->join('ttarjeta','tpartido.codPartido','=','ttarjeta.codPartido')
            ->join('tjugadorjuego','ttarjeta.codjugPart','=','tjugadorjuego.codjugPart')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','<>','suplente')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();

        ///goles

        $golesJT1= DB::table('tpartido')
            ->join('tgol','tpartido.codPartido','=','tgol.codPartido')
            ->join('tjugadorjuego','tgol.codjugPart','=','tjugadorjuego.codjugPart')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();


        $golesJ1= DB::table('tpartido')
            ->join('tgol','tpartido.codPartido','=','tgol.codPartido')
            ->join('tjugadorjuego','tgol.codjugPart','=','tjugadorjuego.codjugPart')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','<>','suplente')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo1)
            ->get();

        $golesJT2= DB::table('tpartido')
            ->join('tgol','tpartido.codPartido','=','tgol.codPartido')
            ->join('tjugadorjuego','tgol.codjugPart','=','tjugadorjuego.codjugPart')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();

        $golesJ2= DB::table('tpartido')
            ->join('tgol','tpartido.codPartido','=','tgol.codPartido')
            ->join('tjugadorjuego','tgol.codjugPart','=','tjugadorjuego.codjugPart')
            ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
            ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
            ->where('tjugadorjuego.condicionenpartido','<>','suplente')
            ->where('tpartido.codPartido','=',$codpartido)
            ->where('tequipo.codEquipo','=',$codequipo2)
            ->get();


        $incidencias=Incidencia::where('codPartido','=',$codpartido)->get();

        $goles=Gol::where('codPartido','=',$codpartido)->get();
        $tajetas=Tarjeta::where('codPartido','=',$codpartido)->get();
        $cambios=Cambio::where('codPartido','=',$codpartido)->get();


        //miembros de mesa
        $miembrosmesa=Mesa::where('codPartido','=',$codpartido)->get();

        $arbixPart=ArbitroPorPartido::where('codPartido','=',$codpartido)->get();

        // datos para terminar
        $nroJ1= Jugador::where('codEquipo','=',$codequipo1)->where('seleccionado','=','1')->count();
        $nroJ2=Jugador::where('codEquipo','=',$codequipo2)->where('seleccionado','=','1')->count();
        $aux=$nroJ1+$nroJ2;
        $nroA=ArbitroPorPartido::where('codPartido','=',$codpartido)->count();
        $suma=$nroA;
        return View::make('user_com_organizing.fecha.partido.insidencia.index',compact('fixture'))
            ->with('codprogramacion',$codprogramacion)
            ->with('codpartido',$codpartido)
            ->with('codequipo1',$codequipo1)
            ->with('codequipo2',$codequipo2)
            ->with('jugador1',$jugador1)
            ->with('jugador2',$jugador2)
            ->with('arbitros',$arbitros)
            //en partido
            ->with('Jugadores1',$Jugadores1)
            ->with('Jugadores2',$Jugadores2)
            ->with('suplentes1',$suplentes1)
            ->with('suplentes2',$suplentes2)
            ->with('JugadoresP1',$JugadoresP1)
            ->with('JugadoresP2',$JugadoresP2)
            ->with('arbixPart',$arbixPart)
            ->with('todosArbitros',$miembrosmesa)
            ->with('flag',$flag)
            ->with('codcampeonato',$codcampeonato)
            ->with('torneo',$torneo)
            ->with('idfecha',$idfecha)
            ->with('todosArbitros',$todosArbitros)
            ->with('codfixture',$codfixture)
            ->with('suma',$suma)
            ->with('aux',$aux)
            ->with('incidencias',$incidencias)
            ->with('goles',$goles)
            ->with('tajetas',$tajetas)
            ->with('cambios',$cambios)
            ->with('tarjetasJT1',$tarjetasJT1)
            ->with('tarjetasJ1',$tarjetasJT1)
            ->with('tarjetasJT2',$tarjetasJT2)
            ->with('tarjetasJ2',$tarjetasJT2)
            ->with('golesJT1',$golesJT1)
            ->with('golesJ1',$golesJ1)
            ->with('golesJT2',$golesJT2)
            ->with('golesJ2',$golesJ2);
        //->with('todoConclusion', $todoConclusion);
    }
    public  function tarjeta_post($codpartido)
    {
        $idfecha = Input::get('idfecha');
        $codcampeonato = Input::get('codcampeonato');
        $idtorneo = Input::get('idtorneo');
        $idfixture = Input::get('idfixture');
        $jugadorjuego=Input::get('jugador');

        date_default_timezone_set('America/Lima');

        $partido=Partido::find($codpartido)->horaInicio;
        $hoyH = date("H:i:s");

        $dteStart = new DateTime($hoyH);
        $dteEnd   = new DateTime($partido);
        $dteDiff  = $dteEnd->diff($dteStart);
        $hora= (int)$dteDiff->format("%H");
        $min= (int)$dteDiff->format("%I");
        $h=(int)$hora;
        $h=$h*60;
        $min=$min+$h;



        $tar=Tarjeta::where('codPartido','=',$codpartido)
            ->where('tipo','=','amarilla')
            ->where('codjugPart','=',$jugadorjuego)->count();
        $tarjeta='';
        if($tar==1)
        {


            $tarjeta='roja';
            $tar1=Tarjeta::where('codPartido','=',$codpartido)
                ->where('tipo','=','amarilla')
                ->where('codjugPart','=',$jugadorjuego)->first();
             $tar1->tipo=$tarjeta;
            $tar1->minuto=$min;
             $tar1->save();
            $respuesta['mensaje'] = 'Tarjeta roja por acumulacion ';



            $j7=JugadorEnJuego::find($jugadorjuego);
            $j7->condicionenpartido="suplente";
            $j7->save();
            return Redirect::back()->withInput()->withErrors($respuesta);


        }
        $tarjeta=Input::get('tipo');
        if($tarjeta=='roja')
        {


            $newtarjeta=new Tarjeta();
            $newtarjeta->codPartido=$codpartido;
            $newtarjeta->codjugPart=$jugadorjuego;
            $newtarjeta->tipo=$tarjeta;
            $newtarjeta->minuto=$min;
            $newtarjeta->save();

            $respuesta['mensaje'] = 'Tarjeta roja  ';


            $j7=JugadorEnJuego::find($jugadorjuego);
            $j7->condicionenpartido="suplente";
            $j7->save();
            return Redirect::back()->withInput()->withErrors($respuesta);

        }

        $newtarjeta = new Tarjeta();
        $newtarjeta->tipo = Input::get('tipo');

        $newtarjeta->codjugPart = Input::get('jugador');
        $newtarjeta->minuto=$min;
        $newtarjeta->codPartido=$codpartido;
        $newtarjeta->save();



        $respuesta['mensaje'] = 'Tarjeta amarilla';
        return Redirect::back()->withInput()->withErrors($respuesta);
    }
    public  function gol_post($codpartido)
    {
        $idfecha = Input::get('idfecha');
        $codcampeonato = Input::get('codcampeonato');
        $idtorneo = Input::get('idtorneo');
        $idfixture = Input::get('idfixture');
        $jugadorjuego=Input::get('jugador');
        $codequipo1=Input::get('codequipo1');
        $codequipo2=Input::get('codequipo2');

        $codequipo=$codequipo1;
        if($codequipo=='')
        {
            $codequipo=$codequipo2;
        }


        date_default_timezone_set('America/Lima');

        $partido=Partido::find($codpartido)->horaInicio;
        $hoyH = date("H:i:s");

        $dteStart = new DateTime($hoyH);
        $dteEnd   = new DateTime($partido);
        $dteDiff  = $dteEnd->diff($dteStart);
        $hora= (int)$dteDiff->format("%H");
        $min= (int)$dteDiff->format("%I");
        $h=(int)$hora;
        $h=$h*60;
        $min=$min+$h;



        $newtarjeta = new Gol;

        $newtarjeta->codjugPart = Input::get('jugador');
        $newtarjeta->minuto=$min;
        $newtarjeta->codPartido=$codpartido;
        $newtarjeta->save();



        $respuesta['mensaje'] = 'gol anotado por '.Equipo::find($codequipo)->nombre;
        return Redirect::back()->withInput()->withErrors($respuesta);
    }

    public function terminarJuego($codpartido, $Goles1,$Goles2){

        $fixture=Fixture::where('codPartido','=',$codpartido)->first();
        date_default_timezone_set('America/Lima');

        $hoyH = date("H:i:s");
        $par=Partido::find($codpartido);
        $par->termino="2";
        $resultado='-3';
        if($Goles1<$Goles2)
            $resultado='3';
        else
            if($Goles1==$Goles2)
                $resultado='0';
        $par->resultado=$resultado;
        $par->horaFin=$hoyH;
        $par->save();


        $respuesta['wilson']='se termino el encuetro entre '. Equipo::find($fixture->codEquipo1)->nombre." - ".Equipo::find($fixture->codEquipo2)->nombre;
        return Redirect::to('/partidosprogramados/'.$fixture->codRueda)->withInput()->withErrors($respuesta);
    }


}
