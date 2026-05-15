<?php

namespace App\Observers;

use App\Models\AuditLog;
use Illuminate\Database\Eloquent\Model;

class AuditObserver
{
    /**
     * Handle the Model "created" event.
     */
    public function created(Model $model): void
    {
        if ($model instanceof AuditLog) {
            return;
        }

        AuditLog::create([
            'user_id' => auth()->id() ?? null,
            'action' => 'create',
            'table_name' => $model->getTable(),
            'record_id' => $model->getKey(),
            'old_values' => null,
            'new_values' => $model->getAttributes(),
            'ip_address' => request()->ip() ?? null,
            'user_agent' => request()->userAgent() ?? null,
        ]);
    }

    /**
     * Handle the Model "updated" event.
     */
    public function updated(Model $model): void
    {
        if ($model instanceof AuditLog) {
            return;
        }

        $old = $model->getOriginal();
        $new = $model->getAttributes();

        AuditLog::create([
            'user_id' => auth()->id() ?? null,
            'action' => 'update',
            'table_name' => $model->getTable(),
            'record_id' => $model->getKey(),
            'old_values' => $old,
            'new_values' => $new,
            'ip_address' => request()->ip() ?? null,
            'user_agent' => request()->userAgent() ?? null,
        ]);
    }

    /**
     * Handle the Model "deleted" event.
     */
    public function deleted(Model $model): void
    {
        if ($model instanceof AuditLog) {
            return;
        }

        AuditLog::create([
            'user_id' => auth()->id() ?? null,
            'action' => 'delete',
            'table_name' => $model->getTable(),
            'record_id' => $model->getKey(),
            'old_values' => $model->getOriginal(),
            'new_values' => null,
            'ip_address' => request()->ip() ?? null,
            'user_agent' => request()->userAgent() ?? null,
        ]);
    }
}
