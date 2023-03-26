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
							<h4 class="content-title mb-0 my-auto">الفواتير</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">طباعه الفاتورة</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('title')
    {{ $offers->name.'_'.$offers->supplier->name}}
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
									<h1 style="text-align: center ; font-weight: bold">اذن صرف شراء منتجات</h1>
									<div class="row mg-t-20">
										<div class="col-md">
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>كود الفاتورة </span> <span>{{$offers->id}}</span></p>
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> اسم المورد</span> <span>{{$offers->supplier->name}}</span></p>
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> اسم الشركه</span> <span>{{$offers->supplier->company_name}}</span></p>
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>س-ت</span> <span>{{$offers->supplier->c_register}}</span><span>ب-ض </span> <span>{{$offers->supplier->tax_card}}</span></p>
										</div>
										<div class="col-md" style="margin-right: 80px">
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>العنوان</span> <span>{{$offers->supplier->address}}</span></p>
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>التليفون</span> <span>{{$offers->supplier->phone}}</span></p>
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>تاريخ اصدار الفاتورة</span> <span>{{$offers->receipt_date}}</span></p>
										</div>
									</div>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th style="font-size: 17px" class="tx-center">م</th>
													<th style="font-size: 17px" class="tx-center">اسم / ماركه</th>
													<th style="font-size: 17px" class="tx-center">التوصيف</th>
													<th style="font-size: 17px" class="tx-center">الكمية</th>
													<th style="font-size: 17px" class="tx-center">سعر الوحدة</th>
													<th style="font-size: 17px" class="tx-center">الاجمالى</th>
												</tr>
											</thead>
											<tbody>
												<?php $i = 0; $totalall = 0; ?>
												@foreach ($details as $product)
													<?php $i++; ?>
													<tr>
														<td style="font-size: 17px;font-weight: 100;border-left: 1px solid rgb(177, 170, 170);">{{ $i }}</td>
														<td style="border-left: 1px solid rgb(177, 170, 170);"><pre style="border:none;font-size: 16px;font-weight: bold;">{{ $product->product->name }}</pre></td>
														<td style="border-left: 1px solid rgb(177, 170, 170);"><pre style="border:none;font-size: 16px;font-weight: bold;">{!! $product->product->description !!}</pre></td>
														<td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ $product->product_quantity }}</td>
														<td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ number_format($product->product_selling_price) }}</td>
														<td style="text-align: center;font-size: 17px;font-weight: bold;">{{number_format($offers->total)}}</td>																																						                              											
													</tr>
												@endforeach
											</tbody>
										</table>
										@php
										$discount = (  $offers->discount / 100 ) * $offers->total;
										$after_discount = $offers->total - $discount ;
										@endphp
										<div class="table-responsive mg-t-40">
											<table  class="table table-invoice border text-md-nowrap mb-0">
												<tbody>
													<tr>
														<td class="valign-middle" colspan="1" rowspan="1">
															<div class="invoice-notes">
																<a href="#" class="btn btn-danger float-left mt-3 mr-2" id="print_Button" onclick="printDiv()">
																	<i class="mdi mdi-printer ml-1"></i>Print
																</a>
															</div><!-- invoice-notes -->													
														</td>
														<th style=" font-size: 32px;font-weight: bold" class="tx-right"> الاجمالي</th>
														<th style="font-size: 25px" class="tx-right" colspan="2">{{ number_format($offers->total,2,'.') }}</th>
														<th style="font-size: 32px;" class="tx-right">نسبه الخصم (%)</th>
														<th style="font-size: 23px;font-weight: bold" class="tx-right" colspan="2">{{ number_format($offers->discount,2,'.') }}</th>
														<th></th><th></th>
														<th style="font-size: 32px;font-weight: bold" class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي  بعد الخصم</th>
														<th style="font-size: 27px;font-weight: bold" class="tx-right" colspan="2">
															<h4 class="tx-primary tx-bold">{{ number_format($after_discount,2,'.') }}</h4>
														</th>
													</tr>
												</tbody>
											</table>
										</div>
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