@extends('layouts.master')
@section('css')
@livewireStyles
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
 بحث القيود اليومية
@stop
@section('content')


<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المحاسبة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/بحث القيود اليومية</span>
        </div>
    </div>
</div>

@livewire('day-search')

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


<script>
    $(document).ready(function(){

        $('#credit').select2().on('change',function(e){
            let livewire = $(this).data('livewire')
            eval(livewire).set('credit_account',$(this).val());
        });
    });
</script>

<script>
    $(document).ready(function(){

        $('#debt').select2().on('change',function(e){
            let livewire = $(this).data('livewire')
            eval(livewire).set('debt_account',$(this).val());
        });
    });
</script>

@endsection