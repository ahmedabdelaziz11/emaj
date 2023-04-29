@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@livewireStyles

@section('title')
    الحضور 
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">الحضور</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
            الحضور</span>
        </div>
    </div>
</div>
<!-- breadcrumb -->
@endsection
@section('content')
@if(session()->has('deleted') || count($errors) > 0)
    @if(count($errors) > 0)
        @foreach ($errors->all() as $error)
            <input type="hidden" id="failed[]" name="errors[]" value="{{ $error }}">
        @endforeach
    @endif
    <input type="hidden" id="failed[]" value="{{ Session::get('deleted')}}">

    <script>

        var errors = document.getElementById("failed[]").value;
            window.onload = function() {
                notif({
                msg: errors,
                type: "error"
                })
            }
    </script>
@endif
@if (session()->has('success'))
    <input type="hidden" id="success" value="{{ Session::get('success')}}">
    <script>
        window.onload = function() {
            var success = document.getElementById("success").value;
            notif({    
                msg: success ,
                type: "success"
            })
        }
    </script>
@endif
<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-body">
            <form name="attendanceForm">
                <div class="row">
                    @csrf
                    <div class="form-group col-6">
                        <label>الموظف</label>
                        <select class="form-control form-control-sm select2" name="employee_id" id="employee_id">
                            <option value="" selected disabled>اختر الموظف</option>
                            @foreach($employees as $key => $value)
                                <option value="{{$key}}">{{$value}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-6">
                        <label>التوقيت</label>
                        <input type="datetime-local" name="date" class="form-control" id="date">
                    </div> 
                </div>
            </form>
            <div class="row">
                <div class="d-flex justify-content-between">
                    <button onclick="submitForm('/attendances/checkin','post')" class="btn rounded btn-sm btn-success m-2" type="button">تسجيل حضور</button>
                    <button onclick="submitForm('/attendances','get')"  class="btn rounded btn-sm btn-primary m-2" type="button">بحث</button>
                    <button onclick="submitForm('/attendances/checkout','post')" id="checkOut" class="btn rounded btn-sm btn-danger m-2" type="button">تسجيل انصراف</button>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th>الموظف</th>
                            <th>التاريخ</th>
                            <th>الحضور</th>
                            <th>الانصراف</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($attendances as $attendance)
                            <tr class="text-center">
                                <td>{{ $attendance->employee->name }}</td>
                                <td>{{ $attendance->created_at->diffForHumans() }}</td>                     
                                <td>{{ $attendance->check_in }}</td>                     
                                <td>{{ $attendance->check_out }}</td>        
                                <td>
                                    <a class="modal-effect btn btn-sm btn-warning" 
                                        href="#" title="تعديل"> <i class="las la-eye"></i> 
                                    </a>
                                    <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                        data-id="{{ $attendance->id }}" data-name="{{ $attendance->employee->name }}"
                                        data-toggle="modal" href="#modaldemo9" title="حذف"><i class="las la-trash"></i>
                                    </a>
                                </td>        
                            </tr>
                        @endforeach
                    </tbody>
                </table>    
                <div class="row d-felx justify-content-center">
                    {{ $attendances->links('pagination-links') }} 
                </div>                       
            </div>
        </div>
    </div>
</div>




<!-- delete -->
<div class="modal" tabindex="-1" id="modaldemo9">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">حذف الحضور</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
                <form action="insurances/destroy" method="post">
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

<!-- Container closed -->
</div>
<!-- main-content closed -->
@endsection
@section('js')
@livewireScripts
<!-- Internal Data tables -->
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
<script>
    
    function submitForm(url,method)
    {
        var employee_id = $('#employee_id').val();
        var date = $('#date').val();

        document.attendanceForm.action = `${url}/${employee_id}/${date}`  
        document.attendanceForm.setAttribute("method", method);
        document.attendanceForm.submit()
    }
</script>

@endsection