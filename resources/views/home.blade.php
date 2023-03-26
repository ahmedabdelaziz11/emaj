@extends('layouts.master')
@section('title')
الرئيسية
@stop
@section('css')
<!--  Owl-carousel css-->
<link href="{{URL::asset('assets/plugins/owl-carousel/owl.carousel.css')}}" rel="stylesheet" />
<!-- Maps css -->
<link href="{{URL::asset('assets/plugins/jqvmap/jqvmap.min.css')}}" rel="stylesheet">
@livewireStyles
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">

				</div>
				<!-- /breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				@can('الرئسية')
				
				<div class="row row-sm">
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h4 style="font-size: 20px; font-weight: bold;" class="mb-3 tx-12 text-white"> رصيد العملاء</h4>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="font-weight-bold mb-1 text-white" style="font-size: 25px; font-weight: bold;">
												{{number_format($c_balance,2)}}
											</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					
					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h4 class="mb-3 tx-12 text-white" style="font-size: 20px; font-weight: bold;"> رصيد الموردين</h4>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div>
											<h4 class="font-weight-bold mb-1 text-white" style="font-size: 25px; font-weight: bold;">
												{{number_format($s_balance,2)}}
											</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h4 class="mb-3 tx-12 text-white" style="font-size: 20px; font-weight: bold;"> رصيد العهد</h4>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div>
											<h4 class="font-weight-bold mb-1 text-white" style="font-size: 25px; font-weight: bold;">
												{{number_format($a_balance,2)}}
											</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-3 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-success-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h4 class="mb-3 tx-12 text-white" style="font-size: 20px; font-weight: bold;"> رصيد الصندوق و البنوك</h4>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div>
											<h4 class="font-weight-bold mb-1 text-white" style="font-size: 25px; font-weight: bold;">
												{{number_format($b_balance,2)}}
											</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row row-sm">
					<div class="col-xl-6 col-lg-6 col-md-12 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h4 style="font-size: 20px; font-weight: bold;" class="mb-3 tx-12 text-white">رصيد القيمة المضافة مبيعات </h4>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="font-weight-bold mb-1 text-white" style="font-size: 25px; font-weight: bold;">
												{{number_format($t_balance,2)}}
											</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					
					<div class="col-xl-6 col-lg-6 col-md-12 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h4 class="mb-3 tx-12 text-white" style="font-size: 20px; font-weight: bold;">رصيد القيمة المضافة مشتريات </h4>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div>
											<h4 class="font-weight-bold mb-1 text-white" style="font-size: 25px; font-weight: bold;">
												{{number_format($m_balance,2)}}
											</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				
								
					
					<div class="row row-sm" id="chart-container">
						<div class="col-md-12 col-lg-12 col-xl-6">
							<div class="card card-dashboard-map-one" style="height: 94%;">

								<label class="main-content-label">   الارباح لسنه {{date('Y')}}</label>
								<br>
								<div style="width: 100% ;">
									{!! $chartjs->render() !!}
								</div>
							</div>
						</div>
				
				
						<div class="col-lg-12 col-xl-6" style="font-size: 16px;">
							<div class="card card-dashboard-map-one">
								<label class="main-content-label" style="font-size: 16px;">تكلفة المخازن  </label>
								<div style="width: 100%;font-size:16px;">
									{!! $chartjs_2->render() !!}
								</div>
							</div>
						</div>
					</div>
					@endcan
			</div>
		</div>
		<!-- Container closed -->
@endsection
@section('js')
@livewireScripts
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
<!-- Moment js -->
<script src="{{URL::asset('assets/plugins/raphael/raphael.min.js')}}"></script>
<!--Internal  Flot js-->
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.pie.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.resize.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jquery.flot/jquery.flot.categories.js')}}"></script>
<script src="{{URL::asset('assets/js/dashboard.sampledata.js')}}"></script>
<script src="{{URL::asset('assets/js/chart.flot.sampledata.js')}}"></script>
<!--Internal Apexchart js-->
<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
<!-- Internal Map -->
<script src="{{URL::asset('assets/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<script src="{{URL::asset('assets/js/modal-popup.js')}}"></script>
<!--Internal  index js -->
<script src="{{URL::asset('assets/js/index.js')}}"></script>
<script src="{{URL::asset('assets/js/jquery.vmap.sampledata.js')}}"></script>	

<script src="{{ URL::asset('assets/plugins/chart.js/Chart.bundle.min.js') }}"></script>
@endsection