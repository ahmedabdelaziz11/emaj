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
        #excel {
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
    مخون قطع الغيار
@stop
@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقرير
                مخزون قطع الغيار  
            </span>
        </div>
    </div>
</div>

    @if (isset($products))
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
                            <h1 style="text-align: center ; font-weight: bold">مخزون قطع الغيار</h1>
                            <div class="row mg-t-20">
                                <div class="col-md">
                                <div class="invoice-notes" style="float: right;">
                                    <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                        <i class="mdi mdi-printer ml-1"></i>Print
                                    </a>
                                    <button type="submit" form="download" id="excel" class="btn btn-success float-left mt-3 mr-2" >
                                        <i class="mdi mdi-printer ml-1"></i>Excel
                                    </button>
                                </div><!-- invoice-notes -->	
                            
                                </div>
                                <div class="col-md">
                                    <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>تاريخ التقرير</span> <span>{{date('Y-m-d')}}</span></p>
                                </div>
                            </div>
                            <div class="table-responsive mg-t-40">
                                <table class="table table-invoice border text-md-nowrap mb-0">
                                    <thead>
                                        <tr>
                                            <th style="font-size: 17px" class="tx-center">#</th>
                                            <th style="font-size: 17px" class="tx-center">اسم المنتج</th>
                                            <th style="font-size: 17px" class="tx-center">سعر البيع</th>
                                            <th style="font-size: 17px" class="tx-center">سعر الشراء</th>
                                            <th style="font-size: 17px" class="tx-center">الكمية</th>
                                            <th style="font-size: 17px" class="tx-center">الاجمالى (سعر شراء)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php $i = $final_total = 0; $sub_total = 0;?>
                                        <form id="download" action="{{ route('download-product-sheet') }}" method="post">
                                        @foreach ($products as $x)
                                            <?php
                                            $sub_total = $x->Purchasing_price * $x->quantity;
                                            $final_total += $sub_total; 
                                            $i++;                                 
                                            ?>
                                            {{ csrf_field() }}
                                            {{ method_field('post') }}
                                            <input type="hidden" name="x[]" value="{{$i}}">
                                            <input type="hidden" name="name[]" value="{{$x->name}}">
                                            <input type="hidden" name="selling_price[]" value="{{$x->selling_price}}">
                                            <input type="hidden" name="Purchasing_price[]" value="{{$x->Purchasing_price}}">
                                            <input type="hidden" name="quantity[]" value="{{$x->quantity}}">
                                            <input type="hidden" name="sub_total[]" value="{{$sub_total}}">
                                                <tr>
                                                    <td style="font-size: 17px;font-weight: 100;border-left: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $x->name }}</td>  
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format($x->selling_price)}}</td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $x->Purchasing_price)}}</td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $x->quantity)}}</td>
                                                    <td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{number_format( $sub_total)}}</td>
                                                    
                                                </tr>
                                                <?php $sub_total = 0;?>
                                        @endforeach
                                        </form>
                                    </tbody>
                                </table>
                            </div>
                            <div class="table-responsive mg-t-40">
                                <table  class="table table-invoice border text-md-nowrap mb-0">
                                    <tbody>
                                        <tr>
                                            <th style=" font-size: 27px;font-weight: bold" class="tx-right"> اجمالي المخزون</th>
                                            <th style="font-size: 25px" class="tx-right" colspan="2">{{ number_format($final_total) }}</th>
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