
<div>     
        <div class="row mg-t-20">
            <div class="col-md">

                    
                @if(isset($day) && $day->trashed())                 
                    <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>الحالة</span>  <span class="text-danger">محذوف</span></p>
                @endif
                <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>تاريخ السند</span> <span>{{$day->date ?? ''}}</span></p>
                <a href="#" class="btn btn-info float-left mt-3 mr-2" id="print_Button4" onclick="printDiv()"><i class="mdi mdi-printer ml-1"></i>Print</a>
                
                @if(isset($day) && !$day->trashed() )
                    @can('حذف قيد')
                    <a href="#modaldemo9" data-toggle="modal" data-effect="effect-scale" class="btn btn-danger float-left mt-3 mr-2"id="print_Button5"><i class="las la-trash"></i>حذف</a>
                    @endcan
                    

                
                @elseif(isset($day) && $day->trashed())
                    @can('استرجاع قيد')
                    <a href="#modaldemo10" data-toggle="modal" data-effect="effect-scale" class="btn btn-danger float-left mt-3 mr-2"id="print_Button3">
                        <i class="fas fa-undo-alt"></i>استرجاع
                    </a>
                    @endcan
                @endif
                @if(isset($day))
                    @can('تعديل قيد')
                        <a href="{{route('days.edit',$day->id)}}" class="btn btn-success float-left mt-3 mr-2" id="print_Button2"><i class="las la-pen"></i>تعديل</a>
                    @endcan
                @endif
                @can('اضافة قيد')
                <a href="{{route('days.create')}}" class="btn btn-primary float-left mt-3 mr-2" id="print_Button1">
                        <i class="fas fa-plus"></i>اضافة
                </a>
                @endcan

    
            </div>
            <div class="col-md">
                <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>رقم القيد</span> <span> <span id="day_id_for_show" style="display: none;">{{$day->id ?? ''}} </span>  <input id="print_Button" class="form-control" value="{{$day->id ?? ''}}" type="number" wire:model="search"/></span></p>
    @if(isset($day))    
    <!-- delete -->
        <div class="modal" id="modaldemo9">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف القيد</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{route('days.destroy',$day->id)}}" method="post">
                        {{ method_field('delete') }}
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="hidden" name="day_id" value="{{$day->id}}">
                            <p class="text-danger text-bold" style="font-size: 20px;font-weight: bold;margin-top: 15px;">هل انت متاكد من عملية الحذف ؟</p><br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
        <div class="modal" id="modaldemo10">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">حذف القيد</h6><button aria-label="Close" class="close" data-dismiss="modal"
                            type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form action="{{route('return-day')}}" method="post">
                        {{ csrf_field() }}
                        <div class="modal-body">
                            <input type="hidden" name="day_id" value="{{$day->id}}">
                            <p class="text-danger text-bold" style="font-size: 20px;font-weight: bold;margin-top: 15px;">هل انت متاكد من عملية الاسترجاع ؟</p><br>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                            <button type="submit" class="btn btn-danger">تاكيد</button>
                        </div>
                </div>
                </form>
            </div>
        </div>
                <p class="invoice-info-row"style="font-size: 17px;font-weight: bold"><span>البيان</span> 
                <span>
                    @if(isset($day) && $day->type == 1 && !$day->trashed() )
                        <a href="{{ url('ReceiptDetails') }}/{{ $day->type_id }}">{{$day->note ?? 'اصل القيد'}}</a>
                    @elseif(isset($day) && $day->type == 3 && !$day->trashed() )
                        <a href="{{ url('InvoiceDetails') }}/{{ $day->type_id }}">{{$day->note ?? 'اصل القيد'}}</a>
                    @elseif(isset($day) && $day->type == 4 && !$day->trashed() )
                        <a href="{{ url('InvoiceDetails_s') }}/{{ $day->type_id }}">{{$day->note ?? 'اصل القيد'}}</a>
                    @elseif(isset($day) && $day->type == 2 && !$day->trashed() )
                        <a href="{{ url('ReceiptDetails_s') }}/{{ $day->type_id }}">{{$day->note ?? 'اصل القيد'}}</a>
                    @elseif(isset($day) && $day->type == 6 && !$day->trashed() )
                        <a href="{{ url('returned-receipts') }}/{{ $day->type_id }}">{{$day->note ?? 'اصل القيد'}}</a>
                    @elseif(isset($day) && $day->type == 5 && !$day->trashed() )
                        <a href="{{ url('returned_invoices') }}/{{ $day->type_id }}">{{$day->note ?? 'اصل القيد'}}</a>
                    @else
                        {{$day->note ?? ''}}
                    @endif  
                </span></p>
            </div>
        </div>
        <input type="hidden" name="day_id" id="day_id" value="0">
        <div class="table-responsive mg-t-40">   
            <table class="table table-invoice border text-md-nowrap mb-0">
                <thead>
                    <tr>
                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">كود الحساب</th>
                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center"> اسم الحساب</th>
                        <th style="font-size: 17px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">البيان</th>
                        <th style="font-size: 17px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">مدين</th>
                        <th style="font-size: 17px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">دائن</th>
                        <th style="font-size: 17px;font-weight: bold; border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">مركز التكللفة</th>
                    </tr>
                </thead>
                <tbody>
                    @php 
                        $total_debit = $total_credit = 0;
                    @endphp
                    @foreach($day->day2 as $x)
                        @php
                            $total_debit += $x->debit ;
                            $total_credit += $x->credit;
                        @endphp
                        <tr>
                            <td class="text-center" style="font-size: 17px;font-weight: 100;border: 1px solid rgb(177, 170, 170);">{{ $x->account->code }}</td>
                            <td class="text-center" style="font-size: 17px;font-weight: 100;border: 1px solid rgb(177, 170, 170);">{{ $x->account->name }}</td>
                            <td class="text-center" style="font-size: 17px;font-weight: 100;border: 1px solid rgb(177, 170, 170);">{{ $x->note }}</td>
                            <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x->debit,2)}}</td>
                            <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{number_format($x->credit,2)}}</td>
                            <td style="text-align: center;font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{$x->cost->name ?? 'لا يوجد'}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div class="table-responsive mg-t-40">
                <table  class="table table-invoice border text-md-nowrap mb-0">
                    <tbody class="border border-light tx-right">
                        <tr>
                            <th style=" font-size: 23px;font-weight: bold" class="tx-right" colspan="3"> اجمالي المدين</th>
                            <th style="font-size: 25px" class="tx-right" >{{ number_format($total_debit,2) }}</th>
                        </tr>
                        <tr>
                            <th style=" font-size: 23px;font-weight: bold" class="tx-right" colspan="3"> اجمالي الدائن</th>
                            <th style="font-size: 25px" class="tx-right">{{ number_format($total_credit,2) }}</th>
                        </tr>
                        <tr class="border border-light tx-right">
                            <th style=" font-size: 23px;font-weight: bold" class="tx-right" colspan="3" >الفرق</th>
                            <th style="font-size: 25px" class="tx-right">{{ number_format($total_debit - $total_credit,2) }}</th>
                        </tr>
                        <tr>
                            <th style="border: none; font-size: 24px; padding-right: 150px;padding-bottom: 40px" class="tx-right">توقيع المحاسب</th>
                            <th style="border: none; font-size: 25px" class="tx-right" colspan="2">توقيع المدير المالى</th>
                            <th style="border: none; font-size: 25px" class="tx-right" colspan="2">توقيع المدير العام</th>
                        </tr>

                        <tr>
                            <th style="border: none; font-size: 27px;font-weight: bold" class="tx-right"></th>
                            <th style="border: none; font-size: 25px" class="tx-right" colspan="2"></th>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
</div>


@endif 



