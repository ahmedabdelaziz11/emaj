@extends('layouts.master')
@section('css')
div.dataTables_wrapper {
	margin-bottom: 20px;
}
@endsection
@section('title')
    الموردين 
@stop
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الموردين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                معلومات المورد</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')


@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@if (session()->has('Add'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('Add') }}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif
@if (session()->has('edit'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
	<strong>{{ session()->get('edit') }}</strong>
	<button type="button" class="close" data-dismiss="alert" aria-label="Close">
		<span aria-hidden="true">&times;</span>
	</button>
</div>
@endif

@if (session()->has('delete'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>{{ session()->get('delete') }}</strong>
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>
@endif

				<!-- row -->

					<div class="col-lg-12">
						<div class="card">
							<div class="card-body">
								<div class="tabs-menu ">
									<!-- Tabs -->
									<ul class="nav nav-tabs profile navtab-custom panel-tabs">
										<li class="active">
											<a href="#home" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span style="font-size: 15px;font-weight: bold" class="hidden-xs"> عن المورد</span> </a>
										</li>
										<li class="">
											<a href="#account" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-list-alt tx-16 mr-1"></i></span> <span style="font-size: 15px;font-weight: bold" class="hidden-xs">حساب المورد</span> </a>
										</li>
										<li class="">
											<a href="#receipts" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-server tx-16 mr-1"></i></span> <span style="font-size: 15px;font-weight: bold" class="hidden-xs">فواتير المنتجات</span> </a>
										</li>
										<li class="">
											<a href="#spare_receipts" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-server tx-16 mr-1"></i></span> <span style="font-size: 15px;font-weight: bold" class="hidden-xs">فواتير قطع الغيار</span> </a>
										</li>

										<li class="">
											<a href="#settings" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="las la-cog tx-16 mr-1"></i></span> <span style="font-size: 15px;font-weight: bold" class="hidden-xs">المرفقات</span> </a>
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
																	<p  style="font-weight: bold" >{{$suppliers->name}}</p>
																</div>
															</div>
														</div>
														<div class="col">
															<div class="d-flex justify-content-between mg-b-20">
																<div>
																	<h5>العنوان</h5>
																	<p  style="font-weight: bold" >{{$suppliers->address}}</p>
																</div>
															</div>
														</div>
													</div>
													<hr style="margin-top : 0px">
													<div class="row">
														<div class="d-flex justify-content-between mg-b-20 col">
															<div>
																<h5>اسم الشركة</h5>
																<p  style="font-weight: bold">{{$suppliers->company_name}}</p>
															</div>
														</div>
													
															<div class="col">
														<h5>السجل التجاري </h5>
														<p style="font-weight: bold">
															{{$suppliers->c_register}} 
														</p><!-- main-profile-bio -->
															</div>
															<div class="col">
														<h5>البطاقه الضريبية</h5>
														<p style="font-weight: bold">
															{{$suppliers->tax_card}} 
														</p><!-- main-profile-bio -->
															</div>
															<div class="col">
																<h5> رقم الحساب</h5>
																<p style="font-weight: bold">
																	{{$suppliers->account_number}} 
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
																	<span>Phone</span> {{$suppliers->phone}}
																</div>
															</div>
															<div class="media col">
																<div class="media-icon bg-danger-transparent text-danger">
																	<i class="icon ion-md-link"></i>
																</div>
																<div class="media-body">
																	<span>Emial</span> {{$suppliers->email}}
																</div>
															</div>
														</div>
													</div>
													<hr>
													<div class="table-responsive mg-t-40">
														<table  class="table table-invoice border text-md-nowrap mb-0">
															<tbody>
																<tr>
																	<td class="valign-middle" colspan="1" rowspan="1">
																		<div class="invoice-notes">
																		</div><!-- invoice-notes -->													
																	</td>
																	<th style=" font-size: 32px;font-weight: bold" class="tx-right">  اجمالى دين المورد الحالى</th>
																	<th style="font-size: 32px;" class="tx-right"></th>
																	<th></th><th></th>
																	<th style="font-size: 32px;font-weight: bold" class="tx-right tx-uppercase tx-bold tx-inverse"><span style="font-weight: bold" class="text-danger">{{number_format($suppliers->debt,2,'.')  }}</span></th>
																	<th style="font-size: 27px;font-weight: bold" class="tx-right" colspan="2">
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
													<form method="post" action="{{ url('/SupplierAttachments') }}"
														enctype="multipart/form-data">
														{{ csrf_field() }}
														<div class="custom-file">
															<input type="file" class="custom-file-input" id="customFile"
																name="file_name" required>
															<input type="hidden" id="invoice_id" name="supplier_id"
																value="{{ $suppliers->id }}">
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
																		href="{{ url('View_file_s') }}/{{ $suppliers->id }}/{{ $attachment->file_name }}"
																		role="button"><i class="fas fa-eye"></i>&nbsp;
																		عرض</a>

																	<a class="btn btn-outline-info btn-sm"
																		href="{{ url('download_s') }}/{{ $suppliers->id }}/{{ $attachment->file_name }}"
																		role="button"><i
																			class="fas fa-download"></i>&nbsp;
																		تحميل</a>

																	{{-- @can('حذف المرفق') --}}
																		<button class="btn btn-outline-danger btn-sm"
																			data-toggle="modal"
																			data-file_name="{{ $attachment->file_name }}"
																			data-supplier_id="{{ $attachment->supplier_id }}"
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


									<div class="tab-pane" id="receipts">
										<div class="card-body">
											<div class="table-responsive">
												<table id="" class="display" style="width:100%" data-page-length='20'
													style="text-align: center">
													<thead style="text-align: center">
														<tr>
															<th class="border-bottom-0">#</th>
															<th class="border-bottom-0">رقم الفاتوره</th>
															<th class="border-bottom-0"> تاريخ الفاتوره</th>
															<th class="border-bottom-0"> اجمالى الفاتوره</th>
															<th class="border-bottom-0"> المبلغ المدفوع</th>
															<th class="border-bottom-0">الحالة</th>
															<th class="border-bottom-0">حذف</th>
														</tr>
													</thead>
													<tbody style="text-align: center;">
														<?php
														 	$receipts_count = $receipts_debt = $receipts_total =$paid_total = $payment_count = $payment_total = $i = 0;
														?>
														@foreach ($suppliers->receipts as $x)
															<?php
																if($x->Value_Status == 0)
																{
																	$receipts_count++;
																	$receipts_debt   = $receipts_debt   + ($x->total - $x->amount_paid);
																	$receipts_total  = $receipts_total  + $x->total ;
																	$paid_total 	 = $paid_total      + $x->amount_paid;
																}														
																elseif($x->Value_Status == 1)
																{
																	$payment_count++;
																	$payment_total  = $payment_total  + $x->amount_paid ;
																}
																$i++ ;																
															?>
															<tr>
																<td>{{ $i }}</td>
																<td><a
																	href="{{ url('ReceiptDetails') }}/{{ $x->id }}">{{ $x->id }}</a>
																</td>
																<td>{{ $x->receipt_date }}</td>
																<td>{{ $x->total }}</td>
																<td>{{ $x->amount_paid }}</td>
																<td>
																	@if ($x->Value_Status == 0)
																		<span style="font-weight: bold" class="text-warning">{{ $x->Status }}</span>
																	@elseif($x->Value_Status == 1)
																		<span style="font-weight: bold" class="text-success">{{ $x->Status }}</span>
																	@else
																		<span class="text-warning">{{ $x->Status }}</span>
																	@endif
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
									<div class="tab-pane" id="spare_receipts">
										<div class="card-body">
											<div class="table-responsive">
												<table id="" class="display" style="width:100%" data-page-length='20'
													style="text-align: center">
													<thead style="text-align: center;">
														<tr>
															<th class="border-bottom-0">#</th>
															<th class="border-bottom-0">رقم الفاتوره</th>
															<th class="border-bottom-0"> تاريخ الفاتوره</th>
															<th class="border-bottom-0"> اجمالى الفاتوره</th>
															<th class="border-bottom-0"> المبلغ المدفوع</th>
															<th class="border-bottom-0">الحالة</th>
															<th class="border-bottom-0">حذف</th>
														</tr>
													</thead>
													<tbody style="text-align: center;">
														<?php
														 	$sreceipts_count = $sreceipts_debt = $sreceipts_total =$spaid_total = $spaymet_count =$spayment_total = $i = 0;
														?>
														@foreach ($suppliers->spare_receipts as $x)
															<?php
																if($x->Value_Status == 0)
																{
																	$sreceipts_count++;
																	$sreceipts_debt  = $sreceipts_debt  + ($x->total - $x->amount_paid);
																	$sreceipts_total = $sreceipts_total + $x->total ;
																	$spaid_total 	 = $spaid_total     + $x->amount_paid; 
																}																	
																elseif($x->Value_Status == 1)
																{
																	$spaymet_count++;
																	$spayment_total = $spayment_total + $x->amount_paid;
																}
																$i++;
															?>
															<tr>
																<td>{{ $i }}</td>
																<td><a
																	href="{{ url('ReceiptDetails_s') }}/{{ $x->id }}">{{ $x->id }}</a>
																</td>
																<td>{{ $x->receipt_date }}</td>
																<td>{{ $x->total }}</td>
																<td>{{ $x->amount_paid }}</td>
																<td>
																	@if ($x->Value_Status == 0)
																		<span style="font-weight: bold" class="text-warning">{{ $x->Status }}</span>
																	@elseif($x->Value_Status == 1)
																		<span style="font-weight: bold" class="text-success">{{ $x->Status }}</span>
																	@else
																		<span class="text-warning">{{ $x->Status }}</span>
																	@endif
																</td>
																<td>
																	<a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
																	data-id="{{ $x->id }}" data-name="{{ "الفاتورة رقم ". $x->id  }}"
																	data-toggle="modal" href="#modaldemo11" title="حذف"><i class="las la-trash"></i></a>													   
																</td>													
															</tr>
														@endforeach
													</tbody>
												</table>
											</div>
										</div>
									</div>  

									<div class="tab-pane" id="account">
										<div class="card-body">
											<form action="{{route('SupplierDetails')}}" method="GET" role="search" autocomplete="off">
												<input type="hidden" name="supplier_id" value="{{$suppliers->id}}">						
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
													style="text-align: center;font-size: 20px">
													<thead>
														<tr>
															<th style="text-align: center;font-size: 20px">#</th>
															<th style="text-align: center;font-size: 20px"> نوع الفواتير</th>
															<th style="text-align: center;font-size: 20px">العدد</th>
															<th style="text-align: center;font-size: 20px">اجمالى الفواتير</th>
															<th style="text-align: center;font-size: 20px">اجمالى المبلغ المدفوع</th>
															<th style="text-align: center;font-size: 20px">الديون</th>
														</tr>
													</thead>
													<tbody >
														<tr>
															<td>1</td>
															<td>شراء منتجات</td>
															<td>{{$receipts_count}}</td>
															<td>{{ number_format($receipts_total,2,'.') }}</td>
															<td>{{ number_format($paid_total,2,'.') }}</td>
															<td><span style="font-weight: bold" class="text-danger">{{ number_format($receipts_debt,2,'.') }}</span></td>
														</tr>
														<tr>
															<td>2</td>
															<td>سداد (منتجات)</td>
															<td>{{$payment_count}}</td>
															<td style="font-weight: bold" class="text-danger">-</td>
															<td>{{ number_format($payment_total,2,'.') }}</td>
															<td><span style="font-weight: bold" class="text-success">{{ number_format($payment_total,2,'.') }}-</span></td>
														</tr>
														<tr>
															<td>3</td>
															<td>شراء قطع غيار</td>
															<td>{{$sreceipts_count }}</td>
															<td>{{number_format($sreceipts_total,2,'.')  }}</td>											
															<td>{{number_format($spaid_total,2,'.')  }}</td>											
															<td><span style="font-weight: bold" class="text-danger">{{number_format($sreceipts_debt,2,'.')  }}</span></td>											
														</tr>
														<tr>
															<td>4</td>
															<td>سداد (قطع غيار)</td>
															<td>{{$spaymet_count}}</td>
															<td style="font-weight: bold" class="text-danger">-</td>
															<td>{{ number_format($spayment_total,2,'.') }}</td>
															<td><span style="font-weight: bold" class="text-success">{{ number_format($spayment_total,2,'.') }}-</span></td>
														</tr>
													</tbody>
												</table>
												<div class="table-responsive mg-t-40">
													<table  class="table table-invoice border text-md-nowrap mb-0">
														<tbody>
															<tr>
																<td class="valign-middle" colspan="1" rowspan="1">
																	<div class="invoice-notes">
																	</div><!-- invoice-notes -->													
																</td>
																<th style=" font-size: 32px;font-weight: bold" class="tx-right"> اجمالى دين المورد فى تلك الفترة</th>																
																<th style="font-size: 32px;" class="tx-right"></th>
																<th></th><th></th>
																<th style="font-size: 32px;font-weight: bold" class="tx-right tx-uppercase tx-bold tx-inverse"><span style="font-weight: bold" class="text-danger">{{number_format(($sreceipts_debt + $receipts_debt) - ($spayment_total + $payment_total),2,'.')  }}</span></th>
																<th style="font-size: 27px;font-weight: bold" class="tx-right" colspan="2">
																</th>
															</tr>
														</tbody>
													</table>
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
											<form action="{{ route('delete_file_s') }}" method="post">
								
												{{ csrf_field() }}
												<div class="modal-body">
													<p class="text-center">
													<h6 style="color:red"> هل انت متاكد من عملية حذف المرفق ؟</h6>
													</p>
								
													<input type="hidden" name="id_file" id="id_file" value="">
													<input type="hidden" name="file_name" id="file_name" value="">
													<input type="hidden" name="supplier_id" id="supplier_id" value="">
								
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
												<form action="{{route('receipts.destroy',1)}}" method="post">
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
											</div>
											</form> 
										</div>
									</div>
									<!-- delete spare receipt -->
									<div class="modal" tabindex="-1" id="modaldemo11">
										<div class="modal-dialog modal-dialog-centered" role="document">
											<div class="modal-content modal-content-demo">
												<div class="modal-header">
													<h6 class="modal-title">حذف الفاتوره</h6><button aria-label="Close" class="close" data-dismiss="modal"
														type="button"><span aria-hidden="true">&times;</span></button>
												</div>
												<form action="{{route('receipts_s.destroy',1)}}" method="post">
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
											</div>
											</form> 
										</div>
									</div>
							
									<!-- /row -->
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
<script>
	$('#delete_file').on('show.bs.modal', function(event) {
		var button = $(event.relatedTarget)
		var id_file = button.data('id_file')
		var file_name = button.data('file_name')
		var supplier_id = button.data('supplier_id')
		var modal = $(this)
		modal.find('.modal-body #id_file').val(id_file);
		modal.find('.modal-body #file_name').val(file_name);
		modal.find('.modal-body #supplier_id').val(supplier_id);
	})
</script>
<script>
	$(document).ready(function(){
	  $("#account_picker").change(function(){
		var account = $(this).find(":selected").attr('account');
		$('input#amount_paid').attr('max',account);
	  });
	});
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
    $('#modaldemo11').on('show.bs.modal', function(event) {
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