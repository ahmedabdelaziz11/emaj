@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

@endsection

@section('title')
    اضافة قطع غيار لمنتج
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='product-spare') }}">قطع غيار المنتجات</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                اضافة قطع غيار لمنتج </span>
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

                  <form  action="{!! route('product-spare.update',0) !!}" method="post" autocomplete="off">
                      @csrf
                      {{ method_field('patch') }}
                      <div class="d-flex justify-content-center">
                        <h1>اضافة قطع غيار لمنتج مركب</h1>
                      </div>
                      <br>
                      <div class="row">
                        <div class="form-group col-3">
                          <label>المنتج</label>
                          <select class="form-control select2 products" id="product_id" name="product_id">
                            <option value=" ">اختر المنتج</option>

                          </select>
                        </div>
                        
                        <div class="form-group col-9">
                          <label class="control-label"> اختر قطع الغيار</label>
                          <select class="form-control select2 spares" id="item_picker">
                            <option value=" ">اختر قطع الغيار</option>

                          </select>
                        </div>
                      </div>


                      <div class="form-group">
                      <table class="table table-bordered mg-b-0 text-md-nowrap">
                          <thead id="container_header" style="display:none;">
                            <th style=" font-size: 15px;">اسم قطع الغيار</th>
                            <th style=" font-size: 15px;" class="text-center">حذف</th>
                          </thead>
                          <tbody id="items_container">
                          </tbody>
                        </table>
                      </div><br>

                      <button type="submit" class="btn btn-primary w-100">اضافة قطع الغيار</button>
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
      var items = 0;
      $("#item_picker").change(function(){
        items++;
        $("#container_header").show();
        var name = $(this).find(":selected").text();
        var id = $(this).val();
        if(!$("#row"+id).length){
          $("#items_container").append(`
              <tr id="row`+id+`">
              <td class="pt-3"style="font-size:17px;font-weight:bold"><input type="hidden" name="spare_ids[]" value="`+id+`" min="1">`+name+`</td>
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
  <script>
    $(document).ready(function(){
        $('.products').select2({
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
    });
    $(document).ready(function(){
        $('.spares').select2({
          placeholder: 'Enter a tag',
          ajax: {
              dataType: 'json',
              url: function(params) {
                  return '/get-all-spares/' + params.term;
              },
              processResults: function (data, page) {
                return {
                  results: data || ' '
                };
              },
          }
        });
    });
  </script>

    
  <script>$(".select2").select2({placeholder:"Choose product",theme: "classic"});</script>
  <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
  <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
@endsection
