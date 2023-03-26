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
	صرف النفقات
@stop
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الخزينة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ النفقات</span>
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
							<div class="m-t-30">
										<div class="">
											<div class="main-profile-overview">
												<div class="table-responsive">
													<table id="" class="display" style="width:100%" data-page-length='50'>
														<thead style="text-align: center">
															<tr>
																<th class="border-bottom-0">#</th>
																<th class="border-bottom-0">رقم النفقة</th>
																<th class="border-bottom-0">التاريخ</th>
																<th class="border-bottom-0">التكلفة</th>
																<th class="border-bottom-0">المنشئ</th>
																<th class="border-bottom-0">القسم</th>
																<th class="border-bottom-0">العمليات</th>
															</tr>
														</thead>
														
														<tbody style="text-align: center">
															<?php $i = 0; ?>
															@foreach ($expenses as $x)
																<?php $i++; ?>
																<tr>
																	<td>{{ $i }}</td>
																	<td>{{ $x->id }}</td>
																	<td>{{ $x->date }}</td>
																	<td>{{ $x->price }}</td>
																	<td>{{ $x->create_by }}</td>
																	<td>{{ $x->section->section_name }}</td>		
																	<td>
																		<button type="button" class="btn btn-info btn-sm" data-toggle="modal"
																		data-target="#expenses{{ $x->id }}"
																		title="تاكيد"><i class="fa fa-edit"></i>تاكيد</button>
																	</td>											
																</tr>

																<div class="modal fade" id="expenses{{ $x->id }}" tabindex="-1" role="dialog"
																	aria-labelledby="exampleModalLabel" aria-hidden="true">
																	<div class="modal-dialog" role="document">
																		<div class="modal-content">
																			<div class="modal-header">
																				<h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
																					id="exampleModalLabel">
																					تاكيد النفقة رقم {{$x->id}}
																				</h5>
																				<button type="button" class="close" data-dismiss="modal"
																					aria-label="Close">
																					<span aria-hidden="true">&times;</span>
																				</button>
																			</div>
																			<div class="modal-body">
																				<form  action="{{ route('expenses_finish') }}" method="post" enctype="multipart/form-data" autocomplete="off">
																					@csrf	
																					<input hidden name="expense_id" value="{{$x->id}}">
																					<input hidden name="price" value="{{$x->price}}">
																					<div class="row">
																						<div class="form-group col">
																							<label>رصيد السحب</label>
																							<select class="form-control select2 " name="account_id"  required="required">
																							<option value="">اختر الرصيد </option>
																							@foreach ($accounts as $account)
																								@if ($account->account >= $x->price)
																								<option value="{{ $account->id }}"> {{ $account->name }} </option>
																								@endif
																							@endforeach
																							</select>
																							<p class="text-danger">تم عرض الارصدة المتوفر بها رصيد كافى فقط</p>
																						</div> 																						
																					</div>
																					<div class="row">
																						<div class="col">
																							<label style="margin-left: 20px">النفقة تتبع الضمان ام لا ؟</label>
																							<input name="rdio" value="1" type="radio" required><span style="margin-left: 20px">نعم </span>
																							<input  name="rdio" value="0" type="radio"><span>لا</span>
																						</div>
																					</div>
																											
																					<br>
																					<button type="submit" class="btn btn-primary w-100 ">تاكيد صرف النفقة</button>
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
		$('input#amount_paid').attr('max',account);
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