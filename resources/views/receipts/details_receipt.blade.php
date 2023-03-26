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
تفاصيل الفاتورة
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">                        
                            <a href="{{ url('/' . $page='receipts') }}">المشتريات</a>
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل الفاتورة</span>
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
                                            <li><a href="#tab6" class="nav-link active" data-toggle="tab">الفاتوره</a></li>
                                            <li><a href="#tab7" class="nav-link" data-toggle="tab">اذن الاضافة</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">تعديل</a></li>
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
                                                                <h1 style="text-align: center ; font-weight: bold">فاتورة شراء</h1>
                                                                <div class="row mg-t-20">
                                                                    <div class="col-md" style="margin-left: 50px;">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>رقم الفاتورة</span> <span></span>{{$receipt->id}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>اسم المورد</span> <span></span>{{$receipt->supplier->name}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>رقم القيد</span><a href="{{url('days')}}/{{$receipt->day_id}}"> {{$receipt->day_id}}</a></p>                                                                    </div>
                                                                    <div class="col-md">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>تاريخ الاصدار</span>{{$receipt->date}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>الحالة</span> {{$receipt->type ? 'مؤكدة' : 'غير مؤكدة'}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>المخزن</span> {{$receipt->stock->name ?? 'لا يوجد'}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>رقم طلب الشراء</span><a href="{{url('orders')}}/{{$receipt->purchase_order_id}}"> {{$receipt->purchase_order_id ?? 'لا يوجد'}}</a></p>

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
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكمية</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">السعر</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الاجمالى</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $i = 0; ?>
                                                                            @foreach ($receipt->receipt_products as $product)
                                                                                <?php $i++; ?>
                                                                                <tr>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->product->name }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->product_quantity }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->product_Purchasing_price,2) }}</td>													                              
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->product_Purchasing_price * $product->product_quantity,2) }}</td>													                              
                                                                                </tr>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="table-responsive mg-t-40" style="width: 49%; float: right;margin-bottom: 10px;margin-left: 10px;">
                                                                        <table  class="table table-invoice  text-md-nowrap mb-0">
                                                                            <tbody class="tx-right">
                                                                                <tr class="border border-light tx-right">
                                                                                        <th class="text-center" style="font-size: 17px;font-weight: bold;">الاجمالى الجزئي</th>
                                                                                        <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2" >{{ number_format($receipt->sub_total,2) }}</th>
                                                                                </tr>
                                                                                @if($receipt->value_added  ==  1)
                                                                                    <tr class="border border-light tx-right">
                                                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;">القيمة المضافة</th>
                                                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2" >{{ number_format($receipt->value_added ? $receipt->sub_total * .14 : 0,2) }}</th>
                                                                                    </tr>
                                                                                @endif

                                                                                @if($receipt->additions > 0)
                                                                                    <tr class="border border-light tx-right">
                                                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;">المصاريف</th>
                                                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2" >{{ number_format($receipt->additions,2) }}</th>
                                                                                    </tr>
                                                                                @endif

                                                                                @if($receipt->discount > 0)
                                                                                    <tr class="border border-light tx-right">
                                                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;">الخصم المكتسب</th>
                                                                                            <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2" >{{ number_format($receipt->discount,2) }}</th>
                                                                                    </tr>
                                                                                @endif

                                                                                <tr class="border border-light tx-right">
                                                                                        <th class="text-center" style="font-size: 23px;font-weight: bold;">الصافى</th>
                                                                                        <th class="text-center" style="font-size: 23px;font-weight: bold;" colspan="2" >{{ number_format($receipt->total,2) }}</th>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <div class="table-responsive mg-t-40" style="width: 49%; float: left;margin-bottom: 10px;">
                                                                        <table  class="table table-invoice  text-md-nowrap mb-0">
                                                                            <tbody class="tx-right">
                                                                                <tr class="border border-light tx-right">
                                                                                        <th class="text-center" style="font-size: 17px;font-weight: bold;">مركز التكلفة</th>
                                                                                        <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2" >{{ $receipt->cost->name ?? "لا يوجد" }}</th>
                                                                                </tr>
                                                                                <tr class="border border-light tx-right">
                                                                                        <th class="text-center" style="font-size: 17px;font-weight: bold;">حساب النقدية</th>
                                                                                        <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2" >{{ $receipt->account->name ?? "اجل" }}</th>
                                                                                </tr>
                                                                                <tr class="border border-light tx-right">
                                                                                        <th class="text-center" style="font-size: 23px;font-weight: bold;">المبلغ المدفوع</th>
                                                                                        <th class="text-center" style="font-size: 23px;font-weight: bold;" colspan="2" >{{ number_format($receipt->amount_paid,2) }}</th>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
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
                                            <div class="row row-sm">
                                                <div class="col-md-12 col-xl-12">
                                                    <div class=" main-content-body-invoice" id="print2">
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
                                                                <h1 style="text-align: center ; font-weight: bold">اذن اضافة فاتورة رقم {{$receipt->id}}</h1>
                                                                <div class="row mg-t-20">
                                                                    <div class="col-md" style="margin-left: 50px;">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>رقم الفاتورة</span> <span></span>{{$receipt->id}}</p>
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>تاريخ الاصدار</span>{{$receipt->date}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>المخزن</span> {{$receipt->stock->name ?? 'لا يوجد'}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>رقم اذن الاضافة</span> <a type="button" style="font-size: 18px;" class="dropdown-item " data-toggle="modal" data-target="#edite{{ $receipt->id }}" title="تعديل الرقم">{{ $receipt->p_num }}</a></p>
                                                                        
                                                                        <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv2()">
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
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكمية</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $i = 0; ?>
                                                                            @foreach ($receipt->receipt_products as $product)
                                                                                <?php $i++; ?>
                                                                                <tr>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->product->name }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->product_quantity }}</td>
                                                                                </tr>
                                                                            @endforeach
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

                                        <div class="modal fade" id="edite{{ $receipt->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
												<div class="modal-dialog" role="document">
													<div class="modal-content">
														<div class="modal-header">
															<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
																تعديل رقم اذن فاتورة رقم {{$receipt->id}}
															</h5>
															<button type="button" class="close" data-dismiss="modal" aria-label="Close">
																<span aria-hidden="true">&times;</span>
															</button>
														</div>
														<div class="modal-body">
														<form action="{{url('/receipts/update')}}" id="{{$receipt->id}}" method="post">
																{{ method_field('patch') }}
																{{ csrf_field() }}
																<div class="modal-body">
																	<input type="hidden" name="receipt_id" value="{{ $receipt->id }}">
																	<div class="form-group">
																		<label>رقم الاذن</label>
																		<input class="form-control" name="p_num" type="text" value="{{$receipt->p_num}}" required>
																	</div>
																</div>

																<div class="modal-footer">
																	<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
																	<button type="submit" form="{{$receipt->id}}" class="btn btn-danger">تاكيد</button>
																</div>
															</form>
														</div>
													</div>
												</div>
											</div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="card-body">
                                                <form  action="{{ route('receipts.update',$receipt->id) }}" method="post" autocomplete="off">
                                                {{ csrf_field() }}
                                                {{ method_field('patch') }}
                                                <input type="hidden" name="stock_id" value="" id="stock_id">
                                                <input type="hidden" name="receipt_id" value="{{$receipt->id}}">
                                                <div class="row">
                                                    <div class="col">
                                                        <label>تاريخ الفاتوره</label>
                                                        <input class="form-control fc-datepicker" name="date" placeholder="YYYY-MM-DD"
                                                            type="text" value="{{ $receipt->date }}" required>
                                                    </div>

                                                    <div class="col">
                                                        <label> حساب المورد</label>
                                                        <select class="form-control select2" name="supplier_id" required="required">
                                                            @foreach ($suppliers as $account)
                                                                <option value="{{ $account->id }}" @if($receipt->supplier_id == $account->id ) selected @endif>{{ $account->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col">
                                                        <label>حساب النقدية</label>
                                                        <select class="form-control select2" name="account_id" id="account_id"  required="required">
                                                            <option value="0" @if($receipt->account_id == null) selected @endif>اجل</option>
                                                            @foreach ($accounts as $account)
                                                            @if($account->id == 58)
                                                                <option value="{{ $account->id }}" disabled  >{{ $account->name }}</option>
                                                            @else
                                                                <option value="{{ $account->id }}" @if($receipt->account_id == $account->id ) selected @endif >{{ $account->name }}</option>
                                                            @endif
                                                            @if($account->accounts->count() > 0)
                                                                @foreach ($account->accounts as $account1)
                                                                <option value="{{ $account1->id }}" @if($receipt->account_id == $account1->id ) selected @endif >{{ $account1->name }}</option>
                                                                @endforeach
                                                            @endif
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="col">
                                                        <label>مركز التكلفة</label>
                                                        <select class="form-control select2" name="cost_id" id="cost_id" required="required">
                                                            <option value="0" @if($receipt->cost_id == null ) selected @endif selected>لا يوجد</option>
                                                            @foreach ($costs as $cost)
                                                            <option value="{{ $cost->id }}" @if($receipt->cost_id == $cost->id ) selected @endif >{{ $cost->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row">
                                                    <div class="col-3">
                                                        <input type="hidden" id="order_temp" value="{{$receipt->purchase_order_id}}">
                                                        <label>طلب الشراء</label>
                                                        <select class="form-control select2" style="font-size:17px;font-weight:bold" name="order_id" id="order_id"  required="required">
                                                        @foreach ($orders as $order)
                                                            <option value="{{ $order->id }}" @if($receipt->purchase_order_id == $order->id ) selected @endif>{{ $order->id }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-3">
                                                        <label>الاجمالى</label>
                                                        <input class="form-control" style="font-size:17px;font-weight:bold" type="number" step=".01"  name="sub_total" id="sub_total" onchange='updateTotal1();' value="0" min="0" readonly>
                                                    </div>
                                                    <div class="col">
                                                        <label>الفاتورة شاملة القيمة المضافة؟</label>
                                                        <select style="font-size:17px;font-weight:bold" class="form-control" value="{{$receipt->value_added}}" name="value_add" id="value_add" onchange='updateTotal1();' required="required">
                                                            <option value="1" @if($receipt->value_added == 1 ) selected @endif>نعم</option>
                                                            <option value="0" @if($receipt->value_added == 0 ) selected @endif>لا</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-3">
                                                    <label>قيمة الخصم بالجنية</label>
                                                    <input class="form-control" style="font-size:17px;font-weight:bold" type="number" name="discount" value="{{$receipt->discount}}" step=".01"  id="discount" onchange='updateTotal1();' min="0">
                                                    </div>

                                                </div>
                                                <br>
                                                <div class="row">
                                                    <div class="form-group col-3">
                                                        <label >  اجمالى المصاريف (نقل,..)</label>
                                                        <input class="form-control" style="font-size:17px;font-weight:bold" type="number" name="additions" step=".01"  id="additions" onchange='updateTotal1();' value="{{$receipt->additions}}" min="0"> 
                                                    </div>

                                                    <div class="form-group col-3">
                                                        <label>الصافى</label>
                                                        <input class="form-control" style="font-size:17px;font-weight:bold" type="text" name="tem_total" id="tem_total" step=".01"  value="0" min="0" disabled>
                                                        <input type="hidden" id="total" name="total">
                                                    </div>

                                                    <div class="form-group col-6">
                                                        <label>المبلغ المدفوع</label>
                                                        <input class="form-control" style="font-size:17px;font-weight:bold" type="number" name="amount_paid" step=".01"  id="amount_paid" value="{{$receipt->amount_paid}}" min="0">
                                                    </div>
                                                </div>
                                                <br>
                                                
                                                <button type="submit" class="btn btn-primary w-100 ">تعديل الفاتوره</button>
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
        updateTotal1();
        
        order_id = document.getElementById('order_temp').value;
        console.log(order_id);
        document.getElementById('order_id').value = order_id;

        $.ajax({
            url: "{{ URL::to('order-total') }}/" + order_id,
            type: "GET",
            dataType: "json",
            success: function(data) {
                document.getElementById('sub_total').value = data.total;
                document.getElementById('stock_id').value = data.stock_id;
                updateTotal1();    
            },
        });
        if(parseFloat(document.getElementById("account_id").value) == 0)
        {
        document.getElementById("amount_paid").readOnly   = true;
        }else{
        document.getElementById("amount_paid").readOnly   = false;
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
        $('select[name="order_id"]').on('change', function() {
            var order_id = $(this).val();
            console.log(order_id);
            if (order_id) {
                $.ajax({
                    url: "{{ URL::to('order-total') }}/" + order_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        document.getElementById('sub_total').value = data.total;
                        document.getElementById('stock_id').value = data.stock_id;
                        updateTotal1();    
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
    document.getElementById("account_id").onchange = function(){
        if(parseFloat(document.getElementById("account_id").value) == 0)
        {
        document.getElementById("amount_paid").readOnly   = true;
        }else{
        document.getElementById("amount_paid").readOnly   = false;
        }
    };
    });
</script>
<script>
    function updateTotal1() {
        var sub_total = parseFloat( document.getElementById("sub_total").value); 
        var additions = parseFloat(document.getElementById("additions").value);
        var discount = parseFloat(document.getElementById("discount").value);
        var value_add = parseFloat(document.getElementById("value_add").value);
        console.log(additions);
        var total = 0;
        total = sub_total ;
        if(value_add == 1)
        {
          total = total + (total * 0.14 );
        }
        total += additions - discount ;
        document.getElementById("total").value = total ;    

        total = new Intl.NumberFormat().format(total);
        document.getElementById("tem_total").value = total ;    

    }
</script>

@endsection