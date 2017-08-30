@extends('_templates.apptemp')

@section('titulo')
    @lang('Varapp.nombre_sistema_mediano')
@stop

@section('rutanavegacion')
    <li><a href="{{ URL::to('/campeonato/listar');}}"><span class="glyphicon glyphicon-book"></span></a></li>
    <li><a href="{{ URL::to('/campeonato/detail/'.$codcampeonato);}}">Detalle de Campeonato</a></li>
    <li>cronograma</li>
@stop

@section('nombrevista')
    @lang('Nueva Actividad')
    <button type="submit" class="btn btn-success pull-right" onclick="history.back()">Atras</button>
@stop

@section('contenido')
    <!-- BEGIN PARA MANEJO DE ERRORES -->
    @include('alerts.allerrors')
    @include('alerts.errors')
    <!-- END PARA MANEJO DE ERRORES -->
    <div class="row">

        <div class="panel panel-default">
            <div class="panel-heading">cronograma de actividades </div>
            <div class="panel-body">
                <div class="col-md-12">
                    {{ Form::open(array('method' => 'POST','url'=>'campeonato/'.$codcampeonato.'/actividad/add.html','autocomplete'=>'off','class'=>'form-inline','role'=>'form'))}}
                        <!-- torneo-->
                            <div class="panel-default">
                                <div class="panel-heading">
                                    <h3> actividad:</h3>
                                </div>
                                <div class="panel-body">
                                    <div class="form-group">
                                        <label> nombre de actividad</label>
                                        <input class="form-control" placeholder="actividad a realizar" name="actividad" required>
                                        <span class="help-block">{{ $errors->first('actividad') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('fecha inicio')}}
                                        <input type="date" class="form-control datepicker" name="fechaI" placeholder="fecha de inicio de inscripcion" required>

                                        <span class="help-block">{{ $errors->first('fechaI') }}</span>
                                    </div>
                                    <div class="form-group">
                                        {{ Form::label('fecha final')}}
                                        <input type="date" class="form-control datepicker" name="fechaF" placeholder="fecha de inicio de inscripcion" required>

                                        <span class="help-block">{{ $errors->first('fechaF') }}</span>
                                    </div>
                                    <div class="form-group">
                                        <label> observaciones</label>&nbsp; &nbsp; &nbsp; &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                        {{ Form::textarea('obser',"",array("class"=>"form-control","rows"=>"4", "cols"=>"52")) }}
                                        <span class="help-block">{{ $errors->first('obser') }}</span>
                                    </div>
                                </div>

                            </div>
                       <!-- end torne0-->
                        <button type="submit" class="btn btn-primary ">Guardar</button>
                        <button type="reset" class="btn btn-default">Limpiar</button>
                        <button type="submit" class="btn btn-danger" onclick="history.back()">Cancelar</button>
                    {{ Form::close() }}
                    <div class="pull-right">

                    </div>
                </div>
                <br>
                <br>
                <div class="col-md-12 r">
                    <div class="panel panel-info">
                        <div class="panel-heading">Actividades
                        </div>
                        <div class="panel-body">
                            <table data-toggle="table" data-url="tables/data2.json">
                                <thead>
                                <tr>
                                    <th>Actividad</th>
                                    <th>Fecha Inicio</th>
                                    <th>Fecha Fin</th>
                                    <th>Observaciones</th>

                                </tr>
                                </thead>
                                <tbody>
                                @foreach($Actividades as $val)
                                    <tr>
                                        <td>{{$val->actividad}}</td>
                                        <td>{{$val->fechaInicio}}</td>
                                        <td>{{$val->fechaFin}}</td>
                                        <td>{{$val->observaciones}}</td>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
@section('scrips')
    <script src="{{asset('/js/bootstrap-table.js')}}"></script>
    <script src="{{asset('/js/bootstrap-datetimepicker.es')}}"></script>
    <script>
        $('.datepicker').datepicker({
            format: "yyyy-mm-dd",
            language: "es",
            autoclose: true
        });
    </script>

@stop