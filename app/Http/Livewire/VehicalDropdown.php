<?php

namespace App\Http\Livewire;

use Livewire\Component;
use DB;

class VehicalDropdown extends Component
{
    public $post,$vehicalId,$selectStatus;
    public function render()
    {
        return view('livewire.vehical-dropdown');
    }
    public function changeEvent($id)
    {
       $vehicalId=$this->vehicalId;
       $selectStatus=$id;
       DB::table('vehicals')->where('id',$vehicalId)->update(['status'=>$selectStatus]);
       return redirect('admin/vehicle')->with('message', 'Status Changed Successfully!');
    }


}
