@extends('layouts.master')
@section('css')
    <!--- Internal Select2 css-->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{ URL::asset('assets/plugins/fileuploads/css/fileupload.css') }}" rel="stylesheet" type="text/css" />
    <!---Internal Fancy uploader css-->
    <link href="{{ URL::asset('assets/plugins/fancyuploder/fancy_fileupload.css') }}" rel="stylesheet" />
    <!--Internal Sumoselect css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/sumoselect/sumoselect-rtl.css') }}">
    <!--Internal  TelephoneInput css-->
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('assets/plugins/telephoneinput/telephoneinput-rtl.css') }}">
    <style>
  .row label {
  font-size: 20px;
}
</style>
@endsection

@section('title')
اضافة فاتوره شراء
@stop

@section('page-header')
    <!-- breadcrumb -->
    <div class="breadcrumb-header justify-content-between">
        <div class="my-auto">
            <div class="d-flex">
                <h4 class="content-title mb-0 my-auto"><a href="{{ url('/' . $page='receipts') }}">المشتريات</a></h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/
                        اضافه فاتوره </span>
            </div>
        </div>
    </div>
    <!-- breadcrumb -->
@endsection
@section('content')
    <!-- row opened -->
    <div class="row row-sm">
      <div class="col-xl-12">

          <div class="card mg-b-20" id="tabs-style2">
              <div class="card-body">
                <form  action="{!! route('receipts.store') !!}" method="post" autocomplete="off">
                  @csrf
                  <div class="d-flex justify-content-center">
                    <h1>فاتورة شراء</h1>
                  </div>
                  <br>
                  <input type="hidden" name="stock_id" value="" id="stock_id">
                  <div class="row">
                      <div class="col">
                          <label>تاريخ الفاتوره</label>
                          <input class="form-control fc-datepicker" name="date" placeholder="YYYY-MM-DD"
                              type="text" value="{{ date('Y-m-d') }}" required>
                      </div>

                      <div class="col">
                          <label> حساب المورد</label>
                          <select class="form-control select2" name="supplier_id"  required="required">
                            <option value="0" selected disabled>اختر المورد </option>
                            @foreach ($suppliers as $account)
                              <option value="{{ $account->id }}" >{{ $account->name }}</option>
                              @if($account->accounts->count() > 0)
                                @foreach ($account->accounts as $account1)
                                  <option value="{{ $account1->id }}" >{{ $account1->name }}</option>
                                @endforeach
                              @endif
                            @endforeach

                          </select>
                      </div>

                      <div class="col">
                          <label>حساب النقدية</label>
                          <select class="form-control select2" name="account_id" id="account_id"  required="required">
                            <option value="0" selected disabled>اختر الحساب </option>
                            <option value="0">اجل</option>
                            @foreach ($accounts as $account)
                              @if($account->id == 58)
                                <option value="{{ $account->id }}" disabled >{{ $account->name }}</option>
                              @else
                                <option value="{{ $account->id }}" >{{ $account->name }}</option>
                              @endif
                              @if($account->accounts->count() > 0)
                                @foreach ($account->accounts as $account1)
                                  <option value="{{ $account1->id }}" >{{ $account1->name }}</option>
                                @endforeach
                              @endif
                            @endforeach
                          </select>
                      </div>

                      <div class="col">
                          <label>مركز التكلفة</label>
                          <select class="form-control select2" name="cost_id" id="cost_id">
                          <option value="0"selected>اختر المركز</option>

                            @foreach ($costs as $cost)
                              <option value="{{ $cost->id }}" >{{ $cost->name }}</option>
                            @endforeach
                          </select>
                      </div>
                  </div>
                  <hr>
                  <div class="row">
                    <div class="col-3">
                        <label>طلب الشراء</label>
                        <select class="form-control select2" style="font-size:17px;font-weight:bold" name="order_id" id="order_id"  required="required">
                          <option style="font-size:17px;font-weight:bold" value="0" selected disabled>اختر الطلب</option>
                          @foreach ($orders as $order)
                            <option style="font-size:17px;font-weight:bold" value="{{ $order->id }}">{{ $order->id }}</option>
                          @endforeach
                        </select>
                    </div>
                    <div class="form-group col-3">
                        <label>الاجمالى</label>
                        <input class="form-control" style="font-size:17px;font-weight:bold" type="number" step=".01"  name="sub_total" id="sub_total" onchange='updateTotal1();' value="0" min="0" readonly>
                    </div>
                    <div class="col">
                          <label>الفاتورة شاملة القيمة المضافة؟</label>
                          <select style="font-size:17px;font-weight:bold" class="form-control" name="value_add" id="value_add" onchange='updateTotal1();' required="required">
                            <option value="1">نعم</option>
                            <option value="0">لا</option>
                          </select>
                    </div>


                  </div>
                  <div class="row">
                   <div class="form-group col-3">
                      <label>قيمة الخصم بالجنية</label>
                      <input class="form-control" style="font-size:17px;font-weight:bold" type="number" name="discount" step=".01"  id="discount" onchange='updateTotal1();' value="0" min="0">
                    </div>
                    <div class="form-group col-3">
                        <label>الصافى</label>
                        <input class="form-control" style="font-size:17px;font-weight:bold" type="text" name="tem_total" id="tem_total" step=".01"  value="0" min="0" disabled>
                        <input type="hidden" id="total" name="total">
                    </div>
                    <div class="form-group col-6">
                        <label>المبلغ المدفوع</label>
                        <input class="form-control" style="font-size:17px;font-weight:bold" type="number" name="amount_paid" step=".01"  id="amount_paid" value="0" min="0">
                    </div>
                  </div>
                  <br>
                  
                  <button type="submit" class="btn btn-primary w-100 ">اضافة الفاتوره</button>
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
    <!-- Internal Select2 js-->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Fileuploads js-->
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fileuploads/js/file-upload.js') }}"></script>
    <!--Internal Fancy uploader js-->
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.ui.widget.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.iframe-transport.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/jquery.fancy-fileupload.js') }}"></script>
    <script src="{{ URL::asset('assets/plugins/fancyuploder/fancy-uploader.js') }}"></script>
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
  <script src="{{ URL::asset('assets/js/advanced-form-elements.js') }}"></script>

    <script>
        var date = $('.fc-datepicker').datepicker({
            dateFormat: 'yy-mm-dd'
        }).val();
    </script>

<script>
  $(document).ready(function() {   
      $('select[name="order_id"]').on('change', function() {
          var order_id = $(this).val();
          if (order_id) {
              $.ajax({
                  url: "{{ URL::to('order-total') }}/" + order_id,
                  type: "GET",
                  dataType: "json",
                  success: function(data) {
                      document.getElementById('sub_total').value = data.total;
                      document.getElementById('stock_id').value = data.stock_id;
                      updateTotal1();    
                  },
              });
          } else {
              console.log('AJAX load did not work');
          }
      });
  });
</script>

<script>
  $(document).ready(function(){
    document.getElementById("account_id").onchange = function(){
      if(parseFloat(document.getElementById("account_id").value) == 0)
      {
        document.getElementById("amount_paid").readOnly = true;
      }else{
        document.getElementById("amount_paid").readOnly = false;
      }
    };
  });
</script>

<script>
  function updateTotal1() {
    var sub_total = parseFloat( document.getElementById("sub_total").value); 
    var discount = parseFloat(document.getElementById("discount").value);
    var value_add = parseFloat(document.getElementById("value_add").value);
    var total = 0;
    total = sub_total ;
    total -= discount ;
    if(value_add == 1) 
    {
      total = total + (total * 0.14 );
    }
    document.getElementById("total").value = total ;    
    total = new Intl.NumberFormat().format(total);
    document.getElementById("tem_total").value = total ;    

  } 
</script>
@endsection
