<?php

namespace App\Http\Controllers;

use App\Services\LoanService;
use App\Services\DataTables\LoanDataTableService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoanController extends Controller
{
    protected $loanService;
    protected $loanDataTableService;

    public function __construct(LoanService $loanService, LoanDataTableService $loanDataTableService)
    {
        $this->loanService = $loanService;
        $this->loanDataTableService = $loanDataTableService;
    }

    public function index()
    {
        try {
            $assets = ['data-table'];
            $pageTitle = 'Book Loan Data';
            $headerAction = '<a href="' . route('admin.loan.create') . '" class="btn btn-sm btn-primary" role="button">Add Loan</a>';
            return $this->loanDataTableService->render('admin.loan.index', compact('assets', 'pageTitle', 'headerAction'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            return back()->withErrors($error);
        }
    }

    public function create(): View
    {
        $assets = ['select2'];
        return view('admin.loan.form', compact('assets'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only([
            'book_copy_id',
            'user_id',
            'loan_date',
            'return_date',
            'status'
        ]);

        $response = $this->loanService->store($data);

        if (isset($response['error'])) {
            return back()->withErrors($response['error'])->withInput();
        }

        return redirect()->route('admin.loan.index');
    }

    public function edit($id): View
    {
        $data = $this->loanService->getById($id);
        return view('admin.loan.form', compact('data', 'id'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $data = $request->only([
            'book_copy_id',
            'user_id',
            'loan_date',
            'return_date',
            'status'
        ]);

        $response = $this->loanService->update($data, $id);

        if (isset($response['error'])) {
            return back()->withErrors($response['error'])->withInput();
        }

        return redirect()->route('admin.loan.index')->withSuccess(__('global-message.update_form', ['form' => 'Loan data']));
    }

    public function destroy($id): RedirectResponse
    {
        $result = $this->loanService->destroy($id);
        $status = $result['status'];
        $message = $result['message'];

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);
    }
}
