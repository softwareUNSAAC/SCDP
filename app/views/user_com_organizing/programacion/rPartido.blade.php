@extends('_templates.apptemp')


@section('estilos')

    <link href="{{asset('/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet">
    <style>
        .table-condensed{
            background-color: #2B2B2B;
        }
    </style>
@stop
@section('rutanavegacion')        
       
	   
@stop

@section('contenido')

    <?php
    $users = DB::table('tescenario')->get();
    $arr=  array();
    foreach($users as $value)
    {
        $arr[$value->codEscenario]=$value->nombre." ".$value->lugar;

    }
    $arr1=  array();

    $arr1["clima"]="clima";
    $arr1["documento"]="documento";
    $arr1["agresion"]="agresion";

    $aux=DB::table('tpartido')
        ->join('tprogramacion', 'tpartido.codPartido', '=', 'tprogramacion.codPartido')
        ->select('tpartido.horaInicio as inicio', 'tprogramacion.diaPartido as fecha')
        ->where( 'tprogramacion.actual', '=', '1')->where('tpartido.codPartido', '=', $partido->codPartido)
        ->first();
    echo $aux->inicio
    ?>
    <div class="row col-lg-12">
        <div class="col-lg-12 col-no-gutter">
            <div class="panel panel-primary">
                <div class="panel-heading"><span class="glyphicon glyphicon-info-sign"></span> Programacion de partido: {{Programacion::find($codprogramacion)->nroPartido}}</div>
                <div class="panel-body">
                    <strong class="primary-font">partido: </strong><span class="text-primary">{{Equipo::find(Fixture::find($codfixture)->codEquipo1)->nombre. " vs " .Equipo::find(Fixture::find($codfixture)->codEquipo2)->nombre }}</span><br>
                    <strong class="primary-font">fecha de partido: <span class="text-primary">{{ $aux->fecha}}</span></strong><br>
                    <strong class="primary-font">hora programada: <span class="text-primary">{{ $aux->inicio}}</span></strong>
                </div>

            </div>
        </div>
    </div>
    <br>
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">reprogramaciom</div>

            @include('alerts.allerrors')
            @include('alerts.errors')
                <div class="panel-body">
                    <div class="col-md-6">
                      {{ Form::open(array('url' => '/editreprogramacion/'.$codprogramacion,'method' => 'post', 'files' => true, 'class' => 'form-horizontal')) }}


                        {{Form::hidden('fecha',$fecha)}}
                        {{Form::hidden('partido',$partido->codPartido)}}
                        {{Form::hidden('codfixture',$codfixture)}}
                            <div class="form-group">
                                <label>Dia del Partido </label>
                                <input  class="form-control datepicker" placeholder="sabado" name="Dia_partido" required>
                            </div>
                        
                            <div class="form-group">
                                <label>hora: </label>
                                <input   type="time" class="form-control datepicker1"  placeholder="sabado" name="nuevaHora" min="08:30:00">
                            </div>
                            <div class="form-group">
                                {{Form::label('lblescenario','Razon')}}
                                {{Form::select('Razon',$arr1,$arr1["agresion"],['class'=>'form-control','placeholder'=>'ingrese escenario','id'=>'autoescenario'])}}
                            </div>

                            <div class="form-group" >
                                {{Form::label('lblescenario','Escenario')}}
                                {{Form::select('escenario',$arr,$arr["ESC0001"],['class'=>'form-control','placeholder'=>'ingrese escenario','id'=>'autoescenario'])}}
                            </div>
                        <div class="form-group">
                            <label> observaciones</label>
                            {{ Form::textarea('obser',"",array("class"=>"form-control","rows"=>"4", "cols"=>"52")) }}
                            <span class="help-block">{{ $errors->first('obser') }}</span>
                        </div>

                            <button type="submit" class="btn btn-primary">Guardar</button>
                            <button type="reset" class="btn btn-default">Limpiar</button>
                        {{ Form::close() }}
                     </div>
                </div>
        </div>
    </div>
</div>

@stop
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

@stop
