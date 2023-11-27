<?php

namespace App\Http\Controllers;

use App\Services\CategoryService;
use App\Services\DataTables\CategoryDataTableService;
// use App\DataTables\CategoriesDataTable;
use Exception;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    public function index(CategoryDataTableService $dataTable)
    {
        try {
            $assets = ['data-table'];
            $pageTitle = 'Book Category Data';
            $headerAction = '<a href="' . route('admin.category.create') . '" class="btn btn-sm btn-primary" role="button">Add Category</a>';
            return $dataTable->render('admin.category.index', compact('assets', 'pageTitle', 'headerAction'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            // return view('error', compact('error'));
            return response()->json($error);
        }
    }
}
