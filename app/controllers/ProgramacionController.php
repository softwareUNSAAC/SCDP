<?php

class ProgramacionController extends \BaseController
{

    /**
     * Created by PhpStorm.
     * User: user
     * Date: 15/02/2016
     * Time: 16:20
     */

    public function  programar($codfixture){

        $codtorneo=Fixture::find($codfixture)->codRueda;
        $codcampeonato=Torneo::find($codtorneo)->codCampeonato;
        $nrofecha=Fixture::find($codfixture)->nroFecha;
        $fecha=Fechas::where('codRueda','=',$codtorneo)->where('nroFecha','=',$nrofecha)->first();
        return View::make('user_com_organizing.programacion.pPartido')
            ->with('codcampeonato',$codcampeonato)
            ->with('codtorneo',$codtorneo)
            ->with('codfixture',$codfixture)->with('fecha',$fecha);
    }
    public  function post_programar($codfixture){

        $codtorneo=Input::get('codtorneo');
        $codEscenario=Input::get('escenario');

        $fixture=Fixture::find($codfixture);
        $equipo1=$fixture->codEquipo1;
        $nombre1=Equipo::find($equipo1)->nombre;
        $nombre1=substr($nombre1,0,3);
        $equipo2=$fixture->codEquipo2;
        $nombre2=Equipo::find($equipo2)->nombre;
        $nombre2=substr($nombre2,0,3);
        $nrofecha=$fixture->nroFecha;
        $horaincio=$fixture->hora;
        $hora=substr($horaincio,0,2);
        $min=substr($horaincio,3,2);
        $horaI=(int)$hora;
        $minI=(int)$min;

        $horaI=$horaI+1;
        $siguiente=$horaI.":".$minI;
        $fecha=DB::table('tfecha')
            ->where( 'nroFecha', '=', $nrofecha)->where('codRueda', '=', $codtorneo)
            ->first();
        $nro=DB::table('tprogramacion')
            ->count();
        $idfecha=$fecha->idFecha;
        $cop="PRO".$idfecha.($nro+1);



        $partido=new Partido;
        $cP="PA".$nombre1.$nombre2;
        $partido->codPartido=$cP;
        $partido->horaInicio=$horaincio;
        $partido->horaFin=$siguiente;
        $partido->tipoPartido="normal";
        $partido->save();


        $programacion= new Programacion();
        $programacion->codProgramacion=$cop;
        $programacion->idFecha=$idfecha;
        $programacion->codPartido=$cP;
        $programacion->diaPartido=$fecha->diaFecha;
        $programacion->nroPartido=$fixture->nroPartido;
        $programacion->codEscenario=$codEscenario;
        $programacion->horainicio=$horaincio;
        $programacion->razon="normal";
        $programacion->actual="1";
        $programacion->save();

        return Redirect::to('/fecha/edit/'.$codtorneo.'/'.$fixture->nroFecha);

    }
    public function  reprogramar($codfixture,$codprogramacion){

        $fecha1=Programacion::where('codProgramacion','=',$codprogramacion)->first();
        $fecha=$fecha1->idFecha;
        $partido=Partido::where('codPartido','=',$fecha1->codPartido)->first();
        return View::make('user_com_organizing.programacion.rPartido')
            ->with('codprogramacion',$codprogramacion)
            ->with('codfixture',$codfixture)
            ->with('partido',$partido)
            ->with('fecha',$fecha);
    }
    public  function post_reprogramar($codprogramacion){

        $codfecha=Input::get('fecha');
        $codfixture=Input::get('codfixture');
        $codpartido=Input::get('partido');
        $fixture=Fixture::find($codfixture);
        $fechaA=Input::get('Dia_partido');
        $actual=Programacion::find($codprogramacion);
        $actual->actual='0';

        date_default_timezone_set('America/Lima');
        $hoy = date("Y-m-d");;
        $flag=strcmp($fechaA,$hoy);
        $flag1=strcmp($fechaA,$actual->diaPartido);
        if($flag==-1 || $flag1==-1){
            $error = ['wilson' => 'fecha incorrecta  '.$fechaA.' '.$hoy,' '.$actual->diaPartido];


            return Redirect::back()->withInput()->withErrors($error);
        }
        $nroP=$actual->nroPartido;
        $actual->save();
        $nro=DB::table('tprogramacion')
            ->count();
        $cop="PRO".$codfecha.($nro+1);
        $horaincio=Input::get('nuevahora');
        $hora=substr($horaincio,0,2);
        $min=substr($horaincio,3,2);
        $horaI=(int)$hora;
        $minI=(int)$min;

        $horaI=$horaI+1;
        $siguiente=$horaI.":".$minI;


        $programacion= new Programacion();
        $programacion->codProgramacion=$cop;
        $programacion->idFecha=$codfecha;
        $programacion->diaPartido=Input::get('Dia_partido');
        $programacion->nroPartido=$nroP;
        $programacion->codEscenario=Input::get('escenario');
        $programacion->horainicio=Input::get('nuevaHora');
        $programacion->razon=Input::get('Razon');
        $programacion->actual="1";
        $programacion->comentario=Input::get('obser');
        $programacion->codPartido=$codpartido;
        $programacion->save();

        $partido=Partido::find($codpartido);
        $partido->horaInicio=Input::get('nuevaHora');
        $partido->horaFin=$siguiente;
        $partido->tipoPartido="reprogramado";

        $partido->save();
        return Redirect::to('/fecha/edit/'.$fixture->codRueda.'/'.$fixture->nroFecha);

    }




    public function  editpartido_get($codcampeonato,$codtorneo,$codfixture){

        return View::make('user_com_organizing.programacion.pPartido')
            ->with('codcampeonato',$codcampeonato)
            ->with('codtorneo',$codtorneo)
            ->with('codfixture',$codfixture)
            ;
    }

    public function  editpartido_post($codcampeonato,$codtorneo,$codfixture)
    {
        $codEscenario=Input::get('escenario');
        $fixture=Fixture::find($codfixture);
        $equipo1=$fixture->codEquipo1;
        $nombre1=Equipo::find($equipo1)->nombre;
        $nombre1=substr($nombre1,0,3);
        $equipo2=$fixture->codEquipo2;
        $nombre2=Equipo::find($equipo2)->nombre;
        $nombre2=substr($nombre2,0,3);
        $nrofecha=$fixture->nroFecha;
        $horaincio=$fixture->hora;
        $hora=substr($horaincio,0,2);
        $min=substr($horaincio,3,2);
        $horaI=(int)$hora;
        $minI=(int)$min;

        $horaI=$horaI+1;
        $siguiente=$horaI.":".$minI;
        $fecha=DB::table('tfecha')
            ->where( 'nroFecha', '=', $nrofecha)->where('codRueda', '=', $codtorneo)
            ->first();
        $nro=DB::table('tprogramacion')
            ->count();
        $idfecha=$fecha->idFecha;
        $cop="PRO".$idfecha.($nro+1);

        $programacion= new Programacion();
        $programacion->codProgramacion=$cop;
        $programacion->idFecha=$idfecha;
        $programacion->diaPartido=$fecha->diaFecha;
        $programacion->nroPartido=$fixture->nroPartido;
        $programacion->codEscenario=$codEscenario;
        $programacion->save();

        $partido=new Partido;
        $cP="PA".$nombre1.$nombre2;
        $partido->codPartido=$cP;
        $partido->codProgramacion=$cop;
        $partido->horaInicio=$horaincio;
        $partido->horaFin=$siguiente;
        $partido->tipoPartido="normal";
        $partido->save();
        return Redirect::to('/fecha/edit/'.$codcampeonato.'/'.$codtorneo.'/'.$fecha->nroFecha);


    }

}