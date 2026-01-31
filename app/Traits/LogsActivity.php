<?php

namespace App\Traits;

use App\Models\ActivityLogs;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

trait LogsActivity
{
    public static function bootLogsActivity()
    {
        static::created(function ($model) {
            self::log('created', $model);
        });

        static::updating(function ($model) {
            self::log('updated', $model);
        });

        static::deleting(function ($model) {
            self::log('deleted', $model);
        });
    }

    public static function log(string $action, Model $model)
    {
        $original = $model->getOriginal(); // Old values
        $changes = $model->getDirty();     // Fields about to be changed

        $old = [];
        $new = [];

        foreach ($changes as $key => $newValue) {
            $old[$key] = $original[$key] ?? null;
            $new[$key] = $newValue;
        }

        // For "deleted", there are no changes, so we log the original values only
        $description = ($action === 'deleted')
            ? json_encode(['old' => $original])
            : json_encode(['attributes' => $new, 'old' => $old]);

        ActivityLogs::create([
            'user_id'       => Auth::id(),
            'action'        => $action,
            'description'   => $description,
            'loggable_type' => get_class($model),
            'loggable_id'   => $model->id,
            'ip_address'    => Request::ip(),
        ]);
    }
}
