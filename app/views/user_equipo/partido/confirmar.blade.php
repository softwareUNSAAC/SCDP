@extends('_templates.apptemp')

@section('titulo')
    @lang('Varapp.nombre_sistema_mediano')
@stop

@section('rutanavegacion')
    <li><a href="{{ URL::to('/campeonato/listar');}}"><span class="glyphicon glyphicon-book"></span></a></li>
    <li>Detalle de Campeonato</li>
@stop

@section('nombrevista')
    @lang('Detalles del equipo')
    <button type="submit" class="btn btn-success pull-right" onclick="history.back()">Atras</button>
@stop

@section('contenido')
    <!--codigo php -->
    <!--fin codigo php -->
    <?php


    $jugadores1 =DB::table('tjugador')
        ->join('tdocente', 'tjugador.codDocente', '=', 'tdocente.codDocente')
        ->where( 'tjugador.codEquipo', '=', $codequipo)->count();

    echo $jugadores1;

        $jugadores1=Jugador::where('codEquipo','=',$codequipo)->count();
    ?>


    <div class="row col-lg-12">
        <div class="col-lg-12 col-no-gutter">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span> Informacion de Equipo</div>
                <div class="panel-body">
                    <strong class="primary-font">Nombre: </strong><span class="text-primary">{{Equipo::find($codequipo)->nombre}}</span><br>
                    <!-- === ver el logo y el uniforme-->
                    <strong class="primary-font">logo: </strong><span class="text-primary">{{Equipo::find($codequipo)->logo}}</span><br>
                    </div>
                <div class="panel panel-footer">
                    <a class="btn btn-info" href="#jugadores">ver jugadores</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row row-no-gutter col-no-gutter-container" id="jugadores">
        <div class="col-md-12 col-no-gutter">
            <div class="panel panel-default">
                <div class="panel-heading">Lista de jugadores

                </div>
                <div class="panel-body">
                    <table data-toggle="table" data-url="tables/data2.json">
                        <thead>
                        <tr>
                            <th>codjugador</th>
                            <th>nombre y apellidos</th>
                            <th>seleccionado</th>
                            <th>acciones</th>


                        </tr>
                        </thead>
                        <tbody>
                        <div class="form-group pull-right">
                            <div class="btn btn-warning">
                                {{ Form::open(array('url' => URL::to('partido/confirmatodo.html/'),'method' => 'post', 'class' => 'form-inline')) }}

                                <button type="submit" class="btn btn-warning"> <span class="ui-icon-arrow-1-s">juegan todos</span>  </button>
                                {{ Form::close() }}

                            </div>
                            <div class="btn btn-danger">
                                {{ Form::open(array('url' => URL::to('partido/terminar.html/'.$codpartido),'method' => 'post', 'class' => 'form-inline')) }}

                                <button type="submit" class="btn btn-danger"><span class="ui-icon-arrow-1-s">terminar</span></button>
                                {{ Form::close() }}
                            </div>

                        </div>
                        @foreach($jugadores as $val)
                            <tr>
                                <?php $variable = (Jugador::find($val->dni)->seleccionado=='1') ? 'si' : 'no';?>
                                <td>{{$val->codDocente}}</td>
                                <td>{{$val->nombre." ".$val->apellidoP." ".$val->apellidoM}}</td>
                                <td>{{$variable}}</td>
                                <td>
                                <div id="jugadores"></div>
                                    <?php $variable = (Jugador::find($val->dni)->seleccionado=='0') ? true : false;?>
                                    {{ Form::open(array('url' => URL::to('partido/confirma.html/'.$val->dni),'method' => 'post', 'class' => 'form-inline')) }}

                                    <div class="form-group ">

                                        {{ Form::label('juega','',array('class'=>'label label-success '))}}
                                        {{Form::radio('habilitado', 'habilitado',$variable,array('class'=>'form-control','id'=>'lo'))}}
                                        {{ Form::label('no juega','',array('class'=>'label label-danger '))}}
                                        {{Form::radio('habilitado', 'desabilitado',!$variable,array('class'=>'form-control '))}}

                                        <br>
                                    </div>
                                    <button type="submit" class="btn btn-primary">cambiar</button>
                                    {{ Form::close() }}

                                </td>


                            </tr>
                        @endforeach

                        </tbody>
                    </table>
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
    <script src="{{asset('/js/bootstrap-table.js')}}"></script>
@stop
