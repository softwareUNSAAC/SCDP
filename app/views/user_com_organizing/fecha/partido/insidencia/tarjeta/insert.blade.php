@extends('_templates.apptemp')

@section('titulo')
    @lang('Tarjeta')
@stop

@section('estilos')
@stop

@section('rutanavegacion')
@stop

@section('nombrevista')
    @lang('Tarjeta')
    <button type="submit" class="btn btn-success pull-right" onclick="history.back()">Atras</button>
@stop

@section('contenido')
    <div class="row">
        <div class="col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">Datos de la tarjeta</div>
                <div class="panel-body">
                    <!-- BEGIN PARA MANEJO DE ERRORES -->
                    @include('alerts.allerrors')
                    @include('alerts.errors')
                    <!-- END PARA MANEJO DE ERRORES -->
                    <div class="col-md-12">
                        {{ Form::open(array('url'=>'fechas/detail/partido/tarjeta.html','autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}
                        <!-- BEGIN CONTENIDO DEL FORMULARIO -->
                        {{ Form::hidden('idtorneo',$idtorneo) }}
                        {{ Form::hidden('codcampeonato',$codcampeonato) }}
                        {{ Form::hidden('idfecha',$idfecha )}}
                        {{ Form::hidden('idfixture',$idfixture) }}
                        {{ Form::hidden('idjugadorenjuego',$idjugadorenjuego)}}
                        <div class="form-group">
                            <label>Tipo de tarjeta</label>
                            <select  class="form-control" name="tipo" required>
                                <option class="form-control" value="amarilla">Amarilla</option>
                                <option class="form-control" value="roja">Roja</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Minuto</label>
                            <input class="form-control" placeholder="24" name="minuto" required maxlength="2">
                        </div>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="submit" class="btn btn-danger" onclick="history.back()">Cancelar</button>
                        {{ Form::close()}}
                        <!-- END CONTENIDO DEL FORMULARIO -->
                    </div>
                </div>
            </div>
        </div>
    </div>
@section ('scrips')
@stop

@endsection

