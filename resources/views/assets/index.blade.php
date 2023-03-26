@extends('layouts.master')
@section('css')
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
@livewireStyles
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">المحاسبة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ ادارة الاصول الثابتة</span>
						</div>
					</div>	
				</div>
				<!-- breadcrumb -->
@endsection
@section('title')
    ادارة الاصول الثابتة 
@stop
@section('content')

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

<livewire:asset-management />
					<!-- add -->
					<div class="modal" id="modaldemo8">
						<div class="modal-dialog" role="document">
							<div class="modal-content modal-content-demo">
								<div class="modal-header">
									<h6 class="modal-title">اضافة صنف</h6><button aria-label="Close" class="close" data-dismiss="modal"
										type="button"><span aria-hidden="true">&times;</span></button>
								</div>
								<div class="modal-body">
									<form action="{{ route('asset-management.store') }}" method="post">
										{{ csrf_field() }}
										{{ method_field('post') }}
										<div class="form-group">
											<label for="exampleInputEmail1">حساب الاصل</label>
											<select class="form-control select2" name="account_id" required="required">
												<option value="اختر" disabled selected>اختر الحساب </option>
												@foreach ($accounts as $a)
													<option value="{{ $a->id }}">{{ $a->name }}</option>
													@if($a->accounts->count() > 0)
														@foreach ($a->accounts as $a1)
															<option value="{{ $a1->id }}" >{{ $a1->name }}</option>
															@if($a1->accounts->count() > 0)
																@foreach ($a1 as $a2)
																	<option value="{{ $a2->id }}" >{{ $a2->name }}</option>
																@endforeach
															@endif
														@endforeach
													@endif
											  	@endforeach
											</select>
										</div>

										<div class="form-group">
											<label for="exampleInputEmail1">حساب السداد</label>
											<select class="form-control select2" name="all_account_id" required="required">
												<option value="اختر" disabled selected>اختر الحساب </option>
												@foreach ($all_accounts as $a)
													<option value="{{ $a->id }}">{{ $a->name }}</option>
											  	@endforeach
											</select>
										</div>
				
										<div class="form-group">
											<label for="exampleInputEmail1">سعر الشراء</label>
											<input type="number" step=".01" class="form-control" name="price">
										</div>

										<div class="form-group">
											<label for="exampleInputEmail1">تاريخ الشراء</label>
											<input class="form-control" name="date" placeholder="YYYY-MM-DD" type="date" value="2022-01-01">
										</div>

										<div class="form-group">
											<label for="exampleInputEmail1">الكمية</label>
											<input type="number" class="form-control" name="quantity" value="1">
										</div>

										<div class="form-group">
											<label for="exampleInputEmail1">مخصص الاهلاك</label>
											<input type="number" step=".01" class="form-control" name="mokhss_elahlak" value="10">
										</div>

										<div class="form-group">
											<label for="exampleInputEmail1">البيان</label>
											<input type="text" class="form-control" name="note">
										</div>
				
										<div class="modal-footer">
											<button type="submit" class="btn btn-success">تاكيد</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- End Basic modal -->
				
				
					</div>
				    <!-- delete -->
					<div class="modal" tabindex="-1" id="modaldemo9">
						<div class="modal-dialog modal-dialog-centered" role="document">
							<div class="modal-content modal-content-demo">
								<div class="modal-header">
									<h6 class="modal-title">حذف الصنف</h6><button aria-label="Close" class="close" data-dismiss="modal"
										type="button"><span aria-hidden="true">&times;</span></button>
								</div>
 								 <form action="asset-management/destroy" method="post">
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
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@livewireScripts
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
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
@endsection