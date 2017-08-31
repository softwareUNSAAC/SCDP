<?php

class AutocompletadoController extends \BaseController
{


    //=============================PARA EL ADMINISTRADOR==================================
    //funcion para que se autoconplete los datos de los docentes
    function autocompletedocente()
    {
        $term = Str::lower(Input::get('term'));
        //convertimos los datos a un arreglo puro
        $data = DB::table('tdocente')->select('codDocente', 'nombre', 'apellidoP', 'apellidoM')->get();
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

    function autocompletedelegado()
    {

        $campeonato=Campeonato::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->get();
        $campeonato1=null;
        foreach ($campeonato as $value )
        {
            $campeonato1=$value;
        }
        $codcampeonato=$campeonato1->codCampeonato;


        $term = Str::lower(Input::get('term'));
        //convertimos los datos a un arreglo puro
        $data=DB::table('tdelegando')
            ->join('tdocente', 'tdelegando.codDocente', '=', 'tdocente.codDocente')
            ->join('tequipo', 'tdelegando.codEquipo', '=', 'tequipo.codEquipo')
            ->select('tdelegando.dni', 'tdocente.nombre','tdocente.apellidoP','tdocente.apellidoM')
            ->where('tequipo.codCampeonato','=', $codcampeonato)
            ->get();


        //$data = DB::table('tarbitro')->joinselect('dni', 'nombre', 'Apellidos')->get();
        $arregloDocente = [];
        foreach ($data as $docente) {
            $codigo = $docente->dni;
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

    function autocompleteescenario($id,$id2)
    {
        $term = Str::lower(Input::get('term'));
        //convertimos los datos a un arreglo puro
        $data = DB::table('tescenario')->select('codEscenario', 'nombre', 'lugar')->get();
        $arregloDocente = [];
        foreach ($data as $docente) {
            $codigo = $docente->codEscenario;
            $nombre = $docente->nombre;
            $ap = $docente->lugar;
            $aux = [$codigo => $codigo . ' ' . $nombre . ' ' . $ap];
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

    function autocompletedocente1()
    {
        $term = Str::lower(Input::get('term'));
        //convertimos los datos a un arreglo puro

        $codequipo = Session::get('user_codequipo');

        $delega=Delegado::where('codEquipo','=',$codequipo);
        $coddocente=$delega->codDocente;
        $departamento=Docente::find($coddocente)->codDptoAcademico;

        $data = DB::table('tdocente')->select('codDocente', 'nombre', 'apellidoP', 'apellidoM')->where('codDptoAcademico','=',$departamento)->get();
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


}