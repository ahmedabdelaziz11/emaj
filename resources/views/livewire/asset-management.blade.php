<div class="col-xl-12">
    <div class="card mg-b-20">
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                 
                            
                <a data-effect="effect-scale" data-toggle="modal" href="#modaldemo8" class="modal-effect btn btn-outline-primary btn-block" style="font-size: 16px;font-weight: bold;"><i class="fas fa-plus"></i>&nbsp; اضافة صنف</a>
            </div>
        </div>

        <div class="card-body">
            <div class="row">
                <div class="col">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;"> البحث بالرقم او اسم الصنف </label>            
                    <input  class="form-control" type="text" wire:model="name"/>
                </div>
                <div class="col">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;">البحث باسم الحساب الرئيسي</label>            
                    <input  class="form-control" type="text" wire:model="parentAccount"/>
                </div>
                <div class="col">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;"> البحث بتاريخ الشراء من</label>            
                    <input  class="form-control" type="date" wire:model="from_date"/>
                </div>

                <div class="col">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;"> البحث بتاريخ الشراء الى</label>            
                    <input  class="form-control" type="date" wire:model="to_date"/>
                </div>
            </div>
            <br>
            <div class="row">
                <div class="col">
                    <a class="btn btn-sm btn-primary" href="show-mokhss-elahlak" style="font-size: 16px">مخصص الاهلاك</a>
                </div>
            </div>
        <br>
            <div class="table-responsive">
                <table  class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th style="font-size: 16px;">اسم الصنف</th>
                            <th style="font-size: 16px;">تاريخ الشراء</th>
                            <th style="font-size: 16px;">سعر الشراء</th>
                            <th style="font-size: 16px;">الكمية</th>
                            <th style="font-size: 16px;">نسبة مخصص الاهلاك</th>
                            <th style="font-size: 16px;">الحساب الرئيسى</th>
                            <th style="font-size: 16px;">حذف</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 16px;">
                        @foreach ($assets as $x)
                            <tr>
                                <td class="text-center"><a href="{{ url('asset-management') }}/{{ $x->id }}">{{ $x->account->name }}</a></td>
                                <td class="text-center">{{ $x->date }}</td>
                                <td class="text-center">{{ $x->price }}</td>
                                <td>{{ $x->quantity }}</td>           
                                <td>{{ $x->mokhss_elahlak }}</td>           
                                <td>{{ $x->account->parentAcount->name }}</td>           
                                <td class="text-center">
                                @can('حذف عرض')
                                <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                    data-id="{{ $x->id }}" data-name="{{ $x->name }}"
                                    data-toggle="modal" href="#modaldemo9" title="حذف"><i class="las la-trash"></i></a>
                                </td>
                                @endcan
                            </tr>
                        @endforeach
                    </tbody>
                </table>    <br>
                <div class="row d-felx justify-content-center">
                    {{ $assets->links('pagination-links') }} 
                </div>                       
            </div>
        </div>
    </div>
</div>
