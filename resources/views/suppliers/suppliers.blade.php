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

@section('title')
    الموردين
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الموردين</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                قائمة الموردين </span>
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
                msg:" فشلت الاضافة اسم المورد مكرر ",
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


    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <!-- @can('اضافة مورد')
                <div class="d-flex justify-content-between">
                   
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo8">اضافة مورد</a>
                    
                </div>
                @endcan -->

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">كود مورد</th>
                                <th class="border-bottom-0">اسم مورد</th>
                                <th class="border-bottom-0">السجل التجاري</th>
                                <th class="border-bottom-0">البطاقة الضريبية</th>
                                <th class="border-bottom-0">رقم الحساب</th>
                                <th class="border-bottom-0">الايميل</th>
                                <th class="border-bottom-0">العنوان</th>
                                <th class="border-bottom-0">الهاتف</th>
                                <th class="border-bottom-0">اسم الشركة</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($suppliers as $x)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $x->account->code ?? 'non' }}</td>
                                    <td>{{ $x->name }}</td>
                                    <td>{{ $x->c_register }}</td>
                                    <td>{{ $x->tax_card }}</td>
                                    <td>{{ $x->account_number }}</td>
                                    <td>{{ $x->email }}</td>
                                    <td>{{ $x->address }}</td>
                                    <td>{{ $x->phone }}</td>
                                    <td>{{ $x->company_name }}</td>                                    
                                    <td> 
                                        @can('تعديل مورد')                                  
                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                                data-address="{{ $x->address }}" data-tax_card="{{ $x->tax_card }}" data-c_register="{{ $x->c_register }}" data-account_number	="{{ $x->account_number }}" data-email="{{ $x->email }}" data-company_name="{{ $x->company_name }}" data-phone="{{ $x->phone }}" 
                                                data-toggle="modal"
                                                href="#exampleModal2" title="تعديل"><i class="las la-pen"></i>
                                            </a>
                                            @endcan 
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="modal" id="modaldemo8">
        <div class="modal-dialog" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">اضافة مورد</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('suppliers.store') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('post') }}
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <label for="exampleInputEmail1">اسم مورد <i class="fa fa-asterisk text-danger"  aria-hidden="true"></i></label>
                            <input type="text" class="form-control" id="name" name="name" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> السجل التجاري</label>
                            <input type="text" class="form-control" id="c_register" name="c_register" value="0">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> البطاقة الضريبية </label>
                            <input type="text" class="form-control" id="tax_card" name="tax_card" value="0">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> رقم الحساب </label>
                            <input type="text" class="form-control" id="account_number" name="account_number" value="0" >
                        </div>
                        

                        <div class="form-group">
                            <label for="exampleInputEmail1">الايميل</label>
                            <input type="text" class="form-control" id="email" name="email" >
                        </div>

                        <div class="form-group">
                            <label for="exampleFormControlTextarea1">العنوان</label>
                            <textarea class="form-control" id="address" name="address" rows="3" ></textarea>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">الهاتف</label>
                            <input class="form-control" type="number" id="phone" name="phone" value="0" >
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"> اسم الشركه</label>
                            <input class="form-control" id="company_name" name="company_name"  >
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
    <!-- edit -->
    <div class="modal fade" id="exampleModal2" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">تعديل مورد</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="suppliers/update" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم مورد <i class="fa fa-asterisk text-danger"  aria-hidden="true"></i></label>
                                <input type="text" class="form-control" id="name" name="name" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> السجل التجاري</label>
                                <input type="text" class="form-control" id="c_register" name="c_register" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> البطاقة الضريبية </label>
                                <input type="text" class="form-control" id="tax_card" name="tax_card" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> رقم الحساب </label>
                                <input type="text" class="form-control" id="account_number" name="account_number" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">الايميل</label>
                                <input type="text" class="form-control" id="email" name="email" >
                            </div>
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">العنوان</label>
                                <textarea class="form-control" id="address" name="address" rows="3" ></textarea>
                            </div>
    
                            <div class="form-group">
                                <label for="exampleInputEmail1">الهاتف</label>
                                <input class="form-control" type="number" id="phone" name="phone" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم الشركه </label>
                                <input type="text" class="form-control" id="company_name" name="company_name" >
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
                    <h6 class="modal-title">حذف مورد</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="suppliers/destroy" method="post">
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
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jquery.dataTables.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/jszip.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/pdfmake.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/vfs_fonts.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.html5.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.print.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js') }}"></script>
<!--Internal  Datatable js -->
<script src="{{ URL::asset('assets/js/table-data.js') }}"></script>
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>

<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>

<script>
    $('#exampleModal2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var c_register = button.data('c_register')
        var account_number = button.data('account_number')
        var tax_card = button.data('tax_card')
        var email = button.data('email')
        var address = button.data('address')
        var phone = button.data('phone')
        var company_name = button.data('company_name')

        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        modal.find('.modal-body #c_register').val(c_register);
        modal.find('.modal-body #account_number').val(account_number);
        modal.find('.modal-body #tax_card').val(tax_card);
        modal.find('.modal-body #email').val(email);
        modal.find('.modal-body #address').val(address);
        modal.find('.modal-body #phone').val(phone);
        modal.find('.modal-body #company_name').val(company_name);
    })
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