<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label"> بحث:</label>            
                    <input  class="form-control" type="text" wire:model="search"/>
                </div>

                <div class="col-md-8">
                    <h6 class="modal-title text-primary" style="padding-top:25px ; float: left; font-size: 35px; "> اجمالى المخزون : {{number_format(\App\Models\products::select(DB::raw('sum(Purchasing_price * quantity  ) as total'))->value('total')) }}</h6>
                </div>

            </div>
        <br>
        <br>
            <div class="table-responsive">
            <table class="table table-invoice border text-md-nowrap mb-0">
                <thead>
                    <tr>
                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكود</th>
                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الاسم</th>
                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">سعر الشراء</th>
                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">سعر البيع</th>
                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكمية الافتتاحية</th>
                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">الكمية الحالية</th>
                        <th style="font-size: 17px;font-weight: bold;  border: 1px solid rgb(177, 170, 170);color: black;" class="tx-center">العمليات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($products as $x)
                        <tr>
                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->id }}</td>
                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ $x->name }}</td>
                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($x->Purchasing_price) }}</td>
                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($x->selling_price) }}</td>
                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($x->start_quantity) }}</td>
                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">{{ number_format($x->quantity) }}</td>
                            
                            <td class="text-center" style="font-size: 17px;font-weight: bold;border: 1px solid rgb(177, 170, 170);">
                                @can('تعديل منتج')

                                <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                data-id="{{ $x->id }}" 
                                data-name="{{ $x->name }}"
                                data-name_en="{{ $x->name_en }}"
                                data-x="{{ $x->Purchasing_price }}"
                                data-description="{{  $x->description  }}"
                                data-description_en="{{  $x->description_en  }}"
                                data-Purchasing="{{ $x->Purchasing_price}}"
                                data-selling_price="{{ $x->selling_price}}"
                                data-Purchasing_price="{{ $x->Purchasing_price}}"
                                data-quantity="{{ $x->start_quantity }}"
                                data-section_name="{{ $x->section->id }}" data-toggle="modal"
                                href="#exampleModal2" title="تعديل"> <i class="las la-pen"></i> </a>
                                @endcan

                                @can('حذف منتج')
                            <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                data-toggle="modal" href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>
                                @endcan
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table> 
            <div class="row d-felx justify-content-center">
                {{ $products->links('pagination-links') }} 
            </div>                       
            </div>
        </div>
    </div>
</div>