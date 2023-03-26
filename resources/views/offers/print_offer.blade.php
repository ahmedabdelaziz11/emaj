@extends('layouts.master')
@section('css')
<style>
	/* @media screen {
  	div.divFooter {
    	display: none;
    	}
	} */
	@media print {
		#print_Button {
			display: none;
		}
		.zxc{
			 border: none; border-collapse: collapse; 
			
		}
		.zxc td { border-left: 1px solid #000; }
	 	.zxc td:first-child { border-left: none; }
		/* div.divFooter {
        	position: fixed;
    		bottom: 0;
  		}   */

	}


</style>
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">العروض</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ طباعه العرض</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('title')
    {{ $offers->name.'_'.$offers->client->client_name}}
@stop
@section('content')
				<!-- row -->
				<div class="row row-sm">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice" id="print">
							<div class="card card-invoice">
								<div class="card-body">
									<div class="invoiceHead">
										<div class="invoice-header">
											<img src="{{URL::asset('assets/img/brand/logo.png')}}" style="height:150px" class="logo-1" alt="logo">
											<div class="billed-from">
												<h6></h6>
												<p style="font-weight: bold;font-size: 17px;">3 محمد سليمان غنام , من محمد رفعت ,النزهة الجديدة      <br>
													الهاتف :  01000241938 / 01208524340   <br>
													الايميل :  info@emajegypt.com</p>
											</div><!-- billed-from -->
										</div><!-- invoice-header -->
									</div>

									<h1 style="text-align: center ; font-weight: bold;">عرض أسعار</h1>
									<div class="row mg-t-20">
										<div class="col-md">
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> اسم العرض</span> <span>{{$offers->name}}</span></p>
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> اسم العميل</span> <span>{{$offers->client->client_name}}</span></p>
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> اسم الشركه</span> <span>{{$offers->client->Commercial_Register}}</span></p>
										</div>
										<div class="col-md" style="margin-right: 80px">
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>العنوان</span> <span>{{$offers->client->address}}</span></p>
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>التليفون</span> <span>{{$offers->client->phone}}</span></p>
											<p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span> تاريخ اصدار العرض</span> <span>{{$offers->offer_Date}}</span></p>
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
														<td style="text-align: center;font-size: 17px;font-weight: bold;border-left: 1px solid rgb(177, 170, 170);">{{ number_format($product->product_price) }}</td>
														@php
															$total = $product->product_quantity * $product->product_price ;
															$totalall = $totalall +$total ;
														@endphp
														<td style="text-align: center;font-size: 17px;font-weight: bold;">{{number_format($total)}}</td>																																						                              											
													</tr>
												@endforeach
												@php
												$discount = (  $offers->discount / 100 ) * $totalall;
												$after_discount = $totalall - $discount ;
											@endphp
											</tbody>
										</table>
									</div>
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
													<th style=" font-size: 23px;font-weight: bold" class="tx-right"> الاجمالي</th>
													<th style=" font-size: 23px;font-weight: bold" class="tx-right" colspan="2">{{ number_format($totalall,2,'.') }}</th>
													<th style=" font-size: 23px;font-weight: bold" class="tx-right">نسبه الخصم (%)</th>
													<th style=" font-size: 23px;font-weight: bold" class="tx-right" colspan="2">{{$offers->discount}}</th>
													<th></th><th></th>
													<th style=" font-size: 23px;font-weight: bold" class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي  بعد الخصم</th>
													<th style=" font-size: 23px;font-weight: bold" class="tx-right" colspan="2">
														<h4 class="tx-primary tx-bold" style=" font-size: 23px;font-weight: bold">{{ number_format($after_discount,2,'.') }}</h4>
													</th>
												</tr>
											</tbody>
										</table>
									</div>
										<table>
											<tr>										
												<td class="tx-right" colspan="6">
													<div class="invoice-notes">
														<p style="color: black"><pre style="color: black;font-size: 16px; border:none">{{$offers->constraints}}</pre></p>
													</div><!-- invoice-notes -->
												</td>
											</tr>
										</table>										
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