@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

@endsection

@section('title')
    اضافة منتج مركب 
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='composite-products') }}">المنتجات المركبة</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                اضافة منتج مركب  </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
<input type="hidden" id="mss" value="{{ Session::get('mss')}}">


@if ($errors->any())
    <script>
        window.onload = function() {
            notif({
                msg:" فشلت الاضافة اسم المنتج مكرر ",
                type: "error"
            })
        }
    </script>
@endif



@if (session()->has('mss'))
<script>
    window.onload = function() {
        var mss = document.getElementById("mss").value;
        notif({    
            msg: mss ,
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

                  <form  action="{!! route('composite-products.store') !!}" method="post" autocomplete="off">
                      @csrf

                      <div class="d-flex justify-content-center">
                        <h1>اضافة منتج مركب</h1>
                      </div><br>

                      <div class="row">
                          <div class="col-3">
                              <label for="inputName" class="control-label">اسم المنتج</label>
                              <input type="text" class="form-control" id="inputName" name="name" title="يرجي ادخال اسم المنتج " required>
                          </div>
                          <div class="col-3">
                              <label for="inputName" class="control-label">سعر البيع</label>
                              <input type="number" step=".01" class="form-control" id="inputName" name="selling_price" required>
                          </div>
                          <div class="col-6">
                              <label for="inputName" class="control-label">وصف المنتج</label>
                              <input type="text" class="form-control" id="inputName" name="description" title="يرجي ادخال وصف المنتج " required>
                          </div>
                      </div> 
                      <br>
                      <div class="row">
                        <div class="form-group col-3">
                          <label>المخزن</label>
                          <select class="form-control select2 " id="stock_id" name="stock_id">
                            <option value="">اختر المخزن</option>
                            @foreach ($stocks as $stock)
                            <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-9">
                          <label for="inputName" class="control-label"> اختر المنتجات</label>
                          <select class="form-control select2 " name="products" id="item_picker" required="required">
                            <option value="">اختر المنتجات</option>
                          </select>
                        </div>
                      </div>


                      <div class="form-group">
                      <table class="table table-bordered mg-b-0 text-md-nowrap">
                          <thead id="container_header" style="display:none;">
                            <th style=" font-size: 15px;">اسم المنتج</th>
                            <th style=" font-size: 15px;" class="text-center">الكميه</th>
                            <th style=" font-size: 15px;" class="text-center">حذف</th>
                          </thead>
                          <tbody id="items_container">
                          </tbody>
                        </table>
                      </div><br>

                      <button type="submit" class="btn btn-primary w-100 ">اضافة المنتج</button>
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
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

<script>
  $(document).ready(function() {   
      $('select[name="stock_id"]').on('change', function() {
          $('select[name="products"]').empty();

          var stock_id = $(this).val();
          if (stock_id) {
              $.ajax({
                  url: "{{ URL::to('sections') }}/" + stock_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                      $("#items_container").empty();
                      $('select[name="products"]').append('<option disabled selected>'+ "اختر الصنف" + '</option>');
                      $.each(data, function(key, value) {
                        $('select[name="products"]').append('<option value="' +value.id + '" selling_price="' +value.selling_price + '">' + value.name + '</option>');
                      });
                  },
              });
          } else {
              console.log('AJAX load did not work');
          }
      });
  });
</script>

<script>
    $(document).ready(function(){
      var items = 0;
      $("#item_picker").change(function(){
        items++;
        console.log(`ITEM AFTER ++ `+items);
        $("#container_header").show();
        var selling_price = $(this).find(":selected").attr('selling_price');
        var quantity = $(this).find(':selected').attr('selling_price');
        var name = $(this).find(":selected").text();
        var id = $(this).val();
        if(!$("#row"+id).length){
          $("#items_container").append(`
            <tr id="row`+id+`">
            <td class="pt-3"style="font-size:17px;font-weight:bold">`+name+`</td>
            <td><input type="hidden" name="id[]" value="`+id+`" min="1"><input type="number" step="1" style="font-size:17px;font-weight:bold"  name="quantity[]" value="1" class=" form-control text-center" min="1"></td>
            <td class="pt-3"><button style="width:100%" type="button" class="btn btn-danger btn-sm rounded-pill ml-3 " id="remove`+id+`"><i class="las la-trash"></i></button></td>
            </tr>
            `);
        }
            
            console.log(items);
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
