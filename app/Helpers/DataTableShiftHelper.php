<?php

namespace App\Helpers;

use Auth;
use DB;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class DataTableShiftHelper
{
    public static function getData(Request $request, Builder $query, array $columnMapping, string $pageStr)
    {

        $columns = array_column($request->input('columns'), 'data');
        $columnData = $request->input('columns');
        $totalDataQuery = clone $query;
        $totalData = $totalDataQuery->count();

        $limit = $request->input('length');
        $start = $request->input('start');
        $orderColumnIndex = $request->input('order.0.column') ?? 'id';
        $orderDirection = $request->input('order.0.dir') ?? 'DESC';

        // dd($request->all() );

        // Apply search filter
        $searchValue = $request->input('search.value');
        if (!empty($searchValue) && isset($columnMapping['Client'])) {
            $clientColumnPath = $columnMapping['Client'];
            $clientColumnParts = explode('.', $clientColumnPath);
            $clientColumnName = preg_replace('/\.(.*)/', '', end($clientColumnParts));

            if (count($clientColumnParts) > 1) {
                $clientRelation = implode('.', array_slice($clientColumnParts, 0, -1));
                $query->orWhereHas($clientRelation, function ($query) use ($clientColumnName, $searchValue) {
                    $query->where($clientColumnName, 'LIKE', '%' . $searchValue . '%');
                });
            } else {
                $query->orWhere($clientColumnName, 'LIKE', '%' . $searchValue . '%');
            }
        }

        // Apply search filter
        $searchValue = $request->input('search.value');
        if (!empty($searchValue) && isset($columnMapping['Driver'])) {
            $clientColumnPath = $columnMapping['Driver'];
            $clientColumnParts = explode('.', $clientColumnPath);
            $clientColumnName = preg_replace('/\.(.*)/', '', end($clientColumnParts));

            if (count($clientColumnParts) > 1) {
                $clientRelation = implode('.', array_slice($clientColumnParts, 0, -1));
                $query->orWhereHas($clientRelation, function ($query) use ($clientColumnName, $searchValue) {
                    $query->where($clientColumnName, 'LIKE', '%' . $searchValue . '%');
                });
            } else {
                $query->orWhere($clientColumnName, 'LIKE', '%' . $searchValue . '%');
            }
        }

        // Apply search filter
        $searchValue = $request->input('search.value');
        if (!empty($searchValue) && isset($columnMapping['Vehicle Type'])) {
            $clientColumnPath = $columnMapping['Vehicle Type'];
            $clientColumnParts = explode('.', $clientColumnPath);
            $clientColumnName = preg_replace('/\.(.*)/', '', end($clientColumnParts));

            if (count($clientColumnParts) > 1) {
                $clientRelation = implode('.', array_slice($clientColumnParts, 0, -1));
                $query->orWhereHas($clientRelation, function ($query) use ($clientColumnName, $searchValue) {
                    $query->where($clientColumnName, 'LIKE', '%' . $searchValue . '%');
                });
            } else {
                $query->orWhere($clientColumnName, 'LIKE', '%' . $searchValue . '%');
            }
        }

        // Apply search filter
        $searchValue = $request->input('search.value');
        if (!empty($searchValue) && isset($columnMapping['State'])) {
            $clientColumnPath = $columnMapping['State'];
            $clientColumnParts = explode('.', $clientColumnPath);
            $clientColumnName = preg_replace('/\.(.*)/', '', end($clientColumnParts));

            if (count($clientColumnParts) > 1) {
                $clientRelation = implode('.', array_slice($clientColumnParts, 0, -1));
                $query->orWhereHas($clientRelation, function ($query) use ($clientColumnName, $searchValue) {
                    $query->where($clientColumnName, 'LIKE', '%' . $searchValue . '%');
                });
            } else {
                $query->orWhere($clientColumnName, 'LIKE', '%' . $searchValue . '%');
            }
        }

        if ($columns) {
            foreach ($columns as $kk => $col) {
                if (isset($columnData[$kk]['search']['value']) && $columnData[$kk]['search']['value'] !== null) {
                    $query->Where($columnMapping[$col], $columnData[$kk]['search']['value']);
                }
            }
        }

        $totalFiltered = $query->count();

        // Order by column
        $orderColumn = $columns[$orderColumnIndex];
        $query->orderBy('id', 'DESC');

        // Fetch data
        $data = $query->offset($start)
            ->limit($limit)
            ->get();

        $formattedData = [];
        if ($pageStr == 'shift_table') {
            $formattedData = self::userData($data, $columns, $columnMapping);
        }

        // Prepare JSON response
        $json_data = [
            'draw' => intval($request->input('draw')),
            'recordsTotal' => intval($totalData),
            'recordsFiltered' => intval($totalFiltered),
            'data' => $formattedData,
        ];

        return response()->json($json_data);
    }

    // Helper function to get nested property
    private static function getNestedProperty($item, $property)
    {
        $nestedProperties = explode('.', $property);
        $value = $item;
        foreach ($nestedProperties as $nestedProperty) {
            if (is_array($value) && array_key_exists($nestedProperty, $value)) {
                $value = $value[$nestedProperty];
            } elseif (is_object($value) && isset($value->{$nestedProperty})) {
                $value = $value->{$nestedProperty};
            } else {
                return '';
            }
        }

        return $value;
    }

    // private static function clientData($items, $columns, $columnMapping)
    // {
    //     $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()),true);
    //     $arr = [];
    //     foreach($D as $v)
    //     {
    //         $arr[] = $v['permission_id'];
    //     }

    //     $formattedData = [];
    //     foreach ($items as $item) {
    //         $nestedData = [];
    //         foreach ($columns as $column) {
    //             $actualColumnName = $columnMapping[$column] ?? $column;
    //             $newNColumn = self::getNestedProperty($item, $actualColumnName);

    //             $nestedData[$column] = $newNColumn;

    //             $tdHtml = '';

    //             if($column == "Status"){
    //                 $tableId = $nestedData['id'];
    //                 $tdHtml = '<div class="form-group">
    //                     <select class="form-control select2 form-select" onchange="changeStatus(\'' . $tableId . '\',this)" data-placeholder="Choose one" style="padding: 8px 15px;">
    //                         <option value="1"';
    //                 if ($newNColumn == 1) {
    //                     $tdHtml .= ' selected';
    //                 }
    //                 $tdHtml .= '>Active</option>
    //                         <option value="2"';
    //                 if ($newNColumn == 2) {
    //                     $tdHtml .= ' selected';
    //                 }
    //                 $tdHtml .= '>Inactive</option>
    //                     </select>
    //                     <p id="message' . $tableId . '" class="message"></p>
    //                 </div>';
    //                 $nestedData[$column] =$tdHtml;
    //             }

    //             if($column == "Action"){
    //                 $tableId = $nestedData['id'];
    //                 $actionHtml = '<div class="g-2">';

    //                 if (in_array("26", $arr)) {
    //                     $actionHtml .= '<a class="btn text-info btn-sm" href="' . route('vehicle.view', ['id' => $tableId]) . '" data-bs-toggle="tooltip" data-bs-original-title="View"><span class="fe fe-eye fs-14"></span></a>';
    //                 }

    //                 if (in_array("27", $arr)) {
    //                     $actionHtml .= '<a class="btn text-primary btn-sm" href="' . route('vehicle.edit', ['id' => $tableId]) . '" data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a>';
    //                 }

    //                 if (in_array("28", $arr)) {
    //                     $actionHtml .= '<a class="btn text-danger btn-sm" onclick="remove_vehicle(\'' . $tableId . '\', this)" data-bs-toggle="tooltip" data-bs-original-title="Delete"><span class="fe fe-trash-2 fs-14"></span></a>';
    //                 }

    //                 $actionHtml .= '</div>';
    //                 $nestedData['Action'] = $actionHtml;
    //             }

    //         }
    //         $formattedData[] = $nestedData;
    //     }
    //     return $formattedData;
    // }

    // private static function  shiftData($items, $columns, $columnMapping)
    // {
    //     $formattedData = [];
    //     foreach ($items as $item) {
    //         $nestedData = [];
    //         foreach ($columns as $column) {
    //             $actualColumnName = $columnMapping[$column] ?? $column;
    //             $newNColumn = self::getNestedProperty($item, $actualColumnName);

    //             $nestedData[$column] = $newNColumn;

    //             if ($column == "Status" && $newNColumn == 1) {
    //                 $nestedData[$column] = "Activewww";
    //             } elseif ($column == "Status" && $newNColumn == 0) {
    //                 $nestedData[$column] = "Inactive";
    //             }

    //         }

    //         // Add an empty 'options' column
    //         $nestedData['Action'] = '<a href="#">Hello</a><br/><a href="#">adsasd</a>';
    //         $formattedData[] = $nestedData;
    //     }
    //     return $formattedData;
    // }

    private static function userData($items, $columns, $columnMapping)
    {

        $D = json_decode(json_encode(Auth::guard('adminLogin')->user()->get_role()), true);
        $arr = [];
        foreach ($D as $v) {
            $arr[] = $v['permission_id'];
        }

        $formattedData = [];
        foreach ($items as $item) {
            $nestedData = [];
            foreach ($columns as $column) {
                $actualColumnName = $columnMapping[$column] ?? $column;
                $newNColumn = self::getNestedProperty($item, $actualColumnName);

                $nestedData[$column] = $newNColumn;

                $driverRole = Auth::guard('adminLogin')->user();
                $driverRole = $driverRole->role_id;

                if ($column == 'Shift Id') {
                    $shiftId = '<div class="">';
                    $shiftId .= 'QE' . $item->shiftRandId . '</div>';
                    $nestedData[$column] = $shiftId;
                }

                if ($column == 'Status') {
                    $tdHtml = '<div class="form-group">';
                    if ($newNColumn == '0') {
                        $tdHtml .= '<span class="light status-Created">Created</span>';
                    } elseif ($newNColumn == '1') {
                        $tdHtml .= '<span class="danger status-InProgress">In Progress</span>';
                    } elseif ($newNColumn == '2') {
                        $tdHtml .= '<span class="light status-ToBeApproved"';
                        if ($driverRole !== 33) {
                            $tdHtml .= ' onclick="approveAndReject()"';
                        }
                        $tdHtml .= '>To Be Approved</span>';
                    } elseif ($newNColumn == '3') {
                        $tdHtml .= '<span class="light status-ToBeApr"';
                        if ($driverRole !== 33) {
                            $tdHtml .= ' onclick="shiftPaid()"';
                        }
                        $tdHtml .= '>Approved</span>';
                    } elseif ($newNColumn == '4') {
                        $tdHtml .= '<span class="light status-ToBeApr">Rejected</span>';
                    } elseif ($newNColumn == '5' || $newNColumn == '6') {
                        $tdHtml .= '<span class="light status-Paid">Paid</span>';
                    } else {
                        // Do something else if none of the conditions match
                    }
                    $tdHtml .= '</div>';
                    $nestedData[$column] = $tdHtml;
                }

                if ($column == 'Total Hours') {
                    $daySum = 0;
                    $nightHours = 0;
                    $weekendHours = 0;
                    if ($item->getFinishShift) {
                        $daySum = floatval($item->getFinishShift->dayHours) ?? 0;
                        $nightHours = floatval($item->getFinishShift->nightHours) ?? 0;
                        $weekendHours = floatval($item->getFinishShift->weekendHours) ?? 0;
                    }
                    $totalHours = $daySum + $nightHours + $weekendHours;
                    $totalhr = '' . $totalHours . '';
                    $nestedData[$column] = $totalhr;
                }

                if ($column == 'Amount Chargeable Day Shift') {
                    $chargeDayShift = ($item->getClientReportCharge->hourlyRateChargeableDays ?? 0) * ($item->getFinishShifts->dayHours ?? 0);
                    $nestedData[$column] = $chargeDayShift;
                }

                $priceCompare = DB::table('personrates')->where('type', $item->vehicleType)->where('personId', $item->driverId)->first();

                if ($column == 'Amount Payable Day Shift') {
                    if ($item->priceOverRideStatus == '1') {
                        $payableDayShift = $priceCompare ? ($priceCompare->hourlyRatePayableDays ?? 0) * optional($item->getFinishShifts)->dayHours ?? 0 : 0;
                    } else {
                        $clientCharge = $item->getClientCharge;
                        $payableDayShift = $clientCharge ? $clientCharge->hourlyRatePayableDay * optional($item->getFinishShifts)->dayHours ?? 0 : 0;
                    }
                    $nestedData[$column] = $payableDayShift;
                }

                if ($column == 'Amount Payable Night Shift') {
                    if ($item->priceOverRideStatus == '1') {
                        $payablenightShift = ($priceCompare ? $priceCompare->hourlyRatePayableNight : 0) * ($item->getFinishShifts ? $item->getFinishShifts->nightHours ?? 0 : 0);
                    } else {
                        if ($item->getFinishShifts && $item->getFinishShifts->nightHours ?? 0 != '0') {
                            $payablenightShift = $item->getClientReportCharge->hourlyRatePayableNight ?? 0 * $item->getFinishShifts->nightHours ?? 0;
                        } else {
                            $payablenightShift = 0;
                        }
                    }
                    $nestedData[$column] = $payablenightShift;
                }

                if ($column == 'Amount Chargeable Night Shift') {
                    $chargeNight = ($item->getClientReportCharge->ourlyRateChargeableNight ?? 0) * ($item->getFinishShifts->nightHours ?? 0);
                    $nestedData[$column] = $chargeNight;
                }

                if ($column == 'Amount Payable Weekend Shift') {
                    if ($item->priceOverRideStatus == '1') {
                        $saturday = ($priceCompare ? ($priceCompare->hourlyRatePayableSaturday ?? 0) * ($item->getFinishShifts ? $item->getFinishShifts->saturdayHours : 0) : 0);
                        $sunday = ($priceCompare ? ($priceCompare->hourlyRatepayableSunday ?? 0) * ($item->getFinishShifts ? $item->getFinishShifts->sundayHours : 0) : 0);
                        $nestedData[$column] = $saturday + $sunday;
                    } else {
                        $saturday = 0;
                        $sunday = 0;

                        if ($item->getFinishShifts && $item->getFinishShifts->saturdayHours != '0') {
                            $saturday = $item->getClientReportCharge->hourlyRatePayableSaturday ?? 0 * $item->getFinishShifts->saturdayHours ?? 0;
                        }
                        if ($item->getFinishShifts && $item->getFinishShifts->sundayHours !== null && $item->getFinishShifts->sundayHours != '0') {
                            $sunday = floatval($item->getClientReportCharge->hourlyRatePayableSunday) * floatval($item->getFinishShifts->sundayHours);
                        }
                    }
                    $nestedData[$column] = $saturday + $sunday;
                }

                if ($column == 'Amount Chargeable Weekend Shift') {
                    if (!empty($item->getFinishShifts->saturdayHours)) {
                        $saturday = $item->getClientReportCharge->hourlyRateChargeableSaturday ?? 0 * $item->getFinishShifts->saturdayHours ?? 0;
                    } else {
                        $saturday = 0;
                    }
                    if (!empty($item->getFinishShifts->sundayHours)) {
                        $sunday = $item->getClientReportCharge->hourlyRateChargeableSunday * $item->getFinishShifts->sundayHours;
                    } else {
                        $sunday = 0;
                    }
                    $nestedData[$column] = $saturday + $sunday;
                }

                $activeBtn = '';
                if ($column == 'Action') {
                    $actionButton = '<div class="form-group"><td class="column-action"><div class="d-flex">';
                    if (in_array('50', $arr)) {
                        if ($item->finishStatus == '2') {
                            $actionButton .= '<a onclick="approveAndReject(\'' . $item->id . '\')" class="btn text-green btn-sm btncls" data-bs-toggle="modal"><span class="ti-check-box fs-14"></span></a>';
                        } else {
                            $actionButton .= '<a class="btn text-green btn-sm btncls"  data-bs-toggle="modal"><span class="ti-check-box fs-14"></span></a>';
                        }
                    }

                    if (in_array('51', $arr)) {
                        $actionButton .= '<a class="btn text-info btn-sm btncls" href="' . route('admin.shift.report.view', ['id' => $item->id]) . '" data-bs-toggle="tooltip" data-bs-original-title="View"><span class="fe fe-eye fs-14"></span></a>';
                    }

                    if (in_array('52', $arr)) {
                        $actionButton .= '<a class="btn text-primary btn-sm btncls" href="' . route('admin.shift.report.edit', ['id' => $item->id]) . '"  data-bs-toggle="tooltip" data-bs-original-title="Edit"><span class="fe fe-edit fs-14"></span></a>';
                    }

                    if (in_array('53', $arr)) {
                        $actionButton .= '<a class="btn text-primary btn-sm btncls" href="' . route('admin.shift.parcels', ['id' => $item->id]) . '" data-bs-toggle="tooltip" data-bs-original-title="Parcel"><span class="fe fe-box"></span></a>';
                    }

                    $actionButton .= '</div></div></div>';
                    $nestedData[$column] = $actionButton;
                }

            }

            $formattedData[] = $nestedData;
        }

        return $formattedData;
    }
}
