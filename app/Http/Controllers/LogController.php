<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\LoginHistory;
use Illuminate\Http\Request;

class LogController extends Controller
{
    // Menampilkan daftar activity log dan login history (auditor)
    public function index()
    {
        // Ambil data activity log terbaru dengan pagination
        $activityLogs = ActivityLog::with('user')->latest()->paginate(20);

        // Ambil data login history terbaru dengan pagination
        $loginHistories = LoginHistory::with('user')->latest()->paginate(20);

        return view('logs.index', compact('activityLogs', 'loginHistories'));
    }
}
