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
    العملاء
@stop

@endsection
@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">العملاء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                قائمة العملاء</span>
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
                msg:" فشلت الاضافة اسم العميل مكرر ",
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
                <div class="d-flex justify-content-between">
                   
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo8">اضافة عميل</a>
                    
                </div>

                

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">اسم العميل</th>
                                <th class="border-bottom-0">client name</th>
                                <th class="border-bottom-0"> السجل التجاري</th>
                                <th class="border-bottom-0"> البطاقة الضريبية</th>
                                <th class="border-bottom-0">الايميل</th>
                                <th class="border-bottom-0">العنوان</th>
                                <th class="border-bottom-0">address</th>
                                <th class="border-bottom-0">الهاتف</th>
                                <th class="border-bottom-0">اسم الشركة</th>
                                <th class="border-bottom-0">company name</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($clients as $x)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $x->client_name }}</td>
                                    <td>{{ $x->client_name_en }}</td>
                                    <td>{{ $x->sgel }}</td>
                                    <td>{{ $x->dreba }}</td>
                                    <td>{{ $x->email }}</td>
                                    <td>{{ $x->address }}</td>
                                    <td>{{ $x->address_en }}</td>
                                    <td>{{ $x->phone }}</td>
                                    <td>{{ $x->Commercial_Register }}</td>                                   
                                    <td>{{ $x->Commercial_Register_en }}</td>                                  
                                    <td>
                                            <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-client_name="{{ $x->client_name }}" data-client_name_en="{{ $x->client_name_en }}"
                                                data-address="{{ $x->address }}" data-address_en="{{ $x->address_en }}" data-dreba="{{ $x->dreba }}" data-sgel="{{ $x->sgel }}" data-email="{{ $x->email }}" data-x="{{ $x->Commercial_Register }}" data-x_en="{{ $x->Commercial_Register_en }}" data-phone="{{ $x->phone }}" 
                                                data-Commercial_Register="{{ $x->Commercial_Register }}"  data-toggle="modal"
                                                href="#exampleModal2" title="تعديل"><i class="las la-pen"></i></a>

                                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" data-client_name="{{ $x->client_name }}"
                                                data-toggle="modal" href="#modaldemo9" title="حذف"><i
                                                    class="las la-trash"></i></a>
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
                    <h6 class="modal-title">اضافة العميل</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('clients.store') }}" method="post">
                        {{ csrf_field() }}
                        {{ method_field('post') }}
                        <div class="form-group">
                            <label for="exampleInputEmail1">اسم العميل <i class="fa fa-asterisk text-danger"  aria-hidden="true"></i></label>
                            <input type="text" class="form-control" id="client_name" name="client_name" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">client name</label>
                            <input type="text" class="form-control" id="client_name_en" name="client_name_en">
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"> السجل التجاري</label>
                            <input type="text" class="form-control" id="sgel" name="sgel" value="0" >
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1"> البطاقة الضريبية </label>
                            <input type="text" class="form-control" id="dreba" name="dreba" value="0">
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
                            <label for="exampleFormControlTextarea1">address</label>
                            <textarea class="form-control" id="address_en" name="address_en" rows="3" ></textarea>
                        </div> 

                        <div class="form-group">
                            <label for="exampleInputEmail1">الهاتف</label>
                            <input class="form-control" type="number" id="phone" name="phone" value="0"  >
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1"> اسم الشركه</label>
                            <input class="form-control" id="Commercial_Register" name="Commercial_Register" >
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">company name</label>
                            <input class="form-control" id="Commercial_Register_en" name="Commercial_Register_en"  >
                        </div>

                        <div class="col">
                                <input class="form-control fc-datepicker" name="invoice_date" placeholder="YYYY-MM-DD"
                                    type="date" value="{{ date('Y-m-d') }}" hidden>
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
                    <h5 class="modal-title" id="exampleModalLabel">تعديل العميل</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="clients/update" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id" value="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم العميل <i class="fa fa-asterisk text-danger"  aria-hidden="true"></i></label>
                                <input type="text" class="form-control" id="client_name" name="client_name" required>
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">client name</label>
                                <input type="text" class="form-control" id="client_name_en" name="client_name_en" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1"> السجل التجاري</label>
                                <input type="text" class="form-control" id="sgel" name="sgel" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1"> البطاقة الضريبية </label>
                                <input type="text" class="form-control" id="dreba" name="dreba" required>
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">الايميل</label>
                                <input type="text" class="form-control" id="email" name="email" >
                            </div>
                            <div class="form-group">
                                <label for="exampleInputEmail1">اسم الشركه </label>
                                <input type="text" class="form-control" id="x" name="x" >
                            </div>

                            <div class="form-group">
                                <label for="exampleInputEmail1">company name</label>
                                <input type="text" class="form-control" id="x_en" name="x_en" >
                            </div>
    
                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">العنوان</label>
                                <textarea class="form-control" id="address" name="address" rows="3" ></textarea>
                            </div>

                            <div class="form-group">
                                <label for="exampleFormControlTextarea1">address</label>
                                <textarea class="form-control" id="address_en" name="address_en" rows="3" ></textarea>
                            </div>
    
                            <div class="form-group">
                                <label for="exampleInputEmail1">الهاتف</label>
                                <input class="form-control" type="number" id="phone" name="phone" required>
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
                    <h6 class="modal-title">حذف العميل</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="clients/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="client_name" id="client_name" type="text" readonly>
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
        var x = button.data('x')
        var x_en = button.data('x_en')
        var client_name = button.data('client_name')
        var client_name_en = button.data('client_name_en')
        var sgel = button.data('sgel')
        var dreba = button.data('dreba')
        var email = button.data('email')
        var address = button.data('address')
        var address_en = button.data('address_en')
        var phone = button.data('phone')
        var Commercial_Register = button.data('Commercial_Register')

        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #x_en').val(x_en);
        modal.find('.modal-body #x').val(x);
        modal.find('.modal-body #client_name_en').val(client_name_en);
        modal.find('.modal-body #client_name').val(client_name);
        modal.find('.modal-body #sgel').val(sgel);
        modal.find('.modal-body #dreba').val(dreba);
        modal.find('.modal-body #email').val(email);
        modal.find('.modal-body #address').val(address);
        modal.find('.modal-body #address_en').val(address_en);
        modal.find('.modal-body #phone').val(phone);
        modal.find('.modal-body #Commercial_Register').val(Commercial_Register);
    })
</script>

<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var client_name = button.data('client_name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #client_name').val(client_name);
    })
</script>

@endsection