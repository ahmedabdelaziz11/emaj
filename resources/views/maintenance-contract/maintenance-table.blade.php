@extends('layouts.master')
@section('css')

<style>
	@media print {
		#print_Button {
			display: none;
		}
	}
</style>
@endsection
@section('title')
    جدول عقود الصيانة 
@stop
@section('content')
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <a href="/maintenance-contracts"><h4 class="content-title mb-0 my-auto">عقود الصيانة</h4></a><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                جدول عقود الصيانة  
            </span>
        </div>
    </div>
</div>

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
                    <h1 style="text-align: center ; font-weight: bold">عقود الصيانة</h1>
                    <div class="row mg-t-20">
                        <div class="col-md">
                        <div class="invoice-notes" style="float: right;">
                        <a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
                            <i class="mdi mdi-printer ml-1"></i>Print
                        </a>
                    </div><!-- invoice-notes -->	
                    
                        </div>
                        <div class="col-md">
                            <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>تاريخ التقرير</span> <span>{{date('Y-m-d')}}</span></p>
                        </div>
                    </div>
                    <div class="table-responsive mg-t-40">
                        <table class="table table-bordered border text-md-nowrap mb-0">
                            <thead>
                                <tr class="tx-center"> 
                                    <th>#</th>
                                    <th>العميل</th>
                                    <th>تاريخ البدء</th>
                                    <th>تاريخ الانتهاء</th>
                                    <th>قمية العقد</th>
                                    <th>عدد الزيارات الدورية</th>
                                    <th>عدد الزيارات الطارئة</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                </tr>
                                @foreach ($maintenances as $x)
                                    <tr class="text-center">
                                        <td>{{$loop->iteration}}</td> 
                                        <td>{{$x->client->name}}</td>
                                        <td>{{ $x->start_date }}</td>        
                                        <td>{{ $x->end_date }}</td>        
                                        <td>{{ number_format($x->contract_amount) }}</td>        
                                        <td>{{ number_format($x->periodic_visits_count) }}</td>        
                                        <td>{{ number_format($x->emergency_visits_count) }}</td>            
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>         
                </div>
            </div>
        </div>
    </div><!-- COL-END -->
</div>
@endsection
@section('js')
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