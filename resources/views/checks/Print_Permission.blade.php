@extends('layouts.master')
@section('css')
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
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">النفقات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">طباعه اذن صرف نفقة</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('title')
    {{ $offers->section->section_name}}
@stop
@section('content')
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
									<h1 style="text-align: center ; font-weight: bold"> اذن صرف نفقة </h1>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="border-bottom-0">#</th>
													<th class="border-bottom-0">التاريخ</th>
													<th class="border-bottom-0">التكلفة</th>
													<th class="border-bottom-0">الملاحظات</th>
													<th class="border-bottom-0">اسم المنشئ</th>
													<th class="border-bottom-0">اسم القسم</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>{{ 1 }}</td>
													<td>{{ $offers->date }}</td>
													<td>{{ $offers->price }}   </td>
													<td>{{ $offers->note }}</td>
													<td>{{ $offers->create_by }}</td>
													<td>{{ $offers->section->section_name }}</td>
												</tr>
											</tbody>
										</table>
															<div class="invoice-notes">
																<a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
																	<i class="mdi mdi-printer ml-1"></i>Print
																</a>
															</div><!-- invoice-notes -->													
									</div>										
								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
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