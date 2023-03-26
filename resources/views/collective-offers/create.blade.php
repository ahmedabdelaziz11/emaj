@extends('layouts.master')

@section('css')
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <link href="{{ URL::asset('assets/plugins/notify/css/notifIt.css') }}" rel="stylesheet" />

@endsection

@section('title')
    اضافة عرض مجمع 
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='collective_offers') }}">العروض المجمعه</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                  اضافة عرض مجمع</span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
<input type="hidden" id="mss" value="{{ Session::get('mss')}}">


@if ($errors->any())
    <script>
        window.onload = function() {
            notif({
                msg:" فشلت الاضافة اسم العرض مكرر ",
                type: "error"
            })
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

    <!-- row opened -->
    <div class="row row-sm">

      <div class="col-xl-12">
          <!-- div -->
          <div class="card mg-b-20" id="tabs-style2">
              <div class="card-body">

                  <form  action="{!! route('collective_offers.store') !!}" method="post" autocomplete="off">
                      @csrf

                      <div class="d-flex justify-content-center">
                        <h1>اضافة عرض مجمع</h1>
                      </div><br>

                      <div class="row">
                          <div class="col-3">
                              <label for="inputName" class="control-label">اسم العرض</label>
                              <input type="text" class="form-control"  name="name" title="يرجي ادخال اسم العرض " required>
                          </div>
                          <div class="col-3">
                              <label for="inputName" class="control-label">التاريخ</label>
                              <input type="date" class="form-control"  name="date" required>
                          </div>
                          <div class="col-3">
                            <label for="inputName" class="control-label"> اختر العميل</label>
                            <select class="form-control select2 " name="client_id" required="required">
                              <option value="">اختر العميل </option>
                              @foreach ($clients as $client)
                                <option value="{{ $client->id }}">{{ $client->client_name }}</option>
                              @endforeach
                            </select>
                          </div>
                          <div class="col-3">
                            <label for="inputName" class="control-label"> اختر الفواتير</label>
                            <select class="form-control select2" name="invoices[]" multiple required="required">
                              <option value="">اختر الفواتير</option>
                              @foreach ($invoices as $i)
                                <option value="{{ $i->id }}">{{ $i->id }}</option>
                              @endforeach
                            </select>
                          </div>
                      </div> 
                      <br>
                      
                      <div class="row">
                        <div class="col">
                          <label for="inputName" class="control-label"> نسبه الخصم (%)</label>
                          <input  type="number" step=".01" class="form-control" id="discount" name="discount"
                          value="0" min="0" max="100" title="يرجي ادخال اسم نسبة الخصم  " required>
                        </div>
                        <div class="col">
                                <label>العرض شاملة القيمة المضافة؟</label>
                                <select style="font-size:17px;font-weight:bold" class="form-control" name="value_add" required="required">
                                  <option value="1">نعم</option>
                                  <option value="0"selected>لا</option>
                                </select>
                          </div>
                    </div><br>

                      <button type="submit" class="btn btn-primary w-100 ">اضافة المنتج</button>
                    </form>
              </div>
          </div>
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
<script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>
<script src="{{ URL::asset('assets/js/select2.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/sumoselect/jquery.sumoselect.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
<script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>
<script>$(".select2").select2({placeholder:"Choose product",theme: "classic"});</script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifIt.js') }}"></script>
<script src="{{ URL::asset('assets/plugins/notify/js/notifit-custom.js') }}"></script>



@endsection
