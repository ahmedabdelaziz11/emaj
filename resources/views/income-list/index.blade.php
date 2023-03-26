@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<style>

	@media print {
		#excel{
			display: none;
		}
        #print_Button{
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
قائمة الدخل
@stop
@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المحاسبة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ قائمة الدخل  
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0" id="form">

                <form action="{{route('income-list.store')}}" method="POST" role="search" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col">
                            <label for="exampleFormControlSelect1">مركز التكلفة</label>
                            <select class="form-control select2 " name="cost_id">
                                <option value="">اختر المركز </option>
                                <option value="0">الكل</option>
                                @foreach ($costs as $cost)
                                    <option value="{{ $cost->id }}">{{ $cost->name }}</option>
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
                        <div class="col-lg-3" style="margin-top: 30px">
                            <button class="btn btn-primary btn-block">بحث</button>
                        </div>
                    </div><br>

                </form>

            </div>
        </div>
    </div>
</div>
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
                            <p style="font-weight: bold">شركة ايماج للهندسة و التجارة     <br>
                            ٣ محمد سليمان غنام , من محمد رفعت ,النزهة الجديدة      <br>
                                الهاتف :  01000241938 / 01208524340   <br>
                                الايميل :  info@emajegypt.com <br>
                                س-ت : 110422 / ب-ض : 560-137-548
                            </p>
                        </div><!-- billed-from -->
                    </div><!-- invoice-header -->
                    <h1 style="text-align: center ; font-weight: bold">قائمة الدخل</h1>
                    <div class="row mg-t-20">
                        <div class="col-md" style="margin-left: 50px;">
                            <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>مركز التكلفة</span> <span></span>{{$Cost->name ?? 'لا يوجد'}}</p>
                        </div>
                        <div class="col-md">
                            <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                <i class="mdi mdi-printer ml-1"></i>Print
                            </a>
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                                    <tr class="thead-light">
                                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center" colspan="2">الايردات</th>
                                    </tr>
                                    <tr>
                                        @php 
                                            $income = 0;
                                        @endphp
                                        @foreach($data as $x)
                                            @if(strval($x['code'])[0] == 3)
                                                @php
                                                    $income += $x['account'] * -1;
                                                @endphp
                                            <tr>
                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x['code'] }} - {{ $x['name'] }}</td>
                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($x['account'] * -1,2) }}</td>
                                            </tr>      
                                            @endif                                   
                                        @endforeach
                                            <tr class="table-success">
                                                <th class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">الاجمالى</th>
                                                <th class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($income,2)}}</th>
                                            </tr>
                                            <tr class="thead-light">
                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center" colspan="2">المصروفات</th>
                                            </tr>
                                        @php 
                                            $expenses = 0;
                                        @endphp
                                        @foreach($data as $x)
                                            @if(strval($x['code'])[0] == 4)
                                                @php
                                                    $expenses += $x['account'];
                                                @endphp
                                            <tr>
                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x['code'] }} - {{ $x['name'] }}</td>
                                                <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($x['account'],2) }}</td>
                                            </tr>  
                                            @endif 
                                        @endforeach
                                        <tr class="table-danger">
                                            <th class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">الاجمالى</th>
                                            <th class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($expenses),2}}</th>
                                        </tr>
                                        <tr class="table-info">
                                            <th class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">الارباح و الخسائر</th>
                                            <th class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($income - $expenses,2)}}</th>
                                        </tr>
                                        

                                    </tr>
                                

                        </table>
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