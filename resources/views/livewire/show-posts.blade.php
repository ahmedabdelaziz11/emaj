<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-header pb-0">
            @can('اضافة منتج')
            <div class="d-flex justify-content-between">
                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                        data-toggle="modal" href="#modaldemo8" style="font-size: 17px;font-weight: bold;">اضافة منتج</a>
            </div>
            @endcan
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label">البحث بالاسم</label>            
                    <input  class="form-control" type="text" wire:model="search"/>
                </div>

                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label">البحث بالمخزن</label>            
                    <select wire:model="selectedStock" class="form-control">
                        <option value="" selected>اختر المخزن</option>
                        @foreach($stocks as $stock)
                            <option value="{{ $stock->id }}">{{ $stock->name }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        <br>
        <br>
            <div class="table-responsive">
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr>
                            <th>رقم المنتج</th>
                            <th>اسم المنتج</th>
                            <th>name</th>
                            <th>الوصف</th>
                            <th>description</th>
                            <th>سعر الشراء</th>
                            <th>سعر البيع</th>
                            <th>الكمية الافتتاحية</th>
                            <th>الكمية</th>
                            <th>المخزن</th>
                            <th>القسم</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $x)
                            <tr>
                                <td><a href="{{ url('products') }}/{{ $x->id }}">{{ $x->id }}</a></td>
                                <td><a href="{{ url('products') }}/{{ $x->id }}">{{ $x->name }}</a></td>
                                <td style="text-align: left;">{{ $x->name_en }}</td>
                                <td><pre style="text-align: right">{!! $x->description !!}</pre>   </td>
                                <td><pre style="text-align: left;">{!! $x->description_en !!}</pre>   </td>
                                <td>{{ number_format($x->Purchasing_price,2) }}</td>
                                <td>{{ number_format($x->selling_price,2) }}</td>
                                <td>{{ number_format($x->start_quantity) }}</td>
                                <td>{{ number_format($x->quantity) }}</td>
                                <td>{{ $x->stock->name }}</td>           
                                <td>{{ $x->section->name }}</td>           
                                <td>
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
                                    data-start_quantity="{{ $x->start_quantity }}"
                                    data-stock_id="{{ $x->stock->id }}"
                                    data-section_name="{{ $x->section_id }}" data-toggle="modal"
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