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

    public function create(): View
    {
        return view('admin.users.form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = (object) $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'phone' => 'required|string',
            'address' => 'required|string',
            'role' => 'required|in:0,1',
            'password' => 'required|min:8|confirmed',
        ]);

        $stored = \App\Models\User::create([
            'name' => $data->name,
            'email' => $data->email,
            'role' => $data->role,
            'phone' => $data->phone,
            'address' => $data->address,
            'password' => bcrypt($data->password),
        ]);

        if (!$stored) {
            return back()->withErrors('Failed to store user data')->withInput();
        }

        return redirect()->route('admin.user.index');
    }

    public function edit($id): View
    {
        $data = \App\Models\User::findOrFail($id);
        return view('admin.users.form', compact('data', 'id'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $data = (object) $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => 'required|string',
            'address' => 'required|string',
            'role' => 'required|in:0,1',
            'password' => 'nullable|min:8|confirmed',
        ]);

        $user = \App\Models\User::findOrFail($id);

        $updated = $user->update([
            'name' => $data->name,
            'email' => $data->email,
            'role' => $data->role,
            'phone' => $data->phone,
            'address' => $data->address,
            'password' => $data->password ? bcrypt($data->password) : $user->password,
        ]);

        if (!$updated) {
            return back()->withErrors('Failed to update user data')->withInput();
        }

        return redirect()->route('admin.user.index');
    }

    public function destroy($id): RedirectResponse
    {
        $status = \App\Models\User::destroy($id);
        $message = __('global-message.delete_form', ['form' => 'User data']);

        if (request()->ajax()) {
            return response()->json(['status' => true, 'message' => $message, 'datatable_reload' => 'dataTable_wrapper']);
        }

        return redirect()->back()->with($status, $message);
    }
}
