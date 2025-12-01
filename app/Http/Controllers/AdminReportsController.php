<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\DocumentRequest;
use Illuminate\Http\Request;

class AdminReportsController extends Controller
{
    public function index()
    {
        $totalUsers = User::where('role', 'user')->count();
        $totalRegisteredResidents = User::where('role', 'user')->count();
        $totalRegisteredStaffs = User::where('role', 'admin')->count();
        $archivedAccounts = 0;

        return view('admin.reports', compact(
            'totalUsers',
            'totalRegisteredResidents',
            'totalRegisteredStaffs',
            'archivedAccounts'
        ));
    }
}
