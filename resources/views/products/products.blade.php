@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
<!--Internal   Notify -->



<!--Internal   Notify -->
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@livewireStyles

@section('title')
    المنتجات
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المخزن</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                المنتجات</span>
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
                msg:" فشلت الاضافة اسم المنتج مكرر ",
                type: "error"
            })
        }
    </script>
@endif

@if (session()->has('c_delete'))
<script>
    window.onload = function() {
        notif({
            msg: "لا يمكن حذف المنتج",
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
<div class="row">
    <livewire:show-posts />

    <div class="modal" id="modaldemo8" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title" style="font-size: 17px;font-weight: bold;">اضافة منتج</h6><button  aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>

                <div class="modal-body">
                    <form id="create_form" action="{{ route('products.store') }}" method="post">
                        {{ csrf_field() }}
                        <meta name="csrf-token" content="{{ csrf_token() }}">


                        <div class="form-group">
                            <label for="exampleInputEmail1">اسم المنتج</label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">product name</label>
                            <input style="text-align: left;" type="text" class="form-control" id="name_en" name="name_en" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">الوصف</label>
                            <textarea class="form-control summernote1"  name="description" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">description</label>
                            <textarea style="text-align: left;" class="form-control summernote1"  name="description_en" rows="3" required></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">سعر شراء</label>
                            <input type="number" step=".01" class="form-control" name="Purchasing_price" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">سعر بيع</label>
                            <input type="number" step=".01" class="form-control" name="selling_price" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">كمية افتتاحية</label>
                            <input type="number" class="form-control"  name="start_quantity" value="0" required>
                        </div>

                        <div class="form-group">
                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">المخزن</label>
                            <select name="stock_id" class="form-control select2" required>
                                <option value="" selected disabled> --حدد المخزن--</option>
                                @foreach ($stocks as $stock)
                                    <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>القسم</label>
                            <select class="form-control select2 " name="section_id" required>
                            <option value="" disabled selected>اختر القسم </option>

                            </select>
                        </div> 
                        
                        <div class="modal-footer">
                            <button type="submit" id="create" class="btn btn-success">تاكيد</button>
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
                        </div>


                    </form>
                </div>
            </div>
        </div>
        <!-- End Basic modal -->


    </div>
    <!-- edit -->
<div class="modal fade" id="exampleModal2" role="dialog" aria-labelledby="exampleModalLabel"
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

                <form action="products/update" method="post" autocomplete="off">
                    {{ method_field('patch') }}
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="">
                        <input type="hidden" name="old_section_id" id="old_section_id" value="">

                        <label for="recipient-name" class="col-form-label">اسم المنتج:</label>
                        <input class="form-control" name="name" id="name" type="text" required>
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="col-form-label">product name :</label>
                        <input style="text-align: left;" class="form-control" name="name_en" id="name_en" type="text" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">الوصف</label>
                        <textarea class="form-control summernotee1" id="description" name="description" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                        <label for="exampleFormControlTextarea1">description</label>
                        <textarea style="text-align: left;" class="form-control summernotee2" id="description_en" name="description_en" rows="3" required></textarea>
                    </div>

                    <div class="form-group">
                            <label for="exampleInputEmail1">سعر شراء</label>
                            <input type="number" step=".01" class="form-control" name="Purchasing_price" id="x" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">سعر بيع</label>
                            <input type="number" step=".01" class="form-control" name="selling_price" id="selling_price" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">كمية افتتاحية</label>
                            <input type="number" class="form-control"  name="start_quantity" id="start_quantity" value="0" required>
                        </div>

                        <div class="form-group">
                            <label class="my-1 mr-2" for="inlineFormCustomSelectPref">المخزن</label>
                            <select name="stock_id"  id="stock_id" class="form-control select2" required>
                                <option value="" selected disabled> --حدد المخزن--</option>
                                @foreach ($stocks as $stock)
                                    <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label>القسم</label>
                            <select class="form-control select2 " name="section_id" required>
                            <option value="" disabled selected>اختر القسم </option>

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


    <!-- delete -->
    <div class="modal" id="modaldemo9">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف المنتج</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="products/destroy" method="post">
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
<!-- Internal Data tables -->
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
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>




<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var name_en = button.data('name_en')
        var x = button.data('x')
        var description = button.data('description')
        var description_en = button.data('description_en')
        var Purchasing = button.data('Purchasing')
        var selling_price = button.data('selling_price')
        var Purchasing_price = button.data('Purchasing_price')
        var start_quantity = button.data('start_quantity')
        var section_name = button.data('section_name')
        var stock_id = button.data('stock_id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #old_section_id').val(section_name);
        modal.find('.modal-body #name_en').val(name_en);
        modal.find('.modal-body #x').val(x);
        modal.find('.modal-body #description').val(description).summernote();
        modal.find('.modal-body #description_en').val(description_en).summernote('justifyLeft');
        modal.find('.modal-body #Purchasing').val(Purchasing);
        modal.find('.modal-body #selling_price').val(selling_price);
        modal.find('.modal-body #Purchasing_price').val(Purchasing_price);
        modal.find('.modal-body #start_quantity').val(start_quantity);
        modal.find('.modal-body #stock_id').val(stock_id).trigger('change');
        $(".summernotee1").summernote("code",description);
        $(".summernotee2").summernote("code",description_en,"justifyLeft");
        $(".summernotee2").summernote("justifyLeft");
    })
</script>

<script>
    $(document).ready(function() {   
        $('select[name="stock_id"]').on('change', function() {
            var old_section_id = parseInt( $('#old_section_id').val());
            var stock_id = $(this).val();
            var temp = 0; 

            if (stock_id) {
                $.ajax({
                    url: "{{ URL::to('stocks') }}/" + stock_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="section_id"]').empty();
                        $.each(data, function(key, value) {
                            if(key == old_section_id)
                            {
                                $('select[name="section_id"]').append('<option selected value="' +
                                key + '">' + value + '</option>');
                                temp = 1; 
                            }else
                            {
                                $('select[name="section_id"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            }

                        });
                        if(temp == 0)
                        {
                            $('select[name="section_id"]').append('<option disabled selected>'+ "اختر القسم" + '</option>');
                        }

                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>

<script>
    $('.summernote1').summernote({
        toolbar: [
             // [groupName, [list of button]]
            ['style', ['bold', 'italic', 'underline', 'clear']],
            ['fontsize', ['fontsize']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['height', ['height']]
        ]
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






@endsection