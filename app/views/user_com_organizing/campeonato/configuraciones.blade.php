@extends('_templates.apptemp')

@section('titulo')
    @lang('Varapp.nombre_sistema_mediano')
@stop
@section('estilos')
    <link href="{{asset('/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" media="screen">

@stop
@section('rutanavegacion')
    <li><a href="{{ URL::to('/campeonato/listar');}}"><span class="glyphicon glyphicon-book"></span></a></li>
    <li><a href="{{ URL::to('/campeonato/detail/'.$campeonato->codCampeonato);}}">Detalle de Campeonato</a></li>
    <li>Nueva configuracion</li>
@stop

@section('nombrevista')
    @lang('Nueva Configuracion')
    <button type="submit" class="btn btn-success pull-right" onclick="history.back()">Atras</button>
@stop
<?php

$torneos=torneo::where('codCampeonato','=',$campeonato->codCampeonato)->count();
$flag=0;
if($torneos!=0){
    $torneosAll=torneo::where('codCampeonato','=',$campeonato->codCampeonato)->get();
    $T=torneo::where('codCampeonato','=',$campeonato->codCampeonato)->first();
}
if($T->nombre!="falta"){
    $flag=-1;
}
$i=0;
$j=0;

$fI=Configuracion::where('variable','=','finscripI')->first();

$fF=Configuracion::where('variable','=','finscripF')->first();
?>
@section('contenido')

    <!-- BEGIN PARA MANEJO DE ERRORES -->
    @include('alerts.allerrors')
    @include('alerts.errors')
    <!-- END PARA MANEJO DE ERRORES -->

    <div class="row">
        <div class="panel panel-default">
            <div class="panel-heading">configuracion Inicial del campeonato</div>
            <div class="panel-body">
                <div class="col-md-12">
                    @if($flag==0)
                        {{ Form::open(array('route'=>'torneo.store','method'=>'POST','autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}
                        <div class="row">
                            <!-- torneo-->

                            @if($torneos==0)
                                <div class="col-md-6">

                                <div class="panel-default">
                                    <div class="panel-heading">
                                        <h3> torneo:</h3>
                                    </div>
                                    <div class="panel-body">
                                        {{Form::hidden('codcampeonato',$campeonato->codCampeonato)}}
                                        <div class="form-group">
                                            <label> nro ruedas</label>
                                            <input  type="number" class="form-control" placeholder="nro ruedas" name="ruedas" min="2" required>
                                        </div>
                                        <label> fechas para inscripcion <br></label>
                                        <div class="form-group">
                                            <input type="date" class="form-control datepicker" name="fechaI" placeholder="fecha de inicio de inscripcion">
                                            <span class="help-block">{{ $errors->first('fecha') }}</span>
                                        </div>

                                        <div class="form-group">
                                            <input type="date" class="form-control datepicker" name="fechaF" placeholder="fecha final de inscripcion">
                                            <span class="help-block">{{ $errors->first('fecha') }}</span>
                                        </div>
                                    </div>

                                </div>

                                </div>
                            @else
                            <!-- end torne0-->



                                <div class="col-md-6">
                        <!--  ruedas-->
                                <div class="panel-default">
                                    <div class="panel-heading">
                                        <h3>torneos :</h3>
                                    </div>
                                    <div class="panel-body">
                                        {{Form::hidden('codcampeonato',$campeonato->codCampeonato)}}
                                        @foreach($torneosAll as $rueda)
                                        <label> tentativa de fecha de inicio <br></label>
                                            {{Form::hidden('codrueda'.$i,$rueda->codRueda)}}
                                        <div class="form-group">
                                            <input type="text" class="form-control" name="{{'nombre'.$i++}}" placeholder="{{'nombre de   rueda'.$i}}">

                                            <span class="help-block">{{ $errors->first('nombre'.$i) }}</span>

                                        </div>

                                        <div class="form-group">
                                            <input type="date" class="form-control datepicker" name="{{'fecha'.$j++}}" placeholder="{{'fecha inicio de rueda'.$j}}">

                                            <span class="help-block">{{ $errors->first('fecha'.$j) }}</span>
                                        </div>
                                        @endforeach
                                    </div>
                                </div>
                        <!--  endruedas-->
                            </div>


                                <div class="col-md-6">

                                    <div class="panel-info">
                                        <div class="panel-heading">
                                            <h3> INSCRIPCIONES</h3>
                                        </div>
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label class="form-inline"> desde</label>
                                                <label class="form-inline"> {{$fI->valor}}</label>
                                                <label class="form-inline"> a </label>
                                                <label class="form-inline"> {{$fF->valor}}</label>
                                            </div>

                                        </div>

                                    </div>

                                </div>

                            @endif
                        </div>

                        <button type="submit" class="btn btn-primary">Guardar</button>

                        {{ Form::close() }}
                        <div class="pull-right">

                        </div>
                        <br>
                    @endif

                    {{ Form::open(array('method' => 'POST','url'=>'campeonato/'.$campeonato->codCampeonato.'/configuracion/add.html','autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}


                    <div class="row">
                    <!-- participantes-->
                        <div class="col-md-6">
                            <div class="panel-default">
                                <div class="panel-heading">
                                    <h3>participantes :</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        {{ Form::label('maximo nro de equipos')}}
                                        <input type="number" name="maximo" min="1" class="form-control" required>
                                        <span class="help-block">{{ $errors->first('fecha') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('maximo de jugadores libres')}}
                                        <input type="number" name="maximoL" min="1" class="form-control">
                                        <span class="help-block">{{ $errors->first('fecha') }}</span>
                                    </div>
                                </div>
                            </div>

                    <!-- endparticipantes-->
                        </div>
                        <div class="col-md-6">
                    <!--partido -->
                        <div class="panel-default">
                            <div class="panel-heading">
                                <h3>partido :</h3>
                            </div>
                            <div class="panel-body">
                                <div class="form-group">
                                    {{ Form::label('duracion de tiempos')}}
                                    <input type="number" name="duracion" min="30" class="form-control">

                                    <span class="help-block">{{ $errors->first('fecha') }}</span>
                                </div>
                                <div class="form-group">
                                    {{ Form::label('tiempo de descanso')}}
                                    <input type="number" name="descanso" min="5" class="form-control">

                                    <span class="help-block">{{ $errors->first('fecha') }}</span>
                                </div>
                                <div class="form-group ">
                                    {{ Form::label('maximo de jugadores menores de ')}}
                                    <input type="number" name="anio" min="35" class="form-control">
                                    {{ Form::label('años')}}
                                    {{ Form::text('maximoM','',array('class' => 'form-control ')) }}
                                    <span class="help-block">{{ $errors->first('fecha') }}</span>
                                </div>

                            </div>

                        </div>
                    <!--endpartido -->
                        </div>
                   </div>

                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="reset" class="btn btn-default">Limpiar</button>
                    <button type="submit" class="btn btn-danger" onclick="history.back()">Cancelar</button>
                    {{ Form::close() }}
                    <div class="pull-right">

                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scrips')
   <script src="{{asset('/js/bootstrap-datetimepicker.es')}}"></script>
<script>
    $('.datepicker').datepicker({
        format: "yyyy-mm-dd",
        language: "es",
        autoclose: true
    });
</script>

@stop

