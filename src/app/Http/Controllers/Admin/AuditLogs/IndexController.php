<?php

namespace App\Http\Controllers\Admin\AuditLogs;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Store;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = AuditLog::with('store')
            ->orderByDesc('created_at');

        if ($request->filled('store_id')) {
            $query->where('store_id', $request->input('store_id'));
        }

        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $logs    = $query->paginate(25)->withQueryString();
        $stores  = Store::orderBy('name')->get(['id', 'name']);

        return view('admin.audit_logs.index', [
            'logs'    => $logs,
            'stores'  => $stores,
            'actions' => AuditLog::ACTIONS,
        ]);
    }
}
