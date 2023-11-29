<?php

namespace App\Http\Controllers;

use App\Services\DataTables\UserDataTableService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userDataTableService;

    public function __construct()
    {
        $this->userDataTableService = new UserDataTableService();
    }

    public function index()
    {
        try {
            $assets = ['data-table'];
            $pageTitle = 'User Data';
            $headerAction = '<a href="' . route('admin.user.create') . '" class="btn btn-sm btn-primary" role="button">Add User</a>';
            return $this->userDataTableService->render('admin.users.index', compact('assets', 'pageTitle', 'headerAction'));
        } catch (\Throwable $th) {
            $error = $th->getMessage();
            return back()->withErrors($error);
        }
    }
}
