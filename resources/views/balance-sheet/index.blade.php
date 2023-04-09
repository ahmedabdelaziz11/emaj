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
ميزان المراجعة
@stop
@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المحاسبة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ميزان المراجعة  
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0" id="form">

                <form action="get-balance-sheet" method="POST" role="search" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="col">
                            <label for="exampleFormControlSelect1">مركز التكلفة</label>
                            <select class="form-control select2 " name="cost_id">
                                <option value="">اختر المركز </option>
                                <option value="0" selected>الكل</option>
                                @foreach ($costs as $cost)
                                    <option value="{{ $cost->id }}" @if (isset($cost_id) && $cost->id == $cost_id)
                                        selected                                        
                                    @endif>{{ $cost->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col">
                            <label for="exampleFormControlSelect1">المستوى</label>
                            <select class="form-control select2 " name="level">
                                <option value="">اختر المستوى </option>
                                <option value="1" @if(isset($level) && $level == 1) selected @endif> المستوى الاول</option>
                                <option value="2" @if(isset($level) && $level == 2) selected @endif>المستوى ثانى</option>
                                <option value="3" @if(isset($level) && $level == 3) selected @endif>المستوى ثالث</option>
                                <option value="4" @if(isset($level) && $level == 4) selected @endif>المستوى الرابع</option>
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
                        </div>
                    <div class="row">
                        <div class="col-lg-12" style="margin-top: 30px">
                            <button class="btn btn-primary btn-block">بحث</button>
                        </div>

                    </div><br>

                </form>

            </div>
        </div>
    </div>
</div>
    @if (isset($data))
                <!-- row -->
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
                    <h1 style="text-align: center ; font-weight: bold">ميزان المراجعة</h1>
                    <div class="row mg-t-20">
                        <div class="col-md" style="margin-left: 50px;">
                            <p class="invoice-info-row"style="font-size: 12px;font-weight: bold"><span>مركز التكلفة</span> <span></span>{{$Cost->name ?? 'لا يوجد'}}</p>
                        </div>
                        <div class="col-md">
                            <p class="invoice-info-row"style="font-size: 12px;font-weight: bold"><span>الفترة</span>من : {{$start_at}}<span> الي : {{$end_at}}</span></p>
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
                                        <th style="font-size: 12px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;padding-bottom: 30px;" class="tx-center" rowspan="2">كود الحساب</th>
                                        <th style="font-size: 12px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;padding-bottom: 30px;width:140px" class="tx-center" rowspan="2"> اسم الحساب</th>
                                        <th style="font-size: 12px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center" colspan="2">الرصيد السابق</th>
                                        <th style="font-size: 12px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center" colspan="2">الحركة</th>
                                        <th style="font-size: 12px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center" colspan="2">الاجمالى</th>
                                        <th style="font-size: 12px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center" colspan="2">الرصيد</th>
                                    </tr>
                                    <tr>
                                        <th style="font-size: 12px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">المدين</th>
                                        <th style="font-size: 12px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الدائن</th>
                                        <th style="font-size: 12px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">مدين</th>
                                        <th style="font-size: 12px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">دائن</th>
                                        <th style="font-size: 12px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">مدين</th>
                                        <th style="font-size: 12px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">دائن</th>
                                        <th style="font-size: 12px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">مدين</th>
                                        <th style="font-size: 12px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">دائن</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php 
                                        $total_debit = $total_credit = $elfr2 = 0;
                                    @endphp
                                    <form id="download" action="{{ route('download-sheet') }}" method="post">
                                    @foreach($data as $x)
                                        @if($x['debit'] != 0 ||  $x['credit'] != 0 || $x['prv_debit']!=0 || $x['prv_cerdit'] != 0 )
                                            @php
                                                $f =  ($x['debit'] + $x['prv_debit']) - ($x['credit'] + $x['prv_cerdit']);
                                                if($f > 0){                        
                                                    $total_debit += $f;
                                                }else{
                                                    $total_credit += -$f;
                                                }
                                            @endphp
                                                {{ csrf_field() }}
                                                {{ method_field('post') }}
                                                <input type="hidden" name="code[]" value="{{$x['code']}}">
                                                <input type="hidden" name="name[]" value="{{$x['name']}}">
                                                <input type="hidden" name="predebit[]" value="{{$x['prv_debit']}}">
                                                <input type="hidden" name="precredit[]" value="{{$x['prv_cerdit']}}">
                                                <input type="hidden" name="debit[]" value="{{$x['debit']}}">
                                                <input type="hidden" name="credit[]" value="{{$x['credit']}}">
                                                <input type="hidden" name="totdebit[]" value="{{$x['debit'] + $x['prv_debit']}}">
                                                <input type="hidden" name="totcredit[]" value="{{$x['credit'] + $x['prv_cerdit']}}">
                                                @if($f > 0)
                                                    <input type="hidden" name="findebit[]" value="{{$f}}">
                                                    <input type="hidden" name="fincredit[]" value="0">
                                                @else
                                                    <input type="hidden" name="fincredit[]" value="{{-$f}}">
                                                    <input type="hidden" name="findebit[]" value="0">
                                                @endif

                                            <tr>
                                                <td class="text-center" style="font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x['code'] }}</td>
                                                <td class="text-center" style="font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);width:140px">{{ $x['name'] }}</td>
                                                <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x['prv_debit'],2)}}</td>
                                                <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x['prv_cerdit'],2)}}</td>

                                                <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x['debit'],2)}}</td>
                                                <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x['credit'],2)}}</td>

                                                <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x['debit'] + $x['prv_debit'],2)}}</td>
                                                <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x['credit'] + $x['prv_cerdit'],2)}}</td>
                                                @if($f > 0)
                                                    <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($f,2)}}</td>
                                                    <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format(0)}}</td>
                                                @elseif($f < 0 )
                                                    <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format(0)}}</td>
                                                    <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($f * -1,2)}}</td>
                                                @else
                                                    <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format(0)}}</td>
                                                    <td style="text-align: center;font-size: 12px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format(0)}}</td>   
                                                @endif
                                            </tr>
                                        @endif    
                                    @endforeach
                                    </form>
                                </tbody>
                            </table>
                            <div class="table-responsive mg-t-40">
                                <table  class="table table-invoice border text-md-nowrap mb-0">
                                    <tbody class="border border-light tx-right">
                                        <tr>
                                            <th style=" font-size: 23px;font-weight: bold" class="tx-right"> اجمالي المدين</th>
                                            <th style="font-size: 25px" class="tx-right" colspan="3">{{ number_format($total_debit,2) }}</th>
                                        </tr>
                                        <tr>
                                            <th style=" font-size: 23px;font-weight: bold" class="tx-right"> اجمالي الدائن</th>
                                            <th style="font-size: 25px" class="tx-right" colspan="3">{{ number_format($total_credit,2) }}</th>
                                        </tr>
                                        <tr class="border border-light tx-right">
                                            <th style=" font-size: 23px;font-weight: bold" class="tx-right">الفرق</th>
                                            <th style="font-size: 25px" class="tx-right" colspan="3">{{ number_format($total_debit - $total_credit,2) }}</th>
                                        </tr>
                                        <tr>
                                            <th style="border: none; font-size: 24px; padding-right: 150px;padding-bottom: 40px" class="tx-right">توقيع المحاسب</th>
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