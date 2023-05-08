@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

    
<style>

	@media print {
		#excel{
			display: none;
		}
        #print_Button{ 
			display: none;
		}
        #sub_print{
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
شهادة ضمان
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">                        
                            <a href="{{ url('/' . $page='tickets') }}">الضمانات</a>
                </h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                شهادة ضمان</span>
            </div>
        </div>

    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
<input type="hidden" id="mss" value="{{ Session::get('mss')}}">
<input type="hidden" id="del" value="{{ Session::get('del')}}">

@if($errors->has('name'))
    @foreach ($errors->all() as $error)
        <input type="hidden" id="err1" value="{{ $error }}">
    @endforeach
@endif



    <div class="row row-sm">
        <div class="col-xl-12">
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab6" class="nav-link active" data-toggle="tab">
                                                    الشهادة</a></li>
                                            <li><a href="#tab7" class="nav-link" data-toggle="tab">
                                                    تعديل</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">
                                        <div class="tab-pane active" id="tab6">
                                            <div class="row row-sm">
                                                <div class="col-md-12 col-xl-12">
                                                    <div class=" main-content-body-invoice" id="print">
                                                        <div class="card card-invoice">
                                                            <div class="card-body">
                                                                <div class="invoice-header">
                                                                    <img src="{{URL::asset('assets/img/brand/logo.png')}}" style="height:150px;width: 150px;" class="logo-1" alt="logo">
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
                                                                <h1 style="text-align: center ; font-weight: bold" class="my-3">شهادة ضمان</h1>
                                                                <div class="row my-3">
                                                                    <div class="col-md" style="margin-left: 50px;">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>رقم الضمان</span> <span></span>{{$ticket->id}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>العميل</span> <span></span>{{$ticket->client->name}}</p>
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>من تاريخ</span>{{$ticket->start_date}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>الى تاريخ</span>{{$ticket->end_date}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"></p>
                                                                        <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                                                            <i class="mdi mdi-printer ml-1"></i>Print
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive mg-t-40">
                                                                    <table class="table table-invoice border text-md-nowrap mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;vertical-align:middle;" class="tx-center">اسم المنتج</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;vertical-align:middle;" class="tx-center">الوصف</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;vertical-align:middle;" class="tx-center">الكمية</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            <td style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">{{$ticket->invoiceProduct->product->name }}</td>
                                                                            <td style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-right">{!!$ticket->invoiceProduct->product->description!!}</td>
                                                                            <td style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">{{$ticket->invoiceProduct->product_quantity}}</td>
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="row mt-3 p-4">
                                                                    <h4>العنوان</h4>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab7">
                                            <div class="card mg-b-20" id="tabs-style2">
                                                <div class="card-body">
                                                    <form action="{{ route('tickets.update',$ticket->id) }}" method="post" autocomplete="off">
                                                    @csrf
                                                    {{ method_field('patch') }}
                                                    <div class="row">
                                                        <input type="hidden" name="ticket_id" value="{{$ticket->id}}">
                                                        <div class="col-3">
                                                            <label>تاريخ البدأ</label>
                                                            <input class="form-control" name="start_date" placeholder="YYYY-MM-DD" type="date" value="{{$ticket->start_date}}" required>
                                                        </div>

                                                        <div class="col-3">
                                                            <label>تاريخ النهاية</label>
                                                            <input class="form-control" name="end_date" placeholder="YYYY-MM-DD" type="date" value="{{$ticket->end_date}}" required>
                                                        </div>

                                                        <div class="col-3">
                                                            <label>الحد الاقصى</label>
                                                            <input class="form-control" name="compensation" type="number" step=".01" value="{{$ticket->compensation}}" required>
                                                        </div>

                                                        <div class="col-3">
                                                            <label>العنوان</label>
                                                            <select class="form-control select2 address" name="address_id">
                                                                <option value="{{$ticket->address_id}}">اختر العنوان</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <button type="submit" class="btn btn-primary w-100 mt-4">تعديل الطلب</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
	</div>
@endsection
@section('js')

    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

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

    <script>
        $(document).ready(function(){
            $('.address').select2({
                placeholder: 'Enter a parent address',
                ajax: {
                    dataType: 'json',
                    url: function(params) {
                        return '/get-addresses-select2/' + params.term;
                    },
                    processResults: function (data, page) {
                        return {
                        results: data || ' '
                        };
                    },
                }
            });
        });
    </script>
@endsection