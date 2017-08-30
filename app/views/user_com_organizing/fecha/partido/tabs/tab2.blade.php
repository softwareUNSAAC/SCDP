
<?php

$equipo2=Equipo::find($codequipo2);
$codplantilla=Planilla::where('codPartido','=',$codpartido)->where('nroPlantilla','=','2')->first()->codPantilla;
?>


<div class="row">
    <div class="row col-no-gutter-container">
        <div class="col-xs-6 col-md-2 col-no-gutter">
            <div class="panel panel-default">
                <div class="panel-body easypiechart-panel">
                    <div>
                        {{ HTML::image('storage/equipo/camiseta/'.$equipo2->logo,'Image Empty',['class'=>'img-responsive','title'=>'logo del equipo '.$equipo2->nombre,'style'=>'width:155px']) }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><br>
<div class="panel-heading">Planilla de jugadores
    <div class="panel-tools pull-right">
        <div class="form-inline">
            <div class="form-group">
                {{Form::open(array('method' => 'POST', 'url' => '/fechas/'.$codcampeonato.'/'.$torneo->idtorneo.'/'.$idfecha.'/'.$partido->codPartido.'/partido.html/planilla/'.$equipo2->codEquipo, 'role' => 'form'))}}

                <div class="form-group">
                    <p>{{Form::submit('PDF', array('class' => 'btn btn-primary'))}}</p>
                </div>

                {{Form::close()}}
            </div>
        </div>
    </div>
</div>
<div class="panel-body panel-footer">
    <div class="row">
        <div class="row col-no-gutter-container">
            @foreach($Delanteros2 as $jugadorenjuego)
                <div class="col-xs-6 col-md-2 col-no-gutter">
                    <div class="panel panel-danger">
                        <div class="panel-heading">
                            @if($jugadorenjuego->escapitan == 'si')
                                <span class="glyphicon glyphicon-bookmark" title="Capitan"><span class="text-lowercase"> capitán</span> Delantero</span>
                            @else
                                Delantero
                            @endif
                        </div>
                        <div class="panel-body easypiechart-panel">
                            {{ HTML::image('storage/jugador/'.$jugadorenjuego->foto,'Image Empty',['class'=>'img-responsive','title'=>'Foto del jugador','style'=>'width:150px']) }}
                            <h5>{{Docente::find(Jugador::find($jugadorenjuego->dni)->codDocente)->apellidoP}}({{$jugadorenjuego->nrocamiseta}})</h5>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div><br>

    <div class="row">
        <div class="row col-no-gutter-container">
            @foreach($Mediocampistas2 as $jugadorenjuego)
                <div class="col-xs-6 col-md-2 col-no-gutter">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            @if($jugadorenjuego->escapitan == 'si')
                                <span class="glyphicon glyphicon-bookmark" title="Capitan"><span class="text-lowercase"> capitán</span> Mediocpta</span>
                            @else
                                Mediocpta
                            @endif
                        </div>
                        <div class="panel-body easypiechart-panel">
                            {{ HTML::image('storage/jugador/'.$jugadorenjuego->foto,'Image Empty',['class'=>'img-responsive','title'=>'Foto del jugador','style'=>'width:150px']) }}
                            <h5>{{Docente::find(Jugador::find($jugadorenjuego->dni)->codDocente)->apellidoP}}({{$jugadorenjuego->nrocamiseta}})</h5>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div><br>

    <div class="row">
        <div class="row col-no-gutter-container">
            @foreach($Defensas2 as $jugadorenjuego)
                <div class="col-xs-6 col-md-2 col-no-gutter">
                    <div class="panel panel-warning">
                        <div class="panel-heading">
                            @if($jugadorenjuego->escapitan == 'si')
                                <span class="glyphicon glyphicon-bookmark" title="Capitan"><span class="text-lowercase"> capitán</span> Defensa</span>
                            @else
                                Defensa
                            @endif
                        </div>
                        <div class="panel-body easypiechart-panel">
                            {{ HTML::image('storage/jugador/'.$jugadorenjuego->foto,'Image Empty',['class'=>'img-responsive','title'=>'Foto del jugador','style'=>'width:150px']) }}
                            <h5>{{Docente::find(Jugador::find($jugadorenjuego->dni)->codDocente)->apellidoP}}({{$jugadorenjuego->nrocamiseta}})</h5>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div><br>

    <div class="row">
        <div class="row col-no-gutter-container">
            @foreach($Guardameta2 as $jugadorenjuego)
                <div class="col-xs-6 col-md-2 col-no-gutter">
                    <div class="panel panel-success">
                        <div class="panel-heading">
                            @if($jugadorenjuego->escapitan == 'si')
                                <span class="glyphicon glyphicon-bookmark" title="Capitan"><span class="text-lowercase"> capitán</span> Arquero</span>
                            @else
                                Arquero
                            @endif
                        </div>
                        <div class="panel-body easypiechart-panel">
                            {{ HTML::image('storage/jugador/'.$jugadorenjuego->foto,'Image Empty',['class'=>'img-responsive','title'=>'Foto del jugador','style'=>'width:150px']) }}
                            <h5>{{Docente::find(Jugador::find($jugadorenjuego->dni)->codDocente)->apellidoP}}({{$jugadorenjuego->nrocamiseta}})</h5>

                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div><br>
</div>



<div class="panel-body panel-footer">
    <div id="step-1 ">
        <div class="row">
            <div class="row col-no-gutter-container">
                @foreach($suplentes2 as $jugadorenjuego)
                    <div class="col-xs-6 col-md-2 col-no-gutter">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                @if($jugadorenjuego->escapitan == 'si')
                                    <span class="glyphicon glyphicon-bookmark" title="Capitan"><span class="text-lowercase"> capitán</span> Suplente</span>
                                @else
                                    Suplente
                                @endif
                            </div>
                            <div class="panel-body easypiechart-panel">
                                <div >
                                    {{ HTML::image('storage/jugador/'.$jugadorenjuego->foto,'Image Empty',['class'=>'img-responsive','title'=>'Foto del jugador','style'=>'width:150px']) }}
                                    <h5>{{Docente::find(Jugador::find($jugadorenjuego->dni)->codDocente)->apellidoP}}({{$jugadorenjuego->nrocamiseta}})</h5>

                                </div>

                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div><br>
    </div>
</div>
<div class="panel-footer">

    {{ Form::open(array('url'=>'fechas/detail/partido/jugador/add.html','autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}
    <div class="col-md-3">
        {{ Form::hidden('codpartido',$partido->codpartido) }}
        {{ Form::hidden('idtorneo',$torneo->idtorneo) }}
        {{ Form::hidden('codcampeonato',$codcampeonato) }}
        {{ Form::hidden('idfecha',$idfecha )}}
        {{ Form::hidden('codfixture',$codfixture) }}
        {{ Form::hidden('codequipo2',$codequipo2) }}
        {{ Form::hidden('codplantilla',$codplantilla) }}
        {{ Form::hidden('codprogramacion',$codprogramacion) }}



        <div class="form-group">
            {{ Form::label('dni', 'Jugador',array("class"=>"control-label")) }}
            <select  class="form-control" name="jugador">
                @foreach( $jugador2 as $val)

                    @if($val->seleccionado=='1')

                    <option class="form-control" value="{{$val->dni}}">{{$val->dataDocente[0]->apellidoP}} {{$val->dataDocente[0]->apellidoM}} {{$val->dataDocente[0]->nombre}}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-3">
        <div class="form-group">
            {{ Form::label('dni', 'Condicion',array("class"=>"control-label")) }}
            <select  class="form-control" name="condicion">
                <option class="form-control" value="delantero">Delantero</option>
                <option class="form-control" value="mediocampista">Mediocampista</option>
                <option class="form-control" value="guardameta">Guardameta</option>
                <option class="form-control" value="defensa">Defensa</option>
                <option class="form-control" value="suplente">Suplente</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {{ Form::label('dni', 'Camiseta',array("class"=>"control-label")) }}
            {{ Form::text('camiseta',null,["class"=>"required form-control","maxlength"=>"2"]) }}
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group">
            {{ Form::label('dni', 'Es campitan?',array("class"=>"control-label")) }}
            <select  class="form-control" name="escapitan">
                <option class="form-control" value="no">No</option>
                <option class="form-control" value="si">Si</option>
            </select>
        </div>
    </div>
    <div class="col-md-2">
        <div class="form-group"><br>
            {{ Form::submit('Agregar',['class' => 'btn btn-primary'])}}
        </div>
    </div>
    {{ Form::close()}}



</div>