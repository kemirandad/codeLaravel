<?php

namespace App\Http\Controllers;

use App\Mail\SummaryReport;
use App\Models\Expense;
use App\Models\ExpenseReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ExpenseReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return ExpenseReport::all();
        return view('expenseReport.index', [
            'expenseReports' => ExpenseReport::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('expenseReport.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validData = $request->validate([
            'title' => 'required | min:3'
        ]);

        $report = new ExpenseReport();
        $report->title = $validData['title'];
        $report->save();

        return redirect('/expense_reports');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(ExpenseReport $expenseReport)
    {
        return view('expenseReport.show', [
            'report' => $expenseReport
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $report = ExpenseReport::findOrFail($id);
        return view('expenseReport.edit', [
            'report' => $report
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $report = ExpenseReport::findOrFail($id);
        $report->title = $request->get('title');
        $report->save();

        return redirect('/expense_reports');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $report = ExpenseReport::findOrFail($id);
        $report->delete();

        return redirect('/expense_reports/');
    }
    /**
     * Función diseñada para generar una nueva vista
     * y confirmar que quiere eliminar la entrada
     */
    public function confirmDelete($id)
    {
        $report = ExpenseReport::findOrFail($id);
        return view('expenseReport.confirmDelete', [
            'report' => $report
        ]);
    }

    public function confirmSendMail($id)
    {
        $report = ExpenseReport::findOrFail($id);
        return view('expenseReport.confirmSendMail', ['report' => $report]);
    }

    public function sendMail(Request $request, $id)
    {
        /*$validData = $request->validate([
            'description' => 'required | min:3',
            'amount' => 'numeric'

        ]);

        $expense = new Expense();
        //$expense->description = $request->get('description');
        $expense->description = $validData['description'];
        //$expense->amount = $request->get('amount');
        $expense->amount = $validData['amount'];
        $expense->expense_report_id = $expenseReport->id;*/

        $validData = $request->validate([
            'email' => 'required|email',
        ]);

        $report = ExpenseReport::findOrFail($id);
        Mail::to($validData['email'])->send(new SummaryReport($report));
        return redirect('/expense_reports/' . $id);
    }
}
