@extends('_templates.apptemp')

@section('titulo')
    @lang('Varapp.nombre_sistema_mediano')
@stop

@section('rutanavegacion')

@stop

@section('nombrevista')
    @lang('Partido: '.Equipo::find($codequipo1)->nombre.' vs '.Equipo::find($codequipo2)->nombre)
    <button type="submit" class="btn btn-success pull-right" onclick="history.back()">Atras</button>
@stop
<?php
$partido=Partido::find($codpartido);

?>
@section('contenido')
    <!-- BEGIN PARA MANEJO DE ERRORES -->
    @include('alerts.allsuccess')
    @include('alerts.errors')
    <?php


    $arr=array();

    $arr[]=$codpartido;
     $suma1=0;
         $suma2=0;
    $conclusiones=DB::select('call Jugadorgoles(?)',$arr);

    foreach ($conclusiones as $val){

        $goles=$val->goles;
        $dni=$val->jugador;
        $j=Jugador::find($dni);

        $jP=JugadorEnJuego::where('dni','=',$dni)->first();
        $equipo=$j->codEquipo;
        if($equipo==$codequipo1){
            $suma1=$suma1+$goles;
        }
        else
            {
                $suma2=$suma2+$goles;
            }

    }


    ?>


    <!-- END PARA MANEJO DE ERRORES -->
    <div class="col-md-12">
        <div class="panel panel-default">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span> Informacion del partido </div>
            <div class="panel-body">
                <strong class="primary-font">Fecha de partido: </strong><span class="text-primary">{{Programacion::find($codprogramacion)->diaPartido}}</span><br>
                <strong class="primary-font">Hora de inicio: </strong><span class="text-primary">{{Partido::find($codpartido)->horaInicio}}</span><br>
                <strong class="primary-font">resultado parcial </strong><span class="text-primary">{{Partido::find($codpartido)->resultado}}</span><br>
                <strong class="primary-font">resultado parcial </strong><span class="text-primary">{{Equipo::find($codequipo1)->nombre.' '.$suma1}} -  {{Equipo::find($codequipo2)->nombre.' '.$suma2}}</span><br>

            </div>
            @if($suma==3&&$aux==0)
                <div class="panel-footer">
                    <a class="btn btn-success margin text-lowercase" type="button" href="{{URL::to('terminarJuego/'.$codpartido.'/'.$suma1.'/'.$suma2)}}"><span class="glyphicon glyphicon-check"></span>terminar</a>

                </div>
            @endif

        </div>
    </div>

    <div>
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-body tabs">
                    <ul class="nav nav-tabs">
                        <!--======== asignacion de personal y designacionde jugadores   -->

                        <!--======== seleccion de arbitro   -->
                        <!--======== equipo1   -->
                        <li><a class="active" href="#tab1" data-toggle="tab">cambios en equipo: {{Equipo::find($codequipo1)->nombre}}</a></li>
                        <!--======== equipo2  -->
                        <li><a href="#tab2" data-toggle="tab">cambios en equipo: {{Equipo::find($codequipo2)->nombre}}</a></li>
                        <li><a href="#tab3" data-toggle="tab">tarjetas</a></li>

                        <li><a href="#tab4" data-toggle="tab">goles</a></li>
                        <!--======== envio de mesa  -->
                        <li><a href="#tab5" data-toggle="tab">incidencias</a></li>


                    </ul>
                    <div class="tab-content">
                        <!--======== equipo 1  -->

                        <div class="tab-pane fade in active" id="tab1">
                                <!-- -->
                            @include('user_com_organizing.fecha.partido.insidencia.tabs.tab1')
                        </div>
                            <!--======== equipo 2  -->
                        <div class="tab-pane fade" id="tab2">
                                <!-- -->
                            @include('user_com_organizing.fecha.partido.insidencia.tabs.tab2')
                        </div>

                    <!--======== arbitros   -->
                        <div class="tab-pane fade" id="tab3">
                            <!-- -->
                            @include('user_com_organizing.fecha.partido.insidencia.tabs.tab3')
                        </div>
                        <!--======== miembros de mesa -->
                        <div class="tab-pane fade" id="tab4">

                            @include('user_com_organizing.fecha.partido.insidencia.tabs.tab4')
                        </div>
                        <div class="tab-pane fade" id="tab5">

                            miembros de mesa2
                        </div>


                    </div>
                </div>
                <div class="panel-footer">

                </div>
            </div><!--/.panel-->
        </div>
    </div>


@endsection
@section ('scrips')
    <script src="{{asset('/js/bootstrap-table.js')}}"></script>
@stop