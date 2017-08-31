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


<
@stop