@extends('_templates.apptemp')

@section('titulo')
    @lang('Varapp.nombre_sistema_mediano')
@stop

@section('rutanavegacion')
@stop

@section('nombrevista')

    @if($campeonato)
        {{"<h2>Bienvenido ". $campeonato->nombre."</h2>" }}
    @else
    @lang('Bienvenido al Campeonato de Futbol Inter Docentes UNSAAC')
    @endif
@stop

@section('contenido')
     @if($campeonato)
       {{" <a href='campeonato/detail/".$campeonato->codCampeonato."'</a>"}}
       @endif

             {{HTML::image('bg/campeonato.png','imagen uniforme',['class'=>'img-responsive','title'=>'uniforme','style'=>'width: 1000px'])}}


<?php
     $JugadoresP1 = DB::table('tpartido')
     ->join('tplantilla','tpartido.codPartido','=','tplantilla.codPartido')
     ->join('tjugadorjuego','tplantilla.codPantilla','=','tjugadorjuego.codPantilla')
     ->join('tjugador','tjugadorjuego.dni','=','tjugador.dni')
     ->join('tequipo','tjugador.codEquipo','=','tequipo.codEquipo')
     ->where('tpartido.termino','=','2')
     ->get();

    $puntaje = DB::table('tpartido')
    ->join('tfixture','tpartido.codPartido','=','tfixture.codPartido')
    ->where('tpartido.termino','=','2')
    ->get();

     var_dump($puntaje);


    $puntaje = DB::table('tpartido')
    ->join('tfixture','tpartido.codPartido','=','tfixture.codPartido')
    ->where('tpartido.termino','=','2')
    ->get();


?>
@stop