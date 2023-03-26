@extends('layouts.master')

@section('css')
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
<link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
<link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
@livewireStyles
@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
			<h4 class="content-title mb-0 my-auto">المشتريات 
			</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">
				/ المشتريات</span>
		</div>
	</div>	
</div>
<!-- breadcrumb -->
@endsection

@section('title')
المشتريات
@stop

@section('content')



		<!-- row -->
		<div class="row">
			<div class="col-xl-12">
				<div class="card mg-b-20">
					<div class="card-header pb-0">
						<div class="d-flex">
							@can('طلب شراء')
								<a href="{{route('orders.create')}}" class="modal-effect btn btn-sm btn-primary" style="color:white;font-size: 20px;width: 20%; margin-left: 15px;"><i class="fas fa-cart-plus"></i>&nbsp; طلب شراء </a>
							@endcan

							@can('اضافة فاتورة شراء')
								<a href="{{route('receipts.create')}}" class="modal-effect btn btn-sm btn-info" style="color:white;font-size: 20px;width: 20%; margin-left: 15px;"><i class="fas fa-file-invoice"></i>&nbsp; اضافة فاتوره</a>
							@endcan
							
							@can('اذن اضافة')
								<a href="{{route('create-permission')}}" class="modal-effect btn btn-sm btn-success" style="color:white;font-size: 20px;width: 20%; margin-left: 15px;"><i class="fas fa-plus"></i>&nbsp;اذن اضافة</a>
							@endcan
						</div>
					</div>

					<livewire:purchases />

				</div>
			</div>					
		</div>
		<!-- delete -->
		<div class="modal" tabindex="-1" id="modaldemo9">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">حذف الفاتوره</h6><button aria-label="Close" class="close" data-dismiss="modal"
							type="button"><span aria-hidden="true">&times;</span></button>
					</div>
						<form action="receipts/destroy" method="post">
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
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
    })
</script>
@endsection