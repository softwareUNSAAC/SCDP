<?php

class ComisionOrganizadorController extends \BaseController {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        $idcomision = Session::get('user_idcom_orgdor');
        $nrointegrantess = IntegrantesCO::where('codCom_Org','=',$idcomision)->count();
        $campeonato = Campeonato::where('codCom_Org','=',$idcomision)->first();

        return View::make('user_com_organizing.index')->with('nrointegrantess',$nrointegrantess)->with('campeonato',$campeonato);
	}
    public function addintegrante_get()
    {
        return View::make('user_com_organizing.integrante.add');
    }


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
                        $success = ['wilson' => 'Integrante Agregado Satisfactoriamente'];
                        return Redirect::to('comision/integrantes/list.html')->withErrors($success);
                    }
                }
            }


    }
    public function listintegrante()
    {
        $integrantesall = IntegrantesCO::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->get();
        return View::make('user_com_organizing.integrante.list')->with('integrantesall',$integrantesall);
    }
    public function deleteintegrante($id)
    {
        IntegrantesCO::find($id)->delete();
        $success = ['wilson' => 'Integrante se elimino Satisfactoriamente'];
        return Redirect::to('campeonato/insertar')->withErrors($success);
    }
}
