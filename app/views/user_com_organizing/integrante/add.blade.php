@extends('_templates.apptemp')

@section('titulo')
    @lang('Nuevo integrante de la comision organizadora')
@stop

@section('estilos')
    <link href="{{asset('/js/jquery-ui/jquery-ui.css')}}" rel="stylesheet">

@stop

@section('rutanavegacion')
    <li><a href="{{ URL::to( '/comision/integrantes/list.html');}}"><span class="glyphicon glyphicon-user"></span></a></li>
    <li>Nuevo integrante</li>
@stop

@section('nombrevista')
    @lang('NUEVO INTEGRANTE')
@stop

@section('contenido')
<div class="row">
    <div class="col-md-7">
        <div class="panel panel-default">
            <div class="panel-heading">Ingrese los datos del nuevo integrante</div>
            <div class="panel-body">
                <!-- BEGIN PARA MANEJO DE ERRORES -->
                @include('alerts.allerrors')
                @include('alerts.errors')
                <!-- END PARA MANEJO DE ERRORES -->
                <div class="col-md-12">
                    {{ Form::open(array('url'=>'comisionintegrantesadd','autocomplete'=>'off','class'=>'form-horizontal','role'=>'form'))}}
                    <!-- BEGIN CONTENIDO DEL FORMULARIO -->
                    <div class="form-group " id="h1">
                        {{Form::label('lbldni','DNI:')}}
                        {{Form::text('dni','',['class'=>'form-control','placeholder'=>'ingrese dni','maxlength'=>'8','id'=>'ver'])}}

                    </div>
                        <div class="form-group " id="h1">
                            {{Form::label('lbnombre','nombre:')}}
                            {{Form::text('dni','',['class'=>'form-control','placeholder'=>'ingrese dni','maxlength'=>'8','id'=>'ver'])}}

                        </div>
                        <div class="form-group " id="h1">
                            {{Form::label('lbapellidos','apellidos:')}}
                            {{Form::text('dni','',['class'=>'form-control','placeholder'=>'ingrese dni','maxlength'=>'8','id'=>'ver'])}}

                        </div>
                    <div class="form-group">
                        <label>Rol</label>
                        <select  class="form-control" name="Rol">
                            <option class="form-control" value="presidente">Presidente</option>
                            <option class="form-control" value="secretario">Secretario</option>
                            <option class="form-control" value="otros">miembro</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                    <button type="reset" class="btn btn-default">Limpiar</button>
                        <div class="pull-right">
                            <button type="submit" class="btn btn-danger" onclick="history.back()">Cancelar</button>
                        </div>
                    {{ Form::close()}}

                        <!-- END CONTENIDO DEL FORMULARIO -->
                </div>
            </div>
        </div>
    </div>
</div>

@section ('scrips')
    <script src="{{asset('/js/jquery-ui/jquery-ui.js')}}"></script>

    <script>
        $(function() {
            $("#docenteauto").autocomplete({
                source: "autodocente",
                minLength: 1,
                select: function( event, ui ) {
                    $('#response').val(ui.item.id);
                }
            });
        });
    </script>


    <script type="text/javascript">
        timer()
        alert($('input:text[dni]').val());

                //saco el valor accediendo a un input de tipo text y name = nombre


    </script>

@stop

@endsection

