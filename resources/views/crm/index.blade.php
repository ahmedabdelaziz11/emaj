@extends('layouts.master')
@section('title')
لوحة تحكم خدمة العملاء
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
					<div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-primary-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h4 style="font-size: 18px; font-weight: bold;" class="mb-3 tx-12 text-white">طلابات الاصلاح المعطلة</h4>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div class="">
											<h4 class="font-weight-bold mb-1 text-white" style="font-size: 18px; font-weight: bold;">
												{{$pending_count}}
											</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					
					<div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-danger-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h4 class="mb-3 tx-12 text-white" style="font-size: 18px; font-weight: bold;">طلابات الاصلاح جارى اصلاحها</h4>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div>
											<h4 class="font-weight-bold mb-1 text-white" style="font-size: 18px; font-weight: bold;">
												{{$in_progress_count}}
											</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-xl-4 col-lg-6 col-md-6 col-xm-12">
						<div class="card overflow-hidden sales-card bg-warning-gradient">
							<div class="pl-3 pt-3 pr-3 pb-2 pt-0">
								<div class="">
									<h4 class="mb-3 tx-12 text-white" style="font-size: 18px; font-weight: bold;">طلابات الاصلاح تم تشغيلها خلال الشهر</h4>
								</div>
								<div class="pb-0 mt-0">
									<div class="d-flex">
										<div>
											<h4 class="font-weight-bold mb-1 text-white" style="font-size: 18px; font-weight: bold;">
												{{$closed_count}}
											</h4>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="row mb-2">
					<div class="col-6">
						<table class="table table-bordered mg-b-0 text-md-nowrap" style="font-size:18px;">
							<tbody>
								<tr class="text-center" >
									<td class="text-center" colspan="2">المنتجات الاكثر استخداما</td>
								</tr>
								<tr>
									<td>اسم المنتج</td>
									<td>العدد</td>
								</tr>
								@foreach ($products as $product)
									<tr>
										<td>{{$product->product->name}}</td>
										<td class="text-center">{{$product->count}}</td>
									</tr>
								@endforeach
							</tbody>
						</table>
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