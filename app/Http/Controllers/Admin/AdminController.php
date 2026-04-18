<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function index()
{
    return view('admin.admins.index', [
        'admins' => Admin::all()
    ]);
}

public function create()
{
    return view('admin.admins.create');
}

public function store(Request $request)
{
    Admin::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    return redirect('/admin/admins');
}

public function destroy($id)
{
    Admin::find($id)->delete();
    return back();
}
    //
}
