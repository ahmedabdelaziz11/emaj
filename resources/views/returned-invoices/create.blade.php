@extends('layouts.master')

@section('css')
<!--- Internal Select2 css-->
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<!---Internal Fileupload css-->
<link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
<!---Internal Fancy uploader css-->
<link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
<!--Internal Sumoselect css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
<!--Internal  TelephoneInput css-->
<link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">

<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
<style>
  .row label {
  font-size: 20px;
}
</style>
@endsection

@section('title')
فاتورة مرتجع مبيعات
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
	<div class="my-auto">
		<div class="d-flex">
			<h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='returned_invoices') }}">فواتير مرتجع المبيعات</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
			اضافة فاتورة</span>
		</div>
	</div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
<input type="hidden" id="mss" value="{{ Session::get('mss')}}">
<input type="hidden" id="del" value="{{ Session::get('del')}}">

@if($errors->has('name'))
    @foreach ($errors->all() as $error)
        <input type="hidden" id="err1" value="{{ $error }}">
    @endforeach
@endif


<script>
    window.onload = function() {
        var del = document.getElementById("del").value;
        if(del){
            notif({
            msg: del,
            type: "error"
            })
        }
    }
</script>

@if (session()->has('mss'))
<script>
    window.onload = function() {
        var mss = document.getElementById("mss").value;
        notif({    
            msg: mss ,
            type: "success"
        })
    }
</script>
@endif
<!-- row opened -->
<div class="row row-sm">
	<div class="col-xl-12">

		<div class="card mg-b-20" id="tabs-style2">
			<div class="card-body">
				<form action="{{ route('returned_invoices.store') }}" method="post" autocomplete="off">
					@csrf
					<div class="d-flex justify-content-center">
						<h1>فاتورة مرتجع مبيعات</h1>
					</div>
					<br>
					<div class="row">

						<div class="col-4">
							<label>التاريخ</label>
							<input class="form-control fc-datepicker" name="date" placeholder="YYYY-MM-DD" type="text" value="{{ date('Y-m-d') }}" required>
						</div>

						<div class="form-group col-8">
							<label>رقم الفاتورة</label>
							<select class="form-control select2 " id="invoice_id" name="invoice_id" required>
								<option value="0" selected disabled>اختر رقم الفاتورة</option>
								@foreach ($invoices as $invoice)
								<option value="{{ $invoice->id }}">{{ $invoice->id }}</option>
								@endforeach
							</select>
						</div>
					</div>
					<br>

					<div class="form-group">
						<table class="table table-bordered mg-b-0 text-md-nowrap" >


							<thead id="container_header" class="text-center">

								<th style=" font-size: 15px;">اسم المنتج</th>
								<th style=" font-size: 15px;" class="text-center">الكمية المراد ارجاعها</th>
							</thead>
							<tbody id="items_container" class="text-center">
							</tbody>
						</table>
					</div>
					<hr>

					<button type="submit" class="btn btn-primary w-100 ">تنفيذ</button>
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

<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>

<script>
	var date = $('.fc-datepicker').datepicker({
		dateFormat: 'yy-mm-dd'
	}).val();
</script>

<script>
	$(document).ready(function() {
		$('select[name="invoice_id"]').on('change', function() {
			var invoice_id = $(this).val();
			if (invoice_id) {
				$.ajax({
					url: "{{ URL::to('invoices') }}/" + invoice_id,
					type: "GET",
					dataType: "json",
					success: function(data) {
						$("#items_container").empty();						
						data.forEach( (product) => {
							if(product.id > 0)
							{
								$("#items_container").append(`
									<tr>
									<td style="padding-top:20px;font-size:17px;font-weight:bold" >` + product.name + `</td>
									<td style="padding-top:20px;font-size:17px;font-weight:bold"><input type="number" style="font-size:17px;font-weight:bold" name="quantity[]" onchange='updateTotal2();' value="` + product.quantity + `" class=" form-control text-center " max="` + product.quantity + `" min="0"></td>
									<input type="hidden" name="id[]" value="` + product.id + `" min="1">
									<input type="hidden" name="type[]" value="` + product.type + `" min="1">
									</tr>
								`);
							}
						});
					},
				});
			} else {
				console.log('AJAX load did not work');
			}
		});
	});
</script>

<script>
	$(document).ready(function() {
		var items = 0;
		$("#item_picker").change(function() {
			items++;
			$("#container_header").show();
			var name = $(this).find(":selected").text();
			var id = $(this).val();
			if (!$("#row" + id).length) {
				$("#items_container").append(`
            <tr id="row` + id + `">
            <td style="padding-top:20px;font-size:17px;font-weight:bold" >` + name + `</td>
            <td><input type="number" style="font-size:17px;font-weight:bold" name="purchasing_price[]" step=".01" value="0" onchange='updateTotal2();' class=" form-control text-center "></td>
            <td> <input type="hidden" name="id[]" value="` + id + `" min="1"><input type="number" style="font-size:17px;font-weight:bold" name="quantity[]" onchange='updateTotal2();' value="1" class=" form-control text-center " min="1"></td>
            <td ><button  onclick="deleteRow(this)" type="button" style="margin-right: 40px" class="btn btn-danger " style="margin-right: 10px"><i class="fas fa-times"></i></button></td>
            </tr>
            `);
			}
			updateTotal2();
		});
	});

	function updateTotal2() {
		var total = 0;
		var list1 = document.getElementsByName("purchasing_price[]");
		var list2 = document.getElementsByName("quantity[]");
		var total1 = 0;
		for (var i = 0; i < list1.length; ++i) {
			total1 += parseFloat(list1[i].value) * parseFloat(list2[i].value);
		}

		document.getElementById("sub_total").value = total1;
	}
</script>

<script>
	function deleteRow(btn) {
		var row = btn.parentNode.parentNode;
		var d = row.parentNode.parentNode.rowIndex;
		row.parentNode.removeChild(row);
		updateTotal2();
	}
</script>
@endsection