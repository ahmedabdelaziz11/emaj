@extends('layouts.master')

@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
<link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
<style>
    .row label {
    font-size: 20px;
    }
</style>

<style>

	@media print {
		#excel{
			display: none;
		}
        #print_Button{ 
			display: none;
		}
        #sub_print{
            display: none;
        }
		.zxc{
			border: none; border-collapse: collapse; 
			
		}
		.zxc td { border-left: 1px solid #000; }
		.zxc td:first-child { border-left: none; }
	}
</style>
@endsection
@section('title')
منتج رقم {{$composite_product->id}}
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">                        
                            <a href="{{ url('/' . $page='composite-products') }}">المنتجات المركبة </a>
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                منتج رقم {{$composite_product->id}}</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
<input type="hidden" id="mss" value="{{ Session::get('mss')}}">
<input type="hidden" id="del" value="{{ Session::get('del')}}">

@if($errors->has('name'))
    @foreach ($errors->all() as $error)
        <input type="hidden" id="err1" value="{{ $error }}">
    @endforeach
@endif


<script>
    window.onload = function() {
        var del = document.getElementById("del").value;
        if(del){
            notif({
            msg: del,
            type: "error"
            })
        }
    }
</script>

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
    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab6" class="nav-link active" data-toggle="tab">التفاصيل</a></li>
                                            <li><a href="#tab7" class="nav-link" data-toggle="tab">تعديل</a></li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">

                                        <div class="tab-pane active" id="tab6">
                                            <div class="row row-sm">
                                                <div class="col-md-12 col-xl-12">
                                                    <div class=" main-content-body-invoice" id="print">
                                                        <div class="card card-invoice">
                                                            <div class="card-body">
                                                                <div class="invoice-header">
                                                                    <img src="{{URL::asset('assets/img/brand/logo.png')}}" style="height:150px;width: 150px;" class="logo-1" alt="logo">
                                                                    <div class="billed-from">
                                                                        <h6></h6>
                                                                        <p style="font-weight: bold">شركة ايماج للهندسة و التجارة     <br>
                                                                        ٣ محمد سليمان غنام , من محمد رفعت ,النزهة الجديدة      <br>
                                                                            الهاتف :  01000241938 / 01208524340   <br>
                                                                            الايميل :  info@emajegypt.com <br>
                                                                            س-ت : 110422 / ب-ض : 560-137-548
                                                                        </p>
                                                                    </div><!-- billed-from -->
                                                                </div><!-- invoice-header -->
                                                                <h1 style="text-align: center ; font-weight: bold">{{ $composite_product->name }}</h1>
                                                                <div class="row mg-t-20">
                                                                    <div class="col-md">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>الوصف</span> <span>{{$composite_product->description}}</span></p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>التكلفة</span> <span>{{number_format($composite_product->cost(),2)}}</span></p>
                                                                    </div>
                                                                    <div class="col-md" style="margin-right: 80px">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>المخزن</span> <span>{{$composite_product->stock->name}}</span></p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>سعر البيع</span> <span>{{number_format($composite_product->selling_price,2)}}</span></p>
                                                                        <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                                                                                <i class="mdi mdi-printer ml-1"></i>Print
                                                                                            </a>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive mg-t-40">
                                                                    <table class="table table-invoice border text-md-nowrap mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <td colspan="5" style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="text-center">المكونات</td>
                                                                            </tr>
                                                                            <tr class="text-center">
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">م</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">اسم / ماركه </th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">التوصيف</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">سعر الشراء بالمخزن</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكمية</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach ($composite_product->products as $product)
                                                                                <tr>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $loop->iteration }}</td>
                                                                                    <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->name }}</td>
                                                                                    <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"><pre style="border:none;font-size: 16px;font-weight: bold;">{!! $product->description !!}</pre></td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->Purchasing_price }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->pivot->quantity }}</td>
                                                                                </tr>
                                                                            @endforeach
                                                                            <tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab7">
                                            <div class="row row-sm">
                                                <div class="col-md-12 col-xl-12">
                                                    <div class=" main-content-body-invoice" id="print">
                                                        <div class="card card-invoice">
                                                            <div class="card-body">
                                                            <form  action="{{ route('composite-products.update',$composite_product->id) }}" method="post" autocomplete="off">
                                                                @csrf
                                                                {{ method_field('patch') }}
                                                                <div class="d-flex justify-content-center">
                                                                    <h1>تعديل منتج مركب</h1>
                                                                </div><br>

                                                                <div class="row">
                                                                    <div class="col-3">
                                                                        <label for="inputName" class="control-label">اسم المنتج</label>
                                                                        <input type="text" class="form-control" value="{{$composite_product->name}}" name="name" title="يرجي ادخال اسم المنتج " required>
                                                                    </div>
                                                                    <div class="col-3">
                                                                        <label for="inputName" class="control-label">سعر البيع</label>
                                                                        <input type="number" step=".01" class="form-control" value="{{$composite_product->selling_price}}" name="selling_price" required>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <label for="inputName" class="control-label">وصف المنتج</label>
                                                                        <input type="text" class="form-control" value="{{$composite_product->description}}" name="description" title="يرجي ادخال وصف المنتج " required>
                                                                    </div>
                                                                </div> 
                                                                <br>
                                                                <div class="row">
                                                                    <div class="form-group col-3">
                                                                    <label>المخزن</label>
                                                                    <select class="form-control select2 " id="stock_id" name="stock_id">
                                                                        <option value="">اختر المخزن</option>
                                                                        @foreach ($stocks as $stock)
                                                                            <option @if($composite_product->stock_id == $stock->id) selected @endif value="{{ $stock->id }}">{{ $stock->name }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    </div>
                                                                    <div class="form-group col-9">
                                                                    <label for="inputName" class="control-label"> اختر المنتجات</label>
                                                                    <select class="form-control select2 " name="products" id="item_picker">
                                                                        <option value="0">اختر المنتجات</option>
                                                                        @foreach($composite_product->stock->products as $product)
                                                                            <option value="{{$product->id}}">{{$product->name}}</option>
                                                                        @endforeach
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
                                                                        @foreach($composite_product->products as $product)
                                                                            <tr>
                                                                                <td class="pt-3"style="font-size:17px;font-weight:bold">{{$product->name}}</td>
                                                                                <td><input type="hidden" name="id[]" value="{{$product->id}}" min="1"><input type="number" step="1" style="font-size:17px;font-weight:bold"  name="quantity[]" value="{{$product->pivot->quantity}}" class=" form-control text-center" min="1"></td>
                                                                                <td class="pt-3"><button onclick="deleteRow(this)" style="width:100%" type="button" class="btn btn-danger btn-sm rounded-pill ml-3 "><i class="las la-trash"></i></button></td>
                                                                            </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                    </table>
                                                                </div><br>

                                                                <button type="submit" class="btn btn-primary w-100 ">تعديل المنتج</button>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
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
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
    function deleteRow(btn) {
        var row = btn.parentNode.parentNode;
        var d = row.parentNode.parentNode.rowIndex;
        row.parentNode.removeChild(row);
    }
    </script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
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

@endsection