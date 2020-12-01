@extends('layouts.master')
@section('title'){{trans_choice('general.add',1)}} {{trans_choice('general.chart_of_account',1)}}
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h3>{{trans_choice('general.add',1)}} {{trans_choice('general.chart_of_account',1)}}</h3>

      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('chart_of_account/store'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
    <div class="panel-body">
      <div class="form-group">
        {!! Form::label('name',trans_choice('general.name',1),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
          {!! Form::text('name',null, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('gl_code',trans_choice('general.gl_code',1),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
          {!! Form::text('gl_code',null, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('account_type',trans_choice('general.type',1),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
          {!!
          Form::select('account_type',['expense'=>trans_choice('general.expense',1),'asset'=>trans_choice('general.asset',1),'equity'=>trans_choice('general.equity',1),'liability'=>trans_choice('general.liability',1),'income'=>trans_choice('general.income',1)],'expense',
          array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
        </div>
      </div>
      <div class="form-group">
        {!! Form::label('notes',trans_choice('general.note',2),array('class'=>'col-sm-3 control-label')) !!}
        <div class="col-sm-9">
          {!! Form::textarea('notes',null, array('class' => 'form-control', 'rows'=>"4")) !!}
        </div>
      </div>

    </div>
    <!-- /.panel-body -->
    <div class="panel-footer">
      <div class="heading-elements">
        <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
        <a class="btn btn-secondary" style="margin-left: 11px;" href="{{url('chart_of_account/data')}}">Cancelar</a>
      </div>
    </div>
    {!! Form::close() !!}
  </div>
</div>
<!-- /.box -->
@endsection