@extends('layouts.master')
@section('css')
@livewireStyles
<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
<style>
    @media print {
        #print_Button {
            display: none;

        }
        #print_Button1{
            display: none;

        }
        #print_Button2{
            display: none;

        }
        #print_Button3{
            display: none;

        }
        #print_Button4{
            display: none;

        }
        #print_Button5{
            display: none;

        }
        #day_id_for_show {
            display: block;
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
القيود اليومية
@stop
@section('content')

<input type="hidden" id="mss" value="{{ Session::get('mss')}}">
<input type="hidden" id="del" value="{{ Session::get('del')}}">

@if (session()->has('del'))
<script>
    window.onload = function() {
        var del = document.getElementById("del").value;
        console.log(del);
        notif({
            msg: del,
            type: "error"
        })
    }
</script>
@endif

@if (session()->has('mss'))
<script>
    window.onload = function() {
        var mss = document.getElementById("mss").value;
        notif({
            msg: mss,
            type: "success"
        })
    }
</script>
@endif
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المحاسبة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/القيود اليومية</span>
        </div>
    </div>
</div>
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
                    <h1 style="text-align: center ; font-weight: bold">قيد يومية</h1>

                    @livewire('day',['day_id' => $day_id ?? null])

                </div>
            </div>
        </div>
    </div><!-- COL-END -->
</div>

@endsection
@section('js')
@livewireScripts
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

<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

<script>
    var date = $('.fc-datepicker').datepicker({
        dateFormat: 'yy-mm-dd'
    }).val();
</script>

<script type="text/javascript">
    function printDiv() {
        var day_id = document.getElementById('day_id_for_show');
        day_id.style.display = 'block';
        var printContents = document.getElementById('print').innerHTML;
        var originalContents = document.body.innerHTML;
        document.body.innerHTML = printContents;
        window.print();
        document.body.innerHTML = originalContents;
        location.reload();
    }
</script>

<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
    })
</script>

@endsection