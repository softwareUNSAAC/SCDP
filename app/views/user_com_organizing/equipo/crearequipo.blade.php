@extends('_templates.apptemp')

@section('titulo')
    @lang('crear una nueva cuenta para un equipo')
@stop

@section('estilos')
    <link href="{{asset('/js/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
@stop

@section('rutanavegacion')
    <li><a href="{{ URL::to('/campeonato/detail/'.$campeonato);}}">Detalle de Campeonato</a></li>
@stop

@section('nombrevista')
    @lang('CREAR NUEVO EQUIPO')
@stop

<?php

$equipo=Equipo::find($cadena);
$flag=-1;
if($equipo)
    $flag=1;
//$codigo=$enviado;

?>

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">EQUIPO</div>
                <div class="panel-body">
                    @include('alerts.allerrors')
                    @include('alerts.errors')
                    <div class="col-md-12 center-block">
                    {{ Form::open(array('url'=>'campeonato/'.$campeonato.'/equipo/add.html','files' => true,'autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}
                        {{Form::hidden('cadena',$cadena)}}
                        <div class="row">
                        <!-- BEGIN CONTENIDO DEL FORMULARIO -->

                            @if($flag)
                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel panel-heading"> equipo</div>
                                    <div class="panel panel-body">
                                        <div class="form-group">
                                            <label> nombre del equipo</label>
                                            <input class="form-control" placeholder="ingrese nombre del equipor" name="nombre" required>
                                            <span class="help-block">{{ $errors->first('actividad') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label> colores del equipo</label>
                                            <input class="form-control" placeholder="ingrese los colores de camiseta" name="colores" required>
                                            <span class="help-block">{{ $errors->first('actividad') }}</span>
                                        </div>
                                        <div class="form-group">
                                            <label> color alternos</label>
                                            <input class="form-control" placeholder="ingrese los colores alterna de camiseta" name="coloresA" required>
                                            <span class="help-block">{{ $errors->first('actividad') }}</span>
                                        </div>

                                        <div class="form-group">
                                            <label>logo:</label><br>
                                            <div class="col-sm-10">
                                                <input name="logo" type="file" id="imgInp" class="btn btn-default">
                                            </div>
                                        </div>

                                        <img id="blah" style="width: 200px" class="img-responsive img-circle"/><br><br>

                                    </div>
                                </div>
                            </div>
                            @endif

                            <div class="col-md-6">
                                <div class="panel panel-primary">
                                    <div class="panel panel-heading"> delegados</div>
                                    <div class="panel panel-body">

                                        @if($equipo)
                                        <table data-toggle="table" data-url="tables/data2.json">
                                            <thead>
                                            <tr>
                                                <th>Codigo</th>
                                                <th>Nombre</th>
                                                <th>estado</th>
                                                <th>rol</th>
                                                <th>Acción</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($delegados as $val)
                                                <tr>
                                                    <td>{{$val->Codigo}}</td>
                                                    <td>{{$val->dataDocente[0]->nombre}} {{$val->dataDocente[0]->apellidoP}} {{$val->dataDocente[0]->apellidoM}}</td>
                                                    <td>{{$val->estado}}</td>
                                                    <td>{{$val->rol}}</td>
                                                    <td>
                                                        <a class="label label-primary" href="{{URL::to('delegadoedit'.$val->dni)}}">
                                                            <span class="glyphicon glyphicon-edit">&nbsp;Edit</span>
                                                        </a><br>

                                                        <a class="label label-danger" href="{{URL::to('delegado/'.$val->dni.'/delete/.html')}}">
                                                            <span class="glyphicon glyphicon-trash">&nbsp;Delete</span>
                                                        </a>
                                                    </td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                        @endif
                                            <div class="form-group ">
                                                {{Form::label('lbldocente','Nombre:')}}
                                                {{Form::text('Nombre',Input::old('docenteauto'),['class'=>'form-control','placeholder'=>'ingrese el nombre del integrante','id'=>'docenteauto'])}}
                                            </div>
                                            <div class="form-group">
                                                {{Form::label('lblrol','rol:')}}
                                                <div class="form-control col-md-1">
                                                {{Form::select('rol',array('delegado' => 'delegado', 'codelegado' => 'codelegado'),['class'=>'form-control ui-selectable'])}}
                                                </div>
                                            </div>

                                    </div>
                                </div>

                            </div>

                        <!-- END CONTENIDO DEL FORMULARIO -->
                        </div>

                        <div class="panel-footer">
                            <div class="form-group">
                                {{ Form::submit('Crear Cuenta',['class' => 'btn btn-primary margin btn-lg btn-block'])}}
                            </div>
                        </div>

                     {{ Form::close()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
@section ('scrips')

                <script src="{{asset('/js/bootstrap-table.js')}}"></script>
                <script src="{{asset('/js/jquery-ui/jquery-ui.js')}}"></script>
                <script>
                    $(function() {
                        $("#docenteauto").autocomplete({
                            source: "../autodocente",
                            minLength: 1,
                            select: function( event, ui ) {
                                $('#response').val(ui.item.id);
                            }
                        });
                    });
                </script>

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