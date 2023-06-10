@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@livewireStyles
@section('title')
    تقارير طلبات الإصلاح
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">خدمة العملاء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
            تقارير طلبات الإصلاح</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
@if(session()->has('deleted') || count($errors) > 0)
  @if(count($errors) > 0)
      @foreach ($errors->all() as $error)
          <input type="hidden" id="failed[]" name="errors[]" value="{{ $error }}">
      @endforeach
  @endif
  <input type="hidden" id="failed[]" value="{{ Session::get('deleted')}}">

  <script>

      var errors = document.getElementById("failed[]").value;
        window.onload = function() {
            notif({
              msg: errors,
              type: "error"
            })
        }
  </script>
@endif
@if (session()->has('success'))
  <input type="hidden" id="success" value="{{ Session::get('success')}}">
  <script>
      window.onload = function() {
          var success = document.getElementById("success").value;
          notif({    
              msg: success ,
              type: "success"
          })
      }
  </script>
@endif
<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-header">
            @if(count($tickets) > 0)
                <div class="card-title">
                    عدد طلبات الإصلاح بنائا على معطيات التقرير: {{ count($tickets) }}
                </div>
            @endif
            <form name="ticketForm" action="{{ route('tickets.reports') }}">        
            <div class="row">
                <div class="col-md-2">
                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">العميل</label>
                        <select wire:model="client_id" name="client_id" class="form-control">
                            <option value="" selected>اختر عميل</option>
                            @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                @if($client->accounts->count() > 0)
                                @foreach ($client->accounts as $account1)
                                    <option value="{{ $account1->id }}" >{{ $account1->name }}</option>
                                @endforeach
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-md-2">
                    <label for="" class="col-form-label">المنتجات</label>            
                    <select name="product" class="form-control">
                        <option value="" selected>اختر منتج</option>
                        @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->name }}</option>
                            @if($client->accounts->count() > 0)
                            @foreach ($client->accounts as $account1)
                                <option value="{{ $account1->id }}" >{{ $account1->name }}</option>
                            @endforeach
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="" class="col-form-label">الفنيين</label>            
                    <select name="employees[]" class="form-control">
                        <option value="" selected>اختر الفنيين</option>
                        @foreach ($employees as $employee)
                            <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="recipient-name" class="col-form-label">حالة طلب الإصلاح</label>
                    <select  class="form-control" name="state" wire:model="state" >
                        <option value="" selected>اختر الحالة</option>
                        <option value="pending">معطل</option>
                        <option value="in_progress">تحت التنفيذ</option>
                        <option value="closed">تمت</option>
                    </select>
                </div>
                <div class="col-md-2 form-gropu">
                    <label for="recipient-name" class="col-form-label">من تاريخ</label>            
                    <input  class="form-control" name="from_date" type="date" wire:model="from_date"/>
                </div>
                <div class="col-md-2">
                    <label for="recipient-name" class="col-form-label">الى تاريخ</label>            
                    <input  class="form-control" name="to_date" type="date" wire:model="to_date"/>
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-primary w-100">عرض التقرير</button>
            </div>
        </form>
        </div>
        <div class="card-body">
        
            <div class="table-responsive">
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th>رقم طلب الإصلاح</th>
                            <th>التاريخ</th>
                            <th>العميل</th>
                            <th>المنشئ</th>
                            <th>الحالة</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tickets as $x)
                            <tr class="text-center">
                                <td><a href="{{ url('tickets') }}/{{ $x->id }}">{{ $x->id }}</a></td>
                                <td>{{ $x->date }}</td>                     
                                <td>{{ $x->client->name}}</td>                     
                                <td>{{ $x->reporter->name }}</td>        
                                <td>{{ $x->state }}</td>             
                                <td>
                                    <a class="modal-effect btn btn-sm btn-warning" 
                                        href="{{route('tickets.show', $x)}}" title="عرض طلب الإصلاح"> <i class="las la-eye"></i> 
                                    </a>
                                    @if ($x->state != 'تمت')
                                <a class="modal-effect btn btn-sm btn-primary" href="{{ route('create-offer-for-ticket', $x->id) }} title="عرض أسعار"><i class="las la-dollar-sign"></i>
                                </a>
                                <a class="modal-effect btn btn-sm btn-secondary" data-effect="effect-scale"
                                data-id="{{ $x->id }}" data-name="{{ $x->id }}"
                                data-toggle="modal" href="#modaldemo3" title="أمر شغل"><i class="las la-briefcase"></i>
                                </a>
                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-id="{{ $x->id }}" data-name="{{ $x->id }}"
                                        data-toggle="modal" href="#modaldemo2" title="إنهاء طلب الإصلاح"><i class="las la-check"></i>
                                    </a>
                                @endif
                                </td>        
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
                <div class="row d-felx justify-content-center">
                    {{-- {{ $tickets->links('pagination-links') }}  --}}
                </div>                       
            </div>
        </div>
    </div>
</div>
@endsection
@secion('js')
    <script>
const form = document.querySelector('form[name="ticketForm"]');
const selectFields = form.querySelectorAll('select');

selectFields.forEach((field) => {
  field.disabled = true;
  field.addEventListener('change', () => {
    selectFields.forEach((field) => {
      field.disabled = false;
    });
  });
});
    </script>
@endsection