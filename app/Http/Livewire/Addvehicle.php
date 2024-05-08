<?php

namespace App\Http\Livewire;
use App\Models\Type;
use App\Models\Driverresponsible;
use App\Models\Vehical;
use App\Models\Driver;



use Livewire\Component;

class Addvehicle extends Component
{
     public $selectType,$rego,$odometer,$model,$driverResponsible,$vehicleControl,$regoDate,$servicesDue,$inspenctionDue;
    public function render()
    {
        $data['type']=Type::get();
 $data['Driverresponsible']=Driver::get();
 return view('livewire.addvehicle',$data);
    }

    public function submit(){
        echo "ok"; die;
        $selectType=$this->selectType;
        $rego=$this->rego;
        $odometer=$this->odometer;
        $model=$this->model;
        $driverResponsible=$this->driverResponsible;
        $vehicleControl=$this->vehicleControl;
        $regoDate=$this->regoDate;
        $servicesDue=$this->servicesDue;
        $inspenctionDue=$this->inspenctionDue;

        Vehical::create([
                        'vehicalType'   => $selectType,
                        'rego'           => $rego,
                        'odometer'        => $odometer,
                        'modelName'       =>$model,
                        'driverResponsible' => $driverResponsible,
                        'controlVehicle' => $vehicleControl,
                        'regoDueDate'     => $regoDate,
                        'serviceDueDate'   => $servicesDue,
                        'inspectionDueDate' => $inspenctionDue,
                        ]);

        return redirect('admin/vehicle')->with('message', 'Vehical Updated Successfully!');
        // session()->flash('message', 'Post successfully updated.');
                    }
}
