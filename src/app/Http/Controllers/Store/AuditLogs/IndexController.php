<?php

namespace App\Http\Controllers\Store\AuditLogs;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = AuditLog::where('store_id', app('currentStore')->id)
            ->orderByDesc('created_at');

        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $logs = $query->paginate(25)->withQueryString();

        return view('store.audit_logs.index', [
            'logs'    => $logs,
            'actions' => AuditLog::ACTIONS,
        ]);
    }
}
