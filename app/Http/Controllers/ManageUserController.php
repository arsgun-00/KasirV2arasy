<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class ManageUserController extends Controller
{
    public function index()
    {
        // Fetch all users except the currently authenticated user
        $users = User::where('id', '!=', auth()->id())->get();

        return view('admin.manage-user.index', compact('users'));
    }
}
