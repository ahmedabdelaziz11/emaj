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
    <!---Internal  Prism css-->
    <link href="{{ URL::asset('assets/plugins/prism/prism.css') }}" rel="stylesheet">
    <!---Internal Input tags css-->
    <link href="{{ URL::asset('assets/plugins/inputtags/inputtags.css') }}" rel="stylesheet">
    <!--- Custom-scroll -->
    <link href="{{ URL::asset('assets/plugins/custom-scroll/jquery.mCustomScrollbar.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@endsection
@section('title')
  تفاصيل العرض
@stop
@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='offers') }}">عروض المنتجات</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                    تفاصيل العرض</span>
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
                msg:" فشلت الاضافة المنتج موجود بالفعل مكرر ",
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




    <!-- row opened -->
    <div class="row row-sm">

        <div class="col-xl-12">
            <!-- div -->
            <div class="card mg-b-20" id="tabs-style2">
                <div class="card-body">
                    <div class="text-wrap">
                        <div class="example">
                            <div class="panel panel-primary tabs-style-2">
                                <div class=" tab-menu-heading">
                                    <div class="tabs-menu1">
                                        <!-- Tabs -->
                                        <ul class="nav panel-tabs main-nav-line">
                                            <li><a href="#tab4" class="nav-link active" data-toggle="tab">معلومات
                                                    العرض</a></li>
                                            <li><a href="#tab5" class="nav-link" data-toggle="tab">معلومات العميل</a></li>
                                            <li><a href="#tab6" class="nav-link" data-toggle="tab">المنتجات</a></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="panel-body tabs-menu-body main-content-body-right border">
                                    <div class="tab-content">


                                        <div class="tab-pane active" id="tab4">
                                            <div class="table-responsive mt-15">

                                                <table class="table table-striped" style="text-align:center">
												   <thead>
													<tr>
														<th scope="row">اسم العرض</th>
														<th scope="row">تاريخ الاصدار</th>                                                            
                                                        <th scope="row">قيود التعاقد</th>
                                                        <th scope="row"> نسبه الخصم </th>
                                                        <th scope="row">المنشئ</th>
                                                        <th scope="row">تعديل</th>											     
													</tr>  
												   </thead>													
													<tbody>              
														<tr>
															<td>{{ $offers->name }}</td>
															<td>{{ $offers->offer_Date }}</td>
                                                            <td>شروط التعاقد</td>
                                                            <td>{{$offers->discount}} %</td>
                                                            <td>{{$offers->Created_by}}</td>
                                                            <td>
                                                                <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                                data-id="{{ $offers->id }}" 
                                                                data-name="{{ $offers->name }}"
                                                                data-name_en="{{ $offers->name_en }}"
                                                                data-date="{{  $offers->offer_Date }}"
                                                                data-constraints="{{ $offers->constraints}}"
                                                                data-constraints_en="{{ $offers->constraints_en}}"
                                                                data-discount="{{ $offers->discount}}"
                                                                data-toggle="modal"
                                                                href="#exampleModal2" title="تعديل"> <i class="las la-pen"></i> </a>
                                                            </td>
														</tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <div class="tab-pane" id="tab5">
                                            <div class="table-responsive mt-15">
                                                <table class="table center-aligned-table mb-0 table-hover"
                                                    style="text-align:center">
                                                    <thead>
														<tr>											
															<th scope="row">العميل</th>														
															<th scope="row">عنوان العميل</th>
															<th scope="row">هاتف العميل</th>
                                                            <th scope="row">اسم الشركة</th> 
                                                            <th scope="row">تغير العميل</th>											     
													</tr>        
														</tr>
                                                    </thead>
                                                    <tbody>				
														<tr>
															<td>{{ $offers->client->client_name }}</td>
															<td>{{ $offers->client->address }}</td>
															<td>{{ $offers->client->phone }}</td>
                                                            <td>{{ $offers->client->Commercial_Register }}</td>
                                                            <td>
                                                                <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                                data-id="{{ $offers->id }}" 
                                                                data-name="{{ $offers->name }}"
                                                                data-offer_Date="{{  $offers->offer_Date  }}"
                                                                data-constraints="{{ $offers->constraints}}"
                                                                data-toggle="modal"
                                                                href="#exampleModal3" title="تعديل"> <i class="las la-pen"></i> </a>
                                                            </td>
														</tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        <div class="tab-pane" id="tab6">
                                            <!--المنتجات-->
                                            <div class="card card-statistics">
                                                <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                                                data-toggle="modal" href="#modaldemo8">اضافة المنتج</a>
                                                
                                                <br>
                                                <div class="table-responsive mt-15">
                                                    <table class="table center-aligned-table mb-0 table table-hover"
                                                        style="text-align:center">
                                                        <thead>
                                                            <tr class="text-dark">
                                                                <th scope="col">#</th>
                                                                <th scope="col">اسم المنتج</th>
                                                                <th scope="col">الوصف</th>
                                                                <th scope="col">الكميه </th>
                                                                <th scope="col">السعر</th>
                                                                <th scope="col">العمليات</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $i = 0; $totalall = 0; ?>
                                                            @foreach ($details as $product)
                                                                @php
                                                                $i++;
                                                                $total = $product->product_quantity * $product->product_price ;
                                                                $totalall = $totalall +$total ;
                                                                @endphp
                                                                <tr>
                                                                    <td>{{ $i }}</td>
                                                                    <td>{{ $product->product->name }}</td>
																	<td>{!! $product->product->description !!}</td>
																	<td>{{ $product->product_quantity }}</td>
																	<td>{{ $product->product_price }}</td>														                              
                                                                    <td colspan="2">
                                                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                                        data-product_id="{{ $product->product->id }}" 
                                                                        data-name="{{ $product->product->name }}"
                                                                        data-product_quantity="{{  $product->product_quantity }}"
                                                                        data-product_price="{{ $product->product_price}}"
                                                                        data-toggle="modal"
                                                                        href="#exampleModal4" title="تعديل"> <i class="las la-pen"></i> </a>

                                                                        <button class="btn btn-outline-danger btn-sm"
																		data-toggle="modal"
																		data-offer_id="{{ $offers->id }}"	
																		data-product_id="{{$product->product->id}}"
                                                                        data-target="#delete_product">حذف</button>
                                                                    
																	</td>

                                                                </tr>

                                                            @endforeach
                                                            @php
                                                                $discount = (  $offers->discount / 100 ) * $totalall;
                                                                $after_discount = $totalall - $discount ;
                                                            @endphp
                                                            <tr>
                                                                <a class="btn btn-outline-success btn-sm"
                                                                href="{{ url('Print_offer') }}/{{ $offers->id }}"
                                                                role="button"><i class="fas fa-eye"></i>&nbsp;
                                                                عرض</a>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    </table> 
                                                    <div class="table-responsive mg-t-40">
                                                        <table  class="table table-invoice border text-md-nowrap mb-0">
                                                            <tbody>
                                                                <tr>
                                                                    <td class="valign-middle" colspan="1" rowspan="1">
                                                                        <div class="invoice-notes">
                                                                        </div><!-- invoice-notes -->														
                                                                    </td>
                                                                    <th style=" font-size: 32px;font-weight: bold" class="tx-right"> الاجمالي</th>
                                                                    <th style="font-size: 25px" class="tx-right" colspan="2">{{ number_format($totalall,2,'.') }}</th>
                                                                    <th style="font-size: 32px;" class="tx-right">نسبه الخصم (%)</th>
                                                                    <th style="font-size: 23px;font-weight: bold" class="tx-right" colspan="2">%    {{$offers->discount}}</th>
                                                                    <th></th><th></th>
                                                                    <th style="font-size: 32px;font-weight: bold" class="tx-right tx-uppercase tx-bold tx-inverse">الاجمالي  بعد الخصم</th>
                                                                    <th style="font-size: 27px;font-weight: bold" class="tx-right" colspan="2">
                                                                        <h4 class="tx-primary tx-bold" style="font-size: 25px;font-weight: bold">{{ number_format($after_discount,2,'.') }}</h4>
                                                                    </th>
                                                                </tr>
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
                    </div>
                </div>
            </div>
            <!-- /div -->
		</div>
		

 {{--************************add products **********************--}}
		<div class="modal"  id="modaldemo8">
			<div class="modal-dialog"   role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
							type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
						<form action="{{ route('add_product') }}" method="post">
							{{ csrf_field() }}			
							<input type="hidden" name="offer_id" value="{{$offers->id}}">				
							<div class="form-group ">
								<select class="form-control select2 " id="item_picker" required="required">
									<option disabled selected >اختر المنتج</option>				   
									@foreach ($products as $product)
									<option value="{{ $product->id }}"  selling_price="{{ $product->selling_price }}" quantity="{{ $product->quantity }}">{{ $product->name }}</option>
										@endforeach
										</select>
									</div>
									<div class="form-group">
										<table class="table table-hover">
										<thead id="container_header" style="display:none;">
											<th style=" font-size: 15px;">اسم المنتج</th>
											<th style=" font-size: 15px;" class="text-center">سعر البيع داخل العرض</th>
											<th style=" font-size: 15px;" class="text-center">الكميه</th>
											<th style=" font-size: 15px;">حذف من العرض</th>
										</thead>
										<tbody id="items_container">
										</tbody>
										</table>
									</div>							
							<div class="modal-footer">
								<button type="submit" class="btn btn-success">اضافه الى العرض</button>
							</div>
						</form>
					</div>
				</div>
            </div>
        </div>
            {{--************************ end add products **********************--}}

            {{--************************edit offer detials**********************--}}
              <!-- edit -->
    <div class="modal fade" id="exampleModal2"  role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل العرض</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('offers.update', $offers->id) }}" method="post" autocomplete="off">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="hidden" name="id" id="id">
                        <input type="hidden" name="client_id" value="{{ $offers->client->id }}">
                        <label for="recipient-name" class="col-form-label">اسم العرض</label>
                        <input type="text" class="form-control" id="name" name="name"
                            title="يرجي ادخال اسم العرض " required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">offer name</label>
                        <input type="text" style="text-align: left" class="form-control" id="name_en" name="name_en"
                            title="يرجي ادخال اسم العرض " required>
                    </div>



                    <label for="exampleFormControlSelect1">التاريخ</label>
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <div class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                            </div>
                        </div><input class="form-control" value="{{date('Y-m-d')}}"
                            name="offer_Date" id="date" placeholder="YYYY-MM-DD" type="date" required>
                    </div><!-- input-group -->
  


                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">نسبه الخصم (%)</label>
                        <input type="number" class="form-control" id="discount" name="discount"
                        value="0" min="0" max="100" title="يرجي ادخال اسم نسبة الخصم  " required>
                    </div>   
                    <label  style="margin-right:15px" for="exampleFormControlTextarea2">قيود التعاقد</label>
                    <textarea style="font-size: 16px;  margin-right:10px" class="form-control" id="constraints" name="constraints" rows="8" cols="142" required>
                    </textarea>
                    <br>

                    <label  style="margin-right:15px" for="exampleFormControlTextarea2">Contract restrictions</label>
                    <textarea style="font-size: 16px; text-align: left;  margin-right:10px" class="form-control" id="constraints_en" name="constraints_en" rows="8" cols="142" required>
                    </textarea>
                 </div> 
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">تاكيد</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            </div>
            </form>
        </div>
    </div>
</div>
            {{--************************end **********************--}}


                       {{--************************edit client **********************--}}
              <!-- edit -->
    <div class="modal fade" id="exampleModal3"  role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل العرض</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('offers.update', $offers->id) }}" method="post" autocomplete="off">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{$offers->id}}">
                        <input type="hidden" name="name" value="{{$offers->name}}">
                        <input type="hidden" name="name_en" value="{{$offers->name_en}}">
                        <input type="hidden" name="offer_Date" value="{{$offers->offer_Date}}">
                        <input type="hidden" name="constraints" value="{{$offers->constraints}}">
                        <input type="hidden" name="constraints_en" value="{{$offers->constraints_en}}">
                    </div>
                    <div class="form-group">
                        <select class="form-control select2 "  id="select2insidemodal" name="client_id" required="required">
                          <option selected disabled>اختر العميل </option>
                          @foreach ($clients as $client)
                            <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                          @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">تاكيد</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            </div>
            </form>
        </div>
    </div>
</div>
            {{--************************end **********************--}}

            
                       {{--************************edit product **********************--}}
    <div class="modal fade" id="exampleModal4" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">تعديل المنتج</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('offer_products.update', $offers->id) }}" method="post" autocomplete="off">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="hidden" name="id" value="{{$offers->id}}">
                        <input type="hidden" id="product_id" name="product_id" value="">
                    </div>
                    <div class="form-group">
                        <label>اسم المنتج</label>
                        <input class="form-control" id="name" name="name" 
                            type="text" readonly required>
                    </div>   
                    <div class="form-group">
                        <label>الكميه</label>
                        <input class="form-control" id="product_quantity" name="product_quantity" 
                            type="number" required>
                    </div>   
                    <div class="form-group">
                        <label>السعر</label>
                        <input class="form-control" id="product_price" name="product_price" 
                            type="number" required>
                    </div>   
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">تاكيد</button>
                <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            </div>
            </form>
        </div>
    </div>
</div>
            {{--************************end **********************--}}
            
	
    <!-- /row -->

    <!-- delete -->
     <div class="modal fade" id="delete_product" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">حذف المنتج</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('delete_product') }}" method="post">

                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p class="text-center">
                        <h6 style="color:red"> هل انت متاكد من عملية حذف المنتج ؟</h6>
                        </p>

                        <input type="hidden" name="offer_id" id="offer_id" value="">
                        <input type="hidden" name="product_id" id="product_id" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div> 
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')

    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
    <!--Internal  Form-elements js-->
    <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
    <script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!--Internal Sumoselect js-->
    <script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

    <script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

    <script>
        $('#exampleModal2').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var id = button.data('id')
            var name = button.data('name')
            var name_en = button.data('name_en')
            var date = button.data('date')
            var constraints = button.data('constraints')
            var constraints_en = button.data('constraints_en')
            var discount = button.data('discount')
            var modal = $(this) 
            modal.find('.modal-body #id').val(id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #name_en').val(name_en);
            modal.find('.modal-body #date').val(date);
            modal.find('.modal-body #constraints').val(constraints);
            modal.find('.modal-body #constraints_en').val(constraints_en);
            modal.find('.modal-body #discount').val(discount);
        })
    </script>

    <script>
        $('#exampleModal4').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var product_id = button.data('product_id')
            var name = button.data('name')
            var product_quantity = button.data('product_quantity')
            var product_price = button.data('product_price')  
            var modal = $(this) 
            modal.find('.modal-body #product_id').val(product_id);
            modal.find('.modal-body #name').val(name);
            modal.find('.modal-body #product_quantity').val(product_quantity);
            modal.find('.modal-body #product_price').val(product_price);
        })
    </script>

    <script>
        $('#delete_product').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget)
            var offer_id = button.data('offer_id')
            var product_id = button.data('product_id')
            var modal = $(this)
            modal.find('.modal-body #offer_id').val(offer_id);
            modal.find('.modal-body #product_id').val(product_id);
        })
    </script>

    <script>
        // Add the following code if you want the name of the file appear on select
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
	</script>
	<script>
		$(document).ready(function(){
		    var items = 0;
		    $("#item_picker").change(function(){
			items++;
			console.log(`ITEM AFTER ++ `+items);
			$("#container_header").show();
			var selling_price = $(this).find(":selected").attr('selling_price');
			var quantity = $(this).find(':selected').attr('selling_price');
			var name = $(this).find(":selected").text();
			var id = $(this).val();
			if(!$("#row"+id).length){
			    $("#items_container").append(`
				<tr id="row`+id+`">
				<td class="pt-5">`+name+`</td>
				<td><input type="number" name="selling_price[]" value="`+selling_price+`" class=" form-control text-center mt-4" min="1"></td>
				<td class="w-25"><input type="number" name="quantity[]" value="1" class=" form-control text-center mt-4" min="1"></td>
				<td hidden><input type="hidden" name="id[]" value="`+id+`" min="1"></td>
				<td><button type="button" class="btn btn-danger btn-sm rounded-pill ml-3 mt-4 " id="remove`+id+`"><i class="fas fa-times"></i></button></td>
				</tr>
				`);
				}
				
				console.log(items);
				$("#remove"+id).on('click',function(){
					items--;
					console.log(items);
					$("#row"+id).remove();
					document.getElementById("item_picker").selectedIndex = 0;
					console.log(items);
					if(items == 0){
						$("#container_header").hide();
					}
				});
    });
		});
	</script>
	<script>
		// Filter table
		$(document).ready(function(){
		$("#ordersTable").on("keyup", function() {
			var value = $(this).val().toLowerCase();
			$(".ordersTable option").filter(function() {
			$(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
			});
		});
		});
		</script>
		
<script>$(".select2").select2({placeholder:"Choose product",theme: "classic"});</script>


@endsection