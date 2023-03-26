<?php

namespace App\Http\Livewire;

use App\Models\day as ModelsDay;
use Livewire\Component;

class Day extends Component
{
    public $search = '';

    public function mount($day_id = null)
    {
        if($day_id != null)
        {
            $this->search = $day_id;
        }else{
            $day =  ModelsDay::withTrashed()->latest('id')->first();
            if($day)
                $this->search = $day->id;
        }

    }

    public function render()
    {
        return view('livewire.day', [
            'day' => ModelsDay::withTrashed()->where(function($query){
                $query->where('id',$this->search);
            })->first(),
        ]);
    } 
}
