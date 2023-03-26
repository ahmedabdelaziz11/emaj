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
    كشف حساب مورد
@stop
@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقرير
                المورد  
            </span>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0" id="form">

                <form action="Search_supplier" method="POST" role="search" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="form-group col">
                            <label for="exampleFormControlSelect1">المورد</label>
                            <select class="form-control select2 " name="supplier_id" required="required">
                            <option value="">اختر المورد </option>
                            @foreach ($suppliers as $supplier)
                                <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
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
                                    value="{{ $end_at ?? '' }}" placeholder="YYYY-MM-DD" type="text" required>
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
    @if (isset($receipts))
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
                                    <p style="font-weight: bold">٣ محمد سليمان غنام , من محمد رفعت ,النزهة الجديدة      <br>
                                        الهاتف :  01000241938 / 01208524340   <br>
                                        الايميل :  info@emajegypt.com <br>
                                        س-ت : 110422 / ب-ض : 560-137-548
                                    </p>
                                </div><!-- billed-from -->
                            </div><!-- invoice-header -->
                            <h1 style="text-align: center ; font-weight: bold">كشف حساب</h1>
                            <div class="row mg-t-20">
                                <div class="col-md">
                                    <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> اسم المورد</span> <span></span>{{$supplier_name}}</p>
                                    <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>رصيد البداية  </span> <span>

                                        {{$start_debt }}

                                    </span></p>

                                </div>
                                <div class="col-md">
                                    <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>تاريخ التقرير</span> <span>{{date('Y-m-d')}}</span></p>
                                    <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>الفترة</span>من : {{$start_at}}<span> الي : {{$end_at}}</span></p>
                                </div>
                            </div>
                            <div class="table-responsive mg-t-40">
                                <table class="table table-invoice border text-md-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 17px" class="tx-center">#</th>
                                            <th style="font-size: 17px" class="tx-center">رقم الفاتورة</th>
                                            <th style="font-size: 17px" class="tx-center">التاريخ</th>
                                            <th style="font-size: 17px" class="tx-center">المدين</th>
                                            <th style="font-size: 17px" class="tx-center">الدائن</th>
                                            <th style="font-size: 17px" class="tx-center">الرصيد</th>
                                            <th style="font-size: 17px" class="tx-center">البيان</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = $paid = $total = 0; ?>
                                        
                                        @foreach ($receipts as $x)
                                            <?php
                                            $i++;
                                                $total = $total + $x->total;                                   
                                                $paid = $paid + $x->amount_paid ;                                   
                                            ?>
                                            @if($x->type == "سند قبض من مورد")
                                                <?php
                                                    $start_debt = $start_debt + $x->amount;
                                                ?>
                                                <tr>
                                                    <td style="font-size: 17px;font-weight: 100;border-left: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">-</td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $x->receipt_date }}</td>  
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">0</td>
                                                    
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $x->amount)}}</td>
                                                    @if($start_debt > 0 )
                                                    <td class="text-danger" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt )}}</td>
                                                    @else
                                                    <td class="text-success" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt)}}</td>
                                                    @endif
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">سند قبض</td>
                                                </tr>
                                            @endif
                                            @if($x->type == "سند صرف من مورد")
                                                <?php
                                                    $start_debt = $start_debt - $x->amount;
                                                ?>
                                                <tr>
                                                    <td style="font-size: 17px;font-weight: 100;border-left: 1px solid rgb(177, 170, 170);">{{ $i }} </td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">-</td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $x->receipt_date }}</td>  
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format($x->amount)}}</td>
                                                    
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">0</td>
                                                    @if($start_debt > 0 )
                                                    <td class="text-danger" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt )}}</td>
                                                    @else
                                                    <td class="text-success" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt )}}</td>
                                                    @endif
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">سند صرف</td>
                                                </tr>
                                            @endif
                                            @if($x->Status == "شراء منتجات" || $x->Status == "شراء قطع غيار")
                                                <?php
                                                    $start_debt = $start_debt + $x->total;
                                                ?>
                                                <tr>
                                                    <td style="font-size: 17px;font-weight: 100;border-left: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">
                                                        @if($x->model_type == "product")
                                                            <a href="{{ url('ReceiptDetails') }}/{{ $x->id }}">{{ $x->id }}</a>
                                                        @else
                                                            <a href="{{ url('ReceiptDetails_s') }}/{{ $x->id }}">{{ $x->id }}</a>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $x->receipt_date }}</td>  
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">0</td>
                                                    
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $x->total)}}</td>
                                                    @if($start_debt > 0 )
                                                    <td class="text-danger" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt )}}</td>
                                                    @else
                                                    <td class="text-success" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt)}}</td>
                                                    @endif
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $x->Status }}</td>
                                                </tr>
                                                @if($x->amount_paid > 0)
                                                <?php
                                                    $start_debt = $start_debt - $x->amount_paid;
                                                ?>
                                                    <tr>
                                                        <td style="font-size: 17px;font-weight: 100;border-left: 1px solid rgb(177, 170, 170);"> </td>
                                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">
                                                        @if($x->model_type == "product")
                                                            <a href="{{ url('ReceiptDetails') }}/{{ $x->id }}">{{ $x->id }}</a>
                                                        @else
                                                            <a href="{{ url('ReceiptDetails_s') }}/{{ $x->id }}">{{ $x->id }}</a>
                                                        @endif
                                                        </td>
                                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $x->receipt_date }}</td>  
                                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format($x->amount_paid)}}</td>
                                                        
                                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">0</td>
                                                        @if($start_debt > 0 )
                                                        <td class="text-danger" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt )}}</td>
                                                        @else
                                                        <td class="text-success" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt )}}</td>
                                                        @endif
                                                        <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">مدفوعات فاتورة رقم {{ $x->id }}</td>
                                                    </tr>
                                                @endif
                                            @elseif($x->Status == "سداد")
                                            <?php
                                                    $start_debt = $start_debt - $x->amount_paid;
                                            ?>
                                                <tr>
                                                    <td style="font-size: 17px;font-weight: 100;border-left: 1px solid rgb(177, 170, 170);"> </td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">
                                                        @if($x->model_type == "product")
                                                            <a href="{{ url('ReceiptDetails') }}/{{ $x->id }}">{{ $x->id }}</a>
                                                        @else
                                                            <a href="{{ url('ReceiptDetails_s') }}/{{ $x->id }}">{{ $x->id }}</a>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $x->receipt_date }}</td>  
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format($x->amount_paid)}}</td>
                                                    
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">0</td>
                                                    @if($start_debt > 0 )
                                                    <td class="text-danger" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt )}}</td>
                                                    @else
                                                    <td class="text-success" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt )}}</td>
                                                    @endif
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $x->Status }}</td>
                                                </tr>
                                            @else
                                            <?php
                                                    $start_debt = $start_debt + $x->total;
                                            ?>
                                                <tr>
                                                    <td style="font-size: 17px;font-weight: 100;border-left: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">
                                                        @if($x->model_type == "product")
                                                            <a href="{{ url('ReceiptDetails') }}/{{ $x->id }}">{{ $x->id }}</a>
                                                        @else
                                                            <a href="{{ url('ReceiptDetails_s') }}/{{ $x->id }}">{{ $x->id }}</a>
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $x->receipt_date }}</td>  
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">0</td>
                                                    
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $x->total)}}</td>
                                                    @if($start_debt > 0 )
                                                    <td class="text-danger" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt )}}</td>
                                                    @else
                                                    <td class="text-success" style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $start_debt )}}</td>
                                                    @endif
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $x->Status }}</td>
                                                </tr>
                                            @endif

                                            <?php
                                            if($loop->last)
                                            {
                                                $final_debt = $x->debt ;
                                            }
                                            ?>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive mg-t-40">
                                <table  class="table table-invoice border text-md-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <th style=" font-size: 27px;font-weight: bold" class="tx-right"> اجمالي الفواتير</th>
                                            <th style="font-size: 25px" class="tx-right" colspan="2">{{ number_format($total) }}</th>
                                        </tr>
                                        <tr>
                                            <th style=" font-size: 27px;font-weight: bold" class="tx-right"> اجمالي المدفوعات</th>
                                            <th style="font-size: 25px" class="tx-right" colspan="2">{{ number_format($paid) }}</th>
                                        </tr>
                                        <tr>
                                            <th style=" font-size: 27px;font-weight: bold" class="tx-right"> اجمالي الرصيد</th>
                                            <th style="font-size: 25px" class="tx-right" colspan="2">{{ number_format($start_debt) }}</th>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="invoice-notes">
                                <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                    <i class="mdi mdi-printer ml-1"></i>Print
                                </a>
                            </div><!-- invoice-notes -->	
                            
                            
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