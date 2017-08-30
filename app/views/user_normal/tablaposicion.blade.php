@extends('_templates.apptemp')

@section('titulo')
    @lang('Varapp.nombre_sistema_mediano')
@stop

@section('rutanavegacion')
    <li><a href="{{ URL::to( '/home');}}"><span class="glyphicon glyphicon-adjust"></span></a></li>
@stop

@section('nombrevista')
    @lang('Tabla de Posiciones')
@stop

@section('contenido')


        <!--/.main-->
    <div class="container">
        <div class="row">
            <div class=" col-md-11" id="posiciones">
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
            </div>

        </div>

        <div class="row">
            <div class=" col-md-11" id="posiciones">
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






    </div>





@endsection
@section ('scrips')
    <script src="{{asset('/js/bootstrap-table.js')}}"></script>

@stop




