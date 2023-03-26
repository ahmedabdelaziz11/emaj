@extends('layouts.master')
@section('css')
    <!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">

<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

<link href="{{ URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css') }}" rel="stylesheet">
    

    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">

    <!-- Internal Select2 css -->



@section('title')
   قائمة الشيكات المؤجلة 
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الخزينة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                قائمة الشيكات المؤجلة  </span>
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
<div class="row">

    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                <div class="d-flex justify-content-between">
                   
                        <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo8">اضافة شيك</a>
                    
                </div>

            </div>
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <a href="{{route('checks_report')}}" class="modal-effect btn btn-sm btn-primary" style="font-size: 15px;color:white">
                            تقرير الشيكات المؤجلة </a>
                </div>

                <br>
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">تاريخ الاستلام</th>
                                <th class="border-bottom-0">تفاصيل الشيك</th>
                                <th class="border-bottom-0">نوع الشيك</th>
                                <th class="border-bottom-0">اسم صاحب الشيك</th>
                                <th class="border-bottom-0"> قيمة الشيك</th>
                                <th class="border-bottom-0">اسم الرصيد</th>
                                <th class="border-bottom-0">الحالة</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($checks as $x)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                        @if (date('Y-m-d') == $x->received_date )
                                            <td><span style="font-weight: bold"  class="text-danger">{{ $x->received_date }}</span></td>
                                        @else
                                            <td>{{ $x->received_date }}</td>
                                        @endif
                                    <td>{{ $x->account }}   </td>
                                    @if($x->type == 0)
                                    <td class="text-success">مستحقة</td>
                                    <td>{{\App\Models\clients::where('id',$x->person_id)->first()->client_name }}</td>

                                    @else
                                    <td class="text-danger">دائنة</td>
                                    <td>{{\App\Models\suppliers::where('id',$x->person_id)->first()->name}}</td>

                                    @endif
                                    <td>{{ number_format($x->price) }}   </td>
                                    <td>{{\App\Models\accounts::where('id',$x->account_id)->first()->name}}</td>
                                    @if($x->status == "غير مؤكدة")
                                        <td class="text-danger">غير مؤكدة</td>
                                    @else
                                        <td class="text-success">مؤكدة</td>
                                    @endif
                                    <td>

                                        <div class="dropdown">
                                            <button aria-expanded="false" aria-haspopup="true"
                                                class="btn ripple btn-primary btn-sm" data-toggle="dropdown"
                                                type="button">العمليات<i class="fas fa-caret-down ml-1"></i></button>
                                            <div class="dropdown-menu tx-13">
                                            @if($x->status == "غير مؤكدة")
                                                <button type="button" class="dropdown-item" data-toggle="modal"
                                                data-target="#submit{{ $x->id }}"
                                                title="تاكيد"><i class="fa fa-edit btn btn-info btn-sm"></i> تاكيد </button>
                                            @endif

                                            <a  data-effect="effect-scale"
                                            class="modal-effect dropdown-item"
                                            data-id="{{ $x->id }}" 
                                            data-price="{{ $x->price }}"
                                            data-received_date="{{  $x->received_date  }}"
                                            data-account="{{ $x->account}}"
                                            data-person_id="{{ $x->person_id}}"
                                            data-account_id="{{ $x->account_id}}"
                                            data-type="{{ $x->type}}"
                                            data-toggle="modal"
                                            href="#exampleModal2" title="تعديل"> <i class="fa fa-edit btn-info las la-pen"></i> تعديل</a>
                                                
                                            <button type="button" class="modal-effect dropdown-item " data-toggle="modal"
                                            data-target="#modaldemo9" data-id="{{ $x->id }}" data-name="{{ $x->id }}"
                                            title="حذف"><i class="fa fa-edit btn btn-sm btn-danger"></i> حذف</button>

                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <div class="modal fade" id="submit{{ $x->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="exampleModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 style="font-family: 'Cairo', sans-serif;" class="modal-title"
                                                    id="exampleModalLabel">
                                                    تاكيد العملية   
                                                </h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <form  action="{{ route('checks_finish') }}" method="post" enctype="multipart/form-data" autocomplete="off">
                                                    @csrf	
                                                    <input hidden name="id" value="{{$x->id}}">

                                                    @if($x->type == 0)
                                                        <p style="font-weight: bold; font-size: 25px;" class="text-danger">{{$x->price}} من ح/ {{\App\Models\accounts::where('id',$x->account_id)->first()->name}}  الى ح العميل/ {{\App\Models\clients::where('id',$x->person_id)->first()->client_name}}</p>
                                                    @else    
                                                        <p style="font-weight: bold; font-size: 25px;" class="text-danger">{{$x->price}} من ح المورد/ {{\App\Models\suppliers::where('id',$x->person_id)->first()->name}}  الى  / {{\App\Models\accounts::where('id',$x->account_id)->first()->name}}</p>
                                                    @endif

                                                    <br>
                                                    <button type="submit" class="btn btn-primary w-100 ">تاكيد</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                    <h6 class="modal-title">اضافة شيك</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('checks.store') }}" method="post">
                        {{ csrf_field() }}

                        <label for="exampleFormControlSelect1">تاريخ الاستلام</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div><input class="form-control fc-datepicker" 
                                name="received_date" id="received_date" placeholder="YYYY-MM-DD" type="date" required>
                        </div><!-- input-group -->
                        <br>

                        <div class="form-group">
                            <label for="exampleInputEmail1">تفاصيل الشيك</label>
                            <input type="text" class="form-control" id="account" name="account" required>
                        </div>

                        <div class="form-group">
                            <label>نوع الشيك</label>
                            <select class="form-control select2 " name="type" id="type" required="required">
                            <option value="" disabled selected>اختر النوع </option>
                                <option value="0"> مستحق </option>
                                <option value="1"> دائنة </option>
                            </select>
                        </div> 

                        <div class="form-group">
                            <label>اختر الحساب</label>
                            <select class="form-control select2 " name="person_id" id="person" required="required">
                            <option value="" disabled selected>اختر الحساب </option>

                            </select>
                        </div> 

                        <div class="form-group">
                            <label>الرصيد</label>
                            <select class="form-control select2 " name="account_id" required="required">
                            <option value="">اختر الرصيد </option>
                            @foreach ($accounts as $account)
                                @if ($account->id != 1)
                                    <option value="{{ $account->id }}"> {{ $account->name }} </option>
                                @endif
                            @endforeach
                            </select>
                        </div> 

                        <div class="form-group">
                            <label for="exampleInputEmail1">قيمة الشيك</label>
                            <input type="number" class="form-control" id="price" name="price" required>
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
    <div class="modal fade" id="exampleModal2" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> تعديل الشيك </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="checks/update" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="temp" id="temp" value="">
                        </div>


                        <label for="exampleFormControlSelect1">تاريخ الاستلام</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <i class="fas fa-calendar-alt"></i>
                                </div>
                            </div><input class="form-control fc-datepicker" 
                                name="received_date" id="received_date" placeholder="YYYY-MM-DD" type="date" required>
                        </div><!-- input-group -->
                        <br>

                        <div class="form-group">
                            <label for="exampleInputEmail1">تفاصيل الشيك</label>
                            <input type="text" class="form-control" id="account" name="account" required>
                        </div>

                        <div class="form-group">
                            <label>نوع الشيك</label>
                            <select class="form-control" name="type" id="type" required="required">
                            <option value="" disabled selected>اختر النوع </option>
                                <option value="0"> مستحق </option>
                                <option value="1"> دائنة </option>
                            </select>
                        </div> 

                        <div class="form-group">
                            <label>اختر الحساب</label>
                            <select class="form-control select2 " name="person_id" required="required">
                            <option value="" disabled selected>اختر الحساب </option>

                            </select>
                        </div> 

                        <div class="form-group">
                            <label>الرصيد</label>
                            <select class="form-control select2 " name="account_id" id="account_id" required="required">
                            <option value="">اختر الرصيد </option>
                            @foreach ($accounts as $account)
                                @if ($account->id != 1)
                                    <option value="{{ $account->id }}"> {{ $account->name }} </option>
                                @endif
                            @endforeach
                            </select>
                        </div> 

                        <div class="form-group">
                            <label for="exampleInputEmail1">قيمة الشيك</label>
                            <input type="number" class="form-control" id="price" name="price" required>
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
                    <h6 class="modal-title">حذف الشيك</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="checks/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="id" id="id" value="">
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
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
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
        var date = button.data('date')
        var price = button.data('price')
        var type = button.data('type')
        var person_id = button.data('person_id')
        var account_id = button.data('account_id')
        var received_date = button.data('received_date')
        var account = button.data('account')
        var user = button.data('user')
        console.log(person_id)
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #date').val(date);
        modal.find('.modal-body #price').val(price);
        modal.find('.modal-body #temp').val(person_id);
        modal.find('.modal-body #type').val(type).trigger('change');

        modal.find('.modal-body #account_id').val(account_id).trigger('change');
        modal.find('.modal-body #received_date').val(received_date);
        modal.find('.modal-body #account').val(account).trigger('change');
        modal.find('.modal-body #user').val(user);

    })
</script>

<script>
    $('#modaldemo9').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
    })
</script>

<script>
    $(document).ready(function() {
        $('select[name="type"]').on('change', function() {
            var person_id = parseInt( $('#temp').val());
            var type = $(this).val();
            var temp = 0; 
            if (type) {
                $.ajax({
                    url: "{{ URL::to('get_person') }}/" + type,
                    type: "GET",
                    dataType: "json",
                    success: function(data) {
                        $('select[name="person_id"]').empty();
                        $.each(data, function(key, value) {
                            if(key == person_id)
                            {
                                $('select[name="person_id"]').append('<option selected value="' +
                                key + '">' + value + '</option>');
                                temp = 1; 
                            }else
                            {
                                $('select[name="person_id"]').append('<option value="' +
                                    key + '">' + value + '</option>');
                            }
                        });
                        if(temp == 0)
                        {
                            $('select[name="person_id"]').append('<option disabled selected>'+ "اختر الحساب" + '</option>');
                        }
                    },
                });
            } else {
                console.log('AJAX load did not work');
            }
        });
    });
</script>


@endsection