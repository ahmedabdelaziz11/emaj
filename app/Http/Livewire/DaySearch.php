<?php

namespace App\Http\Livewire;

use App\Models\AllAccount;
use App\Models\day;
use Livewire\Component;

class DaySearch extends Component
{
    public $date = '';
    public $note = '';
    public $from_date = '';
    public $to_date = '';
    public $debt_account = '';
    public $credit_account = '';

    public function render()
    {
        return view('livewire.day-search',[

            'days' => day::when($this->date,function($q){
                    $q->where('date',$this->date);

                })->when($this->note,function($q){
                    $q->where('note','like','%'.$this->note.'%');

                })->when($this->from_date,function($q){
                    $q->where('date','>=',$this->from_date);

                })->when($this->to_date,function($q){
                    $q->where('date','<=',$this->to_date);

                })->when($this->debt_account,function($q){
                    $q->whereHas('day2',function($q){
                        $q->where('debit','!=',0)->where('account_id',$this->debt_account);
                    });

                })->when($this->credit_account,function($q){
                    $q->whereHas('day2',function($q){
                        $q->where('credit','!=',0)->where('account_id',$this->credit_account);
                    });
            })->orderBy('date','asc')->paginate(150),

            'accounts' => AllAccount::all(),
        ]);


    }
}
