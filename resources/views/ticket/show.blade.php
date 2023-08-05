@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('title')
    عرض طلب الإصلاح
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='tickets') }}">طلبات الإصلاح</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                عرض تفاصيل طلب الإصلاح </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')

@if(session()->has('failed') || count($errors) > 0)
  @if(count($errors) > 0)
      @foreach ($errors->all() as $error)
          <input type="hidden" id="failed[]" name="errors[]" value="{{ $error }}">
      @endforeach
  @endif
  <input type="hidden" id="failed[]" value="{{ Session::get('failed')}}">

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
    <!-- row opened -->
<div class="row row-sm">
    <div class="col-xl-12">
        <!-- div -->
        <div class="card mg-b-20" id="tabs-style2">
            <div class="card-header">
                بيانات طاب الإصلاح الأساسية
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-bordered col-12">
                        <thead>
                            <tr>
                                <th>العميل</th>
                                {{-- <th>المنتج</th> --}}
                                <th>متلقي الطلب</th>
                                <th>تاريخ الطلب</th>
                                <th>نوع الطلب</th>
                                <th>حالة الطلب</th>
                                <th>العنوان</th>
                                <th>التفاصيل</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $ticket->client->name }}</td>
                                {{-- <td>{{ $ticket->product->name ?? '' }}</td> --}}
                                <td>{{ $ticket->reporter->name }}</td>
                                <td>{{ $ticket->created_at->format('Y-m-d h:i A') }}</td>
                                <td>{{ ($ticket->ticket_type == 'invoice')? 'إصلاح بفاتورة' : 'داخل الضمان' }}</td>
                                <td>{{ $ticket->state }}</td>
                                <td>{{ $ticket->address }}</td>
                                <td>{{ ($ticket->feedback)? : "لم يتم توثيق حالة الطلب بعد" }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="card">
    {{-- card for ticket products --}}
    <div class="card-header">
        المنتجات المرتبطة بالطلب
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered col-12">
                <thead>
                    <tr>
                        <th>المنتج</th>
                        <th>التفاصيل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ticket->products as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->pivot['details'] }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="card">
    <div class="card-header">
        متابعة تاريخ طلب الإصلاح
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped table-bordered col-12 text-center">
                <thead>
                    <tr>
                        <th>تاريخ الحدث</th>
                        <th>نوع الحدث</th>
                        <th>التفاصيل</th>
                    </tr>
                <tbody>
                    @foreach ($ticketCollection as $item)
                    <tr>
                        <td>{{ $item->created_at->format('Y-m-d h:i A') }}</td>
                        @if ($item->getTable() == 'ticket_details')
                            <td>إضافة تفاصيل</td>
                            <td>{{ $item->details }}</td>
                        @elseif ($item->getTable() == 'ticket_logs')
                            <td>{{ $item->state }}</td>
                            <td>{{ $item->action }} | صاحب التحديث: {{ $item->user->name }}</td>
                        @elseif ($item->getTable() == 'ticket_compensation')
                            <td>إضافة تكاليف إلى الطلب</td>
                            <td>{{ $item->compensationType->name }} | قيمتها: {{ $item->amount }}</td>
                        @elseif ($item->getTable() == 'employee_ticket')
                            <td>إضافة فني إلى الطلب</td>
                            <td>{{ $item->employee->name }}</td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        تفاصيل تكلفة طلب الإصلاح
    </div>
    <div class="card-body">
        <dev class="table-reponsive">
            <table class="table table-striped table-bordered col-12">
                <thead class="text-center">
                    <tr>
                        <th>نوع التكلفة</th>
                        <th>القيمة</th>
                        <th>تفاصيل</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($ticket->compensationType as $compensation)
                        <tr>
                            <td>{{ $compensation->name }}</td>
                            <td class="text-center">{{ $compensation->pivot['amount'] }}</td>
                            <td>{{ $compensation->details }}</td>
                        </tr>
                    @endforeach
                    @if ($ticket->invoice)
                    @foreach ($ticket->invoice->prodcuts as $item)
                        <tr>
                            <td>{{ $item->name }}</td>
                            <td class="text-center">{{ $item->pivot['product_Purchasing_price'] }}</td>
                            <td>{{ $item->details }}</td>
                        </tr>
                    @endforeach
                    @endif
                    @foreach ($ticket->ticket_employee_daily_payment as $pivot)
                        <tr>
                            <td>يومية عامل</td>
                            <td class="text-center">{{ $pivot->employee->Salary/30 }}</td>
                            <td>{{ $pivot->employee->name }} / {{ $pivot->date }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </dev>
        <div class="card-footer">
            <h5>تكلفة طلب الصيانة: {{ $ticket->total_compensation }}</h5>
        </div>
    </div>
</div>

          
						
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection

@section('js')
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>    
<script>$(".select2").select2({placeholder:"Choose product",theme: "classic"});</script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
