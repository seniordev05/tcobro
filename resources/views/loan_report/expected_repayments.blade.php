@extends('layouts.master')
@section('title')
CrediData | Reporte Cuadre Diario
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">
        Rango de fecha
        @if(!empty($start_date))
        desde: <b>{{$start_date}}</b> hasta <b>{{$end_date}}</b>
        @endif
      </h2>

      <div class="heading-elements">

      </div>
    </div>
    <div class="panel-body hidden-print">
      <!---<h4 class="">{{trans_choice('general.date',1)}} {{trans_choice('general.range',1)}}</h4>--->
      {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form'))
      !!}
      <div class="row">
        <div class="col-md-2 text-center">
          {!! Form::date('start_date',date("Y-m-d"), array('class' => 'form-control date-picker', 'placeholder'=>"Fecha
          inicial",'required'=>'required')) !!}
        </div>
        <div class="col-md-1  text-center" style="padding-top: 15px;">
          al
        </div>
        <div class="col-md-2 text-center">
          {!! Form::date('end_date',date("Y-m-d"), array('class' => 'form-control date-picker', 'placeholder'=>"Fecha
          Final",'required'=>'required')) !!}
        </div>
        <div class="col-md-1 text-center">
          <button type="submit" class="btn btn-success">{{trans_choice('general.search',1)}}
          </button>
        </div>
      </div>
      <!---<div class="panel-body">
                <div class="row">
                    <div class="col-xs-12">
                        <button type="submit" class="btn btn-success">{{trans_choice('general.search',1)}}
                        </button>


                        <a href="{{Request::url()}}"
                           class="btn btn-danger">{{trans_choice('general.reset',1)}}!</a>

                        <div class="btn-group">
                            <button type="button" class="btn bg-blue dropdown-toggle legitRipple"
                                    data-toggle="dropdown">{{trans_choice('general.download',1)}} {{trans_choice('general.report',1)}}
                                <span class="caret"></span></button>
                            <ul class="dropdown-menu dropdown-menu-right">
                            <li>
                                <a href="{{url('report/loan_report/expected_repayments/excel?start_date='.$start_date.'&end_date='.$end_date)}}"
                                       target="_blank"><i
                                                class="icon-file-excel"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.excel',1)}}
                            </a></li>
                            </ul>
                        </div>

                    </div>
                </div>
            </div>--->
      {!! Form::close() !!}

    </div>
    <!-- /.panel-body -->

  </div>

  <!-- /.box -->

  @if(!empty($start_date))

  <div class="card-body">
    <div class="panel-body table-responsive no-padding">

      <?php      
        $total_principals = 0;
        $total_interests = 0;
        $total_feess = 0;
        $total_penaltys = 0;
        $totla_totals = 0;
        $totla_counts = 0;
    ?>

      <table class="table table-bordered table-condensed table-hover">
        <thead>
          <tr>
            <th class="bg-green">Usuario</th>
            <th class="bg-green">Ruta</th>
            <th class="bg-green">Cantidad</th>
            <th class="bg-primary">
              <center>Capital</center>
            </th>
            <th class="bg-primary">
              <center>Interes</center>
            </th>
            <th class="bg-primary">
              <center>Ajuste</center>
            </th>
            <th class="bg-primary">
              <center>Mora</center>
            </th>
            <th class="bg-green">
              <center>Total</center>
            </th>
          </tr>
        </thead>

        <tbody>
          @foreach($expect_report as $key)
          <?php                       
            $total_principals = $total_principals + $key['principal'];
            $total_interests = $total_interests + $key['interest'];
            $total_feess = $total_feess + $key['fees'];
            $total_penaltys = $total_penaltys + $key['penalty'];
            $totla_totals = $totla_totals + $key['total'];
            $totla_counts = $totla_counts + $key['count'];
        ?>

          <tr>
            <td>{{$key['user']}}</td>
            <td>{{$key['route']}}</td>
            <td>
              <center>{{$key['count']}}</center>
            </td>
            <td>
              <center>{{number_format((float)$key['principal'],2)}}</center>
            </td>
            <td>
              <center>{{number_format((float)$key['interest'],2)}}</center>
            </td>
            <td>
              <center>{{number_format((float)$key['fees'],2)}}</center>
            </td>
            <td>
              <center>{{number_format((float)$key['penalty'],2)}}</center>
            </td>
            <td>
              <center>{{number_format((float)$key['total'],2)}}</center>
            </td>
          </tr>
          @endforeach
        </tbody>

        <tfoot>
          <tr>
            <td colspan="2" class="bg-green"><b>Total</b></td>
            <td><b>
                <center>{{$totla_counts}}</center>
              </b></td>
            <td><b>
                <center>{{number_format($total_principals,2)}}</center>
              </b></td>
            <td><b>
                <center>{{number_format($total_interests,2)}}</center>
              </b></td>
            <td><b>
                <center>{{number_format($total_feess,2)}}</center>
              </b></td>
            <td><b>
                <center>{{number_format($total_penaltys,2)}}</center>
              </b></td>
            <td><b>
                <center>{{number_format($totla_totals,2)}}</center>
              </b></td>
          </tr>
        </tfoot>

      </table>
    </div>
  </div>
  @endif
</div>
@endsection
@section('footer-scripts')

@endsection