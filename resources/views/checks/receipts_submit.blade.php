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
	فواتير الشراء
@stop
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الخزينة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ فواتير الشراء</span>
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
										<a href="#receipts" data-toggle="tab" aria-expanded="true"> <span class="visible-xs"><i class="las la-user-circle tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">شراء المنتجات</span> </a>
									</li>

									<li class="">
										<a href="#spare_receipts" data-toggle="tab" aria-expanded="false"> <span class="visible-xs"><i class="fa fa-list-alt tx-16 mr-1"></i></span> <span style="font-size: 11px;font-weight: bold" class="hidden-xs">شراء قطع غيار</span> </a>
									</li>
								</ul>
							</div>

							<div class="tab-content border-left border-bottom border-right border-top-0 p-4">

								<div class="tab-pane active" id="receipts">
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
																<th class="border-bottom-0"> تاريخ الفاتوره</th>
																<th class="border-bottom-0">اسم المورد</th>
																<th class="border-bottom-0">المنشئ</th>
																<th class="border-bottom-0">اجمالى الفاتورة</th>
																<th class="border-bottom-0">العمليات</th>
															</tr>
														</thead>
														
														<tbody style="text-align: center">
															<?php $i = 0; ?>
															@foreach ($receipts as $x)
															<?php $i++; ?>
															<tr>
																<td>{{ $i }}</td>
																<td><a
																	href="{{ url('ReceiptDetails') }}/{{ $x->id }}">{{ $x->id }}</a>
																</td>
																<td>{{ $x->receipt_date }}</td>


																<td><a
																	href="{{ url('SupplierDetails') }}/{{ $x->supplier->id }}">{{ $x->supplier->name }}</a>
																</td>
																<td>{{ $x->Created_by }}</td>
																<td>{{ $x->total }}</td>
																	<td>
																		<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
																		data-target="#receipts{{ $x->id }}"
																		title="تاكيد"><i class="fa fa-edit"></i>تاكيد</button>
																		<button type="button" class="modal-effect btn btn-sm btn-danger" data-toggle="modal"
																			data-target="#delete{{ $x->id }}"
																			title="حذف"><i class="fa fa-edit"></i> حذف
																		</button>
																	</td>											
																</tr>

																<div class="modal fade" id="receipts{{ $x->id }}" tabindex="-1" role="dialog"
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
																				<form  action="{{ route('receipt_finish') }}" method="post" enctype="multipart/form-data" autocomplete="off">
																					@csrf	
																					<input hidden name="invoice_id" value="{{$x->id}}">
																					<input hidden name="supplier_id" value="{{$x->supplier->id}}">

																					<div class="form-group col">
																						<label>رصيد السحب</label>
																						<select class="form-control select2 account_picker" name="account_id" required="required">
																						<option value="">اختر الرصيد </option>
																						@foreach ($accounts as $account)
																								<option value="{{ $account->id }}" account="{{$account->account}}"> {{ $account->name }} </option>
																						@endforeach
																						</select>
																					</div>
																					
																					<input hidden name="total" value="{{$x->total}}" id="total">
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
																				<form action="receipts/destroy" method="post">
																					{{ method_field('delete') }}
																					{{ csrf_field() }}
																					<div class="modal-body">
																						<input type="hidden" name="id" id="id" value="{{$x->id}}">
																						<p class="text-danger" style="font-size: 15px; font-weight: bold;">هل انت متاكد من عملية الحذف ؟</p>
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

								<div class="tab-pane" id="spare_receipts">
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
																<th class="border-bottom-0"> تاريخ الفاتوره</th>
																<th class="border-bottom-0">اسم المورد</th>
																<th class="border-bottom-0">المنشئ</th>
																<th class="border-bottom-0">اجمالى الفاتورة</th>
																<th class="border-bottom-0">العمليات</th>
															</tr>
														</thead>
														
														<tbody style="text-align: center">
															<?php $i = 0; ?>
															@foreach ($spare_receipts as $x)
															<?php $i++; ?>
															<tr>
																<td>{{ $i }}</td>
																<td><a
																	href="{{ url('ReceiptDetails_s') }}/{{ $x->id }}">{{ $x->id }}</a>
																</td>
																<td>{{ $x->receipt_date }}</td>
																<td><a
																	href="{{ url('SupplierDetails') }}/{{ $x->supplier->id }}">{{ $x->supplier->name }}</a>
																</td>
																<td>{{ $x->Created_by }}</td>
																<td>{{ $x->total }}</td>
																	<td>
																		<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
																			data-target="#spare_receipts{{ $x->id }}"
																			title="تاكيد"><i class="fa fa-edit"></i>تاكيد
																		</button>
																		<button type="button" class="modal-effect btn btn-sm btn-danger" data-toggle="modal"
																			data-target="#delete{{ $x->id }}"
																			title="حذف"><i class="fa fa-edit"></i> حذف
																		</button>	
																	</td>	
																
																</tr>

																<div class="modal fade" id="spare_receipts{{ $x->id }}" tabindex="-1" role="dialog"
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
																				<form  action="{{ route('spare_receipts_finish') }}" method="post" enctype="multipart/form-data" autocomplete="off">
																					@csrf	
																					<input hidden name="invoice_id" value="{{$x->id}}">
																					<input hidden name="supplier_id" value="{{$x->supplier->id}}">

																					<div class="form-group col">
																						<label>رصيد السحب</label>
																						<select class="form-control select2 account_picker2" name="account_id" required="required">
																						<option value="">اختر الرصيد </option>
																						@foreach ($accounts as $account)
																								<option value="{{ $account->id }}" account="{{$account->account}}"> {{ $account->name }} </option>
																						@endforeach
																						</select>
																					</div>
																					
																					<input hidden name="total" value="{{$x->total}}" id="total">
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
																				<form action="receipts_s/destroy" method="post">
																					{{ method_field('delete') }}
																					{{ csrf_field() }}
																					<div class="modal-body">
																						<input type="hidden" name="id" id="id" value="{{$x->id}}">
																						<p class="text-danger">هل انت متاكد من عملية الحذف</p>

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
	  $(".account_picker").change(function(){
		var account = parseInt($(this).find(":selected").attr('account'));
		var account_id = parseInt($(this).find(":selected").attr('value'));
		var total   = parseInt(document.getElementById("total").value);

		if(account > total)
		{
			$('input#amount_paid').attr('max',total);
		}
		else
		{
			$('input#amount_paid').attr('max',account);
		}
		if(account_id == 1)
		{
			$('input#amount_paid').attr('max',0);
		}
	  });
	});
</script>

<script>
	$(document).ready(function(){
	  $(".account_picker2").change(function(){
		var account = parseInt($(this).find(":selected").attr('account'));
		var account_id = parseInt($(this).find(":selected").attr('value'));
		var total   = parseInt(document.getElementById("total").value);

		if(account > total)
		{
			$('input#amount_paid2').attr('max',total);
		}
		else
		{
			$('input#amount_paid2').attr('max',account);
		}
		if(account_id == 1)
		{
			$('input#amount_paid2').attr('max',0);
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