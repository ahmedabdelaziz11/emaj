@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection

@section('title')
    اضافة عقد صيانة
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='maintenance-contracts') }}">عقود الصيانة</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                اضافة عقد صيانة </span>
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

                  <form  action="{{ route('maintenance-contracts.store') }}" method="post" autocomplete="off">
                      @csrf
                      <div class="d-flex justify-content-center my-2">
                        <h1>اضافة عقد صيانة</h1>
                      </div>
                      <div class="row">
                        <div class="form-group col-6">
                          <label>العميل</label>
                          <select class="form-control select2 " name="client_id">
                            <option value="" selected disabled>اختر العميل</option>
                            @foreach($clients as $client)
                              <option value="{{$client->id}}">{{$client->name}}</option>
                              @foreach($client->accounts as $subClient)
                                <option value="{{$subClient->id}}">{{$subClient->name}}</option>
                              @endforeach
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-6">
                          <label>العنوان</label>
                          <select class="form-control select2 address" name="address_id">
                            <option value=" ">اختر العنوان</option>
    
                          </select>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-6">
                            <label>تاريخ البدأ</label>
                            <input class="form-control" name="start_date" placeholder="YYYY-MM-DD" type="date"  required>
                        </div>

                        <div class="col-6">
                            <label>تاريخ النهاية</label>
                            <input class="form-control" name="end_date" placeholder="YYYY-MM-DD" type="date" required>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <div class="col-4">
                            <label>عدد الزيارات الدورية</label>
                            <input class="form-control" name="periodic_visits_count" type="number"  required>
                        </div>

                        <div class="col-4">
                            <label>عدد الزيارات الطارئة</label>
                            <input class="form-control" name="emergency_visits_count" type="number" required>
                        </div>

                        
                        <div class="col-4">
                          <label>قيمة العقد</label>
                          <input class="form-control" name="contract_amount" step=".01" type="number" required>
                        </div>
                      </div>
                      <br>
                      <h4>معدات العقد</h4>
                      <div class="row">
                        <div class="form-group col-12">
                          <label>المنتج</label>
                          <select class="form-control select2 allProducts" id="product_id" name="product_id">
                            <option value=" ">اختر المنتج</option>

                          </select>
                        </div>
                      </div>
                      <br>
                      <div class="row">
                        <table class="table table-bordered text-md-nowrap">
                            <thead id="container_header" style="display:none;">
                              <th style=" font-size: 15px;" class="text-center">اسم المعده</th>
                              <th style=" font-size: 15px;" class="text-center">حذف</th>
                            </thead>
                            <tbody id="items_container">
                            </tbody>
                        </table>
                      </div><br>
                      <div class="row">
                        <button type="submit" class="btn btn-primary w-100 mt-2">اضافة عقد الصيانة</button>
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
        $('.address').select2({
            placeholder: 'Enter a parent address',
            ajax: {
                dataType: 'json',
                url: function(params) {
                    return '/get-addresses-select2/' + params.term;
                },
                processResults: function (data, page) {
                    return {
                    results: data || ' '
                    };
                },
            }
        });
        $('.allProducts').select2({
          placeholder: 'Enter a tag',
          ajax: {
              dataType: 'json',
              url: function(params) {
                  return '/get-all-products/' + params.term;
              },
              processResults: function (data, page) {
                return {
                  results: data || ' '
                };
              },
          }
        });

        var items = 0;
        $("#product_id").change(function(){
          items++;
          $("#container_header").show();
          var name = $(this).find(":selected").text();
          var id = $(this).val();
          if(!$("#row"+id).length){
            $("#items_container").append(`
                <tr id="row`+id+`">
                <td class="pt-3"style="font-size:17px;font-weight:bold"><input type="hidden" name="product_ids[]" value="`+id+`" min="1">`+name+`</td>
                <td class="pt-3"><button style="width:100%" type="button" class="btn btn-danger btn-sm rounded-pill ml-3 " id="remove`+id+`"><i class="las la-trash"></i></button></td>
                </tr>
              `);
          }
              
          $("#remove"+id).on('click',function(){
            items--;
            console.log(items);
            $("#row"+id).remove();
            document.getElementById("item_picker").selectedIndex = 0;
            console.log(items);
            if(items == 0){
              $("#container_header").hide();
            }
          });
        });
    });
  </script>
    
  <script>$(".select2").select2({placeholder:"Choose product",theme: "classic"});</script>
  <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>


@endsection
