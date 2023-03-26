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
    <!--Internal  Font Awesome -->
    <link href="{{URL::asset('assets/plugins/fontawesome-free/css/all.min.css')}}" rel="stylesheet">
    <!--Internal  treeview -->
    <link href="{{URL::asset('assets/plugins/treeview/treeview-rtl.css')}}" rel="stylesheet" type="text/css" />

@section('title')
    مراكز التكلفة
@stop

@endsection

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">المحاسبة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
            مراكز التكلفة</span>
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

@if (session()->has('del'))
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
@endif

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
                        <a class="modal-effect btn btn-outline-success " style="margin-left:20px;width: 100%;color: green;font-size: 17px;font-weight: bold;" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo8">اضافة مركز</a>     

                        <a class="modal-effect btn btn-outline-primary " style="width: 100%;color: blue;font-size: 17px;font-weight: bold;" data-effect="effect-scale"
                        data-toggle="modal" href="#exampleModal2">تعديل مركز</a>                  
                </div>
            </div>
            <br>
            <div class="card-body">
                <div class="row">
                    <!-- col -->
                    <div class="col-lg-12" style="font-size: 20px;">
                        <ul id="tree1">
                            @foreach($costs as $x)
                            <li><a href="#">{{$x->name}} - {{$x->details}}</a> 
                                <ul>
                                    @foreach($x->childrens as $x2)
                                        <li>{{$x2->name}} - {{$x2->details}}
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

<div class="modal" id="modaldemo8">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">اضافة مركز</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('costs.store') }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('post') }}
                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم المركز</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">ملاحظات</label>
                        <textarea class="form-control" id="details" name="details" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label>المركز الرئيسي</label>
                        <select class="form-control select2 " name="parent_id" required="required">
                            <option value="0">لا يوجد - مركز رئيسي</option>
                            @foreach ($costs as $cost)
                            <option value="{{ $cost->id }}"> {{ $cost->name }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                        <button type="submit" id="submit_add" class="btn btn-success">تاكيد</button>
                        <button type="button" id="close_add" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
            </div>
                </form>
        </div>
    </div>
    <!-- End Basic modal -->
</div>
<div class="modal" id="exampleModal2">
    <div class="modal-dialog" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">تعديل مركز</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <form id="editForm" action="{{ route('costs.update',6) }}" method="post">
                    {{ csrf_field() }}
                    {{ method_field('patch') }}
                    <div class="form-group">
                        <label>اختر المركز</label>
                        <select class="form-control select2 " name="cost_id" required="required">
                            <option value="" selected disabled>اختر الحساب </option>
                            @foreach ($all_costs as $cost)
                                <option value="{{ $cost->id }}">{{ $cost->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">اسم المركز</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputEmail1">ملاحظات</label>
                        <textarea class="form-control" id="details" name="details" rows="2"></textarea>
                    </div>

                    <div class="form-group">
                        <label>المركز الرئيسي</label>
                        <select class="form-control select2" id="parent_id" name="parent_id">
                            <option value="0">لا يوجد - مركز رئيسي</option>
                            @foreach ($costs as $cost)
                            <option value="{{ $cost->id }}"> {{ $cost->name }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" id="submit_edit" class="btn btn-success">تاكيد</button>
                </form>
                
                <form action="{{route('costs.destroy',1)}}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                            <input type="hidden" name="id" id="del_id" value="" required>
                            <button type="submit" onclick="del()" class="btn btn-danger">حذف</button>
                </form>
                <button type="button" id="close_edit" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
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
        $('select[name="cost_id"]').on('change', function() {
            var cost_id = $(this).val();
            if (cost_id) {
                $.ajax({
                    url: "{{ URL::to('costs') }}/" + cost_id,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        console.log(data)
                        $("div").find('#name').val(data.name);
                        $("div").find('#details').val(data.details);
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
            $('#close_add').click();
            $('#close_edit').click();
        break;
        case 13:
            $('#submit_add').click();
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