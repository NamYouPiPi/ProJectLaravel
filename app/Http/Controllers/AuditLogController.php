<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AuditLogController extends Controller
{
    /**
     * Display a listing of audit logs.
     */
    public function index(Request $request)
    {
        $query = AuditLog::query();

        // Apply filters if provided
        if ($request->has('table')) {
            $query->where('table_name', $request->table);
        }

        if ($request->has('action')) {
            $query->where('action', $request->action);
        }

        if ($request->has('user')) {
            $query->where('user_id', $request->user);
        }

        if ($request->has('date_from')) {
            $query->whereDate('timestamp', '>=', $request->date_from);
        }

        if ($request->has('date_to')) {
            $query->whereDate('timestamp', '<=', $request->date_to);
        }

        $auditLogs = $query->latest('timestamp')->paginate(20);

        // Get unique tables and actions for filters
        $tables = DB::table('audit_log')->distinct()->pluck('table_name');
        $actions = DB::table('audit_log')->distinct()->pluck('action');

        return view('Backend.AuditLogs.index', compact('auditLogs', 'tables', 'actions'));
    }

    /**
     * Display the specified audit log.
     */
    public function show(AuditLog $auditLog)
    {
        return view('Backend.AuditLogs.show', compact('auditLog'));
    }

    /**
     * Export audit logs to CSV.
     */
    public function export(Request $request)
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="audit-logs-'.date('Y-m-d').'.csv"',
        ];

        $query = AuditLog::query();
        // Apply any filters similar to the index method

        return response()->stream(function() use ($query) {
            $handle = fopen('php://output', 'w');

            // Add headers
            fputcsv($handle, ['ID', 'User', 'Table', 'Record ID', 'Action', 'Old Values', 'New Values', 'User Type', 'Timestamp', 'IP Address', 'User Agent']);

            // Add data
            $query->chunk(100, function($logs) use ($handle) {
                foreach ($logs as $log) {
                    fputcsv($handle, [
                        $log->id,
                        $log->user_id,
                        $log->table_name,
                        $log->record_id,
                        $log->action,
                        json_encode($log->old_values),
                        json_encode($log->new_values),
                        $log->user_type,
                        $log->timestamp,
                        $log->ip_address,
                        $log->user_agent
                    ]);
                }
            });

            fclose($handle);
        }, 200, $headers);
    }

    // Filter methods
    public function filterByUser($userId)
    {
        $auditLogs = AuditLog::where('user_id', $userId)->latest('timestamp')->paginate(20);
        $tables = DB::table('audit_log')->distinct()->pluck('table_name');
        $actions = DB::table('audit_log')->distinct()->pluck('action');
        return view('Backend.AuditLogs.index', compact('auditLogs', 'tables', 'actions'));
    }

    public function filterByAction($action)
    {
        $auditLogs = AuditLog::where('action', $action)->latest('timestamp')->paginate(20);
        $tables = DB::table('audit_log')->distinct()->pluck('table_name');
        $actions = DB::table('audit_log')->distinct()->pluck('action');
        return view('Backend.AuditLogs.index', compact('auditLogs', 'tables', 'actions'));
    }

    public function filterByTable($tableName)
    {
        $auditLogs = AuditLog::where('table_name', $tableName)->latest('timestamp')->paginate(20);
        $tables = DB::table('audit_log')->distinct()->pluck('table_name');
        $actions = DB::table('audit_log')->distinct()->pluck('action');
        return view('Backend.AuditLogs.index', compact('auditLogs', 'tables', 'actions'));
    }
}
