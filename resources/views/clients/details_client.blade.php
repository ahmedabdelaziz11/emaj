@extends('layouts.master')
@section('css')

    <!-- Internal Data table css -->
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('title')
    العميل  {{$client->client_name}}
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">العملاء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                معلومات العميل</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')


@if ($errors->any())
    <script>
        window.onload = function() {
            notif({
                msg:" فشلت الاضافة اسم العميل مكرر ",
                type: "error"
            })
        }
    </script>
@endif

@if (session()->has('Add'))
<script>
    window.onload = function() {
        notif({
            msg: "تم الاضافة بنجاح",
            type: "success"
        })
    }
</script>
@endif

@if (session()->has('delete'))
<script>
    window.onload = function() {
        notif({
            msg: "تم الحذف بنجاح",
            type: "error"
        })
    }
</script>
@endif

@if (session()->has('edit'))
<script>
    window.onload = function() {
        notif({
            msg: "تم التعديل بنجاح",
            type: "success"
        })
    }
</script>
@endif

				<!-- row -->

					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<div class="tabs-menu ">
									<!-- Tabs -->
									<ul class="nav nav-tabs profile navtab-custom panel-tabs">
										<li class="active">
											<a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">العميل</span> </a>
										</li>
										<li class="">
											<a href="#account" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-list-alt tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">حساب العميل</span> </a>
										</li>
										<li class="">
											<a href="#offers" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-server tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">عروض المنتجات</span> </a>
										</li>
										<li class="">
											<a href="#spare_offers" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-server tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">عروض قطع الغيار</span> </a>
										</li>
										<li class="">
											<a href="#invoices" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-server tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">فواتير  المنتجات</span> </a>
										</li>
										<li class="">
											<a href="#returned" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-server tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">مرتجعات المنتجات</span> </a>
										</li>
										<li class="">
											<a href="#spare_invoices" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-server tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">فواتير قطع الغيار</span> </a>
										</li>
										<li class="">
											<a href="#sreturned" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-server tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">مرتجعات قطع الغيار</span> </a>
										</li>
										{{-- <li class="">
											<a href="#payment" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-server tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">فاتورة سداد</span> </a>
										</li> --}}
										<li class="">
											<a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-cog tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">المرفقات</span> </a>
										</li>
									</ul>
								</div>
								<div class="tab-content border-left border-bottom border-right border-top-0 p-4">
									<div class="tab-pane active" id="home">
										<div class="m-t-30">
											<div class="">
												<div class="main-profile-overview">

													<div class="row">
														<div class="col">
															<div class="d-flex justify-content-between mg-b-20">
																<div>
																	<h5>الاسم</h5>
																	<p  style="font-weight: bold" >{{$client->client_name}}</p>
																</div>
															</div>
														</div>
														<div class="col">
															<div class="d-flex justify-content-between mg-b-20">
																<div>
																	<h5>العنوان</h5>
																	<p  style="font-weight: bold" >{{$client->address}}</p>
																</div>
															</div>
														</div>
													</div>
													<hr style="margin-top : 0px">
													<div class="row">
														<div class="d-flex justify-content-between mg-b-20 col">
															<div>
																<h5>اسم الشركة</h5>
																<p  style="font-weight: bold">{{$client->Commercial_Register}}</p>
															</div>
														</div>
													
															<div class="col">
														<h5>السجل التجاري </h5>
														<p style="font-weight: bold">
															{{$client->sgel}} 
														</p><!-- main-profile-bio -->
															</div>
															<div class="col">
														<h5>البطاقه الضريبية</h5>
														<p style="font-weight: bold">
															{{$client->dreba}} 
														</p><!-- main-profile-bio -->
															</div>
													</div>
												</div>

												<hr style="margin-top : 0px">
												<label class="main-content-label tx-13 mg-b-20">Social</label>
													<div class="main-profile-social-list">
														<div class="row">
															<div class="media col">
																<div class="media-icon bg-danger-transparent text-danger">
																	<i class="ion-md-phone-portrait"></i>
																</div>
																<div class="media-body">
																	<span>Phone</span> <a href="">{{$client->phone}}</a>
																</div>
															</div>
															<div class="media col">
																<div class="media-icon bg-danger-transparent text-danger">
																	<i class="icon ion-md-link"></i>
																</div>
																<div class="media-body">
																	<span>Emial</span> <a href="">{{$client->email}}</a>
																</div>
															</div>
														</div>
													</div>
													<hr class="mg-y-30">
													<div class="table-responsive mg-t-40">
														<table  class="table table-invoice border text-md-nowrap mb-0">
															<tbody>
																<tr>
																	<td class="valign-middle" colspan="1" rowspan="1">
																		<div class="invoice-notes">
																		</div><!-- invoice-notes -->													
																	</td>
																	<th style=" font-size: 32px;font-weight: bold" class="tx-right">  اجمالى دين العميل الحالى</th>
																	{{-- <th style="font-size: 25px" class="tx-right" colspan="2">{{ number_format($offers->total,2,'.') }}</th> --}}
																	<th style="font-size: 32px;" class="tx-right"></th>
																	{{-- <th style="font-size: 23px;font-weight: bold" class="tx-right" colspan="2">{{ number_format($offers->discount,2,'.') }}</th> --}}
																	<th></th><th></th>
																	<th style="font-size: 32px;font-weight: bold" class="tx-right tx-uppercase tx-bold tx-inverse"><span style="font-weight: bold" class="text-danger">{{number_format($client->debt,2,'.')  }}</span></th>
																	<th style="font-size: 27px;font-weight: bold" class="tx-right" colspan="2">
																		{{-- <h4 class="tx-primary tx-bold">{{ number_format($after_discount,2,'.') }}</h4> --}}
																	</th>
																</tr>
															</tbody>
														</table>
													</div>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="settings">
										<!--المرفقات-->
										<div class="card card-statistics">
											{{-- @can('اضافة مرفق') --}}
											<div class="card-body">
												<p class="text-danger">* صيغة المرفق pdf, jpeg ,.jpg , png </p>
												<h5 class="card-title">اضافة مرفقات</h5>
												<form method="post" action="{{ url('/ClientAttachments') }}"
													enctype="multipart/form-data">
													{{ csrf_field() }}
													<div class="custom-file">
														<input type="file" class="custom-file-input" id="customFile"
															name="file_name" required>
														<input type="hidden" id="client_id" name="client_id"
															value="{{ $client->id }}">
														<label class="custom-file-label" for="customFile">حدد
															المرفق</label>
													</div><br><br>
													<button type="submit" class="btn btn-primary btn-sm "
														name="uploadedFile">تاكيد</button>
												</form> 
											</div>
											{{-- @endcan --}}
											<br>
										
											<div class="table-responsive mt-15">
												<table class="table center-aligned-table mb-0 table table-hover"
													style="text-align:center">
													<thead>
														<tr class="text-dark">
															<th scope="col">م</th>
															<th scope="col">اسم الملف</th>
															<th scope="col">قام بالاضافة</th>
															<th scope="col">تاريخ الاضافة</th>
															<th scope="col">العمليات</th>
														</tr>
													</thead>
													<tbody>
														<?php $i = 0; ?>
														@foreach ($attachments as $attachment)
															<?php $i++; ?>
															<tr>
																<td>{{ $i }}</td>
																<td>{{ $attachment->file_name }}</td>
																<td>{{ $attachment->Created_by }}</td>
																<td>{{ $attachment->created_at }}</td>
																<td colspan="2">

																<a class="btn btn-outline-success btn-sm"
																	href="{{ url('View_file_c') }}/{{ $client->id }}/{{ $attachment->file_name }}"
																	role="button"><i class="fas fa-eye"></i>&nbsp;
																	عرض</a>

																<a class="btn btn-outline-info btn-sm"
																	href="{{ url('download_c') }}/{{ $client->id }}/{{ $attachment->file_name }}"
																	role="button"><i
																		class="fas fa-download"></i>&nbsp;
																	تحميل</a>

																{{-- @can('حذف المرفق') --}}
																	<button class="btn btn-outline-danger btn-sm"
																		data-toggle="modal"
																		data-file_name="{{ $attachment->file_name }}"
																		data-client_id="{{ $attachment->client_id }}"
																		data-id_file="{{ $attachment->id }}"
																		data-target="#delete_file">حذف</button>
																{{-- @endcan --}}

																</td>
															</tr>
														@endforeach
													</tbody>
													</tbody>
												</table>
										
											</div>
										</div>
									</div>	
									<div class="tab-pane" id="offers">
										<div class="card-body">
											<div class="table-responsive">
												<table id="" class="display" style="width:100%" data-page-length='50'
													>
													<thead>
														<tr>
															<th class="border-bottom-0">#</th>
															<th class="border-bottom-0">اسم العرض</th>
															<th class="border-bottom-0"> تاريخ العرض</th>
															<th class="border-bottom-0">طباعه</th>
															<th class="border-bottom-0">حذف</th>
														</tr>
													</thead>
													
													<tbody>
														<?php $offers_count = 0; ?>
														@foreach ($client->offers as $x)
															<?php $offers_count++; ?>
															<tr>
																<td>{{ $offers_count }}</td>
																<td><a
																	href="{{ url('OfferDetails') }}/{{ $x->id }}">{{ $x->name }}</a>
																</td>
																<td>{{ $x->offer_Date }}</td>
																<td>
																	<a class="dropdown-item" href="{{ url('Print_offer')}}/{{ $x->id }}"><i
																		class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
																	</a>														
																</td>
																<td>
																	<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
																	data-id="{{ $x->id }}" data-name="{{ $x->name }}"
																	data-toggle="modal" href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>													   
																</td>													
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="spare_offers">
										<div class="card-body">
											<div class="table-responsive">
												<table id="" class="display" style="width:100%;text-align: center ;" data-page-length='50'
													>
													<thead>
														<tr>
															<th class="border-bottom-0">#</th>
															<th class="border-bottom-0">اسم العرض</th>
															<th class="border-bottom-0"> تاريخ العرض</th>
															<th class="border-bottom-0">طباعه</th>
															<th class="border-bottom-0">حذف</th>
														</tr>
													</thead>
													
													<tbody>
														<?php $soffers_count = $soffers_total =  0; ?>
														@foreach ($client->spare_offers as $x)
															<?php $soffers_count++; ?>
															<tr>
																<td>{{ $soffers_count }}</td>
																<td><a
																	href="{{ url('OfferDetails_s') }}/{{ $x->id }}">{{ $x->name }}</a>
																</td>
																<td>{{ $x->offer_Date }}</td>
																<td>
																	<a class="dropdown-item" href="{{ url('Print_offer_s')}}/{{ $x->id }}"><i
																		class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
																	</a>														
																</td>
																<td>
																	<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
																	data-id="{{ $x->id }}" data-name="{{ $x->name }}"
																	data-toggle="modal" href="#modaldemo11" title="حذف"><i class="las la-trash"></i></a>													   
																</td>													
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="invoices">
										<div class="card-body">
											<div class="table-responsive">
												<table id="" class="display" style="width:100%;text-align: center ;"  data-page-length='20'
													style="text-align: center">
													<thead>
														<tr>
															<th class="border-bottom-0">#</th>
															<th class="border-bottom-0">رقم الفاتوره</th>
															<th class="border-bottom-0">تاريخ الفاتوره</th>
															<th class="border-bottom-0">اجمالى الفاتورة</th>
															<th class="border-bottom-0">المبلغ المدفوع</th>
															<th class="border-bottom-0">الارباح</th>
															<th class="border-bottom-0">النوع</th>
															<th class="border-bottom-0">طباعه</th>
															<th class="border-bottom-0">حذف</th>
														</tr>
													</thead>
													<tbody>
														<?php
														 	$invoices_count  = 0;
															$invoices_total  = 0;
															$paid_total      = 0;
															$invoices_profit = 0;
															$invoices_debt   = 0;
															$payment_count   = 0; 
															$payment_total   = 0;
															$i=0;
														?>
														@foreach ($client->invoices as $x)
															<?php
																if($x->Value_Status == 0)
																{
																	$invoices_count++;
																	$invoices_debt   = $invoices_debt   + ($x->total - $x->amount_paid);
																	$invoices_total  = $invoices_total  + $x->total;
																	$paid_total      = $paid_total + $x->amount_paid ; 
																	$invoices_profit = $invoices_profit + $x->profit ;
																}
																elseif($x->Value_Status == 1)
																{
																	$payment_count++;
																	$payment_total = $x->amount_paid; 
																}
																$i++;
															?>
															<tr>
																<td>{{ $i }}</td>
																<td><a
																	href="{{ url('InvoiceDetails') }}/{{ $x->id }}">{{ $x->id }}</a>
																</td>
																<td>{{ $x->invoice_Date }}</td>
																@if ($x->Value_Status == 0)
																<td>{{ $x->total }}</td>
																@else 
																<td>-</td>
																@endif			
																<td>{{ $x->amount_paid }}</td>
																@if ($x->Value_Status == 0)
																<td>{{ $x->profit }}</td>																														
																@else
																	<td>-</td>
																@endif

																<td><span style="font-weight: bold"  class="text-success">{{ $x->Status }}</span></td> 
																<td>
																	<a class="dropdown-item" href="{{ url('Print_invoice')}}/{{ $x->id }}"><i
																		class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
																	</a>														
																</td>
																<td>
																	<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
																	data-id="{{ $x->id }}" data-name="{{ "الفاتورة رقم ". $x->id  }}"
																	data-toggle="modal" href="#modaldemo10" title="حذف"><i class="las la-trash"></i></a>													   
																</td>													
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="returned">
										<div class="card-body">
											<div class="table-responsive">
												<table id="" class="display" style="width:100%;text-align: center ;"  data-page-length='20'
													style="text-align: center">
													<thead>
														<tr>
															<th class="border-bottom-0">#</th>
															<th class="border-bottom-0">رقم الفاتوره</th>
															<th class="border-bottom-0"> تاريخ الفاتوره</th>
															<th class="border-bottom-0">الاجمالى</th>
															<th class="border-bottom-0">مبلغ الاستلام</th>
															<th class="border-bottom-0">طباعه</th>
															<th class="border-bottom-0">حذف</th>
														</tr>
													</thead>
													<tbody>
														<?php
														 	$returned_count = 0;
															$returned_total = 0; 
															$returned_paid  = 0;
														?>
														@foreach ($client->invoices as $x)
															@foreach ($x->returned_invoice as $x)															
																<?php
																	$returned_count++;
																	$invoices_debt  = $invoices_debt   + $x->total_afterdebt;
																	$returned_total = $returned_total  + $x->total;
																	$returned_paid  = $returned_paid + $x->total_afterdebt ; 
																?>
																<tr>
																	<td>{{ $returned_count }}</td>
																	<td><a
																		href="{{ url('InvoiceDetails') }}/{{ $x->invoice_id }}">{{ $x->id }}</a>
																	</td>
																	<td>{{ $x->invoice_Date }}</td>
																	<td>{{ $x->total }}</td>
																	<td>{{ $x->total_afterdebt }}</td>
																	<td>
																		<a class="dropdown-item" href="{{ url('Print_invoice')}}/{{ $x->id }}"><i
																			class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
																		</a>														
																	</td>
																	<td>
																		<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
																		data-id="{{ $x->id }}" data-name="{{ "الفاتورة رقم ". $x->id  }}"
																		data-toggle="modal" href="#modaldemo10" title="حذف"><i class="las la-trash"></i></a>													   
																	</td>													
																</tr>
															@endforeach
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="spare_invoices">
										<div class="card-body">
											<div class="table-responsive">
												<table id="" class="display" style="width:100%;text-align: center ;"  data-page-length='20'
													style="text-align: center">
													<thead>
														<tr>
															<th class="border-bottom-0">#</th>
															<th class="border-bottom-0">رقم الفاتوره</th>
															<th class="border-bottom-0"> تاريخ الفاتوره</th>
															<th class="border-bottom-0">اجمالى الفاتورة</th>
															<th class="border-bottom-0">المبلغ المدفوع</th>
															<th class="border-bottom-0">الارباح</th>
															<th class="border-bottom-0">النوع</th>
															<th class="border-bottom-0">طباعه</th>
															<th class="border-bottom-0">حذف</th>
														</tr>
													</thead>
													<tbody>
														<?php
															$i = 0 ;															
														    //  فواتير بيع قطع الغيار خارج الضمان 
														 	$sinvoices_out_count  = 0;
															$sinvoices_out_total  = 0;
															$spaid_out_total      = 0;
															$sinvoices_out_profit = 0;
															$sinvoices_out_debt   = 0;
															// فواتير سداد الديون 
															$spayment_count      = 0; 
															$spayment_total      = 0;
															// فواتير بيع قطع الغيار داخل الضمان 
															$sinvoices_on_count = 0;
															$sinvoices_on_total = 0;
														?>
														@foreach ($client->spare_invoices as $x)
															<?php
																if($x->Value_Status == 0)
																{
																	$sinvoices_out_count++;
																	$sinvoices_out_debt   = $sinvoices_out_debt   + ($x->total - $x->amount_paid);
																	$sinvoices_out_total  = $sinvoices_out_total  + $x->total ;
																	$spaid_out_total      = $spaid_out_total      + $x->amount_paid;
																	$sinvoices_out_profit = $sinvoices_out_profit + $x->profit ;
																}
																elseif($x->Value_Status == 1)
																{
																	$spayment_count++;
																	$spayment_total = $spayment_total + $x->amount_paid;
																}
																elseif ($x->Value_Status == 2)
																{
																	$sinvoices_on_count++;
																	$sinvoices_on_total = $sinvoices_on_total + $x->total;
																}
																$i++;
															?>
															<tr>
																<td>{{ $i }}</td>
																<td><a
																	href="{{ url('InvoiceDetails_s') }}/{{ $x->id }}">{{ $x->id }}</a>
																</td>
																<td>{{ $x->invoice_Date }}</td>
																@if ($x->Value_Status == 0)
																<td>{{ $x->total }}</td>
																@else 
																<td>-</td>
																@endif			
																<td>{{ $x->amount_paid }}</td>
																@if ($x->Value_Status == 0)
																<td>{{ $x->profit }}</td>																														
																@else
																	<td>-</td>
																@endif
																<td><span style="font-weight: bold"  class="text-success">{{ $x->Status }}</span></td> 
																<td>
																	<a class="dropdown-item" href="{{ url('Print_invoice_s')}}/{{ $x->id }}"><i
																		class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
																	</a>														
																</td>
																<td>
																	<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
																	data-id="{{ $x->id }}" data-name="{{ "الفاتورة رقم ". $x->id  }}"
																	data-toggle="modal" href="#modaldemo12" title="حذف"><i class="las la-trash"></i></a>													   
																</td>													
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
									<div class="tab-pane" id="sreturned">
										<div class="card-body">
											<div class="table-responsive">
												<table id="" class="display" style="width:100%;text-align: center ;"  data-page-length='20'
													style="text-align: center">
													<thead>
														<tr>
															<th class="border-bottom-0">#</th>
															<th class="border-bottom-0">رقم الفاتوره</th>
															<th class="border-bottom-0"> تاريخ الفاتوره</th>
															<th class="border-bottom-0">الاجمالى</th>
															<th class="border-bottom-0">مبلغ الاستلام</th>
															<th class="border-bottom-0">طباعه</th>
															<th class="border-bottom-0">حذف</th>
														</tr>
													</thead>
													<tbody>
														<?php 
														 	$sreturned_count = 0;
															$sreturned_total = 0; 
															$sreturned_paid  = 0;
														?>
														@foreach ($client->spare_invoices as $x)
															@foreach ($x->returned_invoice as $x)
															<?php
																$sreturned_count++;
																$sinvoices_out_debt = $sinvoices_out_debt  + $x->total_afterdebt;
																$returned_total = $returned_total  + $x->total;
																$returned_paid  = $returned_paid + $x->total_afterdebt ; 
															?>
																<tr>
																	<td>{{ $sreturned_count }}</td>
																	<td><a
																		href="{{ url('InvoiceDetails_s') }}/{{ $x->invoice_id }}">{{ $x->id }}</a>
																	</td>
																	<td>{{ $x->invoice_Date }}</td>																
																	<td>{{ $x->total }}</td>																
																	<td>{{ $x->total_afterdebt }}</td>																
																	<td>
																		<a class="dropdown-item" href="{{ url('Print_invoice_s')}}/{{ $x->id }}"><i
																			class="text-success fas fa-print"></i>&nbsp;&nbsp;طباعة
																		</a>														
																	</td>
																	<td>
																		<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
																		data-id="{{ $x->id }}" data-name="{{ "الفاتورة رقم ". $x->id  }}"
																		data-toggle="modal" href="#modaldemo12" title="حذف"><i class="las la-trash"></i></a>													   
																	</td>													
																</tr>
															@endforeach
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>
									{{-- <div class="tab-pane" id="payment">
										<form  action="{{ route('payment') }}" method="post" autocomplete="off">
											@csrf			
											<input type="hidden" name="client_id" value="{{$client->id}}">						
											<div class="row">
									
												<div class="col">
													<label>تاريخ الفاتوره</label>
													<input class="form-control" name="invoice_Date" placeholder="YYYY-MM-DD"
														type="date" value="{{ date('Y-m-d') }}" required>
												</div>
																				
												<div class="col">
													<div class="form-group">
														<label>رصيد الايداع</label>
														<select class="form-control select2 " name="account_id" id="account_picker" required="required">
															<option value="">اختر الرصيد </option>
															@foreach ($accounts as $account)
																<option value="{{ $account->id }}" account="{{$account->account}}"> {{ $account->name }} </option>
															@endforeach
														</select>
													</div>
												</div>
											</div>
											<div class="row">
													<div class="col-lg-3 mg-t-30">
														<label class="rdiobox">
														<input name="rdio" value="1" type="radio" required><span style="font-weight: bold;font-size: 16px">ديون المنتجات </span></label>
													</div>
													<div class="col-lg-3 mg-t-30 ">
														<label class="rdiobox">
														<input name="rdio" value="2" type="radio"><span style="font-weight: bold; font-size: 16px">ديون قطع الغيار</span></label>
													</div>
												<div class="col">
													<label for="inputName" class="control-label">المبلغ المدفوع</label>
													<input type="number" class="form-control" id="amount_paid" name="amount_paid"
													value="0" min="0" step="0.01"  title="يرجي ادخال المبلغ المدفوع  " required>
												</div>
											</div>
											<br>
											<button type="submit" class="btn btn-primary w-100 ">اضافة الفاتوره</button>
										  </form>
									</div> --}}
									<div class="tab-pane" id="account">
										<div class="card-body">
											<form action="{{route('ClientDetails')}}" method="GET" role="search" autocomplete="off">
												<input type="hidden" name="id" value="{{$client->id}}">						
												<div class="row">
													<div class="col-lg-4" id="start_at">
														<label for="exampleFormControlSelect1">من تاريخ</label>
														<div class="input-group">
															<div class="input-group-prepend">
															</div><input class="form-control" value="{{ $start_at ?? '' }}"
																name="start_at" placeholder="YYYY-MM-DD" type="date" required>
														</div><!-- input-group -->
													</div>
							
													<div class="col-lg-4" id="end_at">
														<label for="exampleFormControlSelect1">الي تاريخ</label>
														<div class="input-group">
															<div class="input-group-prepend">
															</div><input class="form-control" name="end_at"
																value="{{ $end_at ?? '' }}" placeholder="YYYY-MM-DD" type="date" required>
														</div><!-- input-group -->
													</div>
													<div class="col-lg-3">
														<label for="exampleFormControlSelect1">البحث بفترة زمنية</label>
														<div class="input-group">
															<button class="btn btn-primary btn-block">بحث</button>
														</div>
													</div>
												</div><br>					
											</form>
										</div>
										<div class="card-body">
											<div class="table-responsive">
												<table id="example3" class="table key-buttons text-md-nowrap" data-page-length='20'
													style="text-align: center ;text-align: center;font-size: 15px">
													<thead>
														<tr>
															<th style="text-align: center;">#</th>
															<th style="text-align: center;"> نوع الفواتير</th>
															<th style="text-align: center;">العدد</th>
															<th style="text-align: center;">اجمالى الفواتير</th>
															<th style="text-align: center;">اجمالى المبلغ المدفوع</th>
															<th style="text-align: center;">الديون</th>
															<th style="text-align: center;">الارباح</th>
														</tr>
													</thead>														 	
													<tbody>														 	
														<tr>
															<td>1</td>
															<td>بيع منتجات</td>
															<td>{{$invoices_count}}</td>
															<td>{{ number_format($invoices_total,2,'.') }}</td>
															<td>{{ number_format($paid_total,2,'.') }}</td>
															<td><span style="font-weight: bold" class="text-danger">{{ number_format($invoices_debt,2,'.') }}</span></td>
															<td><span style="font-weight: bold" class="text-success">{{number_format($invoices_profit,2,'.')  }}</span></td>
														</tr>
														<tr>
															<td>2</td>
															<td>مرتجعات منتجات</td>
															<td>{{$returned_count}}</td>
															<td>{{ number_format($returned_total,2,'.') }}</td>
															<td><span style="font-weight: bold" class="text-danger">{{ number_format($returned_paid,2,'.') }}-</span></td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
															<td><span style="font-weight: bold" class="text-success">-</span></td>
														</tr>

														<tr>
															<td>3</td>
															<td>بيع قطع غيار (خارج الضمان)</td>
															<td>{{$sinvoices_out_count}}</td>
															<td>{{number_format($sinvoices_out_total,2,'.')  }}</td>											
															<td>{{number_format($spaid_out_total,2,'.')  }}</td>											
															<td><span style="font-weight: bold" class="text-danger">{{number_format($sinvoices_out_debt,2,'.')  }}</span></td>
															<td><span style="font-weight: bold" class="text-success">{{number_format($sinvoices_out_profit,2,'.')  }}</span></td>
														</tr>
														<tr>
															<td>4</td>
															<td> بيع قطع غيار (داخل الضمان)</td>
															<td>{{$sinvoices_on_count}}</td>
															<td>{{ number_format($sinvoices_on_total,2,'.') }}</td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
															<td><span style="font-weight: bold" class="text-danger">{{ number_format($sinvoices_on_total,2,'.') }}-</span></td>
														</tr>
														<tr>
															<td>5</td>
															<td>مرتجعات قطع الغيار</td>
															<td>{{$sreturned_count}}</td>
															<td>{{ number_format($sreturned_total,2,'.') }}</td>
															<td><span style="font-weight: bold" class="text-danger">{{ number_format($sreturned_paid,2,'.') }}-</span></td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
														</tr>
														<tr>
															<td>6</td>
															<td>سداد (منتجات)</td>
															<td>{{$payment_count}}</td>
															<td style="font-weight: bold" class="text-danger">-</td>
															<td>{{ number_format($payment_total,2,'.') }}</td>
															<td><span style="font-weight: bold" class="text-success">{{ number_format($payment_total,2,'.') }}-</span></td>
															<td><span style="font-weight: bold" class="text-success">-</span></td>
														</tr>
														<tr>
															<td>7</td>
															<td>سداد (قطع غيار)</td>
															<td>{{$spayment_count}}</td>
															<td>-</td>
															<td>{{ number_format($spayment_total,2,'.') }}</td>
															<td><span style="font-weight: bold" class="text-success">{{ number_format($spayment_total,2,'.') }}-</span></td>
															<td><span style="font-weight: bold" class="text-success">-</span></td>
														</tr>
														<tr>
															<td>8</td>
															<td>عروض منتجات</td>
															<td>{{$offers_count}}</td>
															<td>-</td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
														</tr>
														<tr>
															<td>9</td>
															<td>عروض قطع الغيار</td>
															<td>{{$soffers_count}}</td>
															<td>-</td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
															<td><span style="font-weight: bold" class="text-danger">-</span></td>
														</tr>
													</tbody>
												</table>
												<div class="table-responsive mg-t-40">
													<table  class="table table-invoice border text-md-nowrap mb-0">
														<tbody>
															<tr>
																<td class="valign-middle" colspan="1" rowspan="1"></td>
																<th style=" font-size: 28px;font-weight: bold" class="tx-right"> دين العميل</th>
																<th style="font-size: 32px;" class="tx-right"></th>
																<th style="font-size: 28px;font-weight: bold" class="tx-right tx-uppercase tx-bold tx-inverse"><span style="font-weight: bold" class="text-danger">{{number_format(($sinvoices_out_debt + $invoices_debt)-($payment_total+$spayment_total),2,'.')  }}</span></th>
																<th></th><th></th>
																<td class="valign-middle" colspan="1" rowspan="1"></td>
																<th style=" font-size: 28px;font-weight: bold" class="tx-right">الارباح</th>
																<th style="font-size: 32px;" class="tx-right"></th>
																<th></th><th></th>
																<th style="font-size: 28px;font-weight: bold" class="tx-right tx-uppercase tx-bold tx-inverse"><span style="font-weight: bold" class="text-success">{{number_format(($sinvoices_out_profit + $invoices_profit)-$sinvoices_on_total,2,'.')  }}</span></th>
															</tr>
														</tbody>
													</table> 
													<br>
												</div>
											</div>
										</div>
									</div>

									<div class="modal fade" id="delete_file" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
									aria-hidden="true">
									<div class="modal-dialog" role="document">
										<div class="modal-content">
											<div class="modal-header">
												<h5 class="modal-title" id="exampleModalLabel">حذف المرفق</h5>
												<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
												</button>
											</div>
											<form action="{{ route('delete_file_c') }}" method="post">
								
												{{ csrf_field() }}
												<div class="modal-body">
													<p class="text-center">
													<h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
													</p>
								
													<input type="hidden" name="id_file" id="id_file" value="">
													<input type="hidden" name="file_name" id="file_name" value="">
													<input type="hidden" name="client_id" id="client_id" value="">
								
												</div>
												<div class="modal-footer">
													<button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
													<button type="submit" class="btn btn-danger">تاكيد</button>
												</div>
											</form>
										</div>
									</div>
								</div>
									<!-- delete invoice -->
									<div class="modal" tabindex="-1" id="modaldemo10">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content modal-content-demo">
												<div class="modal-header">
													<h6 class="modal-title">حذف الفاتوره</h6><button aria-label="Close" class="close" data-dismiss="modal"
														type="button"><span aria-hidden="true">&times;</span></button>
												</div>
												<form action="{{route('invoices.destroy',1)}}" method="post">
													{{ method_field('delete') }}
													{{ csrf_field() }}
													<div class="modal-body">
														<p>هل انت متاكد من عملية الحذف ؟</p><br>
														<input type="hidden" name="id" id="id" value="">															<input class="form-control" name="name" id="name" type="text" readonly>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
														<button type="submit" class="btn btn-danger">تاكيد</button>
													</div>
											</div>
											</form> 
										</div>
									</div>
							
									<!-- /row -->
									<div class="modal" tabindex="-1" id="modaldemo9">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content modal-content-demo">
												<div class="modal-header">
													<h6 class="modal-title">حذف العرض</h6><button aria-label="Close" class="close" data-dismiss="modal"
														type="button"><span aria-hidden="true">&times;</span></button>
												</div>
												 	<form action="{{route('offers.destroy',1)}}" method="post">
													{{ method_field('delete') }}
													{{ csrf_field() }}
													<div class="modal-body">
														<p>هل انت متاكد من عملية الحذف ؟</p><br>
														<input type="hidden" name="id" id="id" value="">
														<input class="form-control" name="name" id="name" type="text" readonly>
													</div>
													<div class="modal-footer">
														<button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
														<button type="submit" class="btn btn-danger">تاكيد</button>
													</div>
													</form> 
											</div>
										</div>
									</div>
							</div>
						</div>
					</div>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<script>
	$('#delete_file').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id_file = button.data('id_file')
		var file_name = button.data('file_name')
		var client_id = button.data('client_id')
		var modal = $(this)
		modal.find('.modal-body #id_file').val(id_file);
		modal.find('.modal-body #file_name').val(file_name);
		modal.find('.modal-body #client_id').val(client_id);
	})
</script>
<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
    })
</script>
<script>
    $('#modaldemo10').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
    })
</script>
<script>
	$(document).ready(function() {
		$('table.display').DataTable({
			select: true
		});
	});
</script>
@endsection