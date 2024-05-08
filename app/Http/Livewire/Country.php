<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Type;
use App\Models\Driverresponsible;

class AddVehical extends Component
{
    public function render()
    {
        $data['type']=Type::get();
        $data['Driverresponsible']=Driverresponsible::get();
        return view('livewire.country',$data);
    }

}
