@extends('layouts.master')
@section('title')
Credidata | Reporte de pagos recibidos
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">
        {{trans_choice('general.report',1)}} de {{trans_choice('general.repayment',2)}}
        @if(!empty($start_date))
        :<b>{{$start_date}} al {{$end_date}}</b>
        @endif
      </h2>

      <div class="heading-elements">

      </div>
    </div>

    <div class="panel-body hidden-print">
      <h4 class="">{{trans_choice('general.date',1)}} {{trans_choice('general.range',1)}}</h4>
      {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form'))
      !!}
      <div class="row">
        <div class="col-md-3">
          {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker', 'placeholder'=>"From
          Date",'required'=>'required')) !!}
        </div>
        <div class="col-md-1 text-center" style="padding-top: 15px;">
          al
        </div>
        <div class="col-md-3">
          {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker', 'placeholder'=>"To
          Date",'required'=>'required')) !!}
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
                                    <a href="{{url('report/loan_report/repayments_report/pdf?start_date='.$start_date.'&end_date='.$end_date)}}"
                                       target="_blank"><i
                                                class="icon-file-pdf"></i> {{trans_choice('general.download',1)}} {{trans_choice('general.to',1)}} {{trans_choice('general.pdf',1)}}
                                    </a></li>--->
                <li>
                  <a href="{{url('report/loan_report/repayments_report/excel?start_date='.$start_date.'&end_date='.$end_date)}}"
                    target="_blank" style="font-size: 13px; margin-top: 5px; padding: 0 10px;"><i class="icon-file-excel"></i> <span style="position: relative; top: -6px;">{{trans_choice('general.download',1)}}
                    {{trans_choice('general.to',1)}} {{trans_choice('general.excel',1)}}</span>
                  </a>
                </li>
                <!---<li>
                                    <a href="{{url('report/loan_report/repayments_report/csv?start_date='.$start_date.'&end_date='.$end_date)}}"
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
            <th>{{trans_choice('general.id',1)}}</th>
            <th>Nombre de cliente</th>
            <th>Capital</th>
            <th>Interes</th>
            <th>Ajustes</th>
            <th>Mora</th>
            <th class="bg-warning">Sobre_Pago</th>
            <th>Total</th>
            <th>Fecha</th>
            <th>Referencia</th>
            <th>Metodo</th>
          </tr>
        </thead>
        <tbody>
          
          <?php
            $total_principal = 0;
            $total_fees = 0;
            $total_interest = 0;
            $total_penalty = 0;
            $total_total = 0;
            ?>

          @foreach($data as $key)
          <?php
            $principal = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed',0)->where('name', "Principal Repayment")->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
            
            $interest = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed',0)->where('name', "Interest Repayment")->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');

            $fees = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed',0)->where('name', "Fees Repayment")->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');

            $penalty = \App\Models\JournalEntry::where('loan_transaction_id', $key->id)->where('reversed',0)->where('name', "Penalty Repayment")->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');
            
            $total_payment = \App\Models\LoanTransaction::where('id', $key->id)->where('reversed', 0)->where('transaction_type', "repayment")->where('branch_id', Sentinel::getUser()->business_id)->sum('credit');


            $total_principal = $total_principal + $principal;
            $total_interest = $total_interest + $interest;
            $total_fees = $total_fees + $fees;
            $total_penalty = $total_penalty + $penalty;
            $total_total = $total_total + $total_payment;
            ?>

          <tr>
            <td>
              @if(!empty($key->id))
              <a target="_BLANK" href="{{url('loan/transaction/'.$key->id.'/show')}}">{{$key->id}}</a>
              @endif
            </td>
            <td>
              @if(!empty($key->borrower))
              <a href="{{url('borrower/'.$key->borrower_id.'/show')}}">{{$key->borrower->first_name}}
                {{$key->borrower->last_name}}</a>
              @endif
            </td>
            <td>{{number_format($principal,2)}}</td>
            <td>{{number_format($interest,2)}}</td>
            <td>{{number_format($fees,2)}}</td>
            <td>{{number_format($penalty,2)}}</td>
            <td>{{number_format($total_payment-$principal-$interest-$fees-$penalty,2)}}</td>
            <td>{{number_format($total_payment,2)}}</td>
            <td>{{$key->date}}</td>
            <td>{{$key->receipt}}</td>
            <td>
              @if(!empty($key->loan_repayment_method))
              {{$key->loan_repayment_method->name}}
              @endif
            </td>
          </tr>
          @endforeach
        </tbody>

        <tfoot>
          <tr>
            <td></td>
            <td><b>Total</b></td>
            <td><b>{{number_format($total_principal,2)}}</b></td>
            <td><b>{{number_format($total_interest,2)}}</b></td>
            <td><b>{{number_format($total_fees,2)}}</b></td>
            <td><b>{{number_format($total_penalty,2)}}</b></td>
            <td><b>{{number_format($total_total-$total_principal-$total_interest-$total_fees-$total_penalty,2)}}</b>
            </td>
            <td><b>{{number_format($total_total,2)}}</b></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
          </tr>
        </tfoot>
      </table>
    </div>
  </div>
</div>
@endif
@endsection
@section('footer-scripts')

@endsection