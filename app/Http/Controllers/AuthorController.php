<?php

namespace App\Http\Controllers;

use App\Services\AuthorService;
use App\Services\DataTables\AuthorDataTableService;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuthorController extends Controller
{
    protected $authorService;
    protected $authorDataTableService;

    public function __construct(AuthorService $authorService, AuthorDataTableService $authorDataTableService)
    {
        $this->authorService = $authorService;
        $this->authorDataTableService = $authorDataTableService;
    }

    public function index()
    {
        try {
            $assets = ['data-table'];
            $pageTitle = 'Book Author Data';
            $headerAction = '<a href="' . route('admin.author.create') . '" class="btn btn-sm btn-primary" role="button">Add Author</a>';
            return $this->authorDataTableService->render('admin.author.index', compact('assets', 'pageTitle', 'headerAction'));
        } catch (Exception $e) {
            $error = $e->getMessage();
            return back()->withErrors($error);
        }
    }

    public function create(): View
    {
        return view('admin.author.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->only([
            'name',
        ]);

        $response = $this->authorService->store($data);

        if (isset($response['error'])) {
            return back()->withErrors($response['error'])->withInput();
        }

        return redirect()->route('admin.author.index');
    }

    public function edit($id): View
    {
        $data = $this->authorService->getById($id);
        return view('admin.author.form', compact('data', 'id'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $data = $request->only([
            'name',
        ]);

        $response = $this->authorService->update($data, $id);

        if (isset($response['error'])) {
            return back()->withErrors($response['error'])->withInput();
        }

        return redirect()->route('admin.author.index')->withSuccess(__('global-message.update_form', ['form' => 'Author data']));
    }

    public function destroy($id): RedirectResponse
    {
        $status = $this->authorService->destroy($id);
        $message = __('global-message.delete_form', ['form' => 'Author data']);

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);
    }
}
