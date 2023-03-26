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
عرض رقم {{$offer->id}}
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">                        
                            <a href="{{ url('/' . $page='offers') }}">العروض</a>
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                عرض رقم {{$offer->id}}</span>
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
                                            <li><a href="#tab6" class="nav-link active" data-toggle="tab">العرض</a></li>
                                            <li><a href="#tab7" class="nav-link" data-toggle="tab">offer</a></li>
                                            @can('تعديل عرض')
                                                <li><a href="#tab5" class="nav-link" data-toggle="tab">تعديل</a></li>
                                            @endcan
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
                                                                <h1 style="text-align: center ; font-weight: bold">عرض اسعار</h1>
                                                                <div class="row mg-t-20">
                                                                    <div class="col-md">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> اسم العرض</span> <span>{{$offer->name}}</span></p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> اسم العميل</span> <span>{{$offer->client->client_name}}</span></p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> اسم الشركه</span> <span>{{$offer->client->Commercial_Register}}</span></p>
                                                                    </div>
                                                                    <div class="col-md" style="margin-right: 80px">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>العنوان</span> <span>{{$offer->client->address}}</span></p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>التليفون</span> <span>{{$offer->client->phone}}</span></p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> تاريخ اصدار العرض</span> <span>{{$offer->date}}</span></p>
                                                                        <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                                                                                <i class="mdi mdi-printer ml-1"></i>Print
                                                                                            </a>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive mg-t-40">
                                                                    <table class="table table-invoice border text-md-nowrap mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">م</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">اسم / ماركه </th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">التوصيف</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكمية</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">سعر الوحدة</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الاجمالى</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $i = 0; $totalall = 0; ?>
                                                                            @foreach ($offer->products as $product)
                                                                                <?php
                                                                                    $i++;
                                                                                    $total = $product->pivot->product_quantity * $product->pivot->product_price;
                                                                                    $totalall = $totalall + $total ;
                                                                                ?>
                                                                                <tr>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                                    <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->name }}</td>
                                                                                    <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"><pre style="border:none;font-size: 16px;font-weight: bold;">{!! $product->description !!}</pre></td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->pivot->product_quantity }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->product_price,2) }}</td>													                              
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->product_quantity * $product->pivot->product_price,2) }}</td>													                              
                                                                                </tr>
                                                                                @php
                                                                                    $discount = (  $offer->discount / 100 ) * $totalall;
                                                                                    $after_discount = $totalall - $discount ;
                                                                                @endphp
                                                                            @endforeach
                                                                            @foreach ($offer->composite_products as $product)
                                                                                <?php
                                                                                    $i++;
                                                                                    $total = $product->pivot->quantity * $product->pivot->selling_price;
                                                                                    $totalall = $totalall + $total ;
                                                                                ?>
                                                                                <tr>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                                    <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->name }}</td>
                                                                                    <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"><pre style="border:none;font-size: 16px;font-weight: bold;">{!! $product->description !!}</pre></td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->pivot->quantity }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->selling_price,2) }}</td>													                              
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->quantity * $product->pivot->selling_price,2) }}</td>													                              
                                                                                </tr>
                                                                                @php
                                                                                    $discount = (  $offer->discount / 100 ) * $totalall;
                                                                                    $after_discount = $totalall - $discount ;
                                                                                @endphp
                                                                            @endforeach
                                                                            <?php $totalser = 0; ?>
                                                                            @forelse($offer->offer_services as $s)
                                                                                <?php
                                                                                    $i++;
                                                                                    $totalser += $s->price ;
                                                                                ?>
                                                                                <tr>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                                    <td colspan="2" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $s->details }}</td>
                                                                                    <td colspan="3" class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($s->price,2) }}</td>													                              
                                                                                </tr>
                                                                            @empty
                                                                            @endforelse


                                                                        </tbody>
                                                                    </table>
                                                                    <div class="table-responsive mg-t-40" style="width: 50%; float: left;margin-bottom: 10px;">
                                                                        <table class="table table-invoice  text-md-nowrap mb-0">
                                                                            <tbody class="tx-right">
                                                                                <tr class="border border-light tx-right">
                                                                                    <th class="text-center" style="font-size: 17px;font-weight: bold;">الاجمالى</th>
                                                                                    <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($totalall,2) }}</th>
                                                                                </tr>
                                                                                @if($totalser != 0)
                                                                                    <tr class="border border-light tx-right">
                                                                                        <th class="text-center" style="font-size: 17px;font-weight: bold;">الخدمات</th>
                                                                                        <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($totalser,2) }}</th>
                                                                                    </tr>
                                                                                @endif
                                                                                @if($offer->value_added != 0)
                                                                                    <tr class="border border-light tx-right">
                                                                                        <th class="text-center" style="font-size: 17px;font-weight: bold;">القيمة المضافة</th>
                                                                                        <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format(($totalall * .14 ),2) }}</th>
                                                                                    </tr>
                                                                                @endif
                                                                                @if($offer->discount != 0)
                                                                                <tr class="border border-light tx-right">
                                                                                    <th class="text-center" style="font-size: 17px;font-weight: bold;"> نسبة الخصم</th>
                                                                                    <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($offer->discount,2) }}%</th>
                                                                                </tr>
                                                                                @endif
                                                                                <tr class="border border-light tx-right">
                                                                                    <th class="text-center" style="font-size: 23px;font-weight: bold;">الصافى</th>
                                                                                    <?php 
                                                                                        if($offer->discount != 0)
                                                                                        {
                                                                                            $totalall -= ($totalall * ($offer->discount / 100));
                                                                                        }
                                                                                        
                                                                                        if($offer->value_added != 0)
                                                                                        {
                                                                                            $totalall += ($totalall * .14) ;
                                                                                        }
                                                                                        

                                                                                    ?>

                                                                                    <th class="text-center" style="font-size: 23px;font-weight: bold;" colspan="2">{{ number_format($totalall + $totalser  ,2)}}</th>
                                                                                </tr>
                                                                            </tbody>
                                                                        </table>
                                                                    </div>
                                                                    <br>
                                                                    <table>
                                                                        <tr>										
                                                                            <td class="tx-right" colspan="6">
                                                                                <div class="invoice-notes">
                                                                                    <p style="color: black"><pre style="color: black;font-size: 16px; border:none">{{$offer->constraints}}</pre></p>
                                                                                </div><!-- invoice-notes -->
                                                                            </td>
                                                                        </tr>
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
                                                    <div class=" main-content-body-invoice" id="print2">
                                                        <div class="card card-invoice">
                                                            <div class="card-body">
                                                                <div class="invoice-header">
                                                                    <div class="billed-from">
                                                                        <h6></h6>
                                                                        <p style="font-weight: bold;font-size: 17px;">3 محمد سليمان غنام , من محمد رفعت ,النزهة الجديدة      <br>
                                                                            الهاتف :  01000241938 / 01208524340   <br>
                                                                            الايميل :  info@emajegypt.com</p>
                                                                    </div><!-- billed-from -->
                                                                    <img src="{{URL::asset('assets/img/brand/logo.png')}}" style="height:150px;width:250px" class="logo-1" alt="logo">

                                                                </div><!-- invoice-header -->
                                                                <h1 style="text-align: center ; font-weight: bold">price offer</h1>
                                                                <div class="row mg-t-20">
                                                                    <div class="col-md">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>{{$offer->client->address_en}}</span><span>address</span></p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>{{$offer->client->phone}}</span><span>phone</span></p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>{{$offer->date}}</span><span>offer date</span></p>
                                                                    </div>
                                                                    <div class="col-md" style="margin-right: 80px">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold;"><span style="text-align: left">{{$offer->name_en}}</span><span>offer name</span></p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold;" ><span style="text-align: left">{{$offer->client->client_name_en}}</span><span>client name</span></p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold;" ><span style="text-align: left">{{$offer->client->Commercial_Register_en}}</span><span>company name</span></p>
                                                                        <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv2()">
                                                                                                <i class="mdi mdi-printer ml-1"></i>Print
                                                                                            </a>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive mg-t-40">
                                                                    <table class="table table-invoice border text-md-nowrap mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">amount</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">unit price</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">quantity</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">description</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">name</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">m</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <?php $i = 0; $totalall = 0; ?>
                                                                            @foreach ($offer->products as $product)
                                                                                <?php
                                                                                    $i++;
                                                                                    $total = $product->pivot->product_quantity * $product->pivot->product_price;
                                                                                    $totalall = $totalall + $total ;
                                                                                ?>
                                                                                <tr>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($total,2) }}</td>
                                                                                    <td class="text-center"  style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->product_price,2) }}</td>
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->pivot->product_quantity }}</td>
                                                                                    <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"><pre style="border:none;font-size: 16px;font-weight: bold;">{!! $product->description_en !!}</pre></td>
                                                                                    <td style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->name_en }}</td>													                              
                                                                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>													                              
                                                                                </tr>
                                                                            @endforeach
                                                                            @php
                                                                                $discount = (  $offer->discount / 100 ) * $totalall;
                                                                                $after_discount = $totalall - $discount ;
                                                                            @endphp
                                                                        </tbody>
                                                                    </table>
                                                                    <div class="table-responsive mg-t-40" style="width: 50%; float: left;margin-bottom: 10px;">
                                                                        <table class="table table-invoice  text-md-nowrap mb-0">
                                                                            <tbody class="tx-right">
                                                                                <tr class="border border-light tx-right">
                                                                                    <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($totalall,2) }}</th>
                                                                                    <th class="text-center" style="font-size: 17px;font-weight: bold;">total</th>
                                                                                </tr>
                                                                                @if($offer->discount != 0)
                                                                                <tr class="border border-light tx-right">
                                                                                    <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($offer->discount,2) }}</th>
                                                                                    <th class="text-center" style="font-size: 17px;font-weight: bold;">(%)discount</th>
                                                                                </tr>
                                                                                <tr class="border border-light tx-right">
                                                                                    <th class="text-center" style="font-size: 23px;font-weight: bold;" colspan="2">{{ number_format($after_discount,2)}}</th>
                                                                                    <th class="text-center" style="font-size: 23px;font-weight: bold;">total after discount</th>
                                                                                </tr>
                                                                                @endif
                                                                            </tbody>
                                                                        </table>
                                                                    </div>   
                                                                    <div class="table-responsive mg-t-40" style="width: 50%; float: right;margin-bottom: 10px;">
                                                                    </div>  
                                                                    <br>
                                                                    <div class="table-responsive mg-t-40" style="float: left;margin-bottom: 10px;">
                                                                        <p style="color: black"><pre style="float: left;text-align: left; color: black;font-size: 16px; border:none">{{$offer->constraints_en}}</pre></p>
                                                                    </div>                                                                                                                                            
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="card-body">
                                                <form  action="{{ route('offers.update',$offer->id) }}" method="post" autocomplete="off">
                                                {{ csrf_field() }}
                                                {{ method_field('patch') }}
                                                <input type="hidden" name="tem_stock_id" value="{{$offer->stock_id}}" id="tem_stock_id">
                                                <input type="hidden" name="offer_id" value="{{$offer->id}}">
                                                <div class="d-flex justify-content-center">
                                                    <h1>عرض اسعار</h1>
                                                </div><br>

                                                <div class="row">
                                                    <div class="col">
                                                        <label for="inputName" class="control-label">اسم العرض</label>
                                                        <input type="text" class="form-control" name="name" value="{{$offer->name}}" title="يرجي ادخال اسم العرض " required>
                                                    </div>

                                                    <div class="col">
                                                        <label for="inputName" class="control-label">offer name</label>
                                                        <input style="text-align: left;" type="text" class="form-control" value="{{$offer->name_en}}" name="name_en"title="يرجي ادخال اسم العرض " required>
                                                    </div>

                                                    <div class="col">
                                                        <label>تاريخ العرض</label>
                                                        <input class="form-control fc-datepicker" name="offer_Date" placeholder="YYYY-MM-DD"
                                                            type="text" value="{{$offer->date}}" required>
                                                    </div>

                                                    <div class="col">
                                                        <label for="inputName" class="control-label"> اختر العميل</label>
                                                        <select class="form-control select2 " name="client_id" required="required">
                                                        <option value="">اختر العميل </option>
                                                        @foreach ($clients as $client)
                                                            <option value="{{ $client->id }}" @if($client->id == $offer->client_id) selected @endif>{{ $client->client_name }}</option>
                                                        @endforeach
                                                        </select>
                                                    </div>
                                                </div> 
                                                <br>
                                                <div class="row">
                                                    <div class="form-group col-3">
                                                    <label>المخزن</label>
                                                    <select class="form-control select2 " id="stock_id" name="stock_id">
                                                        <option value="">اختر المخزن</option>
                                                        @foreach ($stocks as $stock)
                                                        <option value="{{ $stock->id }}" @if($stock->id == $offer->stock_id) selected @endif>{{ $stock->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    </div>
                                                    <div class="form-group col-3">
                                                    <label for="inputName" class="control-label"> اختر المنتجات</label>
                                                    <select class="form-control select2 " name="products" id="item_picker" required="required">
                                                        <option value="">اختر المنتجات</option>
                                                    </select>
                                                    </div>
                                                    <div class="form-group col-3">
                                                        <label for="inputName" class="control-label"> اختر المنتجات المركبة</label>
                                                        <select class="form-control select2 " name="composite_products" id="item_picker2" required="required">
                                                            <option value="">اختر المنتجات</option>
                                                        </select>
                                                    </div>
                                                    <div class="form-group col-3">
                                                        <label for="inputName" class="control-label">اضافة خدمة</label>
                                                        <button type="button" id="add_service" class="btn btn-primary w-100 ">اضافة خدمة</button>
                                                    </div>
                                                </div> <br>


                                                <div class="form-group">
                                                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                        <thead id="container_header">
                                                            <th style=" font-size: 15px;">اسم المنتج</th>
                                                            <th style=" font-size: 15px;" class="text-center">سعر البيع داخل العرض</th>
                                                            <th style=" font-size: 15px;" class="text-center">الكميه</th>
                                                            <th style=" font-size: 15px;" class="text-center">حذف</th>
                                                        </thead>
                                                        <tbody id="items_container">
                                                            @foreach($offer->products as $product)
                                                                <tr>
                                                                    <td class="pt-3"style="font-size:17px;font-weight:bold">{{$product->name}}</td>
                                                                    <td><input type="hidden" name="id[]" value="{{$product->id}}" min="1"><input type="number" step=".01" style="font-size:17px;font-weight:bold"  name="selling_price[]" value="{{$product->pivot->product_price}}" class=" form-control text-center" min="1"></td>
                                                                    <td><input type="number" step=".01" style="font-size:17px;font-weight:bold"  name="quantity[]" value="{{$product->pivot->product_quantity}}" class=" form-control text-center" min="1"></td>
                                                                    <td class="pt-3"><button onclick="deleteRow(this)" type="button" style="width:100%" class="btn btn-danger btn-sm rounded-pill ml-3 "><i class="las la-trash"></i></button></td>
                                                                </tr>
                                                            @endforeach
                                                            @foreach($offer->composite_products as $product)
                                                                <tr>
                                                                    <td class="pt-3"style="font-size:17px;font-weight:bold">{{$product->name}}</td>
                                                                    <td><input type="hidden" name="c_id[]" value="{{$product->id}}" min="1"><input type="number" step=".01" style="font-size:17px;font-weight:bold"  name="c_selling_price[]" value="{{$product->pivot->selling_price}}" class=" form-control text-center" min="1"></td>
                                                                    <td><input type="number" step=".01" style="font-size:17px;font-weight:bold"  name="c_quantity[]" value="{{$product->pivot->quantity}}" class=" form-control text-center" min="1"></td>
                                                                    <td class="pt-3"><button onclick="deleteRow(this)" type="button" style="width:100%" class="btn btn-danger btn-sm rounded-pill ml-3 "><i class="las la-trash"></i></button></td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div><br>

                                                <div class="form-group">
                                                    <table class="table table-bordered mg-b-0 text-md-nowrap">
                                                        <thead id="service_header">
                                                            <th colspan="2" style=" font-size: 15px;">البيان</th>
                                                            <th style=" font-size: 15px;" class="text-center">السعر</th>
                                                            <th style=" font-size: 15px;" class="text-center">حذف</th>
                                                        </thead>
                                                        <tbody id="service_container">
                                                            @foreach($offer->offer_services as $s)
                                                                <tr>
                                                                <tr id="row`+id+`">
                                                                    <td colspan="2"><input type="text" style="font-size:17px;font-weight:bold" name="ser_desc[]" value="{{$s->details}}" class=" form-control"></td>
                                                                    <td><input type="number" step=".01" style="font-size:17px;font-weight:bold" name="ser_price[]" value="{{$s->price}}" class=" form-control text-center"></td>
                                                                    <td style="width:10px"><button type="button" name="delete1" class="btn btn-sm btn-danger float-none" onclick="deleteRow(this)" style="width:100%"><i class="fas fa-times" style="width:100%" class="float-none"></i></button></td>
                                                                </tr>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                        </table>
                                                </div><br>

                                                <div class="row">
                                                    <div class="form-group col">
                                                        <label  style="margin-right:15px" for="exampleFormControlTextarea2">قيود التعاقد</label>
                                                        <textarea style="font-size: 16px;  margin-right:10px" class="form-control" name="constraints" rows="8" cols="142" required>{{$offer->constraints}}</textarea>
                                                    </div>
                                                    <div class="form-group col">
                                                        <label  style="margin-left:15px;float: left;" for="exampleFormControlTextarea2">Contract restrictions</label>
                                                        <textarea style="font-size: 16px;   margin-left:10px; text-align: left;" lang="en"class="form-control" name="constraints_en" rows="8" cols="142" required>{{$offer->constraints_en}}</textarea>
                                                    </div></textarea>
                                                    </div>
                                                </div>

                                                <div class="row">
                                                    <div class="col">
                                                    <label for="inputName" class="control-label"> نسبه الخصم (%)</label>
                                                    <input  type="number" step=".01" class="form-control" id="discount" name="discount"
                                                    value="{{$offer->discount}}" min="0" max="100" title="يرجي ادخال اسم نسبة الخصم  " required>
                                                </div>
                                                <div class="col">
                                                        <label>العرض شاملة القيمة المضافة؟</label>
                                                        <select style="font-size:17px;font-weight:bold" class="form-control" name="value_add" required="required">
                                                        <option value="1">نعم</option>
                                                        <option value="0"selected>لا</option>
                                                        </select>
                                                </div>
                                                </div><br>
                                                
                                                <button type="submit" class="btn btn-primary w-100 ">تعديل العرض</button>
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
function deleteRow(btn) {
    var row = btn.parentNode.parentNode;
    var d = row.parentNode.parentNode.rowIndex;
    row.parentNode.removeChild(row);
    updateTotal();
    updateTotal2();
    check();
}
</script>
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
                $.ajax({
                  url: "{{ URL::to('composite-products-all') }}/" + stock_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                      $('#item_picker2').append('<option disabled selected>'+ "اختر الصنف" + '</option>');
                      $.each(data, function(key, value) {
                        $('#item_picker2').append('<option value="' +value.id + '" selling_price="' +value.selling_price + '">' + value.name + '</option>');
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
                <td><input type="hidden" name="id[]" value="`+id+`" min="1"><input type="number" step=".01" style="font-size:17px;font-weight:bold"  name="selling_price[]" value="`+selling_price+`" class=" form-control text-center" min="1"></td>
                <td><input type="number" step=".01" style="font-size:17px;font-weight:bold"  name="quantity[]" value="1" class=" form-control text-center" min="1"></td>
                <td class="pt-3"><button  onclick="deleteRow(this)" type="button" style="width:100%" type="button" class="btn btn-danger btn-sm rounded-pill ml-3 " id="remove`+id+`"><i class="las la-trash"></i></button></td>
                </tr>
                `);
            }
        
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
                <td class="pt-3"><button onclick="deleteRow(this)" style="width:100%" type="button" class="btn btn-danger btn-sm rounded-pill ml-3 " id="remove2`+id+`"><i class="las la-trash"></i></button></td>
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