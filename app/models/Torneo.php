<?php
class Torneo extends Eloquent {

    protected $table = 'trueda';
    public $timestamps= false;
    protected $primaryKey='codRueda';

    public static function crearinicio($input)
    {


        $codCampeonato=Input::get('codcampeonato');
        $torneos=torneo::where('codCampeonato','=',$codCampeonato)->count();
        $flag=0;
        if($torneos!=0)
            $torneosAll=torneo::where('codCampeonato','=',$codCampeonato)->get();
        $respuesta = [];


        if($torneos==0) {


            $reglas =
                [
                    'ruedas' => array('required'),

                ];
            $validador = Validator::make($input, $reglas);
            if ($validador->fails()) {
                $respuesta['mensaje'] = $validador;
                $respuesta['error'] = true;
            } else {

                //crear el nnumero de reuedad
                $nro = Input::get('ruedas');

                $users = Comision::where('codCom_Org', '=', Session::get('user_idcom_orgdor'))->first();

                $user = substr($users->codCom_Org, 3, 7);
                $tmp = substr($user, 0, 1);

                while ($tmp == "0") {

                    $user = substr($user, 1, strlen($user) - 1);
                    $tmp = substr($user, 0, 1);
                }

                $numero = (int)$user;
                $cadena = "TOR" . $numero;

                $varlor = strcmp(Input::get('fechaI'), Input::get('fechaF'));

                if ($varlor == -1) {


                    for ($i = 0; $i < $nro; $i++) {
                        $codrueda = $cadena.$i;
                        $newtorneo = new Torneo();
                        $newtorneo->codRueda = $codrueda;
                        $newtorneo->codCampeonato = $codCampeonato;
                        $newtorneo->nombre="falta";
                        $newtorneo->fechaCreacion="2017-12-15";
                        $newtorneo->save();
                    }

                    $cadena = "COF" . $numero;
                    $NRO = Configuracion::where('codCampeonato', '=', $codCampeonato)->count();
                    $NRO++;
                    $configuracion1 = new Configuracion;
                    $configuracion1->idConfiguracion = $cadena . $NRO;
                    $NRO++;
                    $configuracion1->descripcion = "fecha inicio de inscripciones";
                    $configuracion1->variable = "finscripI";
                    $configuracion1->valor = Input::get('fechaI');
                    $configuracion1->codCampeonato = $codCampeonato;
                    $configuracion1->save();

                    $configuracion2 = new Configuracion;
                    $configuracion2->idConfiguracion = $cadena . $NRO;
                    $configuracion2->descripcion = "fecha final de inscripciones";
                    $configuracion2->variable = "finscripF";
                    $configuracion2->valor = Input::get('fechaF');
                    $configuracion2->codCampeonato = $codCampeonato;
                    $configuracion2->save();


                    $respuesta['mensaje'] = 'Datos guardados correctamente';
                    $respuesta['error'] = false;


                }
                else{
                    $respuesta['mensaje'] = 'error fechas de inscripcion ';
                    $respuesta['error'] = true;

                }


            }

        }

        else{
            $reglas =
                [
                    'nombre0' => array('required'),
                    'fecha0' => array('required'),
                    'nombre1' => array('required'),
                    'fecha1' => array('required'),

                ];
            $validador = Validator::make($input, $reglas);
            if ($validador->fails()) {
                $respuesta['mensaje'] = $validador;
                $respuesta['error'] = true;
            } else {

                //crear el nnumero de reuedad
                $torneos=torneo::where('codCampeonato','=',$codCampeonato)->count();
                $fechafinal=Configuracion::where('variable','=','finscripF')->first();
                $FI=$fechafinal->valor;
                $flag=0;
                $j=0;
                for ($i=0;$i<$torneos;$i++){
                    $rueda='codrueda'.$j;
                    $torneoActual=Torneo::find(Input::get($rueda));
                    $nombre='nombre'.$j;
                    $torneoActual->nombre=Input::get($nombre);
                    $fecha='fecha'.$j;
                    $varlor = strcmp(Input::get($fecha), $FI);
                    if($varlor == -1)
                    {
                        $flag = -1;
                        $i=50;
                        continue;
                    }
                    $torneoActual->fechaCreacion=Input::get($fecha);
                    $torneoActual->save();
                    $j++;
                }



                if ($flag == -1) {

                    $respuesta['mensaje'] = 'fechas de inicio de rueda es menor que fecha de inscripcion';
                    $respuesta['error'] = true;


                }
                else{
                    $respuesta['mensaje'] = 'asignacion de nombre y fecha de inicio correctos ';
                    $respuesta['error'] = false;

                }


            }
        }


        return $respuesta;
    }
    public static function crear($input)
    {


        $codCampeonato=Input::get('codcampeonato');
        $torneos=torneo::where('codCampeonato','=',$codCampeonato)->count();
        $flag=0;
        if($torneos!=0)
            $torneosAll=torneo::where('codCampeonato','=',$codCampeonato)-get();
        $respuesta = [];


        if($torneos==0){


            $reglas =
                [
                    'ruedas'=>array('required'),

                ];
            $validador = Validator::make($input,$reglas);
            if($validador->fails()){
                $respuesta['mensaje'] = $validador;
                $respuesta['error'] = true;
            }
            else
            {
                $torneo = Torneo::where('nombre','=',Input::get('tipo'))->where('codCampeonato','=',Input::get('codcampeonato'))->first();
                if($torneo == '')
                {
                    //recuperamos la fecha ingresada y lo acomodamos para ingresar a la base de datos
                    $fecha = Input::get('diainicio');
                    $mes = substr($fecha,0,2);
                    $dia = substr($fecha,3,2);
                    $año = substr($fecha,6,4);
                    $fecha = $año.'-'.$mes.'-'.$dia;
                    //se crea un torneo
                    $codCampeonato=Input::get('codcampeonato');
                    $users = DB::table('trueda')->count();
                    $users++;
                    $users1=(int)substr($codCampeonato,3,strlen($codCampeonato));
                    $codconclusion="TORO".$users1.$users;
                    $input = Input::all();
                    $newtorneo = new Torneo();
                    $newtorneo->codRueda=$codconclusion;
                    $newtorneo->nombre = Input::get('tipo');
                    $newtorneo->fechaCreacion= $fecha;
                    $newtorneo->codCampeonato = $codCampeonato;
                    $newtorneo->save();

                    $respuesta['mensaje'] = 'Datos guardados correctamente';
                    $respuesta['error'] = false;
                }
                else
                {
                    $respuesta['mensaje'] = 'Este torneo ya existe';
                    $respuesta['error'] = true;
                }
            }


        }



        return $respuesta;
    }
}