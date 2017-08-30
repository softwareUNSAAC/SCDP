@extends('_templates.apptemp')

@section('titulo')
    @lang('Varapp.nombre_sistema_mediano')
@stop

@section('rutanavegacion')
	<li><a href="{{ URL::to('/campeonato/listar');}}"><span class="glyphicon glyphicon-book"></span></a></li>
	<li>Nuevo Campeonato</li>
@stop

@section('nombrevista')
    @lang('Nuevo campeonato')

@stop

@section('contenido')
    <!-- BEGIN PARA MANEJO DE ERRORES -->
    @include('alerts.allerrors')
    @include('alerts.errors')
    <?php
    $users = Comision::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->first();

    $user=substr($users->codCom_Org,3,7);
    $tmp=substr($user,0,1);

    while($tmp=="0")
        {

            $user=substr($user,1,strlen($user)-1);
            $tmp=substr($user,0,1);
        }

    $numero=(int)$user;
    $cadena= "CAM".$numero."1";
    date_default_timezone_set('America/Lima');
    $fecha = date("Y-m-d");

    $flag=2;
    if($campeonato){
    $flag=strcmp($cadena,$campeonato->codCampeonato);
    }
    $nrointegrantess = IntegrantesCO::where('codCom_Org','=',Session::get('user_idcom_orgdor'))->count();

    ?>
    <!-- END PARA MANEJO DE ERRORES -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">Crear Campeonato</div>
                <div class="panel-body">
                    <div class="col-md-6">
                        {{ Form::open(array('url'=>'campeonato/formulario1','autocomplete'=>'off','class'=>'form_horizontal','role'=>'form'))}}

                        <div class="form-group" style="display: none">
                            <label>Codigo </label>
                            <input class="form-control" value="{{$cadena}}" placeholder="Codigo del campeonato" name="Codigo" readonly="readonly" required>
                        </div>
                        @if($flag!=0)
                        <div class="form-group ">
                            <label>Nombre del campeonato</label>
                            <input class="form-control" placeholder="Nombre" name="Nombre" required>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Fecha creacion')}}
                            <input class="form-control" value="{{$fecha}}"  name="Fecha" readonly="readonly" required>

                            <span class="help-block">{{ $errors->first('Fecha') }}</span>
                        </div>
                        @endif
                        {{Form::label('lbl','integratentes de la comision organizadora',array("class"=>"label-primary"))}}


                        <div class="form-group " id="h1">
                            {{Form::label('lbldni','DNI:')}}
                            {{Form::text('dni','',['class'=>'form-control','placeholder'=>'ingrese dni','maxlength'=>'8','minlength'=>'8'])}}

                        </div>
                        <div class="form-group " id="h1">
                            {{Form::label('lbnombre','nombre:')}}
                            {{Form::text('nombre','',['class'=>'form-control','placeholder'=>'ingrese su nombre','maxlength'=>'20'])}}

                        </div>
                        <div class="form-group " id="h1">
                            {{Form::label('lbapellidos','apellidos:')}}
                            {{Form::text('apellidos','',['class'=>'form-control','placeholder'=>'ingrese sus apellidos','maxlength'=>'100'])}}

                        </div>
                        <div class="form-group">
                            <label>Rol</label>
                            <select  class="form-control" name="Rol">
                                <option class="form-control" value="presidente">Presidente</option>
                                <option class="form-control" value="secretario">Secretario</option>
                                <option class="form-control" value="otros">miembro</option>
                            </select>
                        </div>


                        <button type="submit" class="btn btn-primary btn-">Guardar</button>
                        <button type="reset" class="btn btn-default">Limpiar</button>
                        <button type="submit" class="btn btn-danger" onclick="history.back()">Cancelar</button>



                        {{ Form::close() }}
                        <div class="pull-right">

                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="panel panel-info">
                            <div class="panel panel-heading"> lista de integrates</div>
                            @include('alerts.allsuccess')
                            <div class="panel panel-body">
                    <!-- END PARA MANEJO DE ERRORES -->
                                <table data-toggle="table" data-url="tables/data2.json">
                            <thead>
                            <tr>
                                <th>DNI</th>
                                <th>Nombre</th>
                                <th>Rol</th>
                                <th>Acción</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($integrantesall as $val)
                                <tr>
                                    <td>{{ $val->dni}}</td>
                                    <td>{{ $val->nombre." ".$val->apellidos }}</td>
                                    <td>{{ $val->rol}}</td>
                                    <td>
                                        <a class="label label-danger" href="{{URL::to('comision/integrantes/delete/'.$val->dni)}}">
                                            <span class="glyphicon glyphicon-trash">&nbsp;Delete</span>
                                        </a>
                                    </td>
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

    </div>
@stop

@section ('scrips')
    <script src="{{asset('/js/bootstrap-table.js')}}"></script>
@stop

