@extends('_templates.apptemp')

@section('titulo')
    @lang('Varapp.nombre_sistema_mediano')
@stop

@section('rutanavegacion')
@stop

@section('nombrevista')
    @lang('Home')
@stop

@section('contenido')
    <?php




    date_default_timezone_set('America/Lima');
    $hoy = date("Y-m-d");

    $parJugarProgramados=DB::table('tpartido')
        ->join('tprogramacion', 'tpartido.codPartido', '=', 'tprogramacion.codPartido')
        ->join('tfixture', 'tfixture.codPartido', '=', 'tpartido.codPartido')
        ->select('tprogramacion.codProgramacion as codProgramacion', 'tpartido.codPartido as codpartido','tfixture.codFixture as codfixture')
        ->where( 'tprogramacion.diaPartido', '>', $hoy)
        ->where( 'tprogramacion.actual', '=', '1')
        ->where( 'tpartido.termino', '<>', '2')
        ->where( 'tfixture.codEquipo1', '=', $equipo->codEquipo)->orwhere( 'tfixture.codEquipo2', '=', $equipo->codEquipo)->get();
    //$partidosporjugar->where()->get();

$fixture3=Fixture::where( 'codEquipo1', '=', $equipo->codEquipo)->orwhere( 'codEquipo2', '=', $equipo->codEquipo)->get();



    $habilitado2="";
    $habilitado2=DB::select('SELECT idFecha FROM tprogramacion WHERE diaPartido=adddate(curdate(),1) OR diaPartido=adddate(curdate(),2) OR
    diaPartido=adddate(curdate(),3)');
    $idfecha=-1;
    $descansa=0;
    $codEquipo1=-1;
    $codEquipo2=-1;
    $idfixture=-1;
    $codPla="";

        foreach($habilitado2 as $value) {
            $idfecha=$value->idFecha;
            echo $idfecha;
        }




    ?>
    <!-- BEGIN PAR MANEJO DE ERRORES -->
    @include('alerts.allsuccess')
    @include('alerts.success')
    <!-- END PARA MANEJO DE ERRORES -->
    <div class="container">
        <div class="row-margin-top ">
            <div class="col-md-6 col-no-gutter">
                <div class="panel panel-default">
                    <div class="panel-heading text-center">logo</div>
                    <div class="panel-body">
                        <div class="canvas-wrapper">
                            <div class="col-lg-5">

                                @if($equipo->logo != '')
                                    {{HTML::image('storage/equipo/camiseta/'.$equipo->logo,'imagen logo',['class'=>'img-responsive','title'=>'uniforme','style'=>'width: 600px'])}}
                                    <a class="btn btn-danger  margin" type="button" href="{{URL::to('jugador/logo/delete.html')}}"><span class="glyphicon glyphicon-trash"> Eliminar</span></a>
                                @else
                                    <span class="label label-info">sin Logo</span>
                                    <a class="btn btn-primary btn-circle margin" type="button" href="{{URL::to('jugador/logo.html')}}"><span class="glyphicon glyphicon-plus"></span></a>
                                @endif

                            </div>
                            <div class="col-lg-7">
                                <strong class="primary-font">Nombre: </strong><span class="text-primary">{{$equipo->nombre}}</span><br>
                                <strong class="primary-font">Torneo actual: </strong><span class="text-primary">{{Torneo::find($equipo->torneo)->nombre}}</span><br>
                                <strong class="primary-font">Fecha de creacion: </strong><span class="text-primary">gggg</span><br>
                                <strong class="primary-font">Estado: </strong><span class="text-primary">gggggg</span><br>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-6 col-lg-3 col-no-gutter">
                <div class="panel panel-teal panel-widget">
                    <div class="row no-padding ">
                        <div class="col-sm-3 col-lg-5 widget-left ">jugadores
                            <a class="color-blue" href="{{URL::to('jugador/listar.html')}}"><span class="glyphicon glyphicon-user glyphicon-l"></span></a>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$nrojugadores}}</div>
                            <div class="text-muted">
                                @if($nrojugadores=='1')
                                    Jugador
                                @else
                                    Jugadores
                                @endif

                            </div>
                            <a class="widget-right " href="{{URL::to('jugadorinsertar')}}">
                                <button class="btn btn-block label label-info" type="button">
                                    <span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar Nuevo
                                </button>
                            </a>

                        </div>

                    </div>
                    <div class="row no-padding ">
                        <div class="col-sm-3 col-lg-5 widget-left ">delegados
                            <a class="color-blue" href="{{URL::to('delegado/listar.html')}}"><span class="glyphicon glyphicon-user glyphicon-l"></span></a>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$nrodelegados}}</div>
                            <div class="text-muted">
                                @if($nrodelegados=='1')
                                    Delegado
                                @else
                                    Delegados
                                @endif

                            </div>
                            <a class="widget-right" href="{{URL::to('delegadoinsertar')}}">
                                <button class="btn btn-block label label-info" type="button">
                                    <span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar Nuevo
                                </button>
                            </a>

                        </div>
                    </div>
                    <div class="row no-padding ">
                        <div class="col-sm-3 col-lg-5 widget-left ">partidos
                            <a class="color-orange" href="{{URL::to('partido/list.html')}}"><span class="glyphicon glyphicon-list-alt glyphicon-l"></span></a>
                        </div>
                        <div class="col-sm-9 col-lg-7 widget-right">
                            <div class="large">{{$nrodelegados}}</div>
                            <div class="text-muted">
                                @if($nrodelegados==1)
                                    Delegado
                                @else
                                    Delegados
                                @endif

                            </div>
                            <a class="widget-right" href="{{URL::to('delegadoinsertar')}}">
                                <button class="btn btn-block label label-info" type="button">
                                    <span class="glyphicon glyphicon-plus"></span> &nbsp;Agregar Nuevo
                                </button>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--buscar en archivo percy14022016.txt lo que falte -->
    <div class="container">
        <div class="row ">
            <!--  camabiar este esta con la despues de comenzar el los partidos con el fixture-->


                <div class="col-md-4 col-no-gutter">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">lista de partidos jugados</div>
                        <div class="panel-body">
                            <div class="canvas-wrapper">
                                <div class="col-lg-3">
                                    <!-- referencias  a lista de partidos jugados-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-no-gutter">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">Puntaje</div>
                        <div class="panel-body">
                            <div class="canvas-wrapper">
                                <div class="col-lg-3">
                                    <!-- determinar el puntaje-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-no-gutter">
                    <div class="panel panel-default">
                        <div class="panel-heading text-center">goleadores</div>
                        <div class="panel-body">
                            <div class="canvas-wrapper">
                                <div class="col-lg-3">
                                    <!-- lista de goleadores de equipo-->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

        </div>
    </div>
@stop