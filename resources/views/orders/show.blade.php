@extends('layouts.master')
@section('css')
<!--- Internal Select2 css-->
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
<!---Internal  Prism css-->
<link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
<!---Internal Input tags css-->
<link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
<!--- Custom-scroll -->
<link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    
<link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
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
طلب شراء
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">                        
                            <a href="{{ url('/' . $page='receipts') }}">المشتريات</a>
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                طلب شراء</span>
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
                                            <li><a href="#tab6" class="nav-link active" data-toggle="tab">
                                                    طلب الشراء</a></li>
                                            <li><a href="#tab7" class="nav-link" data-toggle="tab">
                                                    تعديل</a></li>
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
                                                                <h1 style="text-align: center ; font-weight: bold">طلب شراء</h1>
                                                                <div class="row mg-t-20">
                                                                    <div class="col-md" style="margin-left: 50px;">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>رقم الطلب</span> <span></span>{{$purchaseOrder->id}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>المخزن</span> <span></span>{{$purchaseOrder->stock->name}}</p>
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>تاريخ الاصدار</span>{{$purchaseOrder->date}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>البيان</span> {{$purchaseOrder->details}}</p>
                                                                        <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                                                            <i class="mdi mdi-printer ml-1"></i>Print
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive mg-t-40">
                                                                    <table class="table table-invoice border text-md-nowrap mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">#</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">اسم المنتج</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">السعر</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكمية</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الاجمالى</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $i = $total = $quantities = 0; ?>
                                                                            @foreach ($purchaseOrder->products as $product)
                                                                                <?php
                                                                                    $i++;
                                                                                    $total += ($product->pivot->Purchasing_price * $product->pivot->quantity);
                                                                                    $quantities +=  $product->pivot->quantity ;
                                                                                ?>
                                                                                <tr>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->name }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->Purchasing_price,2) }}</td>													                              
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->pivot->quantity }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->Purchasing_price * $product->pivot->quantity,2) }}</td>													                              
                                                                                </tr>
                                                                            @endforeach
                                                                                <tr class="table-dark">
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);" colspan="3">الاجمالى </td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($quantities) }}</td>													                              
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($total,2) }}</td>													                              
                                                                                </tr>
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="table-responsive mg-t-40">
                                                                        <table  class="table table-invoice border text-md-nowrap mb-0">
                                                                        <tbody class="border border-light tx-right">
                                                                                <tr style="padding-bottom: 50px;" >
                                                                                    <th style="border: none; font-size: 24px; padding-right: 150px;padding-bottom: 40px">توقيع المحاسب</th>
                                                                                    <th style="border: none; font-size: 25px" class="tx-right" colspan="2">توقيع المدير المالى</th>
                                                                                    <th style="border: none; font-size: 25px" class="tx-right" colspan="2">توقيع المدير العام</th>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab7">
                                            <div class="card mg-b-20" id="tabs-style2">
                                                <div class="card-body">
                                                    <form action="{{ route('orders.update',$purchaseOrder->id) }}" method="post" autocomplete="off">
                                                    @csrf
                                                    {{ method_field('patch') }}
                                                    <div class="row">
                                                        <input type="hidden" name="order_id" value="{{$purchaseOrder->id}}" >
                                                        <div class="col-4">
                                                        <label>تاريخ الطلب</label>
                                                        <input class="form-control fc-datepicker" name="date" placeholder="YYYY-MM-DD" type="text" value="{{$purchaseOrder->date}}" required>
                                                        </div>

                                                        <div class="col-8">
                                                        <label>البيان</label>
                                                        <input class="form-control" name="details" type="text" value="{{$purchaseOrder->details}}" required>
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <div class="row">

                                                        <div class="form-group col-4">
                                                        <label>المخزن</label>
                                                        <select class="form-control select2 " id="stock_id" name="stock_id">
                                                            @foreach ($stocks as $stock)
                                                                <option value="{{ $stock->id }}" @if($purchaseOrder->stock_id == $stock->id ) selected @endif >{{ $stock->name }}</option>
                                                            @endforeach
                                                        </select>
                                                        </div>
                                                        <div class="form-group col-8">
                                                        <label>المنتجات</label>
                                                        <select class="form-control select2" name="products" id="item_picker">

                                                        </select>
                                                        </div>

                                                    </div>
                                                    <br>
                                                    <div class="form-group">
                                                        <table class="table table-bordered mg-b-0 text-md-nowrap">


                                                        <thead id="container_header">

                                                            <th style=" font-size: 15px;">اسم المنتج</th>
                                                            <th style=" font-size: 15px;" class="text-center">سعر الشراء</th>
                                                            <th style=" font-size: 15px;" class="text-center">الكميه</th>
                                                            <th style=" font-size: 15px;padding-right: 55px;">حذف</th>


                                                        </thead>
                                                        <tbody id="items_container">
                                                            @foreach($purchaseOrder->products as $product)
                                                            <tr>
                                                                <td style="padding-top:20px;font-size:17px;font-weight:bold" >{{$product->name}}</td>
                                                                <td> <input type="number" style="font-size:17px;font-weight:bold" name="purchasing_price[]" step=".01" value="{{$product->pivot->Purchasing_price}}" onchange='updateTotal2();' class=" form-control text-center "></td>
                                                                <td> <input type="hidden" name="id[]" value="{{$product->id}}" min="1"><input type="number" style="font-size:17px;font-weight:bold" name="quantity[]"  onchange='updateTotal2();' value="{{$product->pivot->quantity}}" class=" form-control text-center " min="1"></td>
                                                                <td> <button  onclick="deleteRow(this)" type="button" style="margin-right: 40px" class="btn btn-danger " style="margin-right: 10px"><i class="fas fa-times"></i></button></td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                        </table>
                                                    </div>
                                                    <hr>

                                                    <div class="row">
                                                        <div class="col-3">
                                                        <label style="font-size: 28px; font-weight: bold;margin-right: 30px;">الاجمالى</label>
                                                        </div>
                                                        <div class="form-group col-9">
                                                        <input class="form-control" style="font-size:17px;font-weight:bold" type="number" step=".01" name="sub_total" id="sub_total" onchange='updateTotal1();' value="0" min="0" disabled>
                                                        </div>
                                                    </div>
                                                    <br>

                                                    <button type="submit" class="btn btn-primary w-100 ">تعديل الطلب</button>
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
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script type="text/javascript">
        function printDiv() {
            var printContents = document.getElementById('print').innerHTML;
            var originalContents = document.body.innerHTML;
            document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>

    <script>
        window.onload = function (){
            updateTotal2();
            stock_id = document.getElementById('stock_id').value;
            console.log(stock_id);
            if (stock_id) {
                $.ajax({
                    url: "{{ URL::to('sections') }}/" + stock_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="products"]').empty();
                        updateTotal2();    
                        $('select[name="products"]').append('<option disabled selected>'+ "اختر الصنف" + '</option>');
                        $.each(data, function(key, value) {
                            $('select[name="products"]').append('<option value="' +
                            value.id + '" product_Purchasing_price="' +value.Purchasing_price + '">' + value.name + '</option>');
                        });
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }

            var del = document.getElementById("del").value;
            if(del){
                notif({
                msg: del,
                type: "error"
                })
            }

            var mss = document.getElementById("mss").value;
            if(mss)
            {
                notif({    
                msg: mss ,
                type: "success"
                })
            }
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
            var stock_id = $(this).val();
            if (stock_id) {
                $.ajax({
                    url: "{{ URL::to('sections') }}/" + stock_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="products"]').empty();
                        $("#items_container").empty();
                        updateTotal2();    
                        $('select[name="products"]').append('<option disabled selected>'+ "اختر الصنف" + '</option>');
                        $.each(data, function(key, value) {
                            $('select[name="products"]').append('<option value="' +
                            value.id + '" product_Purchasing_price="' +value.Purchasing_price + '">' + value.name + '</option>');
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
            $("#container_header").show();
            var name = $(this).find(":selected").text();
            var product_Purchasing_price = $(this).find(":selected").attr('product_Purchasing_price');
            var id = $(this).val();
            if(!$("#row"+id).length){
            $("#items_container").append(`
                <tr id="row`+id+`">
                <td style="padding-top:20px;font-size:17px;font-weight:bold" >`+name+`</td>
                <td><input type="number" style="font-size:17px;font-weight:bold" name="purchasing_price[]" step=".01" value="`+product_Purchasing_price+`" onchange='updateTotal2();' class=" form-control text-center "></td>
                <td> <input type="hidden" name="id[]" value="`+id+`" min="1"><input type="number" style="font-size:17px;font-weight:bold" name="quantity[]" onchange='updateTotal2();' value="1" class=" form-control text-center " min="1"></td>
                <td ><button  onclick="deleteRow(this)" type="button" style="margin-right: 40px" class="btn btn-danger " style="margin-right: 10px"><i class="fas fa-times"></i></button></td>
                </tr>
                `);
            }
            updateTotal2();    
        });
        });
        function updateTotal2() {
            var total = 0;
            var list1 = document.getElementsByName("purchasing_price[]");
            var list2 = document.getElementsByName("quantity[]");
            var total1 = 0 ;
            for(var i = 0; i < list1.length; ++i) {
                total1 += parseFloat(list1[i].value) * parseFloat(list2[i].value);
            }

            document.getElementById("sub_total").value = total1;    
        }
    </script>

    <script>
    function deleteRow(btn) {
        var row = btn.parentNode.parentNode;
        var d = row.parentNode.parentNode.rowIndex;
        row.parentNode.removeChild(row);
        updateTotal2();
    }
    </script>
@endsection