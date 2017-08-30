<?php



?>

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
                    <div class="panel panel-default">
                        <div class="panel-heading">condiciones de jugadores en juego  del equipo {{Equipo::find($codequipo1)->nombre}}

                        </div>
                        <div class="panel-body">
                            <!-- BEGIN PARA MANEJO DE ERRORES -->
                        @include('alerts.allsuccess')
                        <!-- END PARA MANEJO DE ERRORES -->
                        <table data-toggle="table" data-url="tables/data2.json">
                                <thead>
                                <tr>
                                    <th>foto</th>
                                    <th>numero camiseta</th>
                                    <th>TA</th>
                                    <th>TR</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($tarjetasJT1 as $val)
                                    <tr>
                                        <td> {{ HTML::image('storage/jugador/'.$val->foto,'Image Empty',['class'=>'img-responsive','title'=>'Foto del jugador','style'=>'width:100px']) }}
                                        </td>
                                        <td>{{$val->nrocamiseta}}</td>
                                        <?php
                                            $nro1=0;
                                            $nro2=0;
                                            if($val->tipo=='amarilla')
                                                $nro1=1;
                                             if($val->tipo=='roja')
                                                 $nro2=1;

                                        ?>
                                        <td><p class="color-orange">{{$nro1}} </p></td>
                                        <td><p class="color-orange">{{$nro2}} </p>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                        </table>

                        </div>
                    </div>

                </div>
            </div><br>

        </div>
    </div>
</div>


<div class="panel-footer">
    <?php



    ?>
    @include('alerts.allerrors')
    @include('alerts.errors')

    {{ Form::open(array('url'=>'/partido/tarjeta/add/'.$codpartido,'autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}

    <div class="col-md-4">
        {{ Form::hidden('codpartido',$partido->codpartido) }}
        {{ Form::hidden('idtorneo',$torneo->idtorneo) }}
        {{ Form::hidden('codcampeonato',$codcampeonato) }}
        {{ Form::hidden('idfecha',$idfecha )}}
        {{ Form::hidden('idfixture',$fixture->idfixture) }}
        <div class="form-group">
            {{ Form::label('dni', 'Jugador que sale ',array("class"=>"control-label")) }}
            <select  class="form-control" name="jugador">
                @foreach( $Jugadores1 as $val)
                        <option class="form-control" value="{{$val->codjugPart}}">{{Docente::find($val->codDocente)->apellidoP}} {{Docente::find($val->codDocente)->apellidoM}} {{Docente::find($val->codDocente)->nombre}} ({{$val->nrocamiseta}})</option>
                @endforeach
            </select>
        </div>
    </div>
        <div class="col-md-4">
            <div class="form-group">
                {{ Form::label('dni', 'Condicion',array("class"=>"control-label")) }}
                <select  class="form-control" name="tipo">
                    <option class="form-control" value="amarilla">amarilla</option>
                    <option class="form-control" value="roja">roja</option>
                </select>
            </div>
        </div>

    <div class="col-md-2">
        <div class="form-group"><br>
            {{ Form::submit('sacar',['class' => 'btn btn-primary'])}}
        </div>
    </div>
    {{ Form::close()}}



</div>
<br>
<br>

<br>


<div class="panel panel-blue"></div>
<div class="form_contenido">
    <div id="step-1">
        <div class="row">
            <div class="row col-no-gutter-container">
                <div class="col-xs-6 col-md-2 col-no-gutter">
                    <div class="panel panel-default">
                        <div class="panel-body easypiechart-panel">
                            <div>
                                {{ HTML::image('storage/equipo/camiseta/'.Equipo::find($codequipo2)->logo,'Image Empty',['class'=>'img-responsive','title'=>'logo del equipo '.Equipo::find($codequipo1)->nombre,'style'=>'width:155px;height: 155px']) }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><br>


        <div class="panel-body panel-footer">
            <div class="row">
                <div class="row col-no-gutter-container">
                    <div class="panel panel-default">
                        <div class="panel-heading">condiciones de jugadores en juego  del equipo {{Equipo::find($codequipo2)->nombre}}

                        </div>
                        <div class="panel-body">
                            <!-- BEGIN PARA MANEJO DE ERRORES -->
                        @include('alerts.allsuccess')
                        <!-- END PARA MANEJO DE ERRORES -->
                            <table data-toggle="table" data-url="tables/data2.json">
                                <thead>
                                <tr>
                                    <th>foto</th>
                                    <th>numero camiseta</th>
                                    <th>TA</th>
                                    <th>TR</th>
                                </tr>
                                </thead>
                                <tbody>

                                @foreach($tarjetasJT2 as $val)
                                    <tr>
                                        <td> {{ HTML::image('storage/jugador/'.$val->foto,'Image Empty',['class'=>'img-responsive','title'=>'Foto del jugador','style'=>'width:100px']) }}
                                        </td>
                                        <td>{{$val->nrocamiseta}}</td>
                                        <?php
                                        $nro1=0;
                                        $nro2=0;
                                        if($val->tipo=='amarilla')
                                        $nro1=1;
                                        if($val->tipo=='roja')
                                        $nro2=1;

                                        ?>
                                        <td><p class="color-orange">{{$nro1}} </p></td>
                                        <td><p class="color-orange">{{$nro2}} </p>
                                        </td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                        </div>
                    </div>

                </div>
            </div><br>

        </div>
    </div>
</div>


<div class="panel-footer">
    <?php



    ?>
    @include('alerts.allerrors')
    @include('alerts.errors')

    {{ Form::open(array('url'=>'/partido/tarjeta/add/'.$codpartido,'autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}

    <div class="col-md-4">
        {{ Form::hidden('codpartido',$partido->codpartido) }}
        {{ Form::hidden('idtorneo',$torneo->idtorneo) }}
        {{ Form::hidden('codcampeonato',$codcampeonato) }}
        {{ Form::hidden('idfecha',$idfecha )}}
        {{ Form::hidden('idfixture',$fixture->idfixture) }}
        <div class="form-group">
            {{ Form::label('dni', 'Jugador que sale ',array("class"=>"control-label")) }}
            <select  class="form-control" name="jugador">
                @foreach( $Jugadores2 as $val)
                    <option class="form-control" value="{{$val->codjugPart}}">{{Docente::find($val->codDocente)->apellidoP}} {{Docente::find($val->codDocente)->apellidoM}} {{Docente::find($val->codDocente)->nombre}} ({{$val->nrocamiseta}})</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group">
            {{ Form::label('dni', 'Condicion',array("class"=>"control-label")) }}
            <select  class="form-control" name="tipo">
                <option class="form-control" value="amarilla">amarilla</option>
                <option class="form-control" value="roja">roja</option>
            </select>
        </div>
    </div>

    <div class="col-md-2">
        <div class="form-group"><br>
            {{ Form::submit('sacar',['class' => 'btn btn-primary'])}}
        </div>
    </div>
    {{ Form::close()}}



</div>