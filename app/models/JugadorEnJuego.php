<?php

class JugadorEnJuego extends Eloquent
{
    protected $table = 'tjugadorjuego';
    protected $primaryKey = 'codjugPart';
	public $timestamps = false;
	protected $fillable = ['nrocamiseta','condicionenpartido','escapitan','dni','codPantilla'];
	


    public static function isertar($input)
    {
        $respuesta = [];
        $reglas = [
            'jugador'=>array('required'),
            'camiseta'=>array('required'),
            'escapitan'=>array('required'),
            'condicion'=>array('required')];
        $validador = Validator::make($input,$reglas);
        if($validador->fails())
        {
            $respuesta['mensaje'] = $validador;
            $respuesta['error'] = true;
        }
        else
        {
            $nro=JugadorEnJuego::count();
            $nro++;
            $newjugadorenjuego = new JugadorEnJuego();
            $newjugadorenjuego ->nrocamiseta = Input::get('camiseta');
            $newjugadorenjuego ->condicionenpartido = Input::get('condicion');
            $newjugadorenjuego ->escapitan = Input::get('escapitan');
            $newjugadorenjuego ->dni = Input::get('jugador');
            $newjugadorenjuego ->codPantilla  = Input::get('codplantilla');
            $newjugadorenjuego->codjugPart='JP'.substr(Input::get('jugador'),0,2).$nro;
            $newjugadorenjuego ->save();


            $jugador=Jugador::find(Input::get('jugador'));
            $jugador->seleccionado='2';
            $jugador->save();
            $respuesta['mensaje'] = 'Jugador agregado correctamente para este partido';
            $respuesta['error'] = false;
        }
        return $respuesta;
    }

}
