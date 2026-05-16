<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AuditLogController extends Controller
{
    /**
     * Display a listing of audit logs.
     */
    public function index(Request $request): View
    {
        $query = AuditLog::with('user');

        // Filter by table
        if ($request->has('table')) {
            $query->where('table_name', $request->get('table'));
        }

        // Filter by action
        if ($request->has('action')) {
            $query->where('action', $request->get('action'));
        }

        // Filter by user
        if ($request->has('user_id')) {
            $query->where('user_id', $request->get('user_id'));
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->whereDate('created_at', '>=', $request->get('date_from'));
        }

        if ($request->has('date_to')) {
            $query->whereDate('created_at', '<=', $request->get('date_to'));
        }

        $logs = $query->latest()->paginate(20);

        return view('audit-logs.index', ['logs' => $logs]);
    }

    /**
     * Display the specified audit log.
     */
    public function show(AuditLog $auditLog): View
    {
        return view('audit-logs.show', [
            'log' => $auditLog->load('user'),
            'differences' => $auditLog->getDifferences(),
        ]);
    }

    /**
     * Get audit logs for a record (API).
     */
    public function forRecord(Request $request)
    {
        $validated = $request->validate([
            'table' => 'required|string',
            'record_id' => 'required|integer',
        ]);

        $logs = AuditLog::forRecord($validated['table'], $validated['record_id'])
                       ->with('user')
                       ->latest()
                       ->get();

        return response()->json($logs);
    }

    /**
     * Get audit summary by table (API).
     */
    public function summary()
    {
        $summary = AuditLog::selectRaw('table_name, action, COUNT(*) as count')
                          ->groupBy('table_name', 'action')
                          ->get();

        return response()->json($summary);
    }

    /**
     * Export audit logs to CSV.
     */
    public function export(Request $request)
    {
        $query = AuditLog::with('user');

        if ($request->has('table')) {
            $query->where('table_name', $request->get('table'));
        }

        $logs = $query->latest()->get();

        $csv = "User,Action,Table,Record ID,Old Values,New Values,IP Address,Date\n";

        foreach ($logs as $log) {
            $csv .= "\"{$log->user?->name}\",\"{$log->action}\",\"{$log->table_name}\",";
            $csv .= "\"{$log->record_id}\"," . json_encode($log->old_values) . ",";
            $csv .= json_encode($log->new_values) . ",\"{$log->ip_address}\",\"{$log->created_at}\"\n";
        }

        return response($csv, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="audit-logs-' . now()->format('Y-m-d') . '.csv"',
        ]);
    }
}
