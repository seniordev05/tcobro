@extends('layouts.master')
@section('title')
T-Cobro Web | Crear cuenta
@endsection
@section('content')
<div class="card">
  <div class="card-body">
    <div class="panel-heading">
      <h3>Crear cuenta contable</h3>

      <div class="heading-elements">

      </div>
    </div>
    {!! Form::open(array('url' => url('chart_of_account/store'), 'method' => 'post', 'class' => 'form-horizontal')) !!}
    <div class="panel-body">
      
    <div class="row">      
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label"><strong>Cuenta: *</strong></label>
              <div class="col-sm-8">
                {!! Form::text('name',null, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
              </div>
            </div>
          </div>
      
      
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label"><strong>Número: *</strong></label>
              <div class="col-sm-8">
                  {!! Form::number('gl_code',null, array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
              </div>
            </div>
          </div>
    </div>
    
    <div class="row">      
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label"><strong>Categoria: *</strong></label>
              <div class="col-sm-8">
          {!!
          Form::select('account_type',['expense'=>trans_choice('general.expense',1),'asset'=>trans_choice('general.asset',1),'equity'=>trans_choice('general.equity',1),'liability'=>trans_choice('general.liability',1),'income'=>trans_choice('general.income',1)],'expense',
          array('class' => 'form-control', 'placeholder'=>"",'required'=>'required')) !!}
              </div>
            </div>
          </div>
          
          <div class="col-md-4">
            <div class="form-group row">
              <label class="col-sm-3 col-form-label"><strong>Descripcion:</strong></label>
              <div class="col-sm-8">
          {!! Form::text('notes',null, array('class' => 'form-control', 'rows'=>"4")) !!}
              </div>
            </div>
          </div>

    </div>
    
    
    
    </div>
    <!-- /.panel-body -->
    <div class="panel-footer">
    <!---  <div class="heading-elements">
        <button type="submit" class="btn btn-primary pull-right">{{trans_choice('general.save',1)}}</button>
        <a class="btn btn-secondary" style="margin-left: 11px;" href="{{url('chart_of_account/data')}}">Cancelar</a>
      </div>--->
    </div>
          <button style="width:115px;" type="submit" class="btn btn-primary mr-2">Guardar</button>
          <a style="width:115px;" class="btn btn-light" href="{{url('chart_of_account/data')}}">Cancelar</a>    
    {!! Form::close() !!}
  </div>
</div>

<!-- /.box -->
@endsection