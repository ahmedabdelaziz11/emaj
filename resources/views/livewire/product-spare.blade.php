<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                    <a  class="modal-effect btn btn-outline-primary btn-block"
                        href="product-spare/create" style="font-size: 17px;font-weight: bold;">اضافة قطع غيار لمنتج</a>
            </div>
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
                            <th>قطع الغيار</th>
                            <th>المخزن</th>
                            <th>العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($products as $x)
                            <tr class="text-center">
                                <td><a href="{{ url('products') }}/{{ $x->id }}">{{ $x->name }}</a></td>
                                <td class="text-right"> 
                                    @foreach($x->spares as $product)
                                        <ul>
                                            <a href="{{ url('products') }}/{{ $product->id }}">{{$product->name}}</a>
                                        </ul>
                                    @endforeach
                                </td>                     
                                <td>   {{ $x->stock->name }}</td>        
                                <td>
                                    <a class="btn btn-sm btn-info"
                                        href="/product-spare/{{$x->id}}/edit" title="تعديل"> <i class="las la-pen"></i> 
                                    </a>
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