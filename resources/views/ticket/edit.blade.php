@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('title')
    تحديث طلب إصلاح
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='tickets') }}">طلبات الإصلاح</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                تحديث طلب إصلاح </span> <a  class="mt-1 tx-13 mr-2 mb-0" href="{{ route('tickets.show', $ticket) }}"> / طلب الإصلاح</a>
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

                  <form  action="{{ route('tickets.update', $ticket) }}" method="POST" autocomplete="off">
                      @csrf
                      <div class="d-flex justify-content-center my-2">
                        <h1>تحديث حالة طلب الإصلاح</h1>
                      </div>

                      <div class="row">
                        {{-- <div class="form-group col-3">
                          <label>رقم طلب إصلاح مسبق ان وجد</label>
                          <input type="number" name="parent_id" class="form-control">
                        </div> --}}
                        <div class="form-group col-3">
                          <label>التاريخ</label>
                          <input required type="date" name="date" class="form-control" value="{{ $ticket->date }}">
                        </div>
                        {{-- <div class="form-group col-3">
                          <label>العميل</label>
                          <select class="form-control select2"  name="client_id" id="client_id">
                            <option value="" selected disabled>اختر العميل</option>
                            @foreach($clients as $client)
                              <option value="{{$client->id}}">{{$client->name}}</option>
                              @foreach($client->accounts as $subClient)
                                <option value="{{$subClient->id}}">{{$subClient->name}}</option>
                              @endforeach
                            @endforeach
                          </select>
                        </div> --}}
                        {{-- <div class="form-group col-3">
                          <label>النوع</label>
                          <select class="form-control" name="ticket_type" id="ticket_type" disabled>
                            <option value="" selected disabled>اختر النوع</option>
                          </select>
                        </div> --}}
                      </div>
                        <div class="form-group">
                        <h5>تكاليف طلب الإصلاح</h5>
                        <div id="compensationsContainer">
                            <div class="row">
                                @if ($ticket->compensationType->count() == 0)
                                  <div  class="col-6">
                                      <label for="compensation_type">نوع التكلفة</label>
                                      <select class="form-control" name="compensation_type[]" id="compensation_type">
                                          <option disabled selected>اختر نوع</option>
                                          @foreach ($compensationTypes as $compensationType)
                                              <option value="{{ $compensationType->id }}">{{ $compensationType->name }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col-6">
                                      <label for="value">قيمة التكلفة</label>
                                      <input class="form-control" name="value[]" id="value" type="number">
                                  </div>
                                @endif

                                @foreach ($ticket->compensationType as $compensation)
                                    <div  class="col-6">
                                      <label for="compensation_type">نوع التكلفة</label>
                                      <select class="form-control" name="compensation_type[]" id="compensation_type">
                                          <option disabled selected>اختر نوع</option>
                                          @foreach ($compensationTypes as $compensationType)
                                              <option value="{{ $compensationType->id }}" @if($compensationType->id == $compensation->id) selected @endif>{{ $compensationType->name }}</option>
                                          @endforeach
                                      </select>
                                  </div>
                                  <div class="col-6">
                                      <label for="value">قيمة التكلفة</label>
                                      <input class="form-control" name="value[]" id="value" value="{{$compensation->pivot['amount']}}" type="number">
                                  </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row m-2">
                            <button type="button" class="btn btn-sm btn-primary" id="addNewCompensation">اضافة تكلفة جديدة</button>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label>العنوان</label>
                          <textarea id="address-textfield" name="address" class="form-control">{{ $ticket->address }}</textarea>
                        </div>
                      </div>
                      <div class="row">
                        <div class="form-group col-12">
                          <label>تفاصيل إضافية</label>
                          <textarea name="details" class="form-control"></textarea>
                        </div>
                      </div>

                      <div class="row">
                        <button type="submit" class="btn btn-primary w-100 mt-2">تحديث</button>
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

        let client_id;
        $('#client_id').change(function(){
          $('#ticket_type').empty();
          $("#ticket_type").attr('disabled', false);
          client_id = this.value;

          $.ajax({ 
            url: '/check-client-insurance/'+client_id,
            type: 'get'
          }).done(function(data) {
            if (data) {
              console.log(true);
              $("#ticket_type").append(`
                <option value="" selected disabled>اختر النوع</option>
                <option value="invoice">اصلاح بفاتورة</option>
                <option value="warranty">بالضمان</option>
              `)
            }else{
              $("#ticket_type").append(`
                <option value="" selected disabled>اختر النوع</option>
                <option value="invoice">اصلاح بفاتورة</option>
              `)
            }
          }).fail(function() {
            console.log('Failed');
          });
        });
 
        $("#ticket_type").change(function(){
          var type = this.value;
          if (type === 'invoice') {
            $.ajax({
              url: '/get-client-invoice-products/'+client_id,
              type: 'get'
            }).done(function(data) {
              $("#products").empty();
              $("#products").append(data)
            }).fail(function() {
              console.log('fail');
            });
          } else if(type === 'warranty') {
            $.ajax({
              url: '/get-client-serials/'+client_id,
              type: 'get'
            }).done(function(data) {
              $("#products").empty();
              $("#products").append(data)
            }).fail(function() {
              console.log('fail');
            });
          }
        });
        $("#addNewCompensation").on('click',function(){
        $("#compensationsContainer").append(`
        <div class="row">
            <div  class="col-4">
                <label for="compensation_type">نوع التكلفة</label>
                <select class="form-control" name="compensation_type[]" id="compensation_type">
                    <option disabled selected>اختر نوع</option>
                    @foreach ($compensationTypes as $compensationType)
                        <option value="{{ $compensationType->id }}">{{ $compensationType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="value">قيمة التكلفة</label>
                <input class="form-control" name="value[]" id="value" type="number">

            </div>
        
        
        `)
    })
    });

  </script>
    
  <script>$(".select2").select2({placeholder:"Choose product",theme: "classic"});</script>
  <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
