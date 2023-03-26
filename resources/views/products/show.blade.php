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
كرت صنف رقم {{$product->id}}
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">                        
                            <a href="{{ url('/' . $page='products') }}">المنتجات</a>
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                كارت صنف رقم {{$product->id}}</span>
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
                                        <h1 style="text-align: center ; font-weight: bold">كارت صنف رقم {{$product->id}}</h1>
                                        <div class="row mg-t-20">
                                            <div class="col-md">
                                                <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> اسم الصنف</span> <span>{{$product->name}}</span></p>
                                                <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>سعر الشراء</span> <span>{{$product->Purchasing_price}}</span></p>
                                                <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>سعر البيع</span> <span>{{$product->selling_price}}</span></p>
                                            </div>
                                            <div class="col-md" style="margin-right: 80px">
                                                <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>الكمية الافتتاحية</span> <span>{{$product->start_quantity}}</span></p>
                                                <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>الكمية الحالية</span> <span>{{$product->quantity}}</span></p>
                                                <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> تاريخ اصدار التقرير</span> <span>{{date('Y-m-d')}}</span></p>
                                                <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                                                        <i class="mdi mdi-printer ml-1"></i>Print
                                                                    </a>
                                            </div>
                                        </div>
                                        <div class="table-responsive mg-t-40">
                                            <table class="table table-invoice border text-md-nowrap mb-0">
                                                <thead>
                                                    <tr>
                                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">التاريخ</th>
                                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">رقم الاذن</th>
                                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">البيان</th>
                                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الوارد</th>
                                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">المنصرف</th>
                                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">سعر شراء</th>
                                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">سعر بيع</th>
                                                    </tr>
                                                </thead>

                                                @php
                                                    $q = $product->start_quantity;
                                                    $m = $w = 0;
                                                @endphp
                                                <tbody>
                                                    @foreach ($invoices as $x)
                                                        <tr>
                                                            @if($x->type == 1)
                                                                @php
                                                                    $q -= $x->product_quantity; 
                                                                    $m += $x->product_quantity;
                                                                @endphp
                                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->invoice->date }}</td>
                                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->invoice->p_num }}</td>

                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"><a href="{{ url('InvoiceDetails') }}/{{ $x->invoice_id }}">فاتورة بيع رقم {{$x->invoice_id}} </a></td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">0</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{$x->product_quantity}}</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x->product_Purchasing_price,2)}}</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x->product_selling_price,2)}}</td>
                                                            @endif
                                                            @if($x->type == 2)
                                                                @php
                                                                    $q += $x->product_quantity; 
                                                                    $w += $x->product_quantity;
                                                                @endphp
                                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->receipt->date }}</td>
                                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->receipt->p_num }}</td>

                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"><a href="{{ url('ReceiptDetails') }}/{{ $x->receipt_id }}">فاتورة شراء رقم {{$x->receipt_id }} </a></td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{$x->product_quantity}}</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">0</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x->product_Purchasing_price,2)}}</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">-</td>
                                                            @endif
                                                            @if($x->type == 3)
                                                                @php
                                                                    $q += $x->product_quantity; 
                                                                    $w += $x->product_quantity;
                                                                @endphp
                                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->created_at }}</td>
                                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">-</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"><a href="{{ url('returned_invoices') }}/{{ $x->invoice_id }}"> فاتورة مرتجع مبيعات رقم {{$x->invoice_id }}</a></td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{$x->product_quantity}}</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">0</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x->product_Purchasing_price,2)}}</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x->product_selling_price,2)}}</td>
                                                            @endif	
                                                            
                                                            @if($x->type == 4)
                                                                @php
                                                                    $q -= $x->product_quantity; 
                                                                    $m += $x->product_quantity;
                                                                @endphp
                                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->created_at }}</td>
                                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">-</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"><a href="{{ url('returned-receipts') }}/{{ $x->invoice_id }}"> فاتورة مرتجع مشتريات رقم {{$x->invoice_id }} </a></td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">0</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{$x->product_quantity}}</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x->product_Purchasing_price,2)}}</td>
                                                                <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">-</td>
                                                            @endif
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>

                                            <div class="table-responsive mg-t-40" style="width: 50%; float: left;margin-bottom: 10px;">
                                                <table class="table table-invoice  text-md-nowrap mb-0">
                                                    <tbody class="tx-right">
                                                        <tr class="border border-light tx-right">
                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;">الوارد</th>
                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($w) }}</th>
                                                        </tr>
                                                        <tr class="border border-light tx-right">
                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;">المنصرف</th>
                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($m) }}</th>
                                                        </tr>
                                                        <tr class="border border-light tx-right">
                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;">الكمية الحالية</th>
                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($q) }}</th>
                                                        </tr>
                                                        <tr class="border border-light tx-right">
                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;">الرصيد</th>
                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($q * $product->Purchasing_price,2) }}</th>
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
        window.onload = function (){
            stock_id = document.getElementById('tem_stock_id').value;
            if (stock_id) {
                $.ajax({
                    url: "{{ URL::to('sections') }}/" + stock_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="products"]').empty();
                        $('select[name="products"]').append('<option disabled selected>'+ "اختر الصنف" + '</option>');
                        $.each(data, function(key, value) {
                            $('select[name="products"]').append('<option value="' +value.id + '" selling_price="' +value.selling_price + '">' + value.name + '</option>');
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

<script type="text/javascript">
    function printDiv() {
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }

    function printDiv2() {
        var printContents = document.getElementById('print2').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
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
                <td><input type="hidden" name="id[]" value="`+id+`" min="1"><input type="number" style="font-size:17px;font-weight:bold"  name="selling_price[]" value="`+selling_price+`" class=" form-control text-center" min="1"></td>
                <td><input type="number" style="font-size:17px;font-weight:bold"  name="quantity[]" value="1" class=" form-control text-center" min="1"></td>
                <td class="pt-3"><button  onclick="deleteRow(this)" type="button" style="width:100%" type="button" class="btn btn-danger btn-sm rounded-pill ml-3 " id="remove`+id+`"><i class="las la-trash"></i></button></td>
                </tr>
                `);
            }
        
        });
    });
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