@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<style>
    @media print {
        #excel {
            display: none;
        }

        #print_Button {
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
تقرير عملاء داخل الضمان {{$client->name ?? ''}}
@stop
@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ عملاء داخل الضمان
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0" id="form">

                <form action="{{route('create-client-report')}}" method="POST" role="search" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="form-group col-3">
                            <label>العميل</label>
                            <select class="form-control select2" name="client_id" required="required">
                                <option value="0" selected disabled>اختر العميل</option>
                                @foreach ($clients as $s)
                                <option value="{{ $s->id }}" @if(isset($client) && $client->id == $s->id) selected @endif> {{ $s->name }} </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-lg-3" id="start_at">
                            <label for="exampleFormControlSelect1">من تاريخ</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" value="{{ $start_at ?? '' }}"
                                    name="start_at" placeholder="YYYY-MM-DD" type="text" required>
                            </div><!-- input-group -->
                        </div>


                        <div class="col-lg-3" id="end_at">
                            <label for="exampleFormControlSelect1">الي تاريخ</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" name="end_at"
                                    value="{{ $end_at ?? date('Y-m-d') }}" placeholder="YYYY-MM-DD" type="text" required>
                            </div><!-- input-group -->
                        </div>

                        <div class="col-lg-3" style="margin-top: 30px;">
                            <button class="btn btn-primary btn-block">بحث</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
</div>
@if (isset($invoices))
<div class="row row-sm">
    <div class="col-md-12 col-xl-12">
        <div class=" main-content-body-invoice" id="print">
            <div class="card card-invoice">
                <div class="card-body">
                    <div class="invoice-header">
                        <img src="{{URL::asset('assets/img/brand/logo.png')}}" style="height:150px" class="logo-1" alt="logo">
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
                    <h1 style="text-align: center ; font-weight: bold">تقرير عملاء داخل الضمان {{$client->name}}</h1>
                    <div class="row mg-t-20">
                        <div class="col-md" style="margin-left: 50px;">
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>اسم العميل</span> <span></span>{{$client->name}}</p>
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>من</span>{{$start_at}} <span> الى </span>{{$end_at}}</p>
                        </div>
                        <div class="col-md">
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>تاريخ التقرير</span>{{ date('Y-m-d') }}</p>
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
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">رقم الفاتورة</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">اسم الصنف</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">سعر الشراء</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">سعر البيع</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكمية</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الرصيد</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $total = 0; ?>
                                @foreach ($invoices as $invoice)
                                    @foreach($invoice->invoice_products as $x)
                                        @php 
                                            $total += ($x->product_Purchasing_price * $x->product_quantity);
                                        @endphp
                                        <tr>
                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $invoice->date }}</td>
                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"><a href="{{ url('InvoiceDetails') }}/{{ $x->invoice_id }}">{{ $x->invoice_id }}</a></td>
                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->product->name }}</td>
                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($x->product_Purchasing_price,2) }}</td>
                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($x->product_selling_price,2) }}</td>
                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->product_quantity }}</td>
                                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($x->product_quantity * $x->product_Purchasing_price ,2) }}</td>
                                        </tr>
                                    @endforeach
                                @endforeach
                            </tbody>
                        </table>

                        <div class="table-responsive mg-t-40">
                            <table  class="table table-invoice border text-md-nowrap mb-0">
                                <tbody class="border border-light tx-right">
                                    <tr>
                                        <th style=" font-size: 23px;font-weight: bold" class="tx-right" colspan="3"> اجمالي التكلفة</th>
                                        <th style="font-size: 25px" class="tx-right" >{{ number_format($total,2) }}</th>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    @endif
    @if (isset($stock) && $type == 2)
    <div class="row row-sm">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice" id="print">
                <div class="card card-invoice">
                    <div class="card-body">
                        <div class="invoice-header">
                            <img src="{{URL::asset('assets/img/brand/logo.png')}}" style="height:150px" class="logo-1" alt="logo">
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
                        <h1 style="text-align: center ; font-weight: bold">تقرير مخزون {{$stock->name}}</h1>
                        <div class="row mg-t-20">
                            <div class="col-md" style="margin-left: 50px;">
                                <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>اسم المخزون</span> <span></span>{{$stock->name}}</p>
                                <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>نوع التقرير</span> <span></span>تفصيلي</p>
                            </div>
                            <div class="col-md">
                                <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>تاريخ التقرير</span>{{ date('Y-m-d') }}</p>
                                <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                    <i class="mdi mdi-printer ml-1"></i>Print
                                </a>
                                <button type="submit" form="download" id="excel" class="btn btn-success float-left mt-3 mr-2" >
                                    <i class="mdi mdi-printer ml-1"></i>Excel
                                </button>
                            </div>
                        </div>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">#</th>
                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكود</th>
                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الاسم</th>
                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">سعر الشراء</th>
                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">سعر البيع</th>
                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكمية</th>
                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الاجمالى</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $i = $total = $f_total = $quantities = 0;
                                    @endphp
                                    <form id="download" action="{{ route('download-product-sheet') }}" method="post">
                                        {{ csrf_field() }}
                                        {{ method_field('post') }}
                                        <input type="hidden" name="stock_name" value="{{$stock->name}}">

                                    @foreach($stock->products()->where('quantity','!=',0)->get()->sortBy('id') as $x)
                                        @php
                                            $i++;
                                            $total = $x->quantity * $x->Purchasing_price;
                                            $f_total += $total;
                                            $quantities += $x->quantity;
                                        @endphp

                                        <input type="hidden" name="name[]" value="{{$x->name}}">
                                        <input type="hidden" name="Purchasing_price[]" value="{{$x->Purchasing_price}}">
                                        <input type="hidden" name="selling_price[]" value="{{$x->selling_price}}">
                                        <input type="hidden" name="quantity[]" value="{{$x->quantity}}">

                                    <tr>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->id }}</td>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->name }}</td>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->Purchasing_price }}</td>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->selling_price }}</td>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->quantity }}</td>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $total}}</td>
                                    </tr>
                                    @endforeach
                                    </form>
                                    <tr class="table-dark" style="color: black;">
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);" colspan="5">الاجمالى</td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($quantities)}}</td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($f_total,2)}}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="table-responsive mg-t-40">
                                <table class="table table-invoice border text-md-nowrap mb-0">
                                    <tbody class="border border-light tx-right">
                                        <tr>
                                            <th style="border: none; font-size: 24px; padding-right: 150px;padding-bottom: 40px">توقيع المحاسب</th>
                                            <th style="border: none; font-size: 25px" class="tx-right" colspan="2">توقيع المدير المالى</th>
                                            <th style="border: none; font-size: 25px" class="tx-right" colspan="2">توقيع المدير العام</th>
                                        </tr>

                                        <tr>
                                            <th style="border: none; font-size: 27px;font-weight: bold" class="tx-right"></th>
                                            <th style="border: none; font-size: 25px" class="tx-right" colspan="2"></th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- COL-END -->
    </div>
    @endif
    @endsection
    @section('js')


    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>
    <!--Internal  Chart.bundle js -->
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