<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\DataTables\CategoryDataTableService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected $categoryService;
    protected $categoryDataTableService;

    public function __construct(CategoryService $categoryService, CategoryDataTableService $categoryDataTableService)
    {
        $this->categoryService = $categoryService;
        $this->categoryDataTableService = $categoryDataTableService;
    }

    public function index()
    {
        try {
            $assets = ['data-table'];
            $pageTitle = 'Book Category Data';
            $headerAction = '<a href="' . route('admin.category.create') . '" class="btn btn-sm btn-primary" role="button">Add Category</a>';
            return $this->categoryDataTableService->render('admin.category.index', compact('assets', 'pageTitle', 'headerAction'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            return back()->withErrors($error);
        }
    }

    public function create(): View
    {
        return view('admin.category.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only([
            'name',
        ]);

        $response = $this->categoryService->store($data);

        if (isset($response['error'])) {
            return back()->withErrors($response['error'])->withInput();
        }

        return redirect()->route('admin.category.index');
    }

    public function edit($id): View
    {
        $data = $this->categoryService->getById($id);
        return view('admin.category.form', compact('data', 'id'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $data = $request->only([
            'name',
        ]);

        $response = $this->categoryService->update($data, $id);

        if (isset($response['error'])) {
            return back()->withErrors($response['error'])->withInput();
        }

        return redirect()->route('admin.category.index')->withSuccess(__('global-message.update_form', ['form' => 'Category data']));
    }

    public function destroy($id): RedirectResponse
    {
        $result = $this->categoryService->destroy($id);
        $status = $result['status'];
        $message = $result['message'];

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);
    }
}
