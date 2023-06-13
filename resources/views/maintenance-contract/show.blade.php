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
عقد صيانة
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto">                        
                            <a href="{{ url('/' . $page='maintenance-contracts') }}">عقود الصيانة</a>
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
                                                    العقد</a></li>
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
                                                                <h1 style="text-align: center ; font-weight: bold" class="my-3">عقد صيانة</h1>
                                                                <div class="row my-3">
                                                                    <div class="col-md" style="margin-left: 50px;">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>العميل</span> <span></span>{{$maintenanceContract->client->name ?? ''}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>عدد الزيارات</span> <span></span>{{$maintenanceContract->periodic_visits_count + $maintenanceContract->emergency_visits_count}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>قيمة العقد</span> <span></span>{{number_format($maintenanceContract->contract_amount)}}</p>
                                                                    </div>
                                                                    <div class="col-md">
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>من تاريخ</span>{{$maintenanceContract->start_date ?? ''}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>الى تاريخ</span>{{$maintenanceContract->end_date ?? ''}}</p>
                                                                        <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"></p>
                                                                        <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                                                                            <i class="mdi mdi-printer ml-1"></i>Print
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="table-responsive mg-t-40">
                                                                    <h3 class="text-center tx-bold">معدات العقد</h3>
                                                                    <table class="table table-invoice border text-md-nowrap mb-0">
                                                                        <thead>
                                                                            <tr>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;vertical-align:middle;" class="tx-center">اسم المعده</th>
                                                                                <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;vertical-align:middle;" class="tx-center">الوصف</th>
                                                                            </tr>
                                                                        </thead>
                                                                        <tbody>
                                                                            @foreach($maintenanceContract->products as $product)
                                                                                <td style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">{{$product->name ?? ''}}</td>
                                                                                <td style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-right">{!!$product->description ?? '' !!}</td>
                                                                            @endforeach
                                                                        </tbody>
                                                                    </table>
                                                                </div>
                                                                <div class="row mt-3 p-4">
                                                                    <h4>العنوان</h4>
                                                                    <p style="font-size: 18px;margin-top: 40px;">{{$maintenanceContract->address->name ?? ''}}</p>
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
                                                    <form action="{{ route('maintenance-contracts.update',$maintenanceContract->id) }}" method="post" autocomplete="off">
                                                        @csrf
                                                        {{ method_field('patch') }}
                                                        <input type="hidden" name="maintenance_contract_id" value="{{$maintenanceContract->id}}">
                                                        <div class="row">
                                                            <div class="form-group col-6">
                                                                <label>العميل</label>
                                                                <select class="form-control select2 " name="client_id">
                                                                    <option value="" selected disabled>اختر العميل</option>
                                                                    @foreach($clients as $client)
                                                                    <option @if($maintenanceContract->client->id == $client->id) selected @endif value="{{$client->id}}">{{$client->name}}</option>
                                                                        @foreach($client->accounts as $subClient)
                                                                            <option @if($maintenanceContract->client->id == $client->id) selected @endif value="{{$subClient->id}}">{{$subClient->name}}</option>
                                                                        @endforeach
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="form-group col-6">
                                                                <label>العنوان</label>
                                                                <input type="text" class="form-control" name="address" value="{{$maintenanceContract->address}}">

                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-6">
                                                                <label>تاريخ البدأ</label>
                                                                <input class="form-control" name="start_date" value="{{$maintenanceContract->start_date}}" placeholder="YYYY-MM-DD" type="date"  required>
                                                            </div>
                                    
                                                            <div class="col-6">
                                                                <label>تاريخ النهاية</label>
                                                                <input class="form-control" name="end_date" value="{{$maintenanceContract->end_date}}" placeholder="YYYY-MM-DD" type="date" required>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <div class="col-4">
                                                                <label>عدد الزيارات الدورية</label>
                                                                <input class="form-control" name="periodic_visits_count" value="{{$maintenanceContract->periodic_visits_count}}" type="number"  required>
                                                            </div>
                                    
                                                            <div class="col-4">
                                                                <label>عدد الزيارات الطارئة</label>
                                                                <input class="form-control" name="emergency_visits_count" value="{{$maintenanceContract->emergency_visits_count}}" type="number" required>
                                                            </div>
                                
                                                            <div class="col-4">
                                                                <label>قيمة العقد</label>
                                                                <input class="form-control" name="contract_amount" step=".01" value="{{$maintenanceContract->contract_amount}}"  type="number" required>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <h4>معدات العقد</h4>
                                                        <div class="row">
                                                            <div class="form-group col-12">
                                                                <label>المنتج</label>
                                                                <select class="form-control select2 allProducts" id="product_id" name="product_id">
                                                                    <option value="">اختر المنتج</option>
                                        
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <br>
                                                        <div class="row">
                                                            <table class="table table-bordered text-md-nowrap">
                                                                <thead id="container_header">
                                                                    <th style=" font-size: 15px;" class="text-center">اسم المعده</th>
                                                                    <th style=" font-size: 15px;" class="text-center">حذف</th>
                                                                </thead>
                                                                <tbody id="items_container">
                                                                    @foreach($maintenanceContract->products as $product)
                                                                        <tr>
                                                                            <td class="pt-3" style="font-size:17px;font-weight:bold"><input type="hidden" name="product_ids[]" value="{{$product->id}}" min="1">{{$product->name}}</td>
                                                                            <td class="pt-3"><button onclick="deleteRow(this)" style="width:100%" type="button" class="btn btn-danger btn-sm rounded-pill ml-3"><i class="las la-trash"></i></button></td>
                                                                        </tr>
                                                                    @endforeach
                                                                </tbody>
                                                            </table>
                                                        </div><br>
                                                        <div class="row">
                                                            <button type="submit" class="btn btn-primary w-100 mt-2">تعديل العقد</button>
                                                        </div>

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
            allowClear: true,
            width: "100%",
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
        $('.allProducts').select2({
            placeholder: 'Enter a tag',
            allowClear: true,
            width: "100%",
            ajax: {
                dataType: 'json',
                url: function(params) {
                    return '/get-all-products/' + params.term;
                },
                processResults: function (data, page) {
                    return {
                    results: data || ' '
                    };
                },
            }
        });

        var items = 0;
        $("#product_id").change(function(){
            items++;
            $("#container_header").show();
            var name = $(this).find(":selected").text();
            var id = $(this).val();
            if(!$("#row"+id).length){
                $("#items_container").append(`
                    <tr id="row`+id+`">
                    <td class="pt-3"style="font-size:17px;font-weight:bold"><input type="hidden" name="product_ids[]" value="`+id+`" min="1">`+name+`</td>
                    <td class="pt-3"><button style="width:100%" type="button" class="btn btn-danger btn-sm rounded-pill ml-3 " id="remove`+id+`"><i class="las la-trash"></i></button></td>
                    </tr>
                `);
            }
            $("#remove"+id).on('click',function(){
                items--;
                console.log(items);
                $("#row"+id).remove();
                document.getElementById("item_picker").selectedIndex = 0;
                console.log(items);
                if(items == 0){
                $("#container_header").hide();
                }
            });
        });
        function deleteRow(btn) {
            var row = btn.parentNode.parentNode;
            var d = row.parentNode.parentNode.rowIndex;
            row.parentNode.removeChild(row);
        }
    });
</script>
@endsection