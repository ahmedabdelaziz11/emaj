<div class="col-xl-12">
    <div class="card mg-b-20">

        <div class="card-header pb-0">
            @can('اضافة منتج')
            <div class="d-flex justify-content-between">
                    <a  class="modal-effect btn btn-outline-primary btn-block"
                        href="composite-products/create" style="font-size: 17px;font-weight: bold;">اضافة منتج</a>
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
            <div class="table-responsive">
                <table class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th>الاسم</th>
                            <th>الوصف</th>
                            <th>المكونات</th>
                            <th>سعر التكلفة الحالى</th>
                            <th>سعر البيع</th>
                            <th>المخزن</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $x)
                            <tr class="text-center">
                                <td><a href="{{ url('composite-products') }}/{{ $x->id }}">{{ $x->name }}</a></td>
                                <td>    <pre style="text-align: right">{!! $x->description !!}</pre>   </td>        
                                <td class="text-right"> 
                                    @foreach($x->products as $product)
                                        <ul>
                                        <a href="{{ url('products') }}/{{ $product->id }}">{{$product->name}}  ({{$product->pivot->quantity}}) </a>
                                        </ul>
                                    @endforeach
                                </td>        
                                <td>   {{ number_format($x->cost(),2) }} </td>        
                                <td>   {{ number_format($x->selling_price,2) }}  </td>        
                                <td>   {{ $x->stock->name }}</td>        
                                <td>
                                    @can('حذف منتج')
                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                            data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                            data-toggle="modal" href="#modaldemo9" title="حذف"><i class="las la-trash"></i>
                                        </a>
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