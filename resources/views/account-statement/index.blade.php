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
كشف حساب {{$account1->name ?? ''}}
@stop
@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المحاسبة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ كشف حساب
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0" id="form">

                <form action="{{route('account-statement.store')}}" method="POST" role="search" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlSelect1">الحساب</label>
                            <select class="form-control select2 " name="account_id" required>
                                <option value="">اختر الحساب </option>
                                @foreach ($accounts as $account)
                                <option @if(isset($account1) && $account1->id == $account->id) selected @endif value="{{ $account->id }}">{{ $account->name }} - {{$account->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="exampleFormControlSelect1">مستوى الفرع</label>
                            <select class="form-control select2 " name="level">
                                <option value="">اختر النوع </option>
                                <option @if(isset($level) && $level == 0) selected @endif value="0">حركات الحساب</option>
                                <option @if(isset($level) && $level == 1) selected @endif value="1">1</option>
                                <option @if(isset($level) && $level == 2) selected @endif value="2">2</option>
                                <option @if(isset($level) && $level == 3) selected @endif value="3">3</option>
                                <option @if(isset($level) && $level == 4) selected @endif value="4">4</option>
                                <option @if(isset($level) && $level == 5) selected @endif value="5">5</option>
                                <option @if(isset($level) && $level == 6) selected @endif value="6">6</option>
                                <option @if(isset($level) && $level == 7) selected @endif value="7">7</option>
                            </select>
                        </div>
                        <div class="col" id="start_at">
                            <label for="exampleFormControlSelect1">من تاريخ</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" value="{{ $start_at ?? '' }}" name="start_at" placeholder="YYYY-MM-DD" type="text" required>
                            </div><!-- input-group -->
                        </div>


                        <div class="col" id="end_at">
                            <label for="exampleFormControlSelect1">الي تاريخ</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" name="end_at" value="{{ $end_at ?? date('Y-m-d') }}" placeholder="YYYY-MM-DD" type="text" required>
                            </div><!-- input-group -->
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12" style="margin-top: 20px">
                            <button class="btn btn-primary btn-block">بحث</button>
                        </div>
                    </div><br>

                </form>

            </div>
        </div>
    </div>
</div>
@if (isset($days))
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
                    <h1 style="text-align: center ; font-weight: bold">كشف حساب</h1>
                    <div class="row mg-t-20">
                        <div class="col-md" style="margin-left: 50px;">
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>كود الحساب</span> <span></span>{{$account1->code}}</p>
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>اسم الحساب</span> <span></span>{{$account1->name}}</p>
                        </div>
                        <div class="col-md">
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>تاريخ التقرير</span>{{ date('Y-m-d') }}</span></p>
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>الفترة</span>من : {{$start_at}}<span> الي : {{$end_at}}</span></p>
                            <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                <i class="mdi mdi-printer ml-1"></i>Print
                            </a>
                            <button type="submit" form="download" id="excel" class="btn btn-success float-left mt-3 mr-2" >
                                <i class="mdi mdi-printer ml-1"></i>Excel
                            </button>
                            <form id="download" action="{{ route('account-statemeent-excel') }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('post') }}
                                    <input type="hidden" name="account_id" value="{{$account1->id}}">
                                    <input type="hidden" name="level" value="{{$level}}">
                                    <input type="hidden" name="start_at" value="{{$start_at}}">
                                    <input type="hidden" name="end_at" value="{{$end_at}}">
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">التاريخ</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">البيان</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">مدين</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">دائن</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">رصيد</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if($start_account != 0 )
                                    <tr>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $start_date }}</td>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">رصيد دفترى</td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format(0)}}</td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format(0)}}</td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($start_account,2)}}</td>
                                    </tr>
                                @endif

                                @php
                                $total_debit = $total_credit = 0;
                                @endphp 
                                @foreach($days as $x) 
                                    @php $total_debit +=$x->debit;
                                        $total_credit += $x->credit;
                                        $start_account += $x->debit - $x->credit;
                                    @endphp
                                    <tr>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->date }}</td>
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"><a href="{{url('days')}}/{{$x->day->id}}">{{$x->note ?? 'لا يوجد'}}</a></td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x->debit,2)}}</td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x->credit,2)}}</td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($start_account,2)}}</td>

                                    </tr>
                                    @endforeach
                                    <tr class="table-dark" style="color: black;">
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);" colspan="2">الاجمالى</td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($total_debit,2)}}</td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($total_credit,2)}}</td>
                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($start_account,2)}}</td>
                                    </tr>
                            </tbody>
                        </table>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <tbody class="border border-light tx-right">
                                    <tr class="border border-light tx-right">
                                        <th style=" font-size: 23px;font-weight: bold" class="tx-center" colspan="3">الرصيد</th>
                                        <th style="font-size: 25px" class="tx-right" colspan="1">{{ number_format($start_account,2) }}</th>
                                    </tr>
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
@if (isset($data))
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
                    <h1 style="text-align: center ; font-weight: bold">كشف حساب</h1>
                    <div class="row mg-t-20">
                        <div class="col-md" style="margin-left: 50px;">
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>كود الحساب</span> <span></span>{{$account1->code}}</p>
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>اسم الحساب</span> <span></span>{{$account1->name}}</p>
                        </div>
                        <div class="col-md">
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>تاريخ التقرير</span>{{ date('Y-m-d') }}</span></p>
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>الفترة</span>من : {{$start_at}}<span> الي : {{$end_at}}</span></p>
                            <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                <i class="mdi mdi-printer ml-1"></i>Print
                            </a>
                            <button type="submit" form="download" id="excel" class="btn btn-success float-left mt-3 mr-2" >
                                <i class="mdi mdi-printer ml-1"></i>Excel
                            </button>
                            <form id="download" action="{{ route('account-statemeent-excel') }}" method="post">
                                {{ csrf_field() }}
                                {{ method_field('post') }}
                                    <input type="hidden" name="account_id" value="{{$account1->id}}">
                                    <input type="hidden" name="level" value="{{$level}}">
                                    <input type="hidden" name="start_at" value="{{$start_at}}">
                                    <input type="hidden" name="end_at" value="{{$end_at}}">
                            </form>
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكود</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الاسم</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">رصيد سابق</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">مدين</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">دائن</th>
                                    <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">رصيد</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                $total_acc = $total_p_acc = $total_debit = $total_credit = 0;
                                @endphp
                                @foreach($data as $x)
                                @php
                                $total_acc += $x['c_account'];
                                $total_p_acc += $x['p_account'];
                                $total_debit += $x['debit'];
                                $total_credit += $x['credit'];
                                @endphp
                                <tr>
                                    <form id="{{$x['id']}}" action="{{route('account-statement.store')}}" method="POST" role="search" autocomplete="off">
                                        {{ csrf_field() }}
                                        <input type="hidden" name="level" value="2">
                                        <input type="hidden" name="account_id" value="{{$x['id']}}">
                                        <input type="hidden" name="end_at" value="{{$end_at}}">
                                        <input type="hidden" name="start_at" value="{{$start_at}}">
                                        <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);"> <a href="javascript:{}" onclick="document.getElementById('{{$x['id']}}').submit();">{{$x['code']}}</a></td>
                                    </form>
                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{$x['name']}}</td>
                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x['p_account'])}}</td>
                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x['debit'])}}</td>
                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x['credit'])}}</td>
                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x['c_account'])}}</td>

                                </tr>
                                @endforeach
                                <tr class="table-dark" style="color: black;">
                                    <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);" colspan="2">الاجمالى</td>
                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($total_p_acc,2)}}</td>
                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($total_debit,2)}}</td>
                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($total_credit,2)}}</td>
                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($total_acc,2)}}</td>
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