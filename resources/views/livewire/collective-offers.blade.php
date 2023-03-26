<div class="col-xl-12">
    <div class="card mg-b-20">
        @can('اضافة عرض')
        <div class="card-header pb-0">
            <div class="d-flex justify-content-between">
                <a href="collective_offers/create" class="modal-effect btn btn-outline-primary btn-block" style="font-size: 16px;font-weight: bold;"><i class="fas fa-plus"></i>&nbsp; اضافة عرض مجمع</a>
            </div>
        </div>
        @endcan

        <div class="card-body">
            <div class="row">
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;"> البحث بالرقم او اسم العرض </label>            
                    <input  class="form-control" type="text" wire:model="name"/>
                </div>
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;">البحث بالعميل</label>            
                    <input  class="form-control" type="text" wire:model="clientName"/>
                </div>
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;"> البحث بالتاريخ من</label>            
                    <input  class="form-control" type="date" wire:model="from_date"/>
                </div>
                <div class="col-md-3">
                    <label for="recipient-name" class="col-form-label" style="font-size: 16px;font-weight: bold;"> البحث بالتاريخ الى</label>            
                    <input  class="form-control" type="date" wire:model="to_date"/>
                </div>
            </div>
        <br>
        <br>
            <div class="table-responsive">
                <table  class="table table-bordered mg-b-0 text-md-nowrap">
                    <thead>
                        <tr class="text-center">
                            <th style="font-size: 16px;">رقم العرض</th>
                            <th style="font-size: 16px;">اسم العرض</th>
                            <th style="font-size: 16px;">التاريخ</th>
                            <th style="font-size: 16px;">اسم العميل</th>
                            <th style="font-size: 16px;">حذف</th>
                        </tr>
                    </thead>
                    <tbody style="font-size: 16px;">
                        @foreach ($offers as $x)
                            <tr>
                                <td class="text-center"><a href="{{ url('collective_offers') }}/{{ $x->id }}">{{ $x->id }}</a></td>
                                <td class="text-center">{{ $x->name }}</td>
                                <td class="text-center">{{ $x->date }}</td>
                                <td>{{ $x->client->client_name }}</td>           
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
                    {{ $offers->links('pagination-links') }} 
                </div>                       
            </div>
        </div>
    </div>
</div>
