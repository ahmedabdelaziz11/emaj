@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<style>
    @media print {
        #excel {
            display: none;
        }
        #row1 {
            display: none;
        }
        #row5 {
            display: none;
        }
        #row3 {
            display: none;
        }
        #row4 {
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
رسم بيانى {{$account1->name ?? ''}}
@stop
@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto" id="row5">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المحاسبة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/  رسم بيانى
            </span>
        </div>
    </div>
</div>
<div class="row" id="row1">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0" id="form">

                <form action="{{route('get-account-graph')}}" method="POST" role="search" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlSelect1">الحساب</label>
                            <select class="form-control select2 " name="account_ids[]" multiple required>
                                <option value="">اختر الحساب </option>
                                @foreach ($accounts as $account)
                                <option @if(isset($account1) && $account1->id == $account->id) selected @endif value="{{ $account->id }}">{{ $account->name }} - {{$account->code}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label>اسم التقرير</label>
                            <input type="text" name="report_name" value="{{$report_name ?? ''}}" placeholder="ادخل اسم الحساب" class="form-control">
                        </div>
                        <div class="col-lg-3" id="start_at">
                            <label for="exampleFormControlSelect1">من تاريخ</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" value="{{ $start_at ?? '' }}" name="start_at" placeholder="YYYY-MM-DD" type="text" required>
                            </div><!-- input-group -->
                        </div>


                        <div class="col-lg-3" id="end_at">
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
@if (isset($report_name))
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
                    <h1 style="text-align: center ; font-weight: bold">{{$report_name}}</h1>
                    <div class="row mg-t-20">
                        <div class="col-md" style="margin-left: 50px;">
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>تاريخ التقرير</span>{{ date('Y-m-d') }}</p>
                        </div>
                        <div class="col-md">
                            <p class="invoice-info-row" style="font-size: 17px;font-weight: bold"><span>الفترة</span>من : {{$start_at}}<span> الي : {{$end_at}}</span></p>
                        </div>
                    </div>
                    <br>
                    <div class="row">
                        <div class="col-8" style="font-size: 16px;width: 80%">
                            <div class="card card-dashboard-map-one">
                                <label class="main-content-label" style="font-size: 16px;">ارصدة الحساب</label>
                                <div style="width: 600px;height: 1000px;font-size:16px;">
                                    {!! $chartjs->render() !!}
                                </div>
                            </div>
                        </div>
                        <div class="col-4" style="width: 20%">
                            <div class="table-responsive mg-t-40">
                                <table class="table table-invoice border text-md-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <td class="text-center" style="font-size: 16px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">الشهر</td>
                                            <td class="text-center" style="font-size: 16px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">الرصيد</td>
                                        </tr>
                                        <?php 
                                            $t = 0;
                                        ?>
                                        @foreach($account_per_month as $m)
                                        <?php 
                                            $t += $m;
                                        ?>
                                            <tr>
                                                <td class="text-center" style="font-size: 20px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{$loop->iteration}}</td>
                                                <td class="text-center" style="font-size: 20px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{$m}}</td>
                                            </tr>
                                        @endforeach
                                        <tr>
                                            <td class="text-center" style="font-size: 20px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">الاجمالى</td>
                                            <td class="text-center" style="font-size: 20px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{$t}}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
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
        window.print();
        location.reload();
    }
</script>
@endsection