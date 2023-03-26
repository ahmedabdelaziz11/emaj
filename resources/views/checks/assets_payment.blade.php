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
    فاتورة سداد مورد
@stop
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الخزينة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ فاتورة سداد مورد</span>
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
							<h3 style="text-align: center">سند قيد اصل ثابت</h3>
							<br>
							<form  action="{{ route('PaymentAssets') }}" method="post" autocomplete="off">
								@csrf								
								<div class="row">
						
									<div class="col">
										<label>تاريخ الفاتوره</label>
										<input class="form-control" name="receipt_date" placeholder="YYYY-MM-DD"
											type="date" value="{{ date('Y-m-d') }}" required>
									</div>

									<div class="col">
										<div class="form-group">
											<label>اختر الاصل</label>
											<select class="form-control select2 " name="asset_id" id="supplier_picker" required="required">
												<option value="">اختر الاصل </option>
												@foreach ($assets as $asset)
													<option value="{{ $asset->id }}"> {{ $asset->name }} </option>
												@endforeach
											</select>
										</div>
									</div>
																	
									<div class="col">
										<div class="form-group">
											<label>رصيد السحب</label>
											<select class="form-control select2 " name="account_id" id="account_picker" required="required">
												<option value="">اختر الرصيد </option>
												@foreach ($accounts as $account)
													@if ($account->id != 1)
														<option value="{{ $account->id }}" account="{{$account->account}}"> {{ $account->name }} </option>
													@endif												
												@endforeach
											</select>
										</div>
									</div>
								</div>

								<div class="row">
									<div class="col">
										<label for="inputName" class="control-label">المبلغ المدفوع</label>
										<input type="number" class="form-control" id="amount_paid" name="amount_paid"
										value="0" min="0" step="1"  title="يرجي ادخال المبلغ المدفوع  " required>
									</div>

								</div>
								<br>
								<button type="submit" class="btn btn-primary w-100 ">اضافة الفاتوره</button>
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
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

<script>
	$(document).ready(function(){
		$("#supplier_picker").change(function(){
			var debt = $(this).find(":selected").attr('debt');
				$("#account_picker").change(function(){
				var account = parseInt((this).find(":selected").attr('account'));
				$('input#amount_paid').attr('max',account);
			});
		});
	});
</script>
@endsection