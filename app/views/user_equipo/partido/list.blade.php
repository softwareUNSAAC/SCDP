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
        $val=$partidoProgramado;

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



                            <?php $fix=Fixture::find($val->codfixture);
                            $fec=Programacion::find($val->codProgramacion);
                            $fec1=Partido::find($val->codpartido);

                            $nroPlantilla=2;


                            $equipo=$fix->codEquipo1;
                            if($codequipo==$equipo)
                                $nroPlantilla=1;
                            $plantilla=Planilla::where('codPartido','=',$val->codpartido)->where('nroPlantilla','=',  $nroPlantilla)->first();
                            $flag=-1;
                            $hoy = date("Y-m-d");
                            $flag=strcmp($fec->diaPartido,$hoy);
                            $flag1=1;
                            ?>

                                <div class="col-md-8">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">{{'partido '.++$nroPartidos}}

                                            <div class="panel-tools pull-right">

                                                <div class="form-inline">
                                                    <div class="form-group">
                                                        @if($fec1->termino==-1)

                                                            @if(!$plantilla)

                                                            <a class="btn btn-warning margin text-lowercase" type="button" href="{{'confirmar.html/'.$val->codpartido}}"><span class="glyphicon glyphicon-plus"></span>confirmar equipo</a>
                                                            @else

                                                                <a class="btn btn-success margin text-lowercase" type="button" href="../equipo/index.html"><span class="glyphicon glyphicon-check"></span>listo</a>
                                                            @endif
                                                        @else
                                                            <a class="btn btn-success margin text-lowercase" type="button" href=""><span class="glyphicon glyphicon-check"></span>salir</a>

                                                        @endif

                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="panel-body ">
                                            <strong class="primary-font">fecha: </strong><span class="text-primary">{{Programacion::find($val->codProgramacion)->diaPartido}}</span><br>
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