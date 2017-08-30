@extends('_templates.apptemp')

@section('titulo')
    @lang('Arbitros')
@stop

@section('estilos')
    <link href="{{asset('/js/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
@stop

@section('rutanavegacion')
    <li><a href="{{ URL::to( '/Arbitros/list.html');}}"><span class="glyphicon glyphicon-tags"></span></a></li>
    <li><span > nuevo arbitro</span></li>
@stop

@section('nombrevista')
    @lang('Arbitros')
@stop

@section('contenido')
    <div class="row">
        <div class="col-md-7">
            <div class="panel panel-default">
                <div class="panel-heading">Ingrese los datos del nuevo arbitro</div>
                <div class="panel-body">
                    <!-- BEGIN PARA MANEJO DE ERRORES -->
                    @include('alerts.allerrors')
                    @include('alerts.errors')
                    <!-- END PARA MANEJO DE ERRORES -->
                    <div class="col-md-12">
                        {{ Form::open(array('url'=>'Arbitros/insertar.html','autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}
                        <!-- BEGIN CONTENIDO DEL FORMULARIO -->
                        <div class="form-group">
                            <label>DNI</label>
                            <input class="form-control" placeholder="ingrese el dni" name="dni" required maxlength="8" minlength="8">
                        </div>
                        <div class="form-group">
                            <label>Nombre</label>
                            <input class="form-control" placeholder="ingrese el nombre del arbitro" name="nombre" required>
                        </div>
                        <div class="form-group">
                            <label>Apellidos</label>
                            <input class="form-control" placeholder="ingrese los apellidos del arbitro" name="apellidos" required>
                        </div>
                            <!-- falta en base de datos y controlador-->
                        <div class="form-group">
                                <label>logo:</label><br>
                                <div class="col-sm-10">
                                    <input name="logo" type="file" id="imgInp" class="btn btn-default">
                                </div>
                            </div>
                            <img id="blah" style="width: 200px" class="img-responsive img-thumbnail"/><br><br>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                        <button type="reset" class="btn btn-default">Limpiar</button>
                        <button type="submit" class="btn btn-danger" onclick="history.back()">Cancelar</button>
                        {{ Form::close()}}
                        <!-- END CONTENIDO DEL FORMULARIO -->
                    </div>
                </div>
            </div>
        </div>
    </div>

p

@endsection
@section ('scrips')
    <script src="{{asset('/js/bootstrap-table.js')}}"></script>
    <script src="{{asset('/js/jquery-ui/jquery-ui.js')}}"></script>
    <script type="text/javascript">
        function readURL(input) {
            if (input.files && input.files[0]) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $('#blah').attr('src', e.target.result);
                }
                reader.readAsDataURL(input.files[0]);
            }
        }
        $("#imgInp").change(function(){
            readURL(this);
        });
    </script>
@stop

