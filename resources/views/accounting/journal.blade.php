@extends('layouts.master')
@section('title')
Tcobro web | Diario general
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h3 class="panel-title">
        
        Diario general
        <!---{{trans_choice('general.journal',1)}} {{trans_choice('general.entry',2)}}
        @if(!empty($start_date))
        for period: <b>{{$start_date}} to {{$end_date}}</b>
        @endif--->
      </h3>

      <div class="heading-elements">
      </div>
    </div>
    <div class="panel-body hidden-print">
      {!! Form::open(array('url' => Request::url(), 'method' => 'post','class'=>'form-horizontal', 'name' => 'form'))
      !!}
   <div class="row">      
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center" style="color:#22ae60;"><strong>Inicial *</strong></label>
            <div class="col-sm-8">
          {!! Form::date('start_date',$start_date, array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Final *</strong></label>
            <div class="col-sm-8">
          {!! Form::date('end_date',$end_date, array('class' => 'form-control date-picker',
          'placeholder'=>"",'required'=>'required')) !!}
            </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="form-group row">
            <label class="col-sm-3 col-form-label" align="center"  style="color:#22ae60;"><strong>Cuenta *</strong></label>
            <div class="col-sm-8">
          {!! Form::select('account_id',$chart_of_accounts,$account_id, array('class' => 'form-control select2',
          'placeholder'=>trans_choice('general.select',1),'required'=>'required')) !!}
        </div>
      </div>
     </div>
    </div> 
      <div class="panel-body">
        <div class="row">
          <div class="col-md-12">
          <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Buscar</button>  
            <!---<a href="{{Request::url()}}" class="btn btn-danger">{{trans_choice('general.reset',1)}}!</a>--->
          </div>
        </div>
      </div>
      {!! Form::close() !!}
    </div>
    <!-- /.panel-body -->
  </div>
</div>
<!-- /.box -->
<br>
@if(!empty($start_date))
<div class="card">
  <div class="card-body">
    <div class="panel-body ">
      <div class="table-responsive">
        <table id="data-table" class="table table-striped table-condensed">
          <thead>
            <tr>
              <th>#</th>
              <th>{{trans_choice('general.transaction',1)}} {{trans_choice('general.id',1)}}</th>
              <th>{{trans_choice('general.transaction',1)}} {{trans_choice('general.type',1)}}</th>
              <th>{{trans_choice('general.date',1)}}</th>
              <th>{{trans_choice('general.account',1)}}</th>
              <th>{{trans_choice('general.debit',1)}}</th>
              <th>{{trans_choice('general.credit',1)}}</th>
            </tr>
          </thead>
          <tbody>
            @foreach($data as $key)
            <tr>
              <td>{{ $key->id }}</td>
              <td>{{ $key->reference }}</td>
              <td>
                @if($key->transaction_type=='disbursement')
                {{trans_choice('general.disbursement',1)}}
                @endif
                @if($key->transaction_type=='accrual')
                {{trans_choice('general.accrual',1)}}
                @endif
                @if($key->transaction_type=='deposit')
                {{trans_choice('general.deposit',1)}}
                @endif
                @if($key->transaction_type=='withdrawal')
                {{trans_choice('general.withdrawal',1)}}
                @endif
                @if($key->transaction_type=='manual_entry')
                {{trans_choice('general.manual_entry',2)}}
                @endif
                @if($key->transaction_type=='pay_charge')
                {{trans_choice('general.pay',1)}} {{trans_choice('general.charge',1)}}
                @endif
                @if($key->transaction_type=='transfer_fund')
                {{trans_choice('general.transfer_fund',1)}} {{trans_choice('general.charge',2)}}
                @endif
                @if($key->transaction_type=='expense')
                {{trans_choice('general.expense',1)}}
                @endif
                @if($key->transaction_type=='payroll')
                {{trans_choice('general.payroll',1)}}
                @endif
                @if($key->transaction_type=='income')
                {{trans_choice('general.income',1)}}
                @endif
                @if($key->transaction_type=='penalty')
                {{trans_choice('general.penalty',1)}}
                @endif
                @if($key->transaction_type=='fee')
                {{trans_choice('general.fee',1)}}
                @endif
                @if($key->transaction_type=='close_write_off')
                {{trans_choice('general.write',1)}} {{trans_choice('general.waiver',2)}}
                @endif
                @if($key->transaction_type=='repayment_recovery')
                {{trans_choice('general.repayment',1)}}
                @endif
                @if($key->transaction_type=='repayment')
                {{trans_choice('general.repayment',1)}}
                @endif
                @if($key->transaction_type=='interest_accrual')
                {{trans_choice('general.interest',1)}} {{trans_choice('general.accrual',1)}}
                @endif
                @if($key->transaction_type=='fee_accrual')
                {{trans_choice('general.fee',1)}} {{trans_choice('general.accrual',1)}}
                @endif
              </td>
              <td>{{ $key->date }}</td>
              <td>
                @if(!empty($key->chart))
                {{ $key->chart->name }}
                @endif
              </td>
              <td>${{ number_format($key->debit,2) }}</td>
              <td>${{ number_format($key->credit,2) }}</td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- /.panel-body -->
  </div>
</div>
@endif
@endsection
@section('footer-scripts')
<script>
$('#data-table').DataTable({
  "order": [
    [0, "asc"]
  ],
  "columnDefs": [{
    "orderable": false,
    "targets": []
  }],
  "language": {
    "lengthMenu": "{{ trans('general.lengthMenu') }}",
    "zeroRecords": "{{ trans('general.zeroRecords') }}",
    "info": "{{ trans('general.info') }}",
    "infoEmpty": "{{ trans('general.infoEmpty') }}",
    "search": "{{ trans('general.search') }}",
    "infoFiltered": "{{ trans('general.infoFiltered') }}",
    "paginate": {
      "first": "{{ trans('general.first') }}",
      "last": "{{ trans('general.last') }}",
      "next": "{{ trans('general.next') }}",
      "previous": "{{ trans('general.previous') }}"
    }
  },
  responsive: false
});
</script>
@endsection