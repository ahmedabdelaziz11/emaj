@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<style>

	@media print {
		#print_Button {
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
مخصص الاهلاك
@stop
@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto"><a href="asset-management">ادرة الالصول الثابتة </a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                مخصص الاهلاك  
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0" id="form">

                <form action="create-mokhss-elahlak" method="POST" role="search" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="form-group col">
                            <label for="exampleFormControlSelect1">السنة</label>
                            <input type="text" name="year" class="form-control" required>
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
    @if (isset($year))
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
                            <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                <i class="mdi mdi-printer ml-1"></i>Print
                            </a>
                            <h1 style="text-align: center ; font-weight: bold">كشف مخصص الاهلاك لسنة {{$year}}</h1>

                            <div class="table-responsive mg-t-40">
                                <table class="table table-invoice border text-md-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">#</th>
                                            <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">اسم الحساب / الاصل</th>
                                            <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">تاريخ الشراء</th>
                                            <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكمية</th>
                                            <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">قيمة الاصل</th>
                                            <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">مخصص الاهلاك</th>
                                            <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">مجمع الاهلاك</th>
                                            <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">نسبة الاهلاك</th>
                                            <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">صافى الاصل</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $total_q = 0;
                                            $total_p = 0;
                                            $total_v = 0;
                                            $total_m = 0;
                                            $total_s = 0;
                                        @endphp
                                        @foreach ($mokhss as $x)
                                        <tr class="tx-center" style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;">
                                            @php
                                                $x1 = App\Models\Asset::find($x->asset_id);
                                                $mogm3_elahlak = 0;
                                                $elmokhssat = App\Models\MokhssElahlak::where('asset_id',$x->asset_id)->get();
                                                foreach($elmokhssat as $m)
                                                {
                                                    $mogm3_elahlak += $m->value ;
                                                }
                                                $total_q += ($x1->quantity);
                                                $total_p += ($x1->price * $x1->quantity);
                                                $total_v += ($x->value * $x1->quantity);
                                                $total_m += ($mogm3_elahlak * $x1->quantity);
                                                $total_s += (($x1->price * $x1->quantity) - ($mogm3_elahlak * $x1->quantity));
                                            @endphp
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;">{{$loop->iteration}}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;">{{$x1->account->name}}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;">{{$x1->date}}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;">{{$x1->quantity}}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;">{{$x1->price * $x1->quantity }}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;">{{$x->value * $x1->quantity}}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;">{{$mogm3_elahlak * $x1->quantity }}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;">{{$x1->mokhss_elahlak}}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;">{{($x1->price * $x1->quantity) - ($mogm3_elahlak * $x1->quantity)}}</td>
                                        </tr>
                                        @endforeach
                                        <tr style="font-size: 16px">
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center" colspan="3">-</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">{{number_format($total_q,2)}}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">{{number_format($total_p,2)}}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">{{number_format($total_v,2)}}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">{{number_format($total_m,2)}}</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">-</td>
                                            <td style="font-size: 14px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">{{number_format($total_s,2)}}</td>
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
@endsection
@section('js')
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>

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