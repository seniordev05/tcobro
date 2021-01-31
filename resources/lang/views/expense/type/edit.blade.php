@extends('layouts.master')
@section('title')
{{trans_choice('general.edit',1)}} {{trans_choice('general.expense',1)}} {{trans_choice('general.type',1)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h2 class="panel-title">{{trans_choice('general.edit',1)}} {{trans_choice('general.expense',1)}}
        {{trans_choice('general.type',1)}}</h2>

      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('expense/type/'.$expense_type->id.'/update'), 'method' => 'post', 'class' =>
    'form-horizontal')) !!}
    <div class="panel-body">
      <div class="form-group">
        {!! Form::label('name',trans_choice('general.name',1),array('class'=>'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          {!! Form::text('name',$expense_type->name, array('class' => 'form-control',
          'placeholder'=>"",'required'=>'required')) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('account_id',trans_choice('general.account',1),array('class'=>'col-sm-2 control-label')) !!}
        <div class="col-sm-10">
          {!! Form::select('account_id',$chart_expenses,$expense_type->account_id, array('class' =>
          'form-control','required'=>'required')) !!}
        </div>
      </div>
    </div>
    <!-- /.panel-body -->
    <div class="panel-footer">
      <div class="heading-elements">
        <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
<!-- /.box -->
@endsection