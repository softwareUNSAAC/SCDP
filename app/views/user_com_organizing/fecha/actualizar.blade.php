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
    <li><a href="{{ URL::to( '/torneo/'.$torneo->codRueda.'/detail.html#fixture');}}"><span class="glyphicon glyphicon-link"></span></a></li>
@stop

@section('nombrevista')
    @lang('actualizar las fechas')
    <button type="submit" class="btn btn-success pull-right" onclick="history.back()">Atras</button>
@stop
@section('contenido')
    <!-- BEGIN PARA MANEJO DE ERRORES -->
    @include('alerts.allerrors')
    @include('alerts.errors')
    <!-- END PARA MANEJO DE ERRORES -->
    @if(!$fechaexiste = Fechas::where('nroFecha', '=',$nrofecha )->where('codRueda','=',$torneo->codRueda)->first())
        <div class="row ">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">actualizacion de fecha {{$nrofecha}}</div>
					<div class="panel-body">
						<div class="col-md-6">
							  {{ Form::open(array('url' => 'fecha/edit/'.$torneo->codRueda.'/add','method' => 'post', 'files' => true, 'class' => 'form-inline')) }}
                            {{Form::hidden('nrofecha',$nrofecha)}}
                            <div class="form-group ">
                                {{ Form::label('fecha ')}}
                                <input type="text" class="form-control datepicker" name="fecha" placeholder="fecha de inicio de inscripcion">
                                <span class="help-block">{{ $errors->first('fecha') }}</span>
                            </div>
                            <div class="form-group">
                                {{ Form::label('hora inicio')}}
                                <input type="time" class="form-control" name="horainicio" placeholder="hora inicio" min="8:30:00" >
                                <span class="help-block">{{ $errors->first('horainicio') }}</span>
                            </div>
                            <div class="row">
                            <div class="form-group">
                                <p>{{Form::submit('agregar', array('class' => 'btn btn-primary'))}}</p>
                            </div>
                            </div>
							{{ Form::close() }}
							</div>

					</div>
				</div>
			</div>
        </div>
    @endif
    <?php $fechaexiste = Fechas::where('nroFecha', '=',$nrofecha )->where('codRueda','=',$torneo->codRueda)->first();?>

    @if(  $fechaexiste = Fechas::where('nroFecha', '=',$nrofecha )->where('codRueda','=',$torneo->codRueda)->first())
        <?php $fixturefecha=Fixture::where('nroFecha', '=',$nrofecha )->where('codRueda','=',$torneo->codRueda)->get(); ?>
        <div class="row row-no-gutter col-no-gutter-container" id="fecha">
            <div class="col-md-12 col-no-gutter ">
                <div class="panel panel-default">
                    <div class="panel-heading">PROGRAMAR PARTIDOS DE LA FECHA {{$nrofecha}}
                    </div>
                    <!-- BEGIN PARA MANEJO DE ERRORES -->
                    @include('alerts.allerrors')
                    @include('alerts.errors')
                    <!-- END PARA MANEJO DE ERRORES -->
                    <div class="panel-body">
                        <div class="row">


                            @foreach($fixturefecha as $val)
                                <div class="col-md-6">
                                    <div class="panel panel-info">
                                        <div class="panel-heading">{{'partido '.$val->nroPartido}}
                                        </div>

                                        <div class="panel-body ">

                                            <table data-toggle="table" data-url="tables/data2.json">
                                                <thead>
                                                <tr>
                                                    <th>{{Equipo::find($val->codEquipo1)->nombre}}</th>
                                                    <th><h2>VS</h2></th>
                                                    <th>{{Equipo::find($val->codEquipo2)->nombre}}</th>
                                                    <th>HORA</th>
                                                    <th>programar</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            {{ HTML::image('storage/equipo/camiseta/'.Equipo::find($val->codEquipo1)->logo,'Uniforme empty',array('class'=>'img-responsive','title'=>'Uniforme del equipo','style'=>'width: 250px')) }}
                                                        </td>
                                                        <td> {{ HTML::image('storage/equipo/camiseta/rayo.jpg','Uniforme empty',array('class'=>'img-responsive','title'=>'Uniforme del equipo','style'=>'width: 250px')) }}
                                                        </td>
                                                        <td>
                                                            {{ HTML::image('storage/equipo/camiseta/'.Equipo::find($val->codEquipo2)->logo,'Uniforme empty',array('class'=>'img-responsive','title'=>'Uniforme del equipo','style'=>'width: 250px')) }}
                                                        </td>
                                                        <td>{{$val->hora}}</td>
                                                        <td>
                                                            <?php
                                                                $nro=Programacion::where('nroPartido', '=', $val->nroPartido)->where('idFecha', '=', $fechaexiste->idFecha)->first()
                                                            ?>
                                                            @if(!$nro)
                                                                <a href="{{URL::to('programacion/'.$val->codFixture)}}" class="btn btn-info label label-info">
                                                                    <span class="glyphicon glyphicon-edit"></span> Programar partido
                                                                </a>
                                                            @else
                                                               <a href="{{URL::to('reprogramacion/'.$val->codFixture.'/'.$nro->codProgramacion)}}" class="btn btn-info label label-info">
                                                                        <span class="glyphicon glyphicon-edit"></span> reprogramar partido
                                                               </a>
                                                            @endif
                                                        </td>
                                                    </tr>

                                                </tbody>
                                            </table>

                                        </div>
                                    </div>
                                </div>
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
    @endif

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