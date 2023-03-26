@extends('layouts.master')
@section('css')
    <link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />

@section('title')
    الدليل الحسابات
@stop

@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المحاسبة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                الدليل الحسابات</span>
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
<!-- row -->
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                        @can('اضافة حساب')
                        <a class="modal-effect btn btn-outline-success " style="margin-left:20px;width: 100%;color: green;font-size: 17px;font-weight: bold;" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo8">اضافة حساب</a>     
                        @endcan
            
                        <a class="modal-effect btn btn-outline-primary " style="width: 100%;color: blue;font-size: 17px;font-weight: bold;" data-effect="effect-scale"
                        data-toggle="modal" href="#modaldemo9">تعديل حساب</a>                  
                </div>
            </div>
            <br>
            <div class="card-body">
                <div class="row">
                    <!-- col -->
                    <div class="col-lg-12" style="font-size: 20px;">
                        <ul id="tree1">
                            @foreach($allAccount as $x)
                                <li><a href="#">{{$x->code}} - {{$x->name}}</a>
                                    <ul>
                                        @foreach($x->accounts as $x2)
                                            <li>{{$x2->code}} - {{$x2->name}}
                                                @if($x2->accounts->count() > 0)
                                                    <ul>
                                                        @foreach($x2->accounts as $x3)
                                                            <li>{{$x3->code}} - {{$x3->name}}  
                                                                @if($x3->accounts->count() > 0)
                                                                    <ul>
                                                                        @foreach($x3->accounts as $x4)
                                                                            <li>{{$x4->code}} - {{$x4->name}}
                                                                                @if($x4->accounts->count() > 0)
                                                                                    <ul>
                                                                                        @foreach($x4->accounts as $x5)
                                                                                            <li>
                                                                                                {{$x5->code}} - {{$x5->name}}
                                                                                            </li>
                                                                                        @endforeach
                                                                                    </ul>
                                                                                @endif
                                                                            </li>
                                                                        @endforeach
                                                                    </ul>
                                                                @endif
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </li>
                                        @endforeach
                                    </ul>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                    <!-- /col -->
                </div>
            </div>
            <br>
        </div>
    </div>
</div>
<!-- row -->
        </div>
    </div>
</div>
<!-- add form  -->
<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافة حساب</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('all-accounts.store') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                    <div class="form-group">
                        <input type="hidden" name="id" id="id" value="">
                        <label for="exampleInputEmail1">اسم الحساب</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>الحساب الرئيسي</label>
                        <select class="form-control select2 " name="parent_id" required="required">
                            <option value="" selected disabled>اختر الحساب </option>
                            @foreach ($parent_acc as $account)
                            <option value="{{ $account->id }}">{{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                        <button type="submit" id="submit" class="btn btn-success">تاكيد</button>
                        <button type="button" class="btn btn-secondary" id="add_close" data-dismiss="modal">اغلاق</button>
            </div>
                </form>
        </div>
    </div>
    <!-- End Basic modal -->
</div>
<!-- edit form -->
<div class="modal" id="modaldemo9">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل حساب</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="{{ route('all-accounts.update',1) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <div class="form-group">
                        <label>الحساب</label>
                        <select class="form-control select2 " name="account_id" required="required">
                            <option value="" selected disabled>اختر الحساب </option>
                            @foreach ($children_acc as $account)
                                <option value="{{ $account->id }}"> {{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم الحساب</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label>الحساب الرئيسي</label>
                        <select class="form-control select2 " name="parent_id" id="parent_id" required="required">
                            <option value="" selected disabled>اختر الحساب </option>
                            @foreach ($parent_acc as $account)
                                <option value="{{ $account->id }}"> {{ $account->code }} - {{ $account->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">رصيد افتتاحي (مدين)</label>
                        <input type="number" step=".01" class="form-control" id="start_debit" name="start_debit" required>
                    </div>
                    <div class="form-group">
                        <label for="exampleInputEmail1">رصيد افتتاحي (دائن)</label>
                        <input type="number" step=".01" class="form-control" id="start_credit" name="start_credit" required>
                    </div>
            </div>
            <div class="modal-footer">
                        @can('تعديل حساب')
                        <button type="submit" form="editForm" id="submit_edit" class="btn btn-success">حفظ</button>
                        @endcan
                        </form>
                        <form action="all-accounts/destroy" method="post">
                                {{ method_field('delete') }}
                                {{ csrf_field() }}
                                    <input type="hidden" name="id" id="del_id" value="" required>
                                    @can('حذف حساب')
                                        <button type="submit" onclick="del()" class="btn btn-danger">حذف</button>
                                    @endcan
                        </form>
                        <button type="button" class="btn btn-secondary" id="edit_close" data-dismiss="modal">اغلاق</button>
            </div>
                
        </div>
    </div>
    <!-- End Basic modal -->
</div>

    <!-- row closed -->
</div>
<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
<script src="{{ URL::asset('assets/js/modal.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script src="{{URL::asset('assets/plugins/treeview/treeview.js')}}"></script>
<script>
    $(document).ready(function() {
        $('select[name="account_id"]').on('change', function() {
            var account_id = $(this).val();
            if (account_id) {
                $.ajax({
                    url: "{{ URL::to('all-accounts') }}/" + account_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data)
                        $("div").find('#name').val(data.name);
                        $("div").find('#start_credit').val(data.start_credit);
                        $("div").find('#start_debit').val(data.start_debit);
                        $("div").find('#del_id').val(data.id);
                        $("div").find('#parent_id').val(data.parent_id).trigger('change');
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>
<script>
$('body').keydown(function(e) {
    switch (e.keyCode) {
        case 27:
            $('#add_close').click();
            $('#edit_close').click();
        break;
        case 13:
            $('#submit').click();
            $('#submit_edit').click();
        break;
    }
});    
</script>
<script>
function del()
{
    alert('هل انت متاكد من عملية الحذف ؟');
}
</script>
@endsection