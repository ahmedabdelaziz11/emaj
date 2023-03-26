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
                <a href="{{ url('/' . $page='returned-receipts') }}"> فواتير مرتجع المشتريات </a>

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
                                    </ul>
                                </div>
                            </div>
                            <div class="panel-body tabs-menu-body main-content-body-right border">
                                <div class="tab-content">

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
                                                            <h1 style="text-align: center ; font-weight: bold">فاتورة مرتجع مشتريات</h1>
                                                            <div class="row mg-t-20">
                                                                <div class="col-md" style="margin-left: 50px;">
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>رقم الفاتورة</span> <span></span>{{$receipt->id}}</p>
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>اسم المورد</span> <span></span>{{$receipt->supplier->name}}</p>
                                                                </div>
                                                                <div class="col-md">
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>تاريخ الاصدار</span>{{$receipt->date}}</p>
                                                                    <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>رقم القيد</span><a href="{{url('days')}}/{{$receipt->day_id}}"> {{$receipt->day_id}}</a></p>
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
                                                                        @foreach ($receipt->prodcuts as $product)
                                                                        <?php $i++; ?>
                                                                        <tr>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->name }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $product->pivot->product_quantity }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->product_Purchasing_price,2) }}</td>
                                                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($product->pivot->product_Purchasing_price * $product->pivot->product_quantity,2) }}</td>
                                                                        </tr>
                                                                        @endforeach
                                                                    </tbody>
                                                                </table>
                                                                <div class="table-responsive mg-t-40" style="width: 50%; float: left;margin-bottom: 10px;">
                                                                    <table class="table table-invoice  text-md-nowrap mb-0">
                                                                        <tbody class="tx-right">
                                                                            <tr class="border border-light tx-right">
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;">الاجمالى الجزئي</th>
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($receipt->sub_total,2) }}</th>
                                                                            </tr>
                                                                            <tr class="border border-light tx-right">
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;">القيمة المضافة</th>
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($receipt->value_added ? $receipt->sub_total * .14 : 0,2) }}</th>
                                                                            </tr>
                                                                            @if($receipt->discount != 0)
                                                                            <tr class="border border-light tx-right">
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;">الخصم</th>
                                                                                <th class="text-center" style="font-size: 17px;font-weight: bold;" colspan="2">{{ number_format($receipt->discount,2) }}</th>
                                                                            </tr>
                                                                            @endif
                                                                            <tr class="border border-light tx-right">
                                                                                <th class="text-center" style="font-size: 23px;font-weight: bold;">الصافى</th>
                                                                                <th class="text-center" style="font-size: 23px;font-weight: bold;" colspan="2">{{ number_format($receipt->total,2)}}</th>
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

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /div -->
    </div>
    <!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

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

@endsection