<?php

class MiembroComJusticiaController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */

    public function comis(){
        $users = Comision::where('codCom_Org', '=', Session::get('user_idcom_orgdor'))->first();

        $user = substr($users->codCom_Org, 3, 7);
        $tmp = substr($user, 0, 1);

        while ($tmp == "0") {

            $user = substr($user, 1, strlen($user) - 1);
            $tmp = substr($user, 0, 1);
        }

        $numero = (int)$user;
        return $numero;
    }
	public function index($codcampeonato)
	{
		$todomiembros = MiembroComJusticia::where('codCampeonato',$codcampeonato)->paginate(3);

        return View::make('user_administrator.miembrocomjusticia.listar')->with('todomiembros',$todomiembros)
            ->with('codcampeonato',$codcampeonato);
	}


	/**
	 * Show the form for creating a new resource.
	 *
	 * @return Response
	 */
 /*public function create()
	{
		//$todocampeonato = Campeonato::all();
        return View::make('campeonato.insertar');
	}*/

	public function insertarmiembro($codcampeonato)
	{
        return View::make('user_administrator.miembrocomjusticia.insertar')->with('codcampeonato',$codcampeonato);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @return Response
	 */
	public function store($codcampeonato)
	{
        //verificamos que el docente exista
        $iddocente =Input::get('docente');
        if(!$docente = MiembroComJusticia::where('dni', '=', $iddocente)->first())
        {

            $miembro = new MiembroComJusticia;
            $miembro->dni=$iddocente;
            $miembro->rol = Input::get('rol');
            $miembro->nombre=Input::get('nombre');
            $miembro->apellidoP=Input::get('apellidopaterno');
            $miembro->apellidoM=Input::get('apellidomaterno');
            $miembro->codCampeonato = $codcampeonato;
            $miembro->save();
            return Redirect::to('campeonato/'.$codcampeonato.'/miembro.html');
        }
        else
        {
            $error = ['wilson'=>'Este miembro ya tiene cargo '];
            return Redirect::back()->withInput()->withErrors($error);
        }
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
	public function editarmiembro($codcampeonato,$id)
	{
        $consultatabla = MiembroComJusticia::find($id);
		return View::make('user_administrator.miembrocomjusticia.editar')
            ->with('consultatabla',$consultatabla)
            ->with('codcampeonato',$codcampeonato);
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function update($id0,$id)
	{

        //verificamos que el docente exista
        $iddocente = Input::get('docente');

            $datosformulario = Input::all();
            DB::table('tmiembrojusticia')
                ->where('dni', $id)
                ->update(array(
                    'rol' => $datosformulario['rol'],
                    'nombre' => $datosformulario['nombre'],
                    'apellidoP' => $datosformulario['apellidopaterno'],
                    'apellidoM' => $datosformulario['apellidomaterno'],
                    ));
        return Redirect::to('campeonato/'.$id0.'/miembro.html');


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
	public function delete($id0,$id)
	{
        DB::table('tmiembrojusticia')
            ->where('dni', $id)
            ->delete();
        return Redirect::to('campeonato/'.$id0.'/miembro.html');
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

}
