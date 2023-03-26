@extends('layouts.master')
@section('css')

<style>
	@media print {
		#print_Button {
			display: none;
		}
        #form{
            display: none;
        }
		.zxc{
			 border: none; border-collapse: collapse; 
			
		}
		.zxc td { border-left: 1px solid #000; }
	 	.zxc td:first-child { border-left: none; }
	}
</style>

    <!-- Internal Data table css -->
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

@section('title')
    تقرير راس المال  
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقرير
                راس المال</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')

@if (count($errors) > 0)
    <div class="alert alert-danger">
        <button aria-label="Close" class="close" data-dismiss="alert" type="button">
            <span aria-hidden="true">&times;</span>
        </button>
        <strong>خطا</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session()->has('delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

<!-- row -->
<div class="row" id="print">

    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div>
                <h4 class="tx-center" style="margin-top: 30px ; margin-bottom: 0px">تقرير راس المال</h4>
            </div>
            <div class="card-body" >
                <div class="table-responsive mg-t-40">
                        <table class="table table-invoice border text-md-nowrap mb-0">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">اسم الاصل</th>
                                    <th class="border-bottom-0">الرصيد</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>الاصول الثابتة</td>
                                    <?php
                                        $f = \App\Models\fixed_assets::select(DB::raw('sum(price ) as total'))->value('total');
                                    ?>
                                    <td>{{number_format($f)}}</td>
                                </tr>

                                <tr>
                                    <td>تامينات لدى الغير</td>
                                    <?php
                                        $Insurance = \App\Models\Insurance::where('type',0)->select(DB::raw('sum(amount) as total'))->value('total');
                                    ?>
                                    <td>{{number_format($Insurance)}}</td>
                                </tr>

                                <tr>
                                    <td>مخزون المنتجات</td>
                                    <?php
                                        $p = \App\Models\products::select(DB::raw('sum(Purchasing_price * quantity  ) as total'))->value('total');
                                    ?>
                                    <td>{{number_format($p) }}</td>
                                </tr>
                                <tr>
                                    <td>مخزون قطع الغيار</td>
                                    <?php
                                        $spare = \App\Models\spares::select(DB::raw('sum(Purchasing_price * quantity  ) as total'))->value('total');
                                    ?>
                                    <td>{{number_format($spare) }}</td>
                                </tr>
                                <tr>
                                    <td>الحسابات المصرفية</td>
                                    <?php
                                        $a = \App\Models\accounts::where('id','!=',1)->sum('account');
                                    ?>
                                    <td>{{number_format($a) }}</td>
                                </tr>
                                <tr>
                                    <td>ديون العملاء</td>
                                    <?php
                                        $c = \App\Models\clients::sum('debt');
                                    ?>
                                    <td>{{number_format($c) }}</td>
                                </tr>

                                <tr>                                
                                    <td>ديون المودين</td>
                                    <?php
                                        $s = \App\Models\suppliers::sum('debt');
                                    ?>
                                    <td class="text-danger">{{number_format($s) }}</td>
                                </tr>

                                <tr>                                
                                    <td>القروض</td>
                                    <?php
                                        $l = \App\Models\Loan::sum('current_balance');
                                    ?>
                                    <td class="text-danger">{{number_format($l) }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <div class="table-responsive mg-t-40">
                            <table  class="table table-invoice border text-md-nowrap mb-0">
                                <tbody>
                                    <tr>
                                        <?php 
                                            $t = $f + $p + $spare + $a + $c + $Insurance - $s - $l; 
                                            $ttt = $s - $l;
                                            $tt = $t -  $ttt;
                                        ?>
                                        <th style=" font-size: 27px;font-weight: bold" class="tx-right">اجمالى راس المال</th>
                                        <th style="font-size: 25px" class="tx-right" colspan="2">{{ number_format($t) }}</th>
                                        </th>
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
    </div>
</div>
<!-- delete -->
<!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
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
<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
    })
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
@endsection