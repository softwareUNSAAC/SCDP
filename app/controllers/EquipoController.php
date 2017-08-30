<?php

class EquipoController extends \BaseController {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
//PUBLIC indexPlantilla
    /*
    function autocompletedocente($id)
    {
        $term = Str::lower(Input::get('term'));
        $codigo=Session::get('user_codequipo');
        //convertimos los datos a un arreglo puro
        $todoasistente=DB::table('treunion')
            ->join('tasistente', 'treunion.codReunion', '=', 'tasistente.codReunion')
            ->join('tdelegando', 'tasistente.dni', '=', 'tdelegando.dni')
            ->join('tdocente', 'tdelegando.codDocente', '=', 'tdocente.codDocente')
            ->select('tdocente.codDocente', 'tdocente.nombre','tdocente.apellidoP','tdocente.apellidoM','tdelegando.rol')
            ->where( 'treunion.codreunion', '=', $id)
            ->get();

        $data = DB::table('tequipo')->join('tjugador', 'treunion.codReunion', '=', 'tasistente.codReunion')
            ->join('tdocente', 'treunion.codReunion', '=', 'tasistente.codReunion')
        ()select('codDocente', 'nombre', 'apellidoP', 'apellidoM')->get();
        $arregloDocente = [];
        foreach ($data as $docente) {
            $codigo = $docente->codDocente;
            $nombre = $docente->nombre;
            $ap = $docente->apellidoP;
            $am = $docente->apellidoM;
            $aux = [$codigo => $codigo . ' ' . $nombre . ' ' . $ap . ' ' . $am];
            $arregloDocente = array_merge($aux, $arregloDocente);
        }
        //filtramos
        $result = [];
        foreach ($arregloDocente as $valor) {
            if (strpos(Str::lower($valor), $term) !== false) {
                $result[] = ['value' => $valor];
            }
        }
        return Response::json($result);
    }
    */
    public function index()
    {
        $codequipo = Session::get('user_codequipo');
        $nrojugadores = Jugador::where('codEquipo','=',$codequipo)->count();
        $nrodelegados=Delegado::where('codEquipo','=',$codequipo)->count();
        $equipo = Equipo::where('codEquipo','=',$codequipo)->first();

        $codcampenato=$equipo->codCampeonato;

        $torneos=Torneo::where('codCampeonato','=',$codcampenato)->get();
        $codtorneo="";



        $fixture=Fixture::where('codEquipo1','=',$codequipo)->where('codEquipo1','=',$codequipo)->get();





        return View::make('user_equipo.index')
            ->with('equipo',$equipo)
            ->with('nrojugadores',$nrojugadores)
            ->with('nrodelegados',$nrodelegados);
    }

    //CAMISETA
    public function camisetaadd_get()
    {
        return View::make('user_equipo.camiseta');
    }

    public function camisetaadd_post()
    {
        $equipo = Equipo::where('codEquipo','=',Session::get('user_codequipo'))->first();
        if(Input::hasFile('uniforme'))//hay foto
        {
            $fullnamefile = $equipo->codEquipo.$equipo->nombre.$equipo->codCampeonato;
            $file = Input::file('uniforme');
            $extension = $file->getClientOriginalExtension();
            $namefotocomplete = $fullnamefile.'.'.$extension;
            $file->move('storage/equipo/camiseta', $namefotocomplete);
            Equipo::where('codEquipo','=',$equipo->codEquipo)->update(['coloresUniforme'=>$namefotocomplete]);

            Session::flash('message','Uniforme agregado correctamente');
            return Redirect::to('equipo/index.html');
        }
        else
        {
            $error = ['wilson'=>'Seleccione una foto'];
            return Redirect::back()->withInput()->withErrors($error);
        }
    }

    public function camisetadelete()
    {
        Equipo::where('codequipo','=',Session::get('user_codequipo'))->update(['coloresUniforme'=>'']);
        Session::flash('message','Uniforme Eliminado correctamente');
        return Redirect::to('equipo/index.html');
    }

    //LOGO
    public function logoadd_get()
    {
        return View::make('user_equipo.logo');
    }

    public function logoadd_post()
    {
        $equipo = Equipo::where('codEquipo','=',Session::get('user_codequipo'))->first();
        if(Input::hasFile('logo'))//hay foto
        {
            $fullnamefile = $equipo->codEquipo.$equipo->nombre.$equipo->codCampeonato;
            $file = Input::file('logo');
            $extension = $file->getClientOriginalExtension();
            $namefotocomplete = $fullnamefile.'.'.$extension;
            $file->move('storage/equipo', $namefotocomplete);
            Equipo::where('codEquipo','=',$equipo->codequipo)->update(['logo'=>$namefotocomplete]);

            Session::flash('message','Logo agregado correctamente');
            return Redirect::to('equipo/index.html');
        }
        else
        {
            $error = ['wilson'=>'Seleccione una foto'];
            return Redirect::back()->withInput()->withErrors($error);
        }
    }

    public function logodelete()
    {
        Equipo::where('codEquipo','=',Session::get('user_codequipo'))->update(['logo'=>'']);
        Session::flash('message','logo Eliminado correctamente');
        return Redirect::to('equipo/index.html');
    }




//falta modificar lo de abajo es  uqe mela sera



    public function addintegrante_post()
    {
        $input = Input::all();
        $regla = [  'Nombre'=>'required','Rol'=>'required'];
        $validacion = Validator::make($input,$regla);
        if($validacion->fails())
        {
            return Redirect::back()->withErrors($validacion);
        }
        else {
            //verificamos que el docente exista
            $iddocente = substr(Input::get('Nombre'), 0, 5);
            if ($docente = Docente::where('coddocente', '=', $iddocente)->first())
            {
                //verificamos de que las funcines no se repitan
                $rol = Input::get('Rol');
                $idcom_orgdor = Session::get('user_idcom_orgdor');
                if ($data = IntegrantesCO::where('idcom_orgdor', '=', $idcom_orgdor)->where('rol','=',$rol)->first())
                {
                    $error = ['wilson' => 'El '.$rol.' es '.$data->DataDocente[0]->nombre.' '.$data->DataDocente[0]
                            ->apellidopaterno.' '.$data->DataDocente[0]->apellidomaterno.' nose aceptan dos '.$rol.'s'];
                    return Redirect::back()->withInput()->withErrors($error);
                }
                else
                {
                    if ($data = IntegrantesCO::where('idcom_orgdor', '=', $idcom_orgdor)->where('coddocente','=',$iddocente)->first())
                    {
                        $error = ['wilson' => 'El docente que ingreso ya es '.$rol.' por favor ingrese otro docente'];
                        return Redirect::back()->withInput()->withErrors($error);
                    }
                    else
                    {
                        $newIntegrante = new IntegrantesCO();
                        $newIntegrante->rol = Input::get('Rol');
                        $newIntegrante->idcom_orgdor = $idcom_orgdor;
                        $newIntegrante->coddocente = $iddocente;
                        $newIntegrante->save();
                        $success = ['wilson' => 'Integrante Agregado Satisfactoriamente'];
                        return Redirect::to('comision/integrantes/list.html')->withErrors($success);
                    }
                }
            }
            else
            {
                $error = ['wilson' => 'Este docente no existe en la base de datos'];
                return Redirect::back()->withInput()->withErrors($error);
            }
        }
    }
    public function listintegrante()
    {
        $integrantesall = IntegrantesCO::where('idcom_orgdor','=',Session::get('user_idcom_orgdor'))->get();
        return View::make('user_com_organizing.integrante.list')->with('integrantesall',$integrantesall);
    }
    public function deleteintegrante($id)
    {
        IntegrantesCO::find($id)->delete();
        $success = ['wilson' => 'Integrante se elimino Satisfactoriamente'];
        return Redirect::to('comision/integrantes/list.html')->withErrors($success);
    }

    public function agregarplantilla_get($codplantilla)
    {
        $codequipo = Session::get('user_codequipo');
        $todosJugadores=Jugador::where('codEquipo','=',$codequipo)->get();
        return View::make('user_equipo.plantilla.insert')->with('codequipo',$codequipo)
            ->with('todosJugadores',$todosJugadores)
            ->with('codplantilla',$codplantilla);

    }

        public function listPartido(){


            $codequipo = Session::get('user_codequipo');
            date_default_timezone_set('America/Lima');
            $hoy = date("Y-m-d");
            $nro=DB::table('tpartido')
                ->join('tfixture', 'tfixture.codPartido', '=', 'tpartido.codPartido')
                ->select('tpartido.codPartido as p','tpartido.termino as t','tfixture.codEquipo1 as e1','tfixture.codEquipo2 as e2')
                ->where( 'tpartido.termino', '=', '2')
                ->get();

            $i=0;
            foreach ($nro as $f)    {
                if($f->e1==$codequipo || $f->e2==$codequipo)
                    $i++;
            }

            $nroPartidos=$i;
            $partidoProgramado=DB::table('tpartido')
                ->join('tprogramacion', 'tpartido.codPartido', '=', 'tprogramacion.codPartido')
                ->join('tfixture', 'tfixture.codPartido', '=', 'tpartido.codPartido')
                ->select('tprogramacion.codProgramacion as codProgramacion', 'tpartido.codPartido as codpartido','tfixture.codFixture as codfixture','tpartido.termino')
                ->where( 'tprogramacion.diaPartido', '>', $hoy)
                ->where( 'tprogramacion.actual', '=', '1')
                ->where( 'tfixture.codEquipo1', '=', $codequipo)
                ->orwhere( 'tfixture.codEquipo2', '=',$codequipo)
                ->where( 'tpartido.termino', '<>', '2')
                ->orderBy('tprogramacion.diaPartido','asc')->first();

            return View::make('user_equipo.partido.list')
                ->with('partidoProgramado', $partidoProgramado)
                ->with('nroPartidos', $nroPartidos)
                ->with('codequipo', $codequipo);

        }

        public  function  confirmar($codpartido){

            $codequipo = Session::get('user_codequipo');
            $fixture=Fixture::where('codPartido','=',$codpartido)->first();
            $jugadores =DB::table('tjugador')
                ->join('tdocente', 'tjugador.codDocente', '=', 'tdocente.codDocente')
                ->select('tdocente.codDocente as codDocente','tdocente.nombre as nombre', 'tdocente.apellidoP as apellidoP ','tdocente.apellidoM as apellidoM','tjugador.dni as dni')
                ->where( 'tjugador.codEquipo', '=', $codequipo)->get();
            $codcampeonato=Torneo::find($fixture->codRueda)->codCampeonato;
            return View::make('user_equipo.partido.confirmar')
                ->with('codpartido',$codpartido)
                ->with('jugadores',$jugadores)
                ->with('codequipo',$codequipo)
                ->with('fixture',$fixture)
                ->with('codcampeonato',$codcampeonato);
        }
        public function post_confirmar($dni){
            $codequipo = Session::get('user_codequipo');
                    $ediJ=Jugador::find($dni);
                    $seleccionado="";
                    if('habilitado'==Input::get('habilitado'))
                    {
                        $seleccionado="1";

                    }
                    else
                    {
                        $seleccionado="0";
                    }
                    if('desabilitado'==Input::get('desabilitado'))
                    {
                        $seleccionado="0";
                    }

                    $ediJ->seleccionado=$seleccionado;
                    $ediJ->save();


                    return Redirect::back();
                }

         public function todo(){

             $codequipo = Session::get('user_codequipo');

             $todo=Jugador::where('codEquipo','=',$codequipo)->get();

             foreach ($todo as $value){
                 $value->seleccionado='1';
                 $value->save();

             }
             return Redirect::back();

         }
        public function terminar($codpartido){

            $codequipo = Session::get('user_codequipo');


            $nro1=Planilla::where('codPartido','=',$codpartido)->count();
            $nro2=Planilla::count();

            $equipo=Fixture::where('codPartido','=',$codpartido)->first();
            $nroplantilla=2;
            if($equipo->codEquipo1==$codequipo)
                $nroplantilla=1;

            $newplantilla= new Planilla;


            $newplantilla->codPantilla="Pl".$nro1.$nro2;

            $newplantilla->nroPlantilla=$nroplantilla;
            $newplantilla->codPartido=$codpartido;
            $newplantilla->save();


            return Redirect::to('partido/list.html');

        }




        }






