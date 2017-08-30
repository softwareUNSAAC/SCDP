<?php
class MovimientoController extends BaseController
{
	public function index()
	{
		$movimientos = Movimiento::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->paginate(10);
		$ingesototal = Movimiento::where('tipo','=','ingreso')->sum('montototal');
		$egresototal = Movimiento::where('tipo','=','egreso')->sum('montototal');
        $saldototal = $ingesototal - $egresototal;
		return View::make('user_com_organizing.movimiento.index')
            ->with('movimientos',$movimientos)
            ->with('saldototal',$saldototal);
	}

	public function createI()
	{
        $cod=Session::get('user_idcom_orgdor');
        $campeonato=Campeonato::where('codCom_Org','=',$cod)->get();
        $cam=null;
        foreach ($campeonato as $value)
        {
            $cam=$value;
        }

        $todoEquipos=Equipo::where('codCampeonato','=',$cam->codCampeonato)->get();
		return View::make('user_com_organizing.movimiento.ingresos.agregar')->with('todoEquipos',$todoEquipos);
		
	}
	public function createE()
	{
        $cod=Session::get('user_idcom_orgdor');
        $campeonato=Campeonato::where('codCom_Org','=',$cod)->get();
        $cam=null;
        foreach ($campeonato as $value)
        {
            $cam=$value;
        }

		$todoEquipos=Equipo::where('codCampeonato','=',$cam->codCampeonato)->get();
		$movimientos = Movimiento::where('codCom_Org','=',$cod)->get();
		return View::make('user_com_organizing.movimiento.egresos.agregar')->with('todoEquipos',$todoEquipos);
	}
	public function storeI()
	{
        date_default_timezone_set("America/Lima");
        $tiempo = getdate();
        $timefull = date('Y-m-d').' '.$tiempo['hours'].':'.$tiempo['minutes'].':'.$tiempo['seconds'];
        $nro=Movimiento::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->count();
        $idmovimiento = DB::table('tmovimiento')->insertGetId([

                            'codMovimiento'=>'MOV'.($nro+1),
							'montoTotal' => Input::get('montototal'),
                            'descripcion' => Input::get('descripcion'),
							'fecha' => $timefull,
                            'codCom_Org'=>Session::get('user_idcom_orgdor')
							]);
		$newingreso = new Ingreso;
		$nro1=Ingreso::count();
		$newingreso -> codEquipo = Input::get('codequipo');
        $newingreso -> codIngreso = 'IN'.($nro1+1);

		$newingreso -> codMovimiento ='MOV'.($nro+1);
		$newingreso -> save();

        $equipo = Equipo::where('codEquipo','=',Input::get('codequipo'))->first();
        $idusuario = $equipo->idUsuario;
        User::where('idUsuario','=',$idusuario)
            ->update(['estado'=>'activo']);
		return Redirect::to('movimientos');
	}
	public function storeE()
	{
        date_default_timezone_set("America/Lima");
        $tiempo = getdate();
        $timefull = date('Y-m-d').' '.$tiempo['hours'].':'.$tiempo['minutes'].':'.$tiempo['seconds'];
        $nro=Movimiento::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->count();
		$idmovimiento = DB::table('tmovimiento')->insertGetId([
                            'codMovimiento'=>'MOV'.($nro+1),
		                    'tipo'=>"Egreso",
							'montoTotal' => Input::get('montototal'),
							'descripcion' => Input::get('descripcion'),
                            'fecha' => $timefull,
                            'codCom_Org'=>Session::get('user_idcom_orgdor')
							]);
        $nro1=Ingreso::count();
		$newingreso = new Egreso;
        $newingreso -> codEgreso = 'EG'.($nro1+1);
        $newingreso -> codMovimiento ='MOV'.($nro+1);
		$newingreso -> save();
		return Redirect::to('movimientos');
	}
     public function editarIngreso($id)
      {
           $todoEquipos=Equipo::all();
            $consultatabla = Ingreso::where('nromovimiento', '=', $id)->get();
            return View::make('movimiento.ingresos.editar',
            	['consultatabla'=>$consultatabla,'todoEquipos'=>$todoEquipos]);

    }
	public function update($id)
	{
		if($id<1)
        {
            //error 404
        } 
        else
        {
            $recuperado = Input::all();
            //print_r($recuperado) ;
            $consultatabla = DB::table('tingreso')
                ->where('nromovimiento',$id)
                ->update(array(
                    'nromovimiento'=> $id,
                    'idingreso'=> $recuperado['idingreso'],
                    'codequipo'=> $recuperado['codequipo'],)
                );
            return Redirect::to('movimientos');  
        }   
	}

	public function destroy($nromovimiento)
	{
        $movimiento = Movimiento::where('codMovimiento','=',$nromovimiento)->first();
        if($movimiento->tipo = 'ingreso')
        {
            Ingreso::where('codMovimiento','=',$nromovimiento)->delete();
        }
        if($movimiento->tipo = 'egreso')
        {
            Egreso::where('codMovimiento','=',$nromovimiento)->delete();
        }
        Movimiento::where('codMovimiento','=',$nromovimiento)->delete();
        return Redirect::to('movimientos');
        //Egreso::where('nromovimiento','=',$nromovimiento)->delete();
        //echo Egreso::where('nromovimiento','=',$nromovimiento)->first();
	}

	
}