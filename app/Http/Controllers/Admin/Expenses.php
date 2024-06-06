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
use DB;
use Illuminate\Http\Request;

class Expenses extends Controller
{
    public function expense(Request $request)
    {

        $date = $request->input('date');
        $personName = $request->input('personName');
        $rego = $request->input('rego');

        $totalExpense = [];
        for ($i = 1; $i <= 12; $i++) {

            $getYear = date('Y');
            $expenseQuery = Expense::orderBy('id', 'desc');
            if (request()->isMethod('post')) {
                if ($date) $expenseQuery->where('created_at', $date);
                if ($personName) $expenseQuery->where('person_name', $personName);
                if ($rego) $expenseQuery->where('rego', $rego);
            }
            $expenseReport[] = $expenseQuery->whereYear('created_at', $getYear)->whereMonth('created_at', $i)->sum('cost');

            $tollexpenseQuery = Tollexpense::orderBy('id', 'desc');
            if (request()->isMethod('post')) {
                $date = $request->input('date');
                $personName = $request->input('personName');
                $rego = $request->input('rego');

                if ($date) $tollexpenseQuery->where('created_at', $date);
                if ($personName) $tollexpenseQuery->where('person_name', $personName);
                if ($rego) $tollexpenseQuery->where('rego', $rego);
            }

            $tollexpense[] = $tollexpenseQuery->whereYear('created_at', $getYear)->whereMonth('created_at', $i)->sum('trip_cost');

            $operactionExp[] = OperactionExp::whereYear('created_at', $getYear)->whereMonth('created_at', $i)->sum('cost');

            $totalOperActionExp = OperactionExp::sum('cost');
            $generalExpenses = Tollexpense::sum('trip_cost');
            $totalexpenseQuery = Expense::sum('cost');

            $overrallExpenseGraph = (int) ($totalOperActionExp + $generalExpenses + $totalexpenseQuery);

            $Clientrate[] = Clientrate::whereYear('created_at', $getYear)->whereMonth('created_at', $i)->sum('adminCharageAmount');
        }

        for ($i = 0; $i <= 11; $i++) {
            $totalExpense[$i] = (int) ($expenseReport[$i] + $tollexpense[$i] + $operactionExp[$i]);
        }

        // dd('totalOperActionExp<br>',$totalOperActionExp, 'generalExpenses<br>',$generalExpenses, 'totalexpenseQuery<br>',$totalexpenseQuery, 'overrallExpenseGraph<br>',$overrallExpenseGraph, 'expenseReport<br>',$expenseReport, 'Clientrate<br>',$Clientrate, 'tollexpense<br>',$tollexpense, 'operactionExp<br>',$operactionExp, 'totalExpense<br>',$totalExpense, 'date<br>',$date, 'personName<br>',$personName, 'rego<br>',$rego);

        $data['person'] = Driver::where('status', '1')->get();
        $data['state'] = State::where('status', '1')->get();
        $data['client'] = Client::where('status', '1')->get();
        $data['client'] = Client::where('status', '1')->get();
        $data['clientcenters'] = DB::table('clientcenters')->get();
        $data['rego'] = DB::table('vehicals')->where('status', '1')->get();

        return view('admin.expenses.dashboard', $data, compact('totalOperActionExp', 'generalExpenses', 'totalexpenseQuery', 'overrallExpenseGraph', 'expenseReport', 'Clientrate', 'tollexpense', 'operactionExp', 'totalExpense', 'date', 'personName', 'rego'));
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
