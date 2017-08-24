@extends('_templates.apptemp')

@section('titulo')
    @lang('Varapp.nombre_sistema_mediano')
@stop

@section('estilos')

    <link href="{{asset('/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <style>
        .table-condensed{
            background-color: #2B2B2B;
        }
    </style>
@stop
@section('rutanavegacion')
    <div class="container" id="pesta"></div>
    <li><a href="{{ URL::to( '/home');}}"><span class="glyphicon glyphicon-home"></span></a>
    <li><a href="{{ URL::to( '/torneo/'.$idtorneo.'/detail.html');}}"><span class="glyphicon glyphicon-link"></span></a></li>
@stop

@section('nombrevista')
    @lang('partidos')
    <button type="submit" class="btn btn-success pull-right" onclick="history.back()">Atras</button>
@stop
@section('contenido')
    <!-- BEGIN PARA MANEJO DE ERRORES -->
    @include('alerts.allerrors')
    @include('alerts.errors')
    <!-- END PARA MANEJO DE ERRORES -->
    <?php

    date_default_timezone_set('America/Lima');
    $hoyH = date("H:i:s");


    ;
    ?>



        <div class="row row-no-gutter col-no-gutter-container" id="fecha">
            <div class="col-md-12 col-no-gutter ">
                <div class="panel panel-default">
                    <div class="panel-heading">PARTIDOS PROGRAMADOS
                    </div>
                    <!-- BEGIN PARA MANEJO DE ERRORES -->
                @include('alerts.allerrors')
                @include('alerts.errors')
                <!-- END PARA MANEJO DE ERRORES -->
                    <div class="panel-body">
                        <div class="row">

                            <?php
                                $i=0;
                            ?>
                            @foreach($fixture as $val)

                                <?php $fix=Fixture::find($val->fixture);
                                      $fec=Programacion::find($val->programacion);
                                      $fec1=Partido::find($val->codpartido);
                                $hoy = date("Y-m-d");
                                $flag=strcmp($fec->diaPartido,$hoy);
                                $flag1=1;
                                ?>
                               @if($flag>=0)
                                @if($i++==0)
                                            <div class="col-md-12">
                                                <h2> partidos por jugar en proximos dias</h2>
                                            </div>
                                @endif
                                <div class="col-md-6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">{{'partido '.$fix->nroPartido}}

                                            <div class="panel-tools pull-right">

                                                <div class="form-inline">
                                                    <div class="form-group">
                                                        @if($fec1->termino==-1)
                                                            <a class="btn btn-success margin text-lowercase" type="button" href=""><span class="glyphicon glyphicon-plus"></span>VER PARTIDO</a>
                                                        @endif
                                                        @if($fec1->termino==0)
                                                            @if($flag>0)
                                                                <a class="btn btn-warning margin text-lowercase" type="button" href=""><span class="glyphicon glyphicon-edit"></span>VER PARTIDO</a>
                                                            @else
                                                                    <?php
                                                                    $hoyH = date("H:i:s");
                                                                    $flag1=strcmp($fec1->horaInicio,$hoyH);
                                                                    $dteStart = new DateTime($hoyH);
                                                                    $dteEnd   = new DateTime($fec1->horaInicio);
                                                                    $dteDiff  = $dteEnd->diff($dteStart);
                                                                    $hora= (int)$dteDiff->format("%H");
                                                                    $min= (int)$dteDiff->format("%I");
                                                                    $aux=0;
                                                                    if($flag1==0)
                                                                        $aux=1;
                                                                    else
                                                                        if($flag1==-1)
                                                                            if($hora&&$min<20)
                                                                                $aux=1;
                                                                    ?>
                                                                @if($aux==1)
                                                                    <a class="btn btn-danger margin text-lowercase" type="button" href=""><span class="glyphicon glyphicon-plus"></span>empezar</a>
                                                                @else
                                                                    <a class="btn btn-danger margin text-lowercase" type="button" href=""><span class="glyphicon glyphicon-plus"></span>supender</a>
                                                                @endif
                                                            @endif
                                                        @endif
                                                        @if($fec1->termino==1)
                                                                <a class="btn btn-danger margin text-lowercase" type="button" href=""><span class="glyphicon glyphicon-plus"></span>incidencias</a>
                                                            @endif
                                                            @if($fec1->termino==2)
                                                                <a class="btn btn-danger margin text-lowercase" type="button" href=""><span class="glyphicon glyphicon-plus"></span>termino</a>
                                                            @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-body ">
                                            <strong class="primary-font">fecha: </strong><span class="text-primary">{{Programacion::find($val->programacion)->diaPartido}}</span><br>
                                            <strong class="primary-font">hora: </strong><span class="text-primary">{{Partido::find($val->codpartido)->horaInicio}}</span><br>

                                            <table class="form1" data-toggle="table" data-url="tables/data2.json">
                                                <thead>
                                                    <tr>
                                                        <th>{{Equipo::find($fix->codEquipo1)->nombre}}</th>
                                                        <th ><h2 style="text-align: center"> VS</h2></th>
                                                        <th>{{Equipo::find($fix->codEquipo2)->nombre}}</th>

                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            {{ HTML::image('storage/equipo/camiseta/'.Equipo::find($fix->codEquipo1)->logo,'Uniforme empty',array('class'=>'img-responsive','title'=>'Uniforme del equipo','style'=>'width: 250px')) }}
                                                        </td>
                                                        <td>
                                                            {{ HTML::image('storage/equipo/camiseta/rayo.jpg','Uniforme empty',array('class'=>'img-responsive','title'=>'Uniforme del equipo','style'=>'width: 200px')) }}
                                                        </td>
                                                        <td>
                                                            {{ HTML::image('storage/equipo/camiseta/'.Equipo::find($fix->codEquipo2)->logo,'Uniforme empty',array('class'=>'img-responsive','title'=>'Uniforme del equipo','style'=>'width: 250px')) }}
                                                        </td>

                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                                @endif

                            @endforeach
                        </div>
                        <div class="row">

                            <?php
                            $i=0;
                            ?>
                                <div class="col-md-12">
                                    <h2> partidos pasados no terminados</h2>
                                </div>
                            @foreach($fixture as $val)

                                <?php $fix=Fixture::find($val->fixture);
                                $fec=Programacion::find($val->programacion);
                                $fec1=Partido::find($val->codpartido);
                                $hoy = date("Y-m-d");
                                $flag=strcmp($fec->diaPartido,$hoy);
                                $flag1=1;
                                ?>

                                @if($flag<0)
                                    <div class="col-md-6">
                                        <div class="panel panel-info">
                                            <div class="panel-heading">{{'partido '.$fix->nroPartido}}

                                                <div class="panel-tools pull-right">

                                                    <div class="form-inline">
                                                        <div class="form-group">
                                                            <a class="btn btn-success margin text-lowercase" type="button" href=""><span class="glyphicon glyphicon-plus"></span>reprogramar</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="panel-body ">
                                                <strong class="primary-font">fecha: </strong><span class="text-primary">{{Programacion::find($val->programacion)->diaPartido}}</span><br>
                                                <strong class="primary-font">hora: </strong><span class="text-primary">{{Partido::find($val->codpartido)->horaInicio}}</span><br>

                                                <table class="form1" data-toggle="table" data-url="tables/data2.json">
                                                    <thead>
                                                    <tr>
                                                        <th>{{Equipo::find($fix->codEquipo1)->nombre}}</th>
                                                        <th ><h2 style="text-align: center"> VS</h2></th>
                                                        <th>{{Equipo::find($fix->codEquipo2)->nombre}}</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>
                                                            {{ HTML::image('storage/equipo/camiseta/'.Equipo::find($fix->codEquipo1)->logo,'Uniforme empty',array('class'=>'img-responsive','title'=>'Uniforme del equipo','style'=>'width: 250px')) }}
                                                        </td>
                                                        <td>
                                                            {{ HTML::image('storage/equipo/camiseta/rayo.jpg','Uniforme empty',array('class'=>'img-responsive','title'=>'Uniforme del equipo','style'=>'width: 200px')) }}
                                                        </td>
                                                        <td>
                                                            {{ HTML::image('storage/equipo/camiseta/'.Equipo::find($fix->codEquipo2)->logo,'Uniforme empty',array('class'=>'img-responsive','title'=>'Uniforme del equipo','style'=>'width: 250px')) }}
                                                        </td>

                                                    </tr>

                                                    </tbody>
                                                </table>

                                            </div>
                                        </div>
                                    </div>
                                @endif

                            @endforeach


                        </div>


                    </div>
                    <div class="panel-footer">
                        <a class="btn btn-success" href="">Aceptar</a>
                    </div>
                </div>
            </div>
        </div>
        <br>


@endsection
@section ('scrips')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="{{asset('/js/bootstrap-table.js')}}"></script>

    <script src="{{asset('js/moment.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-datetimepicker.es.js')}}"></script>
    <script type="text/javascript" src="{{asset('/js/bootstrap-timepicker.js')}}"></script>
    <script>
        $('.datepicker').datetimepicker({
            format: 'YYYY-MM-DD',
            language: "es",
            autoclose: true

        });

    </script>
    <script type="text/javascript">
        $('.datepicker1').timepicker();

    </script>



@stop