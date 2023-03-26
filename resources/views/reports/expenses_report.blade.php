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
        .ht-40{
            display: none;
        }
        .app-sidebar__toggle{
            display: none;
        }
        .navbar-form{
            display: none;
        }
        .header-icon-svgs{
            display: none;
        }
        .main-profile-menu{
            display: none;
        }
        .d-main-profile-menu {
            display: none;
        }
        .main-header-right{
            display: none;
        }
        .main-header .sticky .side-header .nav .nav-item .sticky-pin{
            display: none;
        }
        #h1{
            display: none;
        }
        #h3{
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
    تقرير النفقات السنوي  
@stop
@endsection
@section('page-header')
<!-- breadcrumb -->
<div  class="breadcrumb-header justify-content-between">
    <div id="h1" class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">التقارير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ تقرير
                 النفقات السنوي  
            </span>
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


            <div class="card-header pb-0" id="form">

                <form action="Search_expenses" method="POST" role="search" autocomplete="off">
                    {{ csrf_field() }}
                    <div class="row">

                        <div class="form-group col">
                            <label for="exampleFormControlSelect1">النفقة</label>
                            <select class="form-control select2 " name="expense_id" required="required">
                              <option value="">اختر النفقة </option>
                              @foreach ($expenses as $expense)
                                <option value="0">جميع النفقات</option>
                                <option value="{{ $expense->id }}">{{ $expense->section_name }}</option>
                              @endforeach
                            </select>
                        </div>


                        <div class="col-lg-3" id="end_at">
                            <label for="exampleFormControlSelect1">اختر السنة</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>
                                </div><input class="form-control fc-datepicker" name="year"
                                    value="{{ $end_at ?? '' }}" placeholder="YYYY" type="text" required>
                            </div><!-- input-group -->
                        </div>

                        <div class="col-lg-3" style="margin-top: 30px">
                            <button class="btn btn-primary btn-block">بحث</button>
                        </div>

                    </div><br>

                </form>

            </div>
            <div class="card-body" style="width: 100% ;">
                <div class="table-responsive mg-t-40">
                    @if (isset($chartjs))
                    <div class="row" >
                        <div class="col" style="margin-bottom: 30px ; margin-top: 10px" >
                            <h4 style="text-align: center ; font-weight: bold" >تقرير {{$expense_name}} لسنه {{$year}}</h4>
                        </div>
                    </div>
                    <div class="row row-sm">
                        <div class="col" style="width: 100% ;">
                            <div>
                                <h4>   اجمالى التكلفة خلال سنه {{$year}} = <span class="text-danger" style="font-weight: bold"> {{array_sum($expenses_data)}} </span></h4>
                            </div>
                            <div class="card" >
                                <div class="card-body" style="width: 100% ;">
                                    {!! $chartjs->render() !!}                
                                </div>
                            </div>
                        </div>
                            
                            
                        <div class="col" style="width: 10% ;">
                            <div class="card card-dashboard-map-one">
                                <div class="">
                                    <table class="table" style="width: 100% ;">
                                                    <thead class="thead-dark">
                                                    <tr>
                                                        <th>الشهر</th>
                                                        <th>التكلفة</th>
                                                    </tr>
                                                    </thead>
                                                    <tr>
                                                        <td>يناير</td>
                                                        <td>{{$expenses_data[0]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>فبراير</td>
                                                        <td>{{$expenses_data[1]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>مارس</td>
                                                        <td>{{$expenses_data[2]}}</td> 
                                                    </tr>
                                                        
                                                    <tr>
                                                        <td>ابريل</td>
                                                        <td>{{$expenses_data[3]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>مايو</td>
                                                        <td>{{$expenses_data[4]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>يونيو</td>
                                                        <td>{{$expenses_data[5]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>يوليو</td>
                                                        <td>{{$expenses_data[6]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>أغسطس</td>
                                                        <td>{{$expenses_data[7]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>سبتمبر</td>
                                                        <td>{{$expenses_data[8]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>أكتوبر</td>
                                                        <td>{{$expenses_data[9]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>نوفمبر</td>
                                                        <td>{{$expenses_data[10]}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>ديسمبر </td>
                                                        <td>{{$expenses_data[11]}}</td>
                                                    </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        </div>
                        <div class="invoice-notes">
                            <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                <i class="mdi mdi-printer ml-1"></i>Print
                            </a>
                        </div><!-- invoice-notes -->	
                    @endif
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
            // var originalContents = document.body.innerHTML;
            // document.body.innerHTML = printContents;
            window.print();
            document.body.innerHTML = originalContents;
            location.reload();
        }
    </script>
@endsection