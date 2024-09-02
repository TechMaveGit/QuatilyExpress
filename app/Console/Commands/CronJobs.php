<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\WebSiteMail;
use App\Models\Driver;
use App\Models\Vehical;
use Carbon\Carbon;

class CronJobs extends Command
{
    protected $signature = 'reminders:send';
    protected $description = 'Send reminder emails for document expirations';

    public function handle()
    {
        $settings = DB::table('settings')->where('main_keyword', 'reminder')->get()->pluck('meta_value', 'meta_key')->toArray();

        foreach ($settings as $type => $days) {
        
            if (in_array($type, ['days_before_passport_expire', 'days_before_visa_expire', 'days_before_police_certificate_expire', 'days_before_driver_license_expire'])) {
                $user = $this->getUsersWithExpiringDocuments($type, $days);
                
                if ($user) {
                    foreach ($user['data'] as $driver) {
                        if($type == 'days_before_passport_expire'){
                            $exDate = $driver->traffic_history_expiry_date;
                         }elseif($type == 'days_before_visa_expire'){
                            $exDate = $driver->visa_expiry_date;
                         }elseif($type == 'days_before_police_certificate_expire'){
                            $exDate = $driver->police_chceck_expiry_date;
                         }elseif($type == 'days_before_driver_license_expire'){
                            $exDate = $driver->driving_date_expiry_date;
                         }else{
                            $exDate = null;
                         }
                        if($driver &&  $exDate){
                            Mail::to($driver->email)->send(new WebSiteMail('expirec_docs', "{$user['doc_name']} Document Expired | Quality Express", ['DOCUMENT_NAME' => $user['doc_name'], 'EXPIRED_DATE' => $exDate]));
                        }
                    }
                }
            } elseif (in_array($type, ['days_before_rego_due_date', 'days_before_service_due_date', 'days_before_insepction_due_date'])) {
                $data = $this->getUsersWithVehecleExpiringDocuments($type, $days);
                if($type == 'days_before_rego_due_date'){
                    $docName = 'Rego';
                    $metaKry = 'expirec_rego';
                }elseif($type == 'days_before_service_due_date'){
                    $docName = 'Service';
                    $metaKry = 'expirec_service';
                }else{
                    $docName = 'Inspection';
                    $metaKry = 'expirec_inspection';
                }
                if($data){
                    foreach ($data as $user) {
                        $htmlData = '';
                        if(isset($user['regoData'])){
                            foreach ($user['regoData'] as $rego) {
                                if($type == 'days_before_rego_due_date'){
                                    $dueDate = $rego->regoDueDate;
                                }elseif($type == 'days_before_service_due_date'){
                                    $dueDate = $rego->serviceDueDate;
                                }else{
                                    $dueDate = $rego->inspectionDueDate;
                                }                
                                $htmlData .= '<li> <b>Rego</b> :'.$rego->rego.'  | <b>Due Dates</b> :'.$dueDate.'</li>';
                            }
                        }
                        Mail::to($user['email'])->send(new WebSiteMail($metaKry, "Vehicles $docName Document Expired | Quality Express", ['LIST_VEHICLES' => $htmlData]));
                    }

                }
            }
        }

        $this->info('Reminder emails have been sent.');
        return 0;
    }

    private function getUsersWithExpiringDocuments($type, $days)
    {
        $today = Carbon::now();
        $expirationDate = $today->copy()->addDays($days)->format('Y-m-d');

        if ($type == 'days_before_passport_expire') {
            $driverData = Driver::whereNotNull('traffic_history_expiry_date')->whereDate('traffic_history_expiry_date', '<=', $expirationDate)->get();
            return $driverData ? ['data' => $driverData,'doc_name' => 'Traffic History'] : null;
        } else if ($type == 'days_before_visa_expire') {
            $driverData = Driver::whereNotNull('visa_expiry_date')->whereDate('visa_expiry_date', '<=', $expirationDate)->get();
            return $driverData ? ['data' => $driverData, 'doc_name' => 'Visa'] : null;
        } else if ($type == 'days_before_police_certificate_expire') {
            $driverData = Driver::whereNotNull('police_chceck_expiry_date')->whereDate('police_chceck_expiry_date', '<=', $expirationDate)->get();
            return $driverData ? ['data' => $driverData, 'doc_name' => 'Police Check'] : null;
        } else if ($type == 'days_before_driver_license_expire') {
            $driverData = Driver::whereNotNull('driving_date_expiry_date')->whereDate('driving_date_expiry_date', '<=', $expirationDate)->get();
            return $driverData ? ['data' => $driverData,'doc_name' => 'Driver License'] : null;
        } else {
            return null;
        }
    }

    private function getUsersWithVehecleExpiringDocuments($type, $days)
    {
        $today = Carbon::now();
        $expirationDate = $today->copy()->addDays($days)->format('Y-m-d');

        $today = Carbon::now();
        $expirationDate = $today->copy()->addDays($days)->format('Y-m-d');

        if ($type == 'days_before_rego_due_date') {
            $vehicles = Vehical::with('getDriverRsp')
                ->has('getDriverRsp')
                ->whereNotNull('regoDueDate')
                ->whereDate('regoDueDate', '<=', $expirationDate)
                ->get();

            $groupedData = $vehicles->groupBy(function ($item, $key) {
                return $item->getDriverRsp->id; // Group by driver ID
            });

            $result = [];
            foreach ($groupedData as $driverId => $vehicles) {
                $driver = $vehicles->first()->getDriverRsp;
                $result[] = [
                    'email' => $driver->email,
                    'name' => $driver->fullName,
                    'expiry_dates' => $vehicles->pluck('regoDueDate')->all(),
                    'regoData' => $vehicles->all()
                ];
            }

            return $result;
        } else if ($type == 'days_before_service_due_date') {
            $vehicles = Vehical::with('getDriverRsp')
                ->has('getDriverRsp')
                ->whereNotNull('serviceDueDate')
                ->whereDate('serviceDueDate', '<=', $expirationDate)
                ->get();

            $groupedData = $vehicles->groupBy(function ($item, $key) {
                return $item->getDriverRsp->id; // Group by driver ID
            });

            $result = [];
            foreach ($groupedData as $driverId => $vehicles) {
                $driver = $vehicles->first()->getDriverRsp;
                $result[] = [
                    'email' => $driver->email,
                    'name' => $driver->fullName,
                    'expiry_dates' => $vehicles->pluck('serviceDueDate')->all(),
                    'regoData' => $vehicles->all()
                ];
            }

            return $result;
        } else if ($type == 'days_before_insepction_due_date') {
            $vehicles = Vehical::with('getDriverRsp')
                ->has('getDriverRsp')
                ->whereNotNull('inspectionDueDate')
                ->whereDate('inspectionDueDate', '<=', $expirationDate)
                ->get();

            $groupedData = $vehicles->groupBy(function ($item, $key) {
                return $item->getDriverRsp->id; // Group by driver ID
            });

            $result = [];
            foreach ($groupedData as $driverId => $vehicles) {
                $driver = $vehicles->first()->getDriverRsp;
                $result[] = [
                    'email' => $driver->email,
                    'name' => $driver->fullName,
                    'expiry_dates' => $vehicles->pluck('inspectionDueDate')->all(),
                    'regoData' => $vehicles->all()
                ];
            }

            return $result;
        }
    }
}
