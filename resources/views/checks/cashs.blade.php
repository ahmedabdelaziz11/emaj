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
   قائمة  سندات القبض 
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الخزينة</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                قائمة سندات القبض  </span>
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
            <div class="card-body">
                <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                            data-toggle="modal" href="#modaldemo8">اضافة سند قبض</a>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xl-12">
        <div class="card mg-b-20">
            <div class="card-header pb-0">
                    <form action="{{route('cash-details')}}" method="GET" role="search" autocomplete="off">
                        <div class="row" style="padding: 0px; margin: 0px;">
                            <div class="col-lg-4" id="start_at">
                                <label for="exampleFormControlSelect1">من تاريخ</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    </div><input class="form-control" value="{{ $start_at ?? '' }}"
                                        name="start_at" placeholder="YYYY-MM-DD" type="date" required>
                                </div><!-- input-group -->
                            </div>

                            <div class="col-lg-4" id="end_at">
                                <label for="exampleFormControlSelect1">الي تاريخ</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                    </div><input class="form-control" name="end_at"
                                        value="{{ $end_at ?? '' }}" placeholder="YYYY-MM-DD" type="date" required>
                                </div><!-- input-group -->
                            </div>

                            <div class="col-lg-4">
                                <label for="exampleFormControlSelect1">.</label>
                                <button class="btn btn-primary btn-block">بحث</button>
                            </div>
                        </div>
                    </form>	                    

            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table id="example1" class="table key-buttons text-md-nowrap" data-page-length='50'
                        style="text-align: center">
                        <thead>
                            <tr>
                                <th class="border-bottom-0">#</th>
                                <th class="border-bottom-0">التاريخ</th>
                                <th class="border-bottom-0">البيان</th>
                                <th class="border-bottom-0">نوع الحساب</th>
                                <th class="border-bottom-0">اسم الحساب</th>
                                <th class="border-bottom-0">المبلغ</th>
                                <th class="border-bottom-0">رصيد الايداع</th>
                                <th class="border-bottom-0">العمليات</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach ($cashs as $x)
                                <?php $i++; ?>
                                <tr>
                                    <td>{{ $i }}</td>
                                    <td>{{ $x->date }}</td>
                                    <td>{{ $x->details }}   </td>

                                    @if($x->Value_Status == 0)
                                    <td class="text-success">عميل</td>
                                    <td>{{\App\Models\clients::where('id',$x->person_id)->first()->client_name }}</td>
                                    @elseif($x->Value_Status == 2)
                                    <td class="text-primary">موظف</td>
                                    <td>{{\App\Models\employees::where('id',$x->person_id)->first()->name }}</td>
                                    @elseif($x->Value_Status == 6)
                                    <td class="text-success">المالك</td>
                                    <td>م / محمد</td>
                                    @else
                                    <td class="text-danger">مورد</td>
                                    <td>{{\App\Models\suppliers::where('id',$x->person_id)->first()->name}}</td>
                                    @endif

                                    <td>{{ number_format($x->amount) }}   </td>
                                    <td>{{$x->account->name}}   </td>

                                    <td>

                                        <a  data-effect="effect-scale"
                                        class="modal-effect btn btn-sm btn-info"
                                        data-id="{{ $x->id }}" 
                                        data-amount="{{ $x->amount }}"
                                        data-date="{{  $x->date  }}"
                                        data-details="{{ $x->details}}"
                                        data-person_id="{{ $x->person_id}}"
                                        data-account_id="{{ $x->account_id}}"
                                        data-type="{{ $x->Value_Status}}"
                                        data-toggle="modal"
                                        href="#exampleModal2" title="تعديل"> <i class="las la-pen"></i></a>


                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                data-id="{{ $x->id }}" 
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
                    <h6 class="modal-title">اضافة سند قبض</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('cash-receipts.store') }}" method="post">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <label>التاريخ</label>
                            <input class="form-control" name="date" placeholder="YYYY-MM-DD"
                                type="date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">البيان</label>
                            <input type="text" class="form-control" id="details" name="details" >
                        </div>

                        <div class="form-group">
                            <label>نوع الحساب</label>
                            <select class="form-control select2 " name="type" id="type" required="required">
                            <option value="" disabled selected>اختر النوع </option>
                                <option value="0"> عميل </option>
                                <option value="1"> مورد </option>
                                <option value="2"> موظف </option>
                                <option value="4"> ايراد </option>
                                <option value="6"> مالك (ايداع نقدية) </option>
                            </select>
                        </div> 


                        <div class="form-group">
                            <label>اختر الحساب</label>
                            <select class="form-control select2 " name="person_id" required="required">
                            <option value="" disabled selected>اختر الحساب </option>

                            </select>
                        </div> 

                        
                        <div class="form-group">
                            <label>رصيد الايداع</label>
                            <select class="form-control select2" name="account_id" id="account_picker" required="required">
                                <option value="">اختر الرصيد </option>
                                @foreach ($accounts as $account)
                                    @if ($account->id != 1)
                                        <option value="{{ $account->id }}" account="{{$account->account}}"> {{ $account->name }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputName" class="control-label">المبلغ المدفوع</label>
                            <input type="number" class="form-control" id="amount" name="amount"
                            value="0" min="1" step="1"  title="يرجي ادخال المبلغ المدفوع  " required>
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
                    <h5 class="modal-title" id="exampleModalLabel"> تعديل سند القبض </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">

                    <form action="{{route('cash-receipts.update',1)}}" method="post" autocomplete="off">
                        {{ method_field('patch') }}
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="hidden" name="id" id="id" value="">
                            <input type="hidden" name="temp" id="temp" value="">
                        </div>


                        <div class="form-group">
                            <label>التاريخ</label>
                            <input class="form-control" name="date" placeholder="YYYY-MM-DD"
                                type="date" value="{{ date('Y-m-d') }}" required>
                        </div>

                        <div class="form-group">
                            <label for="exampleInputEmail1">البيان</label>
                            <input type="text" class="form-control" id="details" name="details" >
                        </div>

                        <div class="form-group">
                            <label>نوع الحساب</label>
                            <select class="form-control select2 " name="type" id="type" required="required">
                            <option value="" >اختر النوع </option>
                                <option value="0"> عميل </option>
                                <option value="1"> مورد </option>
                                <option value="2"> موظف </option>
                                <option value="6"> مالك (ايداع نقدية) </option>

                            </select>
                        </div> 


                        <div class="form-group">
                            <label>اختر الحساب</label>
                            <select class="form-control select2 " name="person_id" required>
                            <option value="" disabled selected>اختر الحساب </option>

                            </select>
                        </div> 

                        
                        <div class="form-group">
                            <label>رصيد الايداع</label>
                            <select class="form-control select2" name="account_id" id="account_id" required="required">
                                <option value="">اختر الرصيد </option>
                                @foreach ($accounts as $account)
                                    @if ($account->id != 1)
                                        <option value="{{ $account->id }}" account="{{$account->account}}"> {{ $account->name }} </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="inputName" class="control-label">المبلغ المدفوع</label>
                            <input type="number" class="form-control" id="amount" name="amount"
                            value="0" min="1" step="1"  title="يرجي ادخال المبلغ المدفوع  " required>
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
                    <h6 class="modal-title">حذف السند</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="{{route('cash-receipts.destroy',1)}}" method="post">
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
        var amount = button.data('amount')
        var type = button.data('type')
        var person_id = button.data('person_id')
        var account_id = button.data('account_id')
        var details = button.data('details')
        var account = button.data('account')
        var user = button.data('user')
        console.log(type)
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #date').val(date);
        modal.find('.modal-body #amount').val(amount);

        modal.find('.modal-body #account_id').val(account_id).trigger('change');
        modal.find('.modal-body #temp').val(person_id);
        modal.find('.modal-body #details').val(details);
        modal.find('.modal-body #account').val(account);
        modal.find('.modal-body #type').val(type).trigger('change');

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

            if(type == 6)
            {
                $('select[name="person_id"]').empty();
                var key = 1;
                var value = "م / محمد";
                $('select[name="person_id"]').append('<option selected value="' +
                                key + '">' + value + '</option>');
            }
        });
    });
</script>


@endsection