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
<style>
    @media print {
        #excel {
            display: none;
        }

        #print_Button {
            display: none;
        }
        #print_Button1 {
            display: none;
        }

        #sub_print {
            display: none;
        }

        .zxc {
            border: none;
            border-collapse: collapse;

        }

        .zxc td {
            border-left: 1px solid #000;
        }

        .zxc td:first-child {
            border-left: none;
        }
    }
</style>
@endsection

@section('title')
تفاصيل الفاتورة
@stop

@section('page-header')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">
                <a href="{{ url('/' . $page='invoices') }}"> فواتير المبيعات </a>

            </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                تفاصيل الفاتورة</span>
        </div>
    </div>
</div>
@endsection

@section('content')

<div class="row row-sm">
    <div class="col-xl-12">
        <div class="card mg-b-20" id="tabs-style2">
            <div class="card-body">
                <div class="text-wrap">
                    <div class="example">
                        <div class="panel panel-primary tabs-style-2">
                            <div class=" tab-menu-heading">
                                <div class="tabs-menu1">
                                    <ul class="nav panel-tabs main-nav-line">
                                        <li><a href="#tab4" class="nav-link active" data-toggle="tab">الفاتوره</a></li>
                                        <li><a href="#tab5" class="nav-link" data-toggle="tab">اذن الصرف</a></li>
                                        <li><a href="#tab6" class="nav-link" data-toggle="tab">تعديل</a></li>
                                        <li><a href="#tab9" class="nav-link" data-toggle="tab">المرفقات</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">

                                    <div class="tab-pane" id="tab5">
                                        <div class="row row-sm">
                                            <div class="col-md-12 col-xl-12">
                                                <div class=" main-content-body-invoice" id="print2">
                                                    <div class="card card-invoice">
                                                        <div class="card-body">
                                                            <div class="invoice-header">
                                                                <img src="{{URL::asset('assets/img/brand/logo.png')}}" style="height:150px;width: 150px;" class="logo-1" alt="logo">
                                                                <div class="billed-from">
                                                                    <h6></h6>
                                                                    <p style="font-weight: bold">شركة ايماج للهندسة و التجارة <br>
                                                                        ٣ محمد سليمان غنام , من محمد رفعت ,النزهة الجديدة <br>
                                                                        الهاتف : 01000241938 / 01208524340 <br>
                                                                        الايميل : info@emajegypt.com <br>
                                                                        س-ت : 110422 / ب-ض : 560-137-548
                                                                    </p>
                                                                </div><!-- billed-from -->
                                                            </div><!-- invoice-header -->
                                                            <h1 style="text-align: center ; font-weight: bold">اذن صرف</h1>
                                                            <div class="row mg-t-20">
                                                                <div class="col-md" style="margin-left: 50px;">
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>رقم الاذن</span> <span></span>{{$invoice->id}}</p>
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>اسم العميل</span> <span></span>{{$invoice->client->name}}</p>
                                                                </div>
                                                                <div class="col-md">
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>تاريخ الاصدار</span>{{$invoice->date}}</p>
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span> رقم اذن الصرف</span><a type="button" style="font-size: 18px;" class="dropdown-item " data-toggle="modal" data-target="#edit{{ $invoice->id }}" title="تعديل الرقم">{{ $invoice->p_num }}</a></p>
                                                                    
                                                                    <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv2()">
                                                                        <i class="mdi mdi-printer ml-1"></i>Print
                                                                    </a>

                                                                </div>
                                                            </div>
                                                            <div class="modal fade" id="edit{{ $invoice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                <div class="modal-dialog" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                                                تعديل رقم اذن فاتورة رقم {{$invoice->id}}
                                                                            </h5>
                                                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">
                                                                            <form action="{{ route('invoices.update',$invoice->id) }}" method="post" autocomplete="off">
                                                                                @csrf
                                                                                {{ method_field('patch') }}
                                                                                <div class="modal-body">
                                                                                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                                                                                    <div class="form-group">
                                                                                        <label>رقم الاذن</label>
                                                                                        <input class="form-control" name="p_num" type="text" value="{{$invoice->p_num}}" required>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="modal-footer">
                                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                                                                    <button type="submit" class="btn btn-danger">تاكيد</button>
                                                                                </div>
                                                                            </form>
                                                                        </div>
                                                                    </div>
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
                                                                        <?php $i = $c = 0; ?>
                                                                        @foreach ($invoice->invoice_products as $product)
                                                                        <?php 
                                                                            $i++;
                                                                            $c += $product->product_quantity;
                                                                        ?>
                                                                        <tr>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->product->name }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->product_quantity }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                        @foreach ($invoice->composite_products as $product)
                                                                        <?php 
                                                                            $i++;
                                                                            $c += $product->pivot->quantity;
                                                                        ?>
                                                                        <tr>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->name }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->pivot->quantity}}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                        <tr>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);" colspan="2">اجمالى الكميات</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $c }}</td>
                                                                        </tr>
                                                                    </tbody>
                                                                </table>
                                                                <div class="table-responsive mg-t-40">
                                                                    <table class="table table-invoice border text-md-nowrap mb-0">
                                                                        <tbody class="border border-light tx-right">
                                                                            <tr style="padding-bottom: 50px;">
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

                                    <div class="tab-pane active" id="tab4">
                                        <div class="row row-sm">
                                            <div class="col-md-12 col-xl-12">
                                                <div class=" main-content-body-invoice" id="print">
                                                    <div class="card card-invoice">
                                                        <div class="card-body">
                                                            <div class="invoice-header">
                                                                <img src="{{URL::asset('assets/img/brand/logo.png')}}" style="height:150px;width: 150px;" class="logo-1" alt="logo">
                                                                <div class="billed-from">
                                                                    <h6></h6>
                                                                    <p style="font-weight: bold">شركة ايماج للهندسة و التجارة <br>
                                                                        ٣ محمد سليمان غنام , من محمد رفعت ,النزهة الجديدة <br>
                                                                        الهاتف : 01000241938 / 01208524340 <br>
                                                                        الايميل : info@emajegypt.com <br>
                                                                        س-ت : 110422 / ب-ض : 560-137-548
                                                                    </p>
                                                                </div><!-- billed-from -->
                                                            </div><!-- invoice-header -->
                                                            <h1 style="text-align: center ; font-weight: bold">فاتورة بيع</h1>
                                                            <div class="row mg-t-20">
                                                                <div class="col-md" style="margin-left: 50px;">
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>رقم الفاتورة</span> <span></span>{{$invoice->id}}</p>
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>اسم العميل</span> <span></span>{{$invoice->client->name}}</p>
                                                                </div>
                                                                <div class="col-md">
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>تاريخ الاصدار</span>{{$invoice->date}}</p>
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>رقم القيد</span><a href="{{url('days')}}/{{$invoice->day_id}}"> {{$invoice->day_id}}</a></p>
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>رقم العرض</span><a href="{{url('offers')}}/{{$invoice->offer_id}}"> {{$invoice->offer_id}}</a></p>
                                                                    <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                                                        <i class="mdi mdi-printer ml-1"></i>Print
                                                                    </a>
                                                                    <button type="button" class="btn btn-danger float-left mt-3 mr-2" id="print_Button1" data-toggle="modal" data-target="#delete{{ $invoice->id }}" title="حذف"><i class="btn btn-sm btn-danger fa fa-edit "></i> حذف</button>
                                                                    <div class="modal fade" id="delete{{ $invoice->id }}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                                        <div class="modal-dialog" role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header">
                                                                                    <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title" id="exampleModalLabel">
                                                                                        حذف فاتورة رقم {{$invoice->id}}
                                                                                    </h5>
                                                                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                                        <span aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">
                                                                                    <form id="{{$invoice->id}}" action="{{route('invoices.destroy',1)}}" method="post">
                                                                                        {{ method_field('delete') }}
                                                                                        {{ csrf_field() }}
                                                                                        <div class="modal-body">
                                                                                            <input type="hidden" name="id" value="{{ $invoice->id }}">
                                                                                            <p class="text-danger">هل انت متاكد من عملية الحذف ؟</p>
                                                                                        </div>
                                                                                        <div class="modal-footer">
                                                                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                                                                                            <button type="submit" class="btn btn-danger"onclick="document.getElementById('{{$invoice->id}}').submit();">تاكيد</button>
                                                                                        </div>
                                                                                    </form>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
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
                                                                        <?php $i = 0; $t_services = 0; ?>
                                                                        @foreach ($invoice->invoice_products as $product)
                                                                        <?php $i++; ?>
                                                                        <tr>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->product->name }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->product_quantity }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->product_selling_price,2) }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->product_selling_price * $product->product_quantity,2) }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                        @foreach ($invoice->composite_products as $product)
                                                                        <?php $i++; ?>
                                                                        <tr>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->name }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->pivot->quantity}}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->selling_price,2) }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->selling_price * $product->pivot->quantity,2) }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                        @foreach ($invoice->services as $service)
                                                                        <?php $i++;
                                                                            $t_services += $service->price;
                                                                        ?>
                                                                        <tr>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);" colspan="2">{{ $service->details }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);" colspan="2">{{ $service->price }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                                <div class="table-responsive mg-t-40" style="width: 50%; float: left;margin-bottom: 10px;">
                                                                    <table class="table table-invoice  text-md-nowrap mb-0">
                                                                        <tbody class="tx-right">
                                                                            <tr class="border border-light tx-right">
                                                                                <th class="text-right" style="font-size: 17px;font-weight: bold;">الاجمالى الجزئي</th>
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($invoice->sub_total,2) }}</th>
                                                                            </tr>
                                                                            
                                                                            <tr class="border border-light tx-right">
                                                                                <th class="text-right" style="font-size: 17px;font-weight: bold;">اجمالى الخدمات</th>
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($t_services,2) }}</th>
                                                                            </tr>
                                                                            @if($invoice->additions != 0)
                                                                            <tr class="border border-light tx-right">
                                                                                <th class="text-right" style="font-size: 17px;font-weight: bold;">المصاريف</th>
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($invoice->additions,2) }}</th>
                                                                            </tr>
                                                                            @endif
                                                                            @if($invoice->discount != 0)
                                                                            <tr class="border border-light tx-right">
                                                                                <th class="text-right" style="font-size: 17px;font-weight: bold;">الخصم</th>
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($invoice->sub_total * ($invoice->discount / 100 ),2) }}</th>
                                                                            </tr>
                                                                            @endif
                                                                            @if($invoice->value_added != 0)
                                                                            <tr class="border border-light tx-right">
                                                                                <th class="text-right" style="font-size: 17px;font-weight: bold;">القيمة المضافة</th>
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($invoice->value_added,2) }}</th>
                                                                            </tr>
                                                                            @endif
                                                                            <tr class="border border-light tx-right">
                                                                                <th class="text-right" style="font-size: 23px;font-weight: bold;">الصافى</th>
                                                                                <th class="text-center" style="font-size: 23px;font-weight: bold;" colspan="2">{{ number_format($invoice->total,2)}}</th>
                                                                            </tr>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="table-responsive mg-t-40">
                                                                    <table class="table table-invoice border text-md-nowrap mb-0">
                                                                        <tbody class="border border-light tx-right">
                                                                            <tr style="padding-bottom: 50px;">
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

                                    <div class="tab-pane" id="tab6">
                                        <div class="card mg-b-20" id="tabs-style2">
                                            <div class="card-body">
                                                <form action="{{ route('invoices.update',$invoice->id) }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                                    @csrf
                                                    {{ method_field('patch') }}
                                                    <input type="hidden" id="address" name="adress_id" value="{{$invoice->adress}}">
                                                    <input type="hidden" id="ticket_id" name="ticket_id" value="{{$invoice->ticket_id}}">
                                                    <input type="hidden" name="invoice_id" value="{{$invoice->id}}">
                                                    <div class="row">
                                                        <div class="col">
                                                            <label>تاريخ الفاتوره</label>
                                                            <input class="form-control fc-datepicker" name="date" placeholder="YYYY-MM-DD" type="text" value="{{$invoice->date}}"  required>
                                                        </div>

                                                        <div class="form-group col">
                                                            <label>العميل</label>
                                                            <select class="form-control select2 " name="client_id" required="required">
                                                                <option value="">اختر العميل </option>
                                                                @foreach ($clients as $client)
                                                                <option value="{{ $client->id }}">{{ $client->name }}</option>
                                                                    @if($client->accounts->count() > 0)
                                                                    @foreach ($client->accounts as $account1)
                                                                        <option value="{{ $account1->id }}" >{{ $account1->name }}</option>
                                                                    @endforeach
                                                                    @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col">
                                                            <label>حساب النقدية</label>
                                                            <select class="form-control select2" name="account_id" id="account_id"  required="required">
                                                                <option value="0" @if($invoice->account_id == null) selected @endif>اجل</option>
                                                                @foreach ($accounts as $account)
                                                                @if($account->id == 58)
                                                                    <option value="{{ $account->id }}" disabled  >{{ $account->name }}</option>
                                                                @else
                                                                    <option value="{{ $account->id }}" @if($invoice->account_id == $account->id ) selected @endif >{{ $account->name }}</option>
                                                                @endif
                                                                @if($account->accounts->count() > 0)
                                                                    @foreach ($account->accounts as $account1)
                                                                    <option value="{{ $account1->id }}" @if($invoice->account_id == $account1->id ) selected @endif >{{ $account1->name }}</option>
                                                                    @endforeach
                                                                @endif
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="col">
                                                            <label>مركز التكلفة</label>
                                                            <select class="form-control select2" name="cost_id" id="cost_id" required="required">
                                                                @foreach ($costs as $cost)
                                                                <option value="{{ $cost->id }}" @if($invoice->cost_id == $cost->id  ) selected @endif>{{ $cost->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div><br>


                                                    <div class="row">
                                                        <div class="form-group col">
                                                            <label>المخزن</label>
                                                            <select class="form-control select2" name="stock_id" id="stock_id" required="required">
                                                                <option value="0" selected disabled>اختر المخزن</option>
                                                                @foreach ($stocks as $stock)
                                                                <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                        <div class="form-group col">
                                                            <label>رقم العرض</label>
                                                            <select class="form-control select2" name="offer_id" required="required">
                                                                <option value="">اختر العرض </option>

                                                            </select>
                                                        </div>

                                                        <div class="col">
                                                            <label for="inputName"  class="control-label">نسبة الخصم</label>
                                                            <input style="font-size:17px;font-weight:bold" type="text" step=".01" class="form-control" id="discount" name="discount" readonly>
                                                        </div>
                                                        <input type="hidden" class="form-control" id="profit" name="profit">
                                                        <input type="hidden" class="form-control" id="c_sales" name="c_sales">
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">اجمالى الخدمات</label>
                                                            <input style="font-size:17px;font-weight:bold" type="text" step=".01" class="form-control" id="t_service" name="t_service" readonly>
                                                        </div>
                                                        
                                                    </div><br>

                                                    <div class="row">
                                                        <div class="col">
                                                            <label for="inputName" class="control-label">اجمالى المنتجات</label>
                                                            <input style="font-size:17px;font-weight:bold" type="text" step=".01" class="form-control" id="total" name="total" readonly>
                                                        </div>
                                                        <div class="col">
                                                                <label>الفاتورة شاملة القيمة المضافة؟</label>
                                                                <select style="font-size:17px;font-weight:bold" class="form-control" name="value_add" id="value_add" onchange='updateTotal1();' required="required">
                                                                <option value="1">نعم</option>
                                                                <option value="0">لا</option>
                                                                </select>
                                                        </div>
                                                        <div class="col">
                                                                <label>نوع الفاتورة</label>
                                                                <select style="font-size:17px;font-weight:bold" class="form-control" name="dman" id="dman" onchange='updateTotal();' required="required">
                                                                <option value="0">داخل التكلفة</option>
                                                                <option value="1">خارج التكلفة</option>
                                                                </select>
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <div class="row">
                                                        <div class="form-group col">
                                                            <label>الصافى</label>
                                                            <input style="font-size:17px;font-weight:bold" class="form-control" step=".01" type="text" name="f_total" id="f_total" value="0" min="0" disabled>
                                                        </div>
                                                        <div class="form-group col">
                                                            <label>المبلغ المدفوع</label>
                                                            <input style="font-size:17px;font-weight:bold" class="form-control" step=".01" type="number" name="amount_paid" id="amount_paid" value="0" min="0">
                                                        </div>
                                                    </div>
                                                    <br>
                                                    <button type="submit" class="btn btn-primary w-100 ">تعديل الفاتوره</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="tab-pane" id="tab9">
                                        <!--المرفقات-->
                                        <div class="card card-statistics">
                                            <div class="card-body">
                                                <p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
                                                <h5 class="card-title">اضافة مرفقات</h5>
                                                <form method="post" action="{{ url('/InvoiceAttachments') }}" enctype="multipart/form-data">
                                                    {{ csrf_field() }}
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="customFile" name="file_name" required>
                                                        <input type="hidden" id="invoice_id" name="invoice_id" value="{{ $invoice->id }}">
                                                        <label class="custom-file-label" for="customFile">حدد
                                                            المرفق</label>
                                                    </div><br><br>
                                                    <button type="submit" class="btn btn-primary btn-sm " name="uploadedFile">تاكيد</button>
                                                </form>
                                            </div>
                                            <br>

                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table table-hover" style="text-align:center">
                                                    <thead>
                                                        <tr class="text-dark">
                                                            <th scope="col">م</th>
                                                            <th scope="col">اسم الملف</th>
                                                            <th scope="col">قام بالاضافة</th>
                                                            <th scope="col">تاريخ الاضافة</th>
                                                            <th scope="col">العمليات</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <?php $i = 0; ?>
                                                        @foreach ($attachments as $attachment)
                                                        <?php $i++; ?>
                                                        <tr>
                                                            <td>{{ $i }}</td>
                                                            <td>{{ $attachment->file_name }}</td>
                                                            <td>{{ $attachment->Created_by }}</td>
                                                            <td>{{ $attachment->created_at }}</td>
                                                            <td colspan="2">

                                                                <a class="btn btn-outline-success btn-sm" href="{{ url('View_file') }}/{{ $invoice->id }}/{{ $attachment->file_name }}" role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                    عرض</a>

                                                                <a class="btn btn-outline-info btn-sm" href="{{ url('download') }}/{{ $invoice->id }}/{{ $attachment->file_name }}" role="button"><i class="fas fa-download"></i>&nbsp;
                                                                    تحميل</a>

                                                                {{-- @can('حذف المرفق') --}}
                                                                <button class="btn btn-outline-danger btn-sm" data-toggle="modal" data-file_name="{{ $attachment->file_name }}" data-invoice_id="{{ $attachment->invoice_id }}" data-id_file="{{ $attachment->id }}" data-target="#delete_file">حذف</button>
                                                                {{-- @endcan --}}

                                                            </td>
                                                        </tr>
                                                        @endforeach
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
        <!-- /div -->
    </div>
    <!-- delete -->
    <div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_file') }}" method="post">

                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
                        </p>

                        <input type="hidden" name="id_file" id="id_file" value="">
                        <input type="hidden" name="file_name" id="file_name" value="">
                        <input type="hidden" name="invoice_id" id="invoice_id" value="">

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
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
<script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();
</script>
<script>
        window.onload = function (){
        

        if(parseFloat(document.getElementById("account_id").value) == 0)
        {
        document.getElementById("amount_paid").readOnly   = true;
        }else{
        document.getElementById("amount_paid").readOnly   = false;
        }
    }
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
</script>

<script type="text/javascript">
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
    $('#delete_file').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id_file = button.data('id_file')
        var file_name = button.data('file_name')
        var invoice_id = button.data('invoice_id')
        var modal = $(this)
        modal.find('.modal-body #id_file').val(id_file);
        modal.find('.modal-body #file_name').val(file_name);
        modal.find('.modal-body #invoice_id').val(invoice_id);
    })
</script>

<script>
    $(document).ready(function() {
        document.getElementById("account_id").onchange = function() {
            if (parseFloat(document.getElementById("account_id").value) == 0) {
                document.getElementById("amount_paid").readOnly = true;
            } else {
                if (parseFloat(document.getElementById("dman").value) == 1) {
                    document.getElementById("amount_paid").readOnly = true;
                } else {
                    document.getElementById("amount_paid").readOnly = false;
                }
            }
        };
        document.getElementById("dman").onchange = function() {
            if (parseFloat(document.getElementById("dman").value) == 1) {
                document.getElementById("amount_paid").readOnly = true;
            } else {
                if (parseFloat(document.getElementById("account_id").value) == 0) {
                    document.getElementById("amount_paid").readOnly = true;
                } else {
                    document.getElementById("amount_paid").readOnly = false;
                }
            }
        };
    });
</script>

<script>
    function updateTotal1() {
        var sub_total = parseFloat( document.getElementById("total").value); 
        var t_service = parseFloat( document.getElementById("t_service").value); 
        var discount  =  parseFloat(document.getElementById("discount").value);
        var value_add = parseFloat(document.getElementById("value_add").value);
        var total = 0;
        total = sub_total ;
        total = total - (total * (discount/100));
        if(value_add == 1)
        {
          total = total + (total * 0.14 );
        }
        total = total + t_service;
        total = new Intl.NumberFormat().format(total);
        document.getElementById("f_total").value = total ;   
    }
</script>

<script>
    $(document).ready(function() {
        $('select[name="offer_id"]').on('change', function() {
            var OfferId = $(this).val();
            if (OfferId) {
                $.ajax({
                    url: "{{ URL::to('offer_data') }}/" + OfferId,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        document.getElementById("discount").value = data['discount'];
                        document.getElementById("t_service").value = data['t_service'];
                        document.getElementById("total").value  = data['total'];
                        document.getElementById("profit").value = data['profit'];
                        document.getElementById("c_sales").value = data['c_sales'];
                        document.getElementById("address").value = data['address'];
                        document.getElementById("ticket_id").value = data['ticket_id'];
                        updateTotal1();
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });

        $('select[name="stock_id"]').on('change', function() {
            var stock_id = $(this).val();
            $.ajax({
                url: "{{ URL::to('get-offer') }}/" + stock_id,
                type: "GET",
                dataType: "json",
                success: function(data) {
                    $('select[name="offer_id"]').empty();
                    $('select[name="offer_id"]').append('<option disabled selected>' + "اختر العرض" + '</option>');
                    $.each(data, function(key, value) {
                        $('select[name="offer_id"]').append('<option value="' + value + '">' + value + '</option>');
                    });
                },
            });
            updateTotal1();
        
        });
    });
</script>

@endsection