<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-header pb-0">
            @can('اضافة منتج')
            <div class="d-flex justify-content-between">
                    <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                        data-toggle="modal" href="#modaldemo8">اضافة المنتج</a>
                
            </div>
            @endcan

        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label"> بحث:</label>            
                    <input  class="form-control" type="text" wire:model="search"/>
                </div>

            </div>
            <br>
            <br>
            <div class="table-responsive">
                <table  class="table key-buttons text-md-nowrap" data-page-length='50'
                    style="text-align: center">
                    <thead>
                        <tr>
                            <th class="border-bottom-0">#</th>
                            <th class="border-bottom-0">رقم المنتج</th>
                            <th class="border-bottom-0">اسم المنتج</th>
                            <th class="border-bottom-0">name</th>
                            <th class="border-bottom-0">الوصف</th>
                            <th class="border-bottom-0">description</th>
                            <th class="border-bottom-0">اسم القسم</th>
                            <th class="border-bottom-0">العمليات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $i = 0; ?>
                        @foreach ($spares as $x)
                            <?php $i++; ?>
                            <tr>
                                <td>{{ $i }}</td>
                                <td>{{ $x->id }}</td>
                                <td>{{ $x->name }}</td>
                                <td style="text-align: left;">{{ $x->name_en }}</td>
                                <td><pre>{!! $x->description !!}</pre>   </td>
                                <td style="text-align: left;"><pre>{!! $x->description_en !!}</pre>   </td>
                                <td>{{ $x->section->section_name }}</td>
                                
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
                    {{ $spares->links('pagination-links') }} 
                </div> 
            </div>
        </div>
    </div>
</div>