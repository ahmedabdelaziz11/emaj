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
                    <table class="table table-striped table-bordered col-8">
                        <thead>
                            <tr>
                                <th>العميل</th>
                                <th>المنتج</th>
                                <th>متلقي الطلب</th>
                                <th>تاريخ الطلب</th>
                                <th>حالة الطلب</th>
                                <th>العنوان</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>{{ $ticket->client->name }}</td>
                                <td>{{ $ticket->invoiceProduct->product->name }}</td>
                                <td>{{ $ticket->client->name }}</td>
                                <td>{{ $ticket->date }}</td>
                                <td>{{ $ticket->state }}</td>
                                <td>{{ $ticket->address }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        تاريخ طلب الإصلاح
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <div class="table table-striped table-bordered col-8">
                <tbody>
                    @foreach ($ticketCollection as $item)
                        tr
                    @endforeach
                </tbody>
            </div>
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
