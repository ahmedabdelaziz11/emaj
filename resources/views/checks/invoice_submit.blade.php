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
	<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@endsection
@section('title')
	فواتير البيع
@stop
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الخزينة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ فواتير البيع</span>
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
                msg:" فشلت الاضافة ",
                type: "error"
            })
        }
    </script>
@endif

@if (session()->has('add'))
<script>
    window.onload = function() {
        notif({
            msg: "تم التاكيد بنجاح",
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
										<a href="#invoices" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">بيع المنتجات</span> </a>
									</li>
									<li class="">
										<a href="#spare_invoices" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-list-alt tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">بيع قطع غيار</span> </a>
									</li>
									<li class="">
										<a href="#returned_invoices" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-list-alt tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">مرتجع المنتجات</span> </a>
									</li>

									<li class="">
										<a href="#sreturned_invoices" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-list-alt tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">مرتجع قطع غيار</span> </a>
									</li>
								</ul>
							</div>

							<div class="tab-content border-left border-bottom border-right border-top-0 p-4">

								<div class="tab-pane active" id="invoices">
									<div class="m-t-30">
										<div class="">
											<div class="main-profile-overview">

												<div class="table-responsive">
													<table id="" class="display" style="width:100%" data-page-length='50'
														>
														<thead style="text-align: center">
															<tr>
																<th class="border-bottom-0">#</th>
																<th class="border-bottom-0">رقم الفاتوره</th>
																<th class="border-bottom-0">اسم العميل</th>
																<th class="border-bottom-0">المنشئ</th>
																<th class="border-bottom-0">الاجمالى</th>
																<th class="border-bottom-0">العمليات</th>
															</tr>
														</thead>
														
														<tbody style="text-align: center">
															<?php $i = 0; ?>
															@foreach ($invoices as $x)
																<?php $i++; ?>
																<tr>
																	<td>{{ $i }}</td>
																	<td><a
																		href="{{ url('InvoiceDetails') }}/{{ $x->id }}">{{ $x->id }}</a>
																	</td>
																	<td><a
																		href="{{ url('ClientDetails') }}/{{ $x->client->id }}">{{ $x->client->client_name }}</a>
																	</td>
																	<td>{{ $x->Created_by }}</td>
																	<td>{{ $x->total }}</td>		
																	<td>
																		<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
																		data-target="#edit{{ $x->id }}"
																		title="تاكيد"><i class="fa fa-edit"></i>تاكيد</button>

																		<button type="button" class="btn btn-sm btn-danger" data-toggle="modal"
																		data-target="#delete{{ $x->id }}"
																		title="حذف"><i class=" fa fa-edit "></i> حذف</button>
																	</td>											
																</tr>

																<div class="modal fade" id="edit{{ $x->id }}" tabindex="-1" role="dialog"
																	aria-labelledby="exampleModalLabel" aria-hidden="true">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
																					id="exampleModalLabel">
																					تاكيد فاتورة رقم {{$x->id}}
																				</h5>
																				<button type="button" class="close" data-dismiss="modal"
																					aria-label="Close">
																					<span aria-hidden="true">&times;</span>
																				</button>
																			</div>
																			<div class="modal-body">
																				<form  action="{{ route('invoice_finish') }}" method="post" enctype="multipart/form-data" autocomplete="off">
																					@csrf	
																					<input hidden name="invoice_id" value="{{$x->id}}">

																					<div class="form-group col">
																						<label>رصيد الايداع</label>
																						<select class="form-control select2 " name="account_id" id="account_picker" required="required">
																						<option value="">اختر الرصيد </option>
																						@foreach ($accounts as $account)
																							<option value="{{ $account->id }}" account="{{$x->total}}" account_id="{{$account->id}}"> {{ $account->name }} </option>
																						@endforeach
																						</select>
																					</div> 
																											
																					<div class="col">
																						<label for="inputName" class="control-label">المبلغ المدفوع</label>
																						<input type="number" class="form-control" id="amount_paid" name="amount_paid"
																						value="0" min="0" step="1"  title="يرجي ادخال المبلغ المدفوع  " required>
																					</div>

																					<br>
																					<button type="submit" class="btn btn-primary w-100 ">تاكيد الفاتوره</button>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>
															

																<div class="modal fade" id="delete{{ $x->id }}" tabindex="-1" role="dialog"
																	aria-labelledby="exampleModalLabel" aria-hidden="true">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
																					id="exampleModalLabel">
																					حذف فاتورة رقم  {{$x->id}}
																				</h5>
																				<button type="button" class="close" data-dismiss="modal"
																					aria-label="Close">
																					<span aria-hidden="true">&times;</span>
																				</button>
																			</div>
																			<div class="modal-body">
																				<form action="invoices/destroy" method="post">
																					{{ method_field('delete') }}
																					{{ csrf_field() }}
																					<div class="modal-body">
																						<input type="hidden" name="id" value="{{ $x->id }}">
																						<p class="text-danger">هل انت متاكد من عملية الحذف ؟</p>
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
															@endforeach
														</tbody>
													</table>
												</div>

											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="returned_invoices">
									<div class="m-t-30">
										<div class="">
											<div class="main-profile-overview">
												<div class="table-responsive">
													<table id="" class="display" style="width:100%" data-page-length='50'>
														
														<thead style="text-align: center">
															<tr>
																<th class="border-bottom-0">#</th>
																<th class="border-bottom-0">رقم الفاتوره</th>
																<th class="border-bottom-0">اسم العميل</th>
																<th class="border-bottom-0">المنشئ</th>
																<th class="border-bottom-0">الاجمالى</th>
																<th class="border-bottom-0">المبلغ المستحق</th>
																<th class="border-bottom-0">منتجات الفاتورة</th>
																<th class="border-bottom-0">العمليات</th>
															</tr>
														</thead>
														
														<tbody style="text-align: center">
															<?php $i = 0; ?>
														@foreach ($returned_invoices as $x)
																	<?php $i++; ?>
																	<tr>
																		<td>{{ $i }}</td>
																		<td><a
																			href="{{ url('InvoiceDetails') }}/{{ $x->invoice_id }}">{{ $x->id }}</a>
																		</td>
																		<td><a
																			href="{{ url('ClientDetails') }}/{{ $x->client->id }}">{{ $x->client->client_name }}</a>
																		</td>
																		<td>{{ $x->Created_by }}</td>
																		<td>{{ $x->total }}</td>
																		<td>{{ $x->total_afterdebt }}</td>
																		<td>
																			<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
																			data-target="#product{{ $x->id }}"
																			title="تعديل"><i class="fa fa-edit"></i></button>
																		</td>
																		<td>
																			<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
																			data-target="#returned_submit{{ $x->id }}"
																			title="تعديل"><i class="fa fa-paper-plane"></i></button>
																		</td>															
																	</tr>															
															</tbody>
															<div class="modal fade" id="product{{ $x->id }}" tabindex="-1" role="dialog"
																aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog" role="document">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
																				id="exampleModalLabel">
																				منتجات فاتورة المرتجع رقم {{$x->id}}
																			</h5>
																			<button type="button" class="close" data-dismiss="modal"
																				aria-label="Close">
																				<span aria-hidden="true">&times;</span>
																			</button>
																		</div>
																		<div class="modal-body">
																				<div class="row">
																					<div class="col">اسم المنتج </div>
																					<div class="col">الكميه     </div>
																					<div class="col">السعر      </div>
																					<div class="col">الاجمالى    </div>
																				</div>
																				<hr>
																				@foreach($x->invoice_products as $products)
																					<div class="row" style="margin-bottom: 10px">                                                               
																						<div class="col">{{$products->product->name}} </div>
																						<div class="col">{{$products->product_quantity}} </div>
																						<div class="col">{{$products->selling_price}} </div>
																						<div class="col">{{$products->product_quantity * $products->selling_price }} </div>                                                                          
																					</div>
																				@endforeach 
																		</div>
																	</div>
																</div>
															</div>
															<div class="modal fade" id="returned_submit{{ $x->id }}" tabindex="-1" role="dialog"
																aria-labelledby="exampleModalLabel" aria-hidden="true">
																<div class="modal-dialog" role="document">
																	<div class="modal-content">
																		<div class="modal-header">
																			<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
																				id="exampleModalLabel">
																				تاكيد فاتورة المرتجع رقم {{$x->id}}
																			</h5>
																			<button type="button" class="close" data-dismiss="modal"
																				aria-label="Close">
																				<span aria-hidden="true">&times;</span>
																			</button>
																		</div>
																		<div class="modal-body">
																			<form  action="{{ route('returned_finish') }}" method="post" enctype="multipart/form-data" autocomplete="off">
																				@csrf	
																				<input hidden name="invoice_id" value="{{$x->id}}">
																				<input hidden name="client_id" value="{{$x->client->id}}">
																				<div class="col">
																					<label> رصيد سجب المبلغ المستحق</label>
																					<select class="form-control select2 " name="account_id" required="required">
																					<option value="">اختر الرصيد </option>
																					@foreach ($accounts as $account)
																						
																						@if (  $account->id  != 1 &&  $account->account >= $x->total_afterdebt )
																							<option value="{{ $account->id }}"> {{ $account->name }} </option>
																						@endif
																						
																						
																					@endforeach
																					</select>
																					<p class="text-danger">تم عرض الارصدة المتوفر بها رصيد كافى فقط</p>
																				</div>
																				<br>
																				<button type="submit" class="btn btn-primary w-100 ">تاكيد الفاتوره</button>
																			</form>                                                                    
																		</div>
																	</div>
																</div>
															</div>
														@endforeach
													</table>
												</div>
											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="spare_invoices">
									<div class="m-t-30">
										<div class="">
											<div class="main-profile-overview">

												<div class="table-responsive">
													<table id="" class="display" style="width:100%" data-page-length='50'>														
														<thead style="text-align: center">
															<tr>
																<th class="border-bottom-0">#</th>
																<th class="border-bottom-0">رقم الفاتوره</th>
																<th class="border-bottom-0">نوع الفاتورة</th>
																<th class="border-bottom-0">اسم العميل</th>
																<th class="border-bottom-0">المنشئ</th>
																<th class="border-bottom-0">الاجمالى</th>
																<th class="border-bottom-0">العمليات</th>
															</tr>
														</thead>
														
														<tbody style="text-align: center">
															<?php $i = 0; ?>
															@foreach ($spare_invoices as $x)
																<?php $i++; ?>
																<tr>
																	<td>{{ $i }}</td>
																	<td><a
																		href="{{ url('InvoiceDetails_s') }}/{{ $x->id }}">{{ $x->id }}</a>
																	</td>
																	@if ($x->Value_Status == 2)
																	<td><span style="font-weight: bold"  class="text-warning">خارج التكلفة</span></td>
																	@else
																	<td><span style="font-weight: bold"  class="text-success">داخل التكلفة</span></td>
																	@endif																	
																	<td><a
																		href="{{ url('ClientDetails') }}/{{ $x->client->id }}">{{ $x->client->client_name }}</a>
																	</td>
																	<td>{{ $x->Created_by }}</td>
																	<td>{{ $x->total }}</td>																
																	<td>
																		<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
																		data-target="#spare_invoice{{ $x->id }}"
																		title="تاكيد"><i class="fa fa-edit"></i>تاكيد</button>
																	</td>	
																</tr>
																<div class="modal fade" id="spare_invoice{{ $x->id }}" tabindex="-1" role="dialog"
																	aria-labelledby="exampleModalLabel" aria-hidden="true">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
																					id="exampleModalLabel">
																					تاكيد فاتورة رقم {{$x->id}}
																				</h5>
																				<button type="button" class="close" data-dismiss="modal"
																					aria-label="Close">
																					<span aria-hidden="true">&times;</span>
																				</button>
																			</div>
																			<div class="modal-body">
																				<form  action="{{ route('spare_invoice_finish') }}" method="post" enctype="multipart/form-data" autocomplete="off">
																					@csrf	
																					<input hidden name="invoice_id" value="{{$x->id}}">
																					<input hidden name="invoice_type" value="{{$x->Value_Status}}">

																					<div class="form-group col">
																						<label>رصيد الايداع</label>
																						<select class="form-control select2" name="account_id" id="account_picker2" required="required">
																						<option value="">اختر الرصيد </option>
																						@foreach ($accounts as $account)
																							<option value="{{ $account->id }}" account_id="{{$account->id}}" account="{{$x->total}}"> {{ $account->name }} </option>
																						@endforeach
																						</select>
																					</div> 
																											
																					<div class="col">
																						<label for="inputName" class="control-label">المبلغ المدفوع</label>
																						<input type="number" class="form-control" id="amount_paid2" name="amount_paid"
																						value="0" min="0" step="1"  title="يرجي ادخال المبلغ المدفوع  " required>
																					</div>


																					<br>
																					<button type="submit" class="btn btn-primary w-100 ">تاكيد الفاتوره</button>
																				</form>
																			</div>
																		</div>
																	</div>
																</div>
															@endforeach
														</tbody>
													</table>
												</div>

											</div>
										</div>
									</div>
								</div>

								<div class="tab-pane" id="sreturned_invoices">
									<div class="m-t-30">
										<div class="">
											<div class="main-profile-overview">
												<div class="table-responsive">
													<table id="" class="display" style="width:100%" data-page-length='50'>
														
														<thead style="text-align: center">
															<tr>
																<th class="border-bottom-0">#</th>
																<th class="border-bottom-0">رقم الفاتوره</th>
																<th class="border-bottom-0">اسم العميل</th>
																<th class="border-bottom-0">المنشئ</th>
																<th class="border-bottom-0">الاجمالى</th>
																<th class="border-bottom-0">المبلغ المستحق</th>
																<th class="border-bottom-0">منتجات الفاتورة</th>
																<th class="border-bottom-0">العمليات</th>
															</tr>
														</thead>
														
														<tbody style="text-align: center">
															<?php $i = 0; ?>
															@foreach ($sreturned_invoices as $x)
																<?php $i++; ?>
																<tr>
																	<td>{{ $i }}</td>
																	<td><a
																		href="{{ url('InvoiceDetails_s') }}/{{ $x->invoice_id }}">{{ $x->id }}</a>
																	</td>
																	<td><a
																		href="{{ url('ClientDetails') }}/{{ $x->client->id }}">{{ $x->client->client_name }}</a>
																	</td>
																	<td>{{ $x->Created_by }}</td>
																	<td>{{ $x->total }}</td>
																	<td>{{ $x->total_afterdebt }}</td>
																	<td>
																		<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
																		data-target="#spare{{ $x->id }}"
																		title="تعديل"><i class="fa fa-edit"></i></button>
																	</td>
																	<td>
																		<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
																		data-target="#sreturned_submit{{ $x->id }}"
																		title="تعديل"><i class="fa fa-paper-plane"></i></button>
																	</td>																															
											
																</tr>
														</tbody>
														<div class="modal fade" id="spare{{ $x->id }}" tabindex="-1" role="dialog"
															aria-labelledby="exampleModalLabel" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
																			id="exampleModalLabel">
																			منتجات فاتورة المرتجع رقم {{$x->id}}
																		</h5>
																		<button type="button" class="close" data-dismiss="modal"
																			aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																			<div class="row">
																				<div class="col">اسم المنتج </div>
																				<div class="col">الكميه     </div>
																				<div class="col">السعر      </div>
																				<div class="col">الاجمالى    </div>
																			</div>
																			<hr>
																			@foreach($x->invoice_products as $products)
																				<div class="row" style="margin-bottom: 10px">                                                               
																					<div class="col">{{$products->product->name}} </div>
																					<div class="col">{{$products->product_quantity}} </div>
																					<div class="col">{{$products->selling_price}} </div>
																					<div class="col">{{$products->product_quantity * $products->selling_price }} </div>                                                                          
																				</div>
																			@endforeach 
																	</div>
																</div>
															</div>
														</div>
														<div class="modal fade" id="sreturned_submit{{ $x->id }}" tabindex="-1" role="dialog"
															aria-labelledby="exampleModalLabel" aria-hidden="true">
															<div class="modal-dialog" role="document">
																<div class="modal-content">
																	<div class="modal-header">
																		<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
																			id="exampleModalLabel">
																			تاكيد فاتورة المرتجع رقم {{$x->id}}
																		</h5>
																		<button type="button" class="close" data-dismiss="modal"
																			aria-label="Close">
																			<span aria-hidden="true">&times;</span>
																		</button>
																	</div>
																	<div class="modal-body">
																		<form  action="{{ route('spare_returned_finish') }}" method="post" enctype="multipart/form-data" autocomplete="off">
																			@csrf	
																			<input hidden name="invoice_id" value="{{$x->id}}">
																			<input hidden name="client_id" value="{{$x->client->id}}">
																			<div class="col">
																				<label> رصيد سجب المبلغ المستحق</label>
																				<select class="form-control select2 " name="account_id" required="required">
																				<option value="">اختر الرصيد </option>
																				@foreach ($accounts as $account)
																					
																					@if (  $account->id  != 1 &&  $account->account >= $x->total_afterdebt )
																						<option value="{{ $account->id }}"> {{ $account->name }} </option>
																					@endif
																					
																					
																				@endforeach
																				</select>
																				<p class="text-danger">تم عرض الارصدة المتوفر بها رصيد كافى فقط</p>
																			</div>
																			<br>
																			<button type="submit" class="btn btn-primary w-100 ">تاكيد الفاتوره</button>
																		</form>                                                                    
																	</div>
																</div>
															</div>
														</div>
														@endforeach
													</table>
												</div>

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
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
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
	$(document).ready(function(){
	  $("#account_picker").change(function(){

		var account = $(this).find(":selected").attr('account');
		var account_id = $(this).find(":selected").attr('account_id');
		if(account_id == 1 )
		{
			$('input#amount_paid').attr('max',0);
		}
		else{
			$('input#amount_paid').attr('max',account);
		}
	  });
	});
</script>

<script>
	$(document).ready(function(){
	  $("#account_picker2").change(function(){

		var account = $(this).find(":selected").attr('account');
		var account_id = $(this).find(":selected").attr('account_id');
		if(account_id == 1 )
		{
			$('input#amount_paid2').attr('max',0);
		}
		else{
			$('input#amount_paid2').attr('max',account);
		}
	  });
	});
</script>



<script>
	$(document).ready(function() {
		$('table.display').DataTable({
			select: true
		});
	});
</script>

@endsection