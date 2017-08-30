




<div class="form_contenido">
    <div id="step-1">
        <div class="row">
            <div class="row col-no-gutter-container">
                <div class="col-xs-6 col-md-2 col-no-gutter">
                    <div class="panel panel-default">
                        <div class="panel-body easypiechart-panel">
                            <div>
                                {{ HTML::image('storage/equipo/camiseta/'.Equipo::find($codequipo1)->logo,'Image Empty',['class'=>'img-responsive','title'=>'logo del equipo '.Equipo::find($codequipo1)->nombre,'style'=>'width:155px;height: 155px']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>
        <div class="panel-heading">lista de jugadores

        </div>
        <div class="panel-body panel-footer">
            <div class="row">
                <div class="row col-no-gutter-container">
                    @foreach($Jugadores2 as $jugadorenjuego)
                        <div class="col-xs-6 col-md-2 col-no-gutter">
                            <div class="panel panel-danger">
                                <div class="panel-heading">
                                    @if($jugadorenjuego->escapitan == 'si')
                                        <span class="glyphicon glyphicon-bookmark" title="Capitan"><span class="text-lowercase"> capitan</span> {{$jugadorenjuego->condicionenpartido}}</span>
                                    @else
                                        {{$jugadorenjuego->condicionenpartido}}
                                    @endif
                                </div>
                                <div class="panel-body easypiechart-panel">
                                    <div >
                                        {{ HTML::image('storage/jugador/'.$jugadorenjuego->foto,'Image Empty',['class'=>'img-responsive','title'=>'Foto del jugador','style'=>'width:150px']) }}
                                        <h5>{{Docente::find(Jugador::find($jugadorenjuego->dni)->codDocente)->apellidoP}}({{$jugadorenjuego->nrocamiseta}})</h5>

                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div><br>

        </div>
    </div>
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
                                    <span class="glyphicon glyphicon-bookmark" title="Capitan"><span class="text-lowercase"> capitÃ¡n</span> Suplente</span>
                                @else
                                    Suplente
                                @endif
                            </div>
                            <div class="panel-body easypiechart-panel">
                                <div >
                                    {{ HTML::image('storage/jugador/'.$jugadorenjuego->foto,'Image Empty',['class'=>'img-responsive','title'=>'Foto del jugador','style'=>'width:150px']) }}
                                    <h5>{{Docente::find(Jugador::find($jugadorenjuego->dni)->codDocente)->apellidoP}}({{$jugadorenjuego->nrocamiseta}})</h5>

                                </div>

                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div><br>
    </div>
</div>



<div class="panel-footer">





    <?php



    ?>
    @include('alerts.allerrors')
    @include('alerts.errors')

    {{ Form::open(array('url'=>'/partido/cambios/add/'.$codpartido,'autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}

    <div class="col-md-4">
        {{ Form::hidden('codpartido',$partido->codpartido) }}
        {{ Form::hidden('idtorneo',$torneo->idtorneo) }}
        {{ Form::hidden('codcampeonato',$codcampeonato) }}
        {{ Form::hidden('idfecha',$idfecha )}}
        {{ Form::hidden('idfixture',$fixture->idfixture) }}
        <div class="form-group">
            {{ Form::label('dni', 'Jugador que sale ',array("class"=>"control-label")) }}
            <select  class="form-control" name="sale">
                @foreach( $Jugadores2 as $val)
                    @if($val->cambio=='0')
                        <option class="form-control" value="{{$val->codjugPart}}">{{Docente::find($val->codDocente)->apellidoP}} {{Docente::find($val->codDocente)->apellidoM}} {{Docente::find($val->codDocente)->nombre}} ({{$val->nrocamiseta}})</option>
                    @endif
                @endforeach
            </select>

        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('dni', 'Jugador que entra',array("class"=>"control-label")) }}
            <select  class="form-control" name="entra">
                @foreach( $suplentes2 as $val)
                    @if($val->cambio=='0')
                        <option class="form-control" value="{{$val->codjugPart}}">{{Docente::find($val->codDocente)->apellidoP}} {{Docente::find($val->codDocente)->apellidoM}} {{Docente::find($val->codDocente)->nombre}} ({{$val->nrocamiseta}})</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>


    <div class="col-md-2">
        <div class="form-group"><br>
            {{ Form::submit('cambio',['class' => 'btn btn-primary'])}}
        </div>
    </div>
    {{ Form::close()}}
</div>