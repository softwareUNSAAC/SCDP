@extends('_templates.apptemp')

@section('titulo')
@stop
    @lang('Varapp.nombre_sistema_mediano')

@section('estilos')
    <link href="{{asset('/js/jquery-ui/jquery-ui.css')}}" rel="stylesheet">
@stop

@section('rutanavegacion')
    <li><a href="{{ URL::to( '/campeonato/detail/'.$codcampeonato);}}"><span > detalle campenato</span></a></li>
    <li><a href="{{ URL::to( 'campeonato/'.$codcampeonato.'/miembro.html'.$codcampeonato);}}"><span > lista de miembros</span></a></li>

@stop

@section('nombrevista')
    @lang('comison de justicia')
@stop

@section('contenido')
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Ingrese los datos del nuevo integrate</div>
                <div class="panel-body">

                    <div class="col-xs-7 col-md-7 col-sm-8">
                        {{ Form::open(array('url'=>'campeonato/'.$codcampeonato.'/miembro/add.html','autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}

                        <!-- BEGIN PARA MANEJO DE ERRORES -->
                        @if (count($errors) > 0)
                            <div class="alert bg-danger" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <ul class="error_list">
                                    @foreach ($errors->all() as $error)
                                        <li>
                                            <span class="glyphicon glyphicon-exclamation-sign"></span>
                                            {{ $error }}
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif
                        <!-- END PARA MANEJO DE ERRORES -->

                            <!-- BEGIN CONTENIDO DEL FORMULARIO -->

                            <div class="form-group">
                                {{Form::label('lbldocente','dni:')}}
                                {{Form::text('docente','',['class'=>'form-control','placeholder'=>'ingrese dni','maxlength'=>'8','minlength'=>'8'])}}
                            </div>

                            <div class="form-group">
                                <label>Rol</label>
                                <br>
                                {{Form::select('rol',['Presitente'=>'Presitente','Secretario'=>'Secretario','miembro'=>'miembro'],null,['class'=>'form-control-static label-success'])}}
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input class="form-control" placeholder="ingrese el nombre" name="nombre" required>
                            </div>
                            <div class="form-group">
                                <label>Apellido Paterno</label>
                                <input class="form-control" placeholder="ingrese apellido paterno" name="apellidopaterno" required>
                            </div>
                            <div class="form-group">
                                <label>Apellido Materno</label>
                                <input class="form-control" placeholder="ingrese apellido materno" name="apellidomaterno" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                            <!-- END CONTENIDO DEL FORMULARIO -->


                    </div>
                </div>
                {{ Form::close()}}
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
        $(function() {
            $("#arbitroauto").autocomplete({
                source: "autoarbitro",
                minLength: 1,
                select: function( event, ui ) {
                    $('#response').val(ui.item.id);
                }
            });
        });
    </script>
@stop

@endsection