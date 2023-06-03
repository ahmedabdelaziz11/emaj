@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
@endsection

@section('title')
    اضافة العرض 
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='offers') }}">عروض المنتجات</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                            اضافه عرض  </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')


    <!-- row opened -->
    <div class="row row-sm">

      <div class="col-xl-12">
          <!-- div -->
          <div class="card mg-b-20" id="tabs-style2">
              <div class="card-body">

                  <form  action="{!! route('offers.store') !!}" method="post" autocomplete="off">
                      @csrf

                      <div class="d-flex justify-content-center">
                        <h1>عرض اسعار</h1>
                      </div><br>

                      <div class="row">
                          <div class="col">
                              <label for="inputName" class="control-label">اسم العرض</label>
                              <input type="text" class="form-control" id="inputName" name="name"title="يرجي ادخال اسم العرض " required>
                          </div>

                          <div class="col">
                            <label for="inputName" class="control-label">offer name</label>
                            <input style="text-align: left;" type="text" class="form-control" id="inputName" name="name_en"title="يرجي ادخال اسم العرض " required>
                        </div>

                          <div class="col">
                              <label>تاريخ العرض</label>
                              <input class="form-control fc-datepicker" name="offer_Date" placeholder="YYYY-MM-DD"
                                  type="text" value="{{ date('Y-m-d') }}" required>
                          </div>

                          <div class="col">
                            <label for="inputName" class="control-label"> اختر العميل</label>
                            @if (isset($ticket))
                            <input type="text"class="form-control" value="{{ $ticket->client->name }}" readonly>
                            <input name="client_id" type="hidden" value="{{ $ticket->client->id }}" class="form-control">
                            @else
                            <select class="form-control select2 " name="client_id" required="required">
                              <option value="">اختر العميل </option>
                              @foreach ($clients as $client)
                                <option    value="{{ $client->id }}">{{ $client->client_name }}</option>
                              @endforeach
                            </select>
                            @endif
                          </div>
                      </div> 
                      <br>
                      <div class="row">
                        <div class="form-group col-4">
                          <label>المخزن</label>
                          <select class="form-control select2 " id="stock_id" name="stock_id">
                            <option value="">اختر المخزن</option>
                            @foreach ($stocks as $stock)
                            <option value="{{ $stock->id }}" @if(isset($ticket)) selected @endif>{{ $stock->name }}</option>
                            @endforeach
                          </select>
                        </div>
                        <div class="form-group col-4" id="ticketDev" @if(!isset($ticket)) style="display: none;" @endif>
                          <label class="control-label">رقم طلب الإصلاح</label>
                          <input type="number" id="ticket_id" name="ticket_id" value="{{$ticket->id ?? ''}}" class="form-control" readonly>
                        </div>
                        <div class="form-group col-4">
                          <label for="inputName" class="control-label">اختر المنتجات</label>
                          <select class="form-control select2 " name="products" id="item_picker" required="required">
                            <option value="">اختر المنتجات</option>
                          </select>
                        </div>
                        <div class="form-group col-6">
                          <label for="inputName" class="control-label"> اختر المنتجات المركبة</label>
                          <select class="form-control select2 " name="composite_products" id="item_picker2">
                            <option value="">اختر المنتجات</option>
                          </select>
                        </div>
                        <div class="form-group col-6">
                          <label for="inputName" class="control-label">اضافة خدمة</label>
                          <button type="button" id="add_service" class="btn btn-primary w-100 ">اضافة خدمة</button>
                        </div>
                      </div>


                      <div class="form-group">
                      <table class="table table-bordered mg-b-0 text-md-nowrap">
                          <thead id="container_header" style="display:none;">
                            <th style=" font-size: 15px;">اسم المنتج</th>
                            <th style=" font-size: 15px;" class="text-center">سعر البيع داخل العرض</th>
                            <th style=" font-size: 15px;" class="text-center">الكميه</th>
                            <th style=" font-size: 15px;" class="text-center">حذف</th>
                          </thead>
                          <tbody id="items_container">
                          </tbody>
                        </table>
                      </div><br>

                      <div class="form-group">
                      <table class="table table-bordered mg-b-0 text-md-nowrap">
                          <thead id="service_header" style="display:none;">
                            <th colspan="2" style=" font-size: 15px;">البيان</th>
                            <th style=" font-size: 15px;" class="text-center">السعر</th>
                            <th style=" font-size: 15px;" class="text-center">حذف</th>
                          </thead>
                          <tbody id="service_container">
                          </tbody>
                        </table>
                      </div><br>
                      <div class="row">
                        <div class="form-group col-12">
                          <select class="form-control select2 address" name="address_id">
                            <option value=" ">اختر العنوان</option>
    
                          </select>
                        </div>
                      </div><br>
                      <div class="row">
                        <div class="form-group col">
                          <label  style="margin-right:15px" for="exampleFormControlTextarea2">قيود التعاقد</label>
            <textarea style="font-size: 16px;  margin-right:10px" class="form-control" name="constraints" rows="8" cols="142" required>
شروط التعاقد :
سداد مبلغ مقدم وقدره 70٪ من قيمة العرض.
سداد مبلغ وقدره 30٪ عند التوريد والاستلام.
التوريد خلال 30 ثالثون يوم استلام استلام الدفعه المقدمة
الاسعار غير شاملة ضريبة القيمة المضافة.
الضمان عامان حول عيوب الصناعه (العام الأول يشمل قطع الغيار و الصيانه 
دوريه و الاصلاح - العام الثاني لا يشمل قطع الغيار و يشمل الصيانه الدوريه و الاصلاح)
مده سريان العرض اسبوع من تاريخ
            </textarea>
                      </div>
                      <div class="form-group col">
                        <label  style="margin-left:15px;float: left;" for="exampleFormControlTextarea2">Contract restrictions</label>
            <textarea style="font-size: 16px;   margin-left:10px; text-align: left;" lang="en"class="form-control" name="constraints_en" rows="8" cols="142" required>
:Terms of contract
.Payment of an advance amount of 70% of the bid value
.Payment of 30% upon supply and receipt
Supply within 30 thirty days of receiving the advance payment
.Prices do not include VAT
Two years warranty for manufacturing defects (the first year includes spare parts and maintenance
(Periodicity and repair - the second year does not include spare parts and includes periodic maintenance and repair 
The period of validity of the offer is a week from the date
            </textarea>
                    </div>
                    </div>

                      <div class="row">
                        <div class="col">
                          <label for="inputName" class="control-label"> نسبه الخصم (%)</label>
                          <input  type="number" step=".01" class="form-control" id="discount" name="discount"
                          value="0" min="0" max="100" title="يرجي ادخال اسم نسبة الخصم  " required>
                        </div>
                        <div class="col">
                                <label>العرض شاملة القيمة المضافة؟</label>
                                <select style="font-size:17px;font-weight:bold" class="form-control" name="value_add" required="required">
                                  <option value="1">نعم</option>
                                  <option value="0"selected>لا</option>
                                </select>
                          </div>
                    </div><br>
                      <button type="submit" class="btn btn-primary w-100 ">اضافة العرض</button>
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
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();
</script>

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
    });
window.onload = function (){
  var ticket_id = $("#ticket_id").val();
  var stock_id  = $("#stock_id").val();
  $('select[name="products"]').empty();
  $('#item_picker2').empty();
  if(ticket_id && stock_id)
  {
    $.ajax({
      url: "{{ URL::to('get-spare-products-by-ticket') }}/"+ticket_id+"/"+stock_id,
      type: "GET",
      dataType: "json",
      success: function(data) {
          $("#items_container").empty();
          $('select[name="products"]').append('<option disabled selected>'+ "اختر الصنف" + '</option>');
          $.each(data, function(key, value) {
            $('select[name="products"]').append('<option value="' +value.id + '" selling_price="' +value.selling_price + '">' + value.name + '-' + value.id + '</option>');
          });
      },
    });
  }
}
  $(document).ready(function() {   
        
      $('select[name="stock_id"]').on('change', function() {
        var stock_id = $(this).val();
        if($("#stock_id option:selected").text() =="قطع الغيار"){
          $("#ticketDev").css('display','block');
        }else{
          $("#ticketDev").css('display','none');
          $('select[name="products"]').empty();
          $('#item_picker2').empty();
          var ticket_id = $("#ticket_id").val();
          if (stock_id && ticket_id === '') {
              $.ajax({
                  url: "{{ URL::to('sections') }}/" + stock_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                      $("#items_container").empty();
                      $('select[name="products"]').append('<option disabled selected>'+ "اختر الصنف" + '</option>');
                      $.each(data, function(key, value) {
                        $('select[name="products"]').append('<option value="' +value.id + '" selling_price="' +value.selling_price + '">' + value.name + '-' + value.id + '</option>');
                      });
                  },
              });

              $.ajax({
                  url: "{{ URL::to('composite-products-all') }}/" + stock_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                      $("#items_container").empty();
                      $('#item_picker2').append('<option disabled selected>'+ "اختر الصنف" + '</option>');
                      $.each(data, function(key, value) {
                        $('#item_picker2').append('<option value="' +value.id + '" selling_price="' +value.selling_price + '">' + value.name + '</option>');
                      });
                  },
              });
          } else {
              console.log('AJAX load did not work');
          }
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
            <td><input type="hidden" name="id[]" value="`+id+`" min="1"><input type="number" step=".01" style="font-size:17px;font-weight:bold"  name="selling_price[]" value="`+selling_price+`" class=" form-control text-center" min="1"></td>
            <td><input type="number" step="1" style="font-size:17px;font-weight:bold"  name="quantity[]" value="1" class=" form-control text-center" min="1"></td>
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
      $("#item_picker2").change(function(){
        items++;
        $("#container_header").show();
        var selling_price = $(this).find(":selected").attr('selling_price');
        var name = $(this).find(":selected").text();
        var id = $(this).val();
        if(!$("#row2"+id).length){
          $("#items_container").append(`
            <tr id="row2`+id+`">
            <td class="pt-3"style="font-size:17px;font-weight:bold">`+name+`</td>
            <td><input type="hidden" name="c_id[]" value="`+id+`" min="1"><input type="number" step=".01" style="font-size:17px;font-weight:bold"  name="c_selling_price[]" value="`+selling_price+`" class=" form-control text-center" min="1"></td>
            <td><input type="number" step="1" style="font-size:17px;font-weight:bold"  name="c_quantity[]" value="1" class=" form-control text-center" min="1"></td>
            <td class="pt-3"><button style="width:100%" type="button" class="btn btn-danger btn-sm rounded-pill ml-3 " id="remove2`+id+`"><i class="las la-trash"></i></button></td>
            </tr>
            `);
        }
        $("#remove2"+id).on('click',function(){
        items--;
        console.log(items);
        $("#row2"+id).remove();
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
    // Filter table
    $(document).ready(function(){
      $("#ordersTable").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $(".ordersTable option").filter(function() {
          $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
      });
    });
    </script>
    
    <script>$(".select2").select2({placeholder:"Choose product",theme: "classic"});</script>

    <script>
    $(document).ready(function(){
        var items = 0;
        var id = 0;
        $("#add_service").on('click',function(){
            items++;
            id++;
            $("#service_header").show();
            if(!$("#row"+id).length){
            $("#service_container").append(`
                <tr id="row`+id+`">
                <td colspan="2"><input type="text" style="font-size:17px;font-weight:bold" name="ser_desc[]" class=" form-control"></td>
                <td><input type="number" step=".01" style="font-size:17px;font-weight:bold" name="ser_price[]" value="0" class=" form-control text-center"></td>
                <td style="width:10px"><button type="button" name="delete1" class="btn btn-sm btn-danger float-none" id="remove_product`+id+`" value="`+id+`" style="width:100%"><i class="fas fa-times" style="width:100%" class="float-none"></i></button></td>
                </tr>
                `);
            }

            $("#remove_product"+id).on('click',function(){
            items--;
            var id = $(this).val(); 
            $("#row"+id).remove();
            if(items == 0){
                $("#service_header").hide();
            }
            });
        });
    });
</script>




@endsection
