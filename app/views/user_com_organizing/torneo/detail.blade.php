@extends('_templates.apptemp')

@section('titulo')
    @lang('Varapp.nombre_sistema_mediano')
@stop

@section('rutanavegacion')
    <li><a href="{{ URL::to('/campeonato/listar');}}"><span class="glyphicon glyphicon-book"></span></a></li>
    <li><a href="{{ URL::to('/campeonato/detail/'.$codcampeonato);}}">Detalle de Campeonato</a></li>
    <li><a href="{{ URL::to('/torneo/'.$codcampeonato);}}">Torneos</a></li>
    <li>Detalle del torneo {{$torneo->nombre}}</li>
@stop

@section('nombrevista')
    @lang('Detalles del Torneo')
    <button type="submit" class="btn btn-success pull-right" onclick="history.back()">Atras</button>
@stop

@section('contenido')
    <div class="col-md-12">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span> Informacion de Torneo {{$torneo->nombre}}</div>
            <div class="panel-body">
                <strong class="primary-font">Tipo: </strong><span class="text-primary">Torneo {{$torneo->nombre}}</span><br>
                <strong class="primary-font">Dia de Inicio: </strong><span class="text-primary">{{$torneo->fechaCreacion}}</span><br>
            </div>
            <div class="panel panel-footer">
                <a class="btn btn-danger" href="#fixture1">Tabla de posiciones</a>

                <?php $fixturefechaexiste=Fixture::where('codRueda','=',$torneo->codRueda)->first();
                $fixture=Fixture::where('codRueda','=',$torneo->codRueda)->get();?>
                @if($fixturefechaexiste == '')
                    <a class="btn btn-primary" href="{{ URL::to('torneo/'.$codcampeonato.'/'.$torneo->codRueda.'/fixture.html');}}">Generar Fixture</a>
                @endif
                <a class="btn btn-primary" href="#programacion">PROGRAMAR FECHAS {{$torneo->nombre}}</a>
                <a class="btn btn-primary" href="#fixture">FECHAS {{$torneo->nombre}}</a>
                @if($fixturefechaexiste != '')
                <a class="btn btn-primary" href="{{URL::to('partidosprogramados/'.$torneo->codRueda)}}">PARTIDOS PROGRAMADOS DEL   {{$torneo->nombre}}</a>
                @endif
            </div>
        </div>
    </div>

    <!--============= tabla de posiciones  buscararchivo tabla150216.txt ==================== -->
    <!--============= endtabla de posiciones    -->

    <div class="col-md-12" id="fixture1">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span> resumen {{$torneo->nombre}}</div>
            <div class="panel-body color-orange">
                <!-- aqui se pondra el fixture del torneo -->
                <div class="panel panel-footer">


                    <div class="panel panel-info ui-tabs-panel">
                        <div class="panel-heading">Tabla de Colocaciones </div>
                        <div class="panel-body color-orange">

                            <table data-toggle="table" data-url="tables/data2.json">
                                <thead>
                                <tr>
                                    <th>nro</th>
                                    <th>Equipos</th>
                                    <th>PJ</th>
                                    <th>PG</th>
                                    <th>PE</th>
                                    <th>PP</th>
                                    <th>GF</th>
                                    <th>GE</th>
                                    <th>DG</th>
                                    <th>Puntos</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                $iterator = new MultipleIterator();
                                $iterator->attachIterator(new ArrayIterator($tabla));
                                $iterator->attachIterator(new ArrayIterator($goles));


                                $nro=1;?>

                                @foreach ($iterator as $current)
                                    <tr>
                                        <td>{{$nro++}}</td>
                                        <td>{{Equipo::find($current[1]->equipo)->nombre}}</td>
                                        <td>{{$current[0]->PJ}}</td>
                                        <td>{{$current[0]->PG}}</td>
                                        <td>{{$current[0]->PE}}</td>
                                        <td>{{$current[0]->PP}}</td>
                                        <td> {{$current[1]->GF}}</td>
                                        <td>{{$current[1]->GC}}</td>
                                        <td>{{$current[1]->DG}}</td>
                                        <td>{{$current[0]->PU}}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>



                    <div class="panel panel-info ui-tabs-panel">
                        <div class="panel-heading">Tabla de Goleadores </div>
                        <div class="panel-body color-orange">

                            <table data-toggle="table" data-url="tables/data2.json">
                                <thead>
                                <tr>
                                    <th>nro</th>
                                    <th>nombre</th>
                                    <th>goles</th>

                                </tr>
                                </thead>
                                <tbody>
                                <?php



                                $nro=1;?>

                                @foreach ($goleadores as $value)
                                    <tr>
                                        <?php
                                        $docente=Docente::find(Jugador::find($value->dni)->codDocente);

                                        ?>
                                        <td>{{$nro++}}</td>
                                        <td>{{$docente->nombre}} {{$docente->apellidoP}} {{$docente->apellidoM}}</td>
                                        <td>{{$value->goles}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>

                    </div>


                </div>
            </div>
            <div class="panel-footer">
                <a class="btn btn-primary" href="#">Aceptar</a>
            </div>
        </div>
    </div>


    <div class="col-md-12" id="fixture">
        <div class="panel panel-primary">
            <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span> Fixtures del torneo {{$torneo->nombre}}</div>
            <div class="panel-body color-orange">
                <!-- aqui se pondra el fixture del torneo -->
                <div class="panel panel-footer">
                    <?php
                    $nroPartido=0;
                    $nroPartido=(int)($nroequipos/2);
                    if($nroequipos % 2!=0)
                        $nroequipos++;
                    $nrofechas=$nroequipos-1;
                    ?>

                    <?php for ($i=0;$i<$nrofechas;$i++){?>
                    <?php $fecha=$i+1;?>

                    <div class="panel-info">
                        <div class="panel-heading">
                            FECHA {{$fecha}}
                            <div class="pull-right">
                                <?php $fechaexiste = Fechas::where('nroFecha', '=',$fecha )->where('codRueda','=',$torneo->codRueda)->first();?>
                            </div>
                        </div>
                        <div class="panel-body">

                            <table data-toggle="table" data-url="tables/data1.json">
                                <thead>
                                <tr>
                                    <th>primer equipo </th>
                                    <th>segundo equipo</th>
                                </tr>
                                </thead>
                                <?php $fixturefecha=Fixture::where('nroFecha', '=',$fecha )->where('codRueda','=',$torneo->codRueda)->get();?>
                                <?php $fixture2=Fixtureaux::where('nroFecha', '=',$fecha )->where('codRueda','=',$torneo->codRueda)->get();?>
                                <tbody>
                                <?php $descansa=""; ?>
                                @foreach($fixture2 as $value)
                                    <?php if($value->codEquipo1==""){?>
                                    <?php $descansa=$value->codEquipo2;?>
                                    <?php }?>
                                    <?php if($value->codEquipo2==""){?>
                                    <?php $descansa=$value->codEquipo1;?>
                                    <?php }?>
                                @endforeach

                                @foreach($fixturefecha as $val)
                                    <tr>
                                        <td>{{Equipo::find($val->codEquipo1)->nombre}}</td>
                                        <td>{{Equipo::find($val->codEquipo2)->nombre}}</td>


                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                            <table class="table" data-align="table">
                                <thead>
                                @if($descansa!="")
                                    <tr>
                                        <th>
                                            {{ "descansa ".Equipo::find($descansa)->nombre}}
                                        </th>
                                    </tr>
                                @endif
                                </thead>
                            </table>
                        </div>

                    </div>
                    <?php }?>



                        <div class="panel panel-info" id="programacion">
                            <div class="panel-heading">
                                programacion de las fechas
                            </div>
                            <div class="panel-body">
                                <?php
                                for($i=0;$i<$nrofechas;$i++){?>
                                    <?php $valor=$i+1;
                                     $fex=Fechas::where('nroFecha','=',$valor)->where('codRueda','=',$torneo->codRueda)->first();

                                ?>
                                    <div class="col-xs-2">
                                        @if($fex)
                                             <a href="<?php echo URL::to('/fecha/edit/'.$torneo->codRueda.'/'.$valor)?>" class="btn btn-success btn-lg glyphicon glyphicon-check" role="button"><?php echo "fecha ".$valor?></a>
                                        @else
                                            <a href="<?php echo URL::to('/fecha/edit/'.$torneo->codRueda.'/'.$valor)?>" class="btn btn-primary btn-lg " role="button"><?php echo "fecha ".$valor?></a>

                                        @endif
                                    </div>
                                    <?php }?>
                            </div>
                            <div class="panel-footer">
                                <a  href=""><label class="glyphicon glyphicon-arrow-up btn btn-success btn-circle"></label></a>
                            </div>
                        </div>


                </div>
            </div>
            <div class="panel-footer">
                <a class="btn btn-primary" href="#">Aceptar</a>
            </div>
        </div>
    </div>

@endsection
@section ('scrips')
    <script src="{{asset('/js/bootstrap-table.js')}}"></script>
@stop