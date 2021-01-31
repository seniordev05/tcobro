@extends('layouts.master')
@section('title')
Credidata | Reporte de prestamos desembolsados
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">
        Prestamos desembolsados desde
        <?php
        $fecha_inicial = $start_date;
        $timestamp = strtotime($fecha_inicial);
        $date_inicial = date("d-m-Y", $timestamp);
    ?>
        <?php
        $fecha_final = $end_date;
        $timestamp = strtotime($fecha_final);
        $date_final = date("d-m-Y", $timestamp);
    ?>
        @if(!empty($date_inicial)):<b>{{$date_inicial}}</b> hasta <b>{{$date_final}}</b>
        @endif
      </h2>

      <div class="heading-elements">

      </div>
    </div>

    <div class="panel-body hidden-print">
      {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form'))
      !!}
      <div class="row">
        <div class="col-md-4">          
          {!! Form::label('start_date','Fecha inicial',array('class'=>'')) !!}
          {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
        </div>
        <div class="col-md-4">
          Fecha final
          {!! Form::label('end_date','Fecha final',array('class'=>'')) !!}
          {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
        </div>
        <div class="col-md-4">
          {!! Form::label('loan_product_id',trans_choice('general.product',1),array('class'=>'')) !!}
          {!! Form::select('loan_product_id',$loan_products,$loan_product_id, array('class' => 'form-control
          select2','required'=>'required')) !!}
        </div>
      </div>
      <br>
      
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
            <button type="submit" class="btn btn-success">{{trans_choice('general.search',1)}}!
            </button>
            <a href="{{Request::url()}}" class="btn btn-danger">{{trans_choice('general.reset',1)}}!</a>

            <div class="btn-group">
              <button type="button" class="btn dropdown-toggle legitRipple"
                data-toggle="dropdown">{{trans_choice('general.download',1)}} {{trans_choice('general.report',1)}}
                </button>
              <ul class="dropdown-menu dropdown-menu-right">
                <!---<li>
                                    <a href="{{url('report/loan_report/disbursed_loans/pdf?start_date='.$start_date.'&end_date='.$end_date."&loan_product_id=".$user_id)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.pdf',1)}}
                                                                                
                                        </a></li>--->
                <li>
                  <a href="{{url('report/loan_report/disbursed_loans/excel?start_date='.$start_date.'&end_date='.$end_date.'&loan_product_id='.$loan_product_id)}}"
                    target="_blank" style="font-size: 13px; margin-top: 5px; padding: 0 10px;"><i class="icon-file-excel"></i> <span style="position: relative; top: -6px;">{{trans_choice('general.download',1)}}
                    {{trans_choice('general.to',1)}} {{trans_choice('general.excel',1)}}</span>
                  </a>
                </li>
                <!---<li>
                                    <a href="{{url('report/loan_report/disbursed_loans/csv?start_date='.$start_date.'&end_date='.$end_date."&loan_product_id=".$user_id)}}"
                                       target="_blank"><i
                                                class="icon-download"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.csv',1)}}
                                    </a></li>--->
              </ul>
            </div>

          </div>
        </div>
      </div>
      {!! Form::close() !!}

    </div>
    <!-- /.panel-body -->

  </div>

  <!-- /.box -->
  @if(!empty($start_date))
  <div class="card-body">
    <div class="panel-body table-responsive no-padding">

      <table id="order-listing" class="table">
        <thead>
          <tr>
            <th>#</th>
            <th>{{trans_choice('general.borrower',1)}}</th>
            <th>{{trans_choice('general.product',1)}}</th>
            <th>Estatus</th>
            <th>Desembolsado</th>
            <th>Vencimiento</th>
            <th>Capital</th>
            <th>Interes</th>
            <th>Ajuste</th>
            <th>Penalidad</th>
            <th>Total</th>
            <th>Pagado</th>
            <th>Balance</th>
          </tr>
        </thead>
        <tbody>
          <?php
                    $total_outstanding = 0;
                    $total_due = 0;
                    $total_payments = 0;
                    $total_principal = 0;
                    $total_interest = 0;
                    $total_fees = 0;
                    $total_penalty = 0;
                    $total_amount = 0;
                    ?>
          @foreach($data as $key)
          <?php
                        $loan_due_items = \App\Helpers\GeneralHelper::loan_due_items($key->id);
                        $loan_paid_items = \App\Helpers\GeneralHelper::loan_paid_items($key->id);
                        $due = $loan_due_items["principal"] + $loan_due_items["interest"] + $loan_due_items["fees"] + $loan_due_items["penalty"];
                        $payments = $loan_paid_items["principal"] + $loan_paid_items["interest"] + $loan_paid_items["fees"] + $loan_paid_items["penalty"];
                        $balance = $due - $payments;
                        $principal = $loan_due_items["principal"];
                        $interest = $loan_due_items["interest"];
                        $fees = $loan_due_items["fees"];
                        $penalty = $loan_due_items["penalty"];

                        $total_outstanding = $total_outstanding + $balance;
                        $total_due = $total_due + $due;
                        $total_principal = $total_principal + $principal;
                        $total_interest = $total_interest + $interest;
                        $total_fees = $total_fees + $fees;
                        $total_penalty = $total_penalty + $penalty;
                        $total_payments = $total_payments + $payments;



                        //select appropriate schedules


                        ?>

          <tr>
            <td><a href="{{url('loan/'.$key->id.'/show')}}">{{$key->id}}</a></td>
            <td>
              @if(!empty($key->borrower))
              <a href="{{url('borrower/'.$key->borrower_id.'/show')}}">{{$key->borrower->first_name}}
                {{$key->borrower->last_name}}</a>
              @endif
            </td>
            <td>
              @if(!empty($key->loan_product))
              {{$key->loan_product->name}}
              @endif
            </td>
            <td>
              @if($key->status=='pending')
              <span class="label label-warning">Pendiente de aprobacion}</span>
              @endif
              @if($key->status=='approved')
              <span class="label label-warning">Aprobado</span>
              @endif
              @if($key->status=='disbursed')
              <span class="label label-info">Activo</span>
              @endif
              @if($key->status=='declined')
              <span class="label label-danger">Declinado</span>
              @endif
              @if($key->status=='withdrawn')
              <span class="label label-danger">{{trans_choice('general.withdrawn',1)}}</span>
              @endif
              @if($key->status=='written_off')
              <span class="label label-danger">Castigado</span>
              @endif
              @if($key->status=='closed')
              <span class="label label-success">Cancelado</span>
              @endif
              @if($key->status=='pending_reschedule')
              <span class="label label-warning">{{trans_choice('general.pending',1)}}
                {{trans_choice('general.reschedule',1)}}</span>
              @endif
              @if($key->status=='rescheduled')
              <span class="label label-info">{{trans_choice('general.rescheduled',1)}}</span>
              @endif
            </td>
            <td>
              <?php
                                $fecha_desembolso = $key->release_date;
                                $timestamp = strtotime($fecha_desembolso);
                                $date_desembolso = date("d-m-Y", $timestamp);
                            ?>
              {{$date_desembolso}}</td>
            <td>
              <?php
                                $fecha_vencimiento = $key->maturity_date;
                                $timestamp = strtotime($fecha_vencimiento);
                                $date_vencimiento = date("d-m-Y", $timestamp);
                            ?>
              {{$date_vencimiento}}
            </td>
            <td>{{number_format($principal,2)}}</td>
            <td>{{number_format($interest,2)}}</td>
            <td>{{number_format($fees,2)}}</td>
            <td>{{number_format($penalty,2)}}</td>
            <td>{{number_format($due,2)}}</td>
            <td>{{number_format($payments,2)}}</td>
            <td>{{number_format($balance,2)}}</td>
          </tr>
          @endforeach
        </tbody>
        <tfoot>
          <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>{{number_format($total_principal,2)}}</th>
            <th>{{number_format($total_interest,2)}}</th>
            <th>{{number_format($total_fees,2)}}</th>
            <th>{{number_format($total_penalty,2)}}</th>
            <th>{{number_format($total_due,2)}}</th>
            <th>{{number_format($total_payments,2)}}</th>
            <th>{{number_format($total_outstanding,2)}}</th>

          </tr>
        </tfoot>
      </table>
    </div>
  </div>
  <script>
  $(document).ready(function() {
    $("body").addClass('sidebar-xs');
  });
  </script>
  @endif
</div>
@endsection
@section('footer-scripts')

@endsection