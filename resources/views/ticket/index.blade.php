@extends('layouts.master')
@section('css')
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
<link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />
@livewireStyles

@section('title')
    طلبات الإصلاح 
@stop

@section('page-header')
<!-- breadcrumb -->
<div class="breadcrumb-header justify-content-between">
    <div class="my-auto">
        <div class="d-flex">
            <h4 class="content-title mb-0 my-auto">خدمة العملاء</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
            طلبات الإصلاح</span>
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
<div class="row">
    <livewire:ticket />
</div>

<div class="modal" tabindex="-1" id="modaldemo2">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">إنهاء شكوى</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
                <form action="" id="compensationForm" method="post">
                {{ method_field('post') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <h5>تكاليف الشكوى</h5>
                        <div id="compensationsContainer">
                            <div class="row">
                                <div  class="col-4">
                                    <label for="compensation_type">نوع التكلفة</label>
                                    <select class="form-control" name="compensation_type[]" id="compensation_type">
                                        <option disabled selected>اختر نوع</option>
                                        @foreach ($compensationTypes as $compensationType)
                                            <option value="{{ $compensationType->id }}">{{ $compensationType->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-4">
                                    <label for="value">قيمة التكلفة</label>
                                    <input class="form-control" name="value[]" id="value" type="number">
    
                                </div>
                            </div>
                        </div>
                        <div class="row m-2">
                            <button type="button" class="btn btn-sm btn-primary" id="addNewCompensation">اضافة تكلفة جديدة</button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-8">
                                <label for="feedback">حالة الشكوى النهائية</label>
                                <select name="feedback" id="feedback" class="form-control">
                                    <option value="1">تم حل الشكوى</option>
                                    <option value="2">لم يتم حل الشكوى</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-8">
                                <label for="closing_note">ملاحظات انهاء طلب الإصلاح</label>
                                <textarea name="closing_note" id="closing_note" cols="30" rows="5"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-primary">تاكيد</button>
                </div>
        </div>
        </form> 
    </div>
</div>
<div class="modal" tabindex="-1" id="modaldemo3">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content modal-content-demo">
            <div class="modal-header">
                <h6 class="modal-title">إصدار أمر شغل</h6><button aria-label="Close" class="close" data-dismiss="modal"
                    type="button"><span aria-hidden="true">&times;</span></button>
            </div>
                <form action="" id="ticket_employees_form" method="post">
                {{ method_field('post') }}
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <div class="row">
                          <div class="form-group col-12">
                            <label for="employees">القائمين على الشكوي</label>
                            <select required class="form-control select2" multiple="multiple" name="employees[]" id="employees">
                              @foreach($employees as $id => $employee)
                                <option {{-- @if (in_array($id, $ticket->employees->pluck('id')->toArray()))
                                    selected 
                                    
                                @endif --}}value="{{$id}}">{{$employee}}</option>
                              @endforeach
                            </select>
                          </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                    <button type="submit" class="btn btn-primary">تاكيد</button>
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
    $('#modaldemo2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var name = button.data('name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #name').val(name);
        $('#compensationForm').attr('action', '/tickets/compensation/' + id);
    })

    $('#modaldemo3').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var modal = $(this)
        $('#ticket_employees_form').attr('action', '/tickets/employees/' + id);
    })

    $('#printTable').click(function(){
        document.insuranceForm.action = "/print-insurance-table"  
        document.insuranceForm.submit()
    })

    $("#addNewCompensation").on('click',function(){
        $("#compensationsContainer").append(`
        <div class="row">
            <div  class="col-4">
                <label for="compensation_type">نوع التكلفة</label>
                <select class="form-control" name="compensation_type[]" id="compensation_type">
                    <option disabled selected>اختر نوع</option>
                    @foreach ($compensationTypes as $compensationType)
                        <option value="{{ $compensationType->id }}">{{ $compensationType->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-4">
                <label for="value">قيمة التكلفة</label>
                <input class="form-control" name="value[]" id="value" type="number">

            </div>
        
        
        `)
    })
</script>
@endsection