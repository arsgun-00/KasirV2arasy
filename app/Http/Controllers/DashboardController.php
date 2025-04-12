<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $data['main'] = 'Home Dashboard';
        $data['sub'] = 'Dashboard';
        

        return view('admin.dashboard', $data);
    }
}
