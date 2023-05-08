@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('title')
    اضافة شكوى
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='tickets') }}">الشكاوى</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                اضافة شكوى </span>
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
              <div class="card-body">

                  <form  action="{{ route('tickets.store') }}" method="post" autocomplete="off">
                      @csrf
                      <div class="d-flex justify-content-center my-2">
                        <h1>اضافة شكوى</h1>
                      </div>

                      <div class="row">
                        <div class="form-group col-3">
                          <label>رقم شكوى مسبق ان وجد</label>
                          <input type="number" name="parent_id" class="form-control">
                        </div>
                        <div class="form-group col-3">
                          <label>التاريخ</label>
                          <input type="date" name="date" class="form-control">
                        </div>
                        <div class="form-group col-3">
                          <label>النوع</label>
                          <select class="form-control" name="ticket_type">
                            <option value="" selected disabled>اختر النوع</option>
                            <option value="invoice">اصلاح بفاتورة</option>
                            <option value="warranty">بالضمان</option>
                            <option value="other">اخرى</option>
                          </select>
                        </div>
                        <div class="form-group col-3">
                          <label>العميل</label>
                          <select class="form-control select2"  name="client_id">
                            <option value="" selected disabled>اختر العميل</option>
                            @foreach($clients as $client)
                              <option value="{{$client->id}}">{{$client->name}}</option>
                              @foreach($client->accounts as $subClient)
                                <option value="{{$subClient->id}}">{{$subClient->name}}</option>
                              @endforeach
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label for="employees">القائمين على الشكوي</label>
                          <select class="form-control select2" multiple="multiple" name="employees[]" id="employees">
                            @foreach($employees as $id => $employee)
                              <option value="{{$id}}">{{$employee}}</option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label>العنوان</label>
                          <textarea name="address" class="form-control"></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label>ارشادات المواصلات ينصح اتباعها</label>
                          <textarea name="recommended_path" class="form-control"></textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label>تفاصيل إضافية</label>
                          <textarea name="details" class="form-control"></textarea>
                        </div>
                      </div>

                      <div class="row">
                        <button type="submit" class="btn btn-primary w-100 mt-2">اضافة الشكوى</button>
                      </div>
                    </form>
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

  <script>
    $(document).ready(function(){

        $('#client_id').change(function(){
          var client_id = this.value;

          $.ajax({ 
            url: '/get-client-invoicesProducts/'+client_id,
            type: 'get'
          }).done(function(data) {
            $('#productsTable').html(data);
          }).fail(function() {
            console.log('Failed');
          });

          $.ajax({ 
            url: '/get-client-invoices/'+client_id,
            type: 'get'
          }).done(function(data) {
            $('#invoice_id').empty();
            $('#invoice_id').append('<option disabled selected>'+ "اختر الفاتورة" + '</option>');
            $.each(data, function(key, value) {
              $('#invoice_id').append('<option value="' + value + '">' + value + '</option>');
            });
          }).fail(function() {
            console.log('Failed');
          });
        });

        $('#invoice_id').change(function(){
          let invoice_id = this.value;
          var client_id  = $("#client_id").val();
          $.ajax({ 
            url: '/get-client-invoicesProducts/'+client_id+'/'+invoice_id,
            type: 'get'
          }).done(function(data) {
            $('#productsTable').html(data);
          }).fail(function() {
            console.log('Failed');
          });
        });

        $('#in_isurance').click(function(){
          console.log('dsds');

          $('.is_in_isurance').prop( "checked", true );
        });

        $('#out_isurance').click(function(){
          console.log('dsds');
          $('.is_in_isurance').prop( "checked", false );
        });
    });

  </script>
    
  <script>$(".select2").select2({placeholder:"Choose product",theme: "classic"});</script>
  <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
