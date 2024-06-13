<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Clientrate;
use App\Models\Driver;
use App\Models\Expense;
use App\Models\Generalexpensestype;
use App\Models\OperactionExp;
use App\Models\Operatingexpensetype;
use App\Models\State;
use App\Models\Tollexpense;
use App\Models\Type;
use App\Models\Vehical;
use Carbon\Carbon;
use DB;
use Illuminate\Http\Request;

class Expenses extends Controller
{
    public function expense(Request $request)
    {
        // dd($request->all());
        $datesData = null;
        $date_range = $request->input('date_range',null);

        if($date_range) $datesData = explode('to',$date_range);
        if($datesData && isset($datesData[1])){
            $todayMonth = date('Y-m-d',strtotime($datesData[0]));
            $lastMonth =  date('Y-m-d',strtotime($datesData[1]));
        }else{
            $todayMonth = date('Y-m-d');
            $lastMonth = date('Y-m-d', strtotime($todayMonth. ' - 1 years'));
        }

        $personName = $request->input('personName',null);
        $rego = $request->input('rego',null);

        

        $totalExpense = [];
        $totalOperActionExp = 0;
        $generalExpenses = 0;
        $totalexpenseQuery = 0;
        $overrallExpenseGraph = 0;
        $monthsData = [];


        $expenseQuery = Expense::whereBetween('date',[$lastMonth,$todayMonth])->orderBy('date', 'desc');
        $tollexpenseQuery = Tollexpense::whereBetween('start_date',[$lastMonth,$todayMonth])->orderBy('start_date', 'desc');
        $operactionExpQuery = OperactionExp::whereBetween('date',[$lastMonth,$todayMonth])->orderBy('date', 'desc');
        $ClientrateQuery = Clientrate::whereBetween('created_at',[$lastMonth,$todayMonth])->orderBy('created_at', 'desc');

        if (request()->isMethod('post')) {
            if ($personName){
                $expenseQuery->where('person_name', $personName);
                $tollexpenseQuery->where('person_name', $personName);
                $operactionExpQuery->where('person_name', $personName);
            } 
            if ($rego){
                $expenseQuery->where('rego', $rego);
                $tollexpenseQuery->where('rego', $rego);
                $operactionExpQuery->where('rego', $rego);
            }
        }
        $expenseQeReport = $expenseQuery->get();
        $tollexpenseQeReport = $tollexpenseQuery->get();
        $operactionExpQeReport = $operactionExpQuery->get();
        $ClientrateQeReport = $ClientrateQuery->get();

        $monthNames = [];
        $expenseReport = [];
        $tollexpense = [];
        $operactionExp = [];
        $Clientrate = [];

        for ($i = 0; $i < 12; $i++) {
            $currentDate = Carbon::now()->subMonths($i);
            $month = $currentDate->month;
            $year = $currentDate->year;
            $monthNames[] = $currentDate->format('M-y');
        
            $expenseReport[] = $expenseQeReport->filter(function ($item) use ($month, $year) {
                $itemDate = Carbon::parse($item->date);
                return $itemDate->month == $month && $itemDate->year == $year;
            })->sum('cost');
        
            $tollexpense[] = $tollexpenseQeReport->filter(function ($item) use ($month, $year) {
                $itemDate = Carbon::parse($item->start_date);
                return $itemDate->month == $month && $itemDate->year == $year;
            })->sum('trip_cost');
        
            $operactionExp[] = $operactionExpQeReport->filter(function ($item) use ($month, $year) {
                $itemDate = Carbon::parse($item->date);
                return $itemDate->month == $month && $itemDate->year == $year;
            })->sum('cost');
        
            $Clientrate[] = $ClientrateQeReport->filter(function ($item) use ($month, $year) {
                $itemDate = Carbon::parse($item->created_at);
                return $itemDate->month == $month && $itemDate->year == $year;
            })->sum('adminCharageAmount');
        }

        $totalOperActionExp = $operactionExpQeReport->sum('cost');
        $generalExpenses = $tollexpenseQeReport->sum('trip_cost');
        $totalexpenseQuery = $expenseQeReport->sum('cost');

        $overrallExpenseGraph = (int)($totalOperActionExp + $generalExpenses + $totalexpenseQuery);

        $totalExpense = [];
        for ($i = 0; $i < 12; $i++) {
            $totalExpense[$i] = (int)($expenseReport[$i] + $tollexpense[$i] + $operactionExp[$i]);
        }


        // dd('totalOperActionExp<br>',$totalOperActionExp, 'generalExpenses<br>',$generalExpenses, 'totalexpenseQuery<br>',$totalexpenseQuery, 'overrallExpenseGraph<br>',$overrallExpenseGraph, 'expenseReport<br>',$expenseReport, 'Clientrate<br>',$Clientrate, 'tollexpense<br>',$tollexpense, 'operactionExp<br>',$operactionExp, 'totalExpense<br>',$totalExpense, 'personName<br>',$personName, 'rego<br>',$rego);

        $data['person'] = Driver::where('status', '1')->get();
        $data['state'] = State::where('status', '1')->get();
        $data['client'] = Client::where('status', '1')->get();
        $data['client'] = Client::where('status', '1')->get();
        $data['clientcenters'] = DB::table('clientcenters')->get();
        $data['rego'] = DB::table('vehicals')->where('status', '1')->get();

        return view('admin.expenses.dashboard', $data, compact('totalOperActionExp', 'generalExpenses', 'totalexpenseQuery', 'overrallExpenseGraph', 'expenseReport', 'Clientrate', 'tollexpense', 'operactionExp', 'totalExpense', 'personName', 'rego','monthNames','date_range'));
    }

    public function expenseSheet(Request $request)
    {

        if (request()->isMethod('post')) {

            if ($request->input('firstSection') == 1) {
                $expense = $request->except(['_token', 'submit']);
                Expense::create($expense);
                $expense = Expense::orderBy('id', 'DESC')->first();
                $expense->vehical_type = DB::table('generalexpensestypes')->where('id', $expense->vehical_type)->first()->name ?? 'N/A';
                $expense->rego = DB::table('vehicals')->where('id', $expense->rego)->first()->rego;
                $expense->userName = Driver::whereId($expense->person_name)->first()->userName ?? 'N/A';

                return response()->json([
                    'success' => '200',
                    'message' => 'expense saved successfully.',
                    'data'   => $expense,
                ]);
            }

            if ($request->input('firstSection') == 2) {
                $expense = $request->except(['_token', 'submit']);
                $expense['general_expense_id'] = Expense::orderBy('id', 'DESC')->first()->id;
                Tollexpense::create($expense);
                $Tollexpense = Tollexpense::orderBy('id', 'DESC')->first();
                $Tollexpense->rego = DB::table('vehicals')->where('id', $Tollexpense->rego)->first()->rego;

                return response()->json([
                    'success' => '200',
                    'message' => 'expense saved successfully.',
                    'data'   => $Tollexpense,
                ]);
            }

            if ($request->input('firstSection') == 3) {
                // return $request->all();
                $expense1 = $request->except(['_token', 'submit']);
                OperactionExp::create($expense1);
                $OperactionExp = OperactionExp::orderBy('id', 'DESC')->first();
                $OperactionExp->vehical_type = DB::table('generalexpensestypes')->where('id', $OperactionExp->vehical_type)->first()->name ?? 'N/A';

                $OperactionExp->userName = Driver::whereId($OperactionExp->person_name)->first()->userName ?? '';

                return response()->json([
                    'success' => '200',
                    'message' => 'Operaction Expenses added successfully.',
                    'data'   => $OperactionExp,
                ]);
            }
        }

        $data['types'] = Type::where('status', '1')->get();
        $data['dr'] = Driver::where('role_id', '33')->where('status', '1')->get();

        $data['selectPersonType'] = Driver::where('status', '1')->where('role_id', '!=', 33)->get();
        $data['expense'] = Expense::orderBy('id', 'DESC')->get();
        $data['tollexpense'] = Tollexpense::orderBy('id', 'DESC')->get();
        $data['operactionexp'] = OperactionExp::orderBy('id', 'DESC')->get();
        $data['states'] = State::orderBy('id', 'DESC')->get();
        $data['generalexpensestypes'] = Generalexpensestype::get();
        $data['operatingexpensetype'] = Operatingexpensetype::get();
        $data['vehicals'] = DB::table('vehicals')->where('status', '1')->get();

        return view('admin.expenses.sheet', $data);
    }

    public function getRego(Request $request)
    {
        $typeId = $request->input('typeId');
        $getdriverResponsible = Vehical::where('driverResponsible', $typeId)->get();

        if ($getdriverResponsible) {
            return response()->json([
                'success' => '200',
                'message' => 'get rego',
                'vehicleData' => $getdriverResponsible,
            ]);
        }
    }

    public function addVehicle(Request $request)
    {
        $Generalexpensestype = Generalexpensestype::where('name', $request->input('vehicaleTyle'))->first();
        if ($Generalexpensestype) {
            return redirect()->back()->with('error', 'Already exist!');
        } else {
            $vehicaleTyle = $request->input('vehicaleTyle');
            Generalexpensestype::insert(['name' => $vehicaleTyle]);

            return redirect()->back()->with('message', 'Expense type added Successfully!');
        }
    }

    public function addopVehicle(Request $request)
    {
        $Operatingexpensetype = Operatingexpensetype::where('name', $request->input('vehicaleTyle'))->first();
        if ($Operatingexpensetype) {
            return redirect()->back()->with('error', 'Already exist');
        } else {
            $vehicaleTyle = $request->input('vehicaleTyle');
            Operatingexpensetype::insert(['name' => $vehicaleTyle]);

            return redirect()->back()->with('message', 'Operation Expenses added successfully!');
        }
    }

    public function deletGeneralExp(Request $request)
    {
        $clientId = $request->input('clientId');
        $expense = Expense::whereId($clientId)->delete();

        if ($expense) {
            return response()->json([
                'success' => '200',
                'message' => 'General Expense Deleted successfully!',
            ]);
        }
    }

    public function deletTotalExp(Request $request)
    {
        $id = $request->input('clientId');
        $deleteData = Tollexpense::whereId($id)->delete();
        if ($deleteData) {
            return response()->json([
                'success' => '200',
                'message' => 'Toll Expense Deleted  successfully.',
            ]);
        }
    }

    public function deletTotalOperaction(Request $request)
    {

        $id = $request->input('clientId');
        $deleteDat1 = OperactionExp::whereId($id)->delete();
        if ($deleteDat1) {
            return response()->json([
                'success' => '200',
                'message' => 'Operaction Expenses Deleted  successfully.',
            ]);
        }
    }
}
