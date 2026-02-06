<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Session;
use RuntimeException;

trait CompanyScoped
{
    protected static function bootCompanyScoped()
    {
        // 1) Always filter by company_id from session
        static::addGlobalScope('company', function (Builder $builder) {
            $companyId = Session::get('company_id');

            // safer: show nothing if not set
            if (!$companyId) {
                $builder->whereRaw('1=0');
                return;
            }

            $builder->where($builder->getModel()->getTable() . '.company_id', $companyId);
        });

        // 2) Auto-set company_id on create
        static::creating(function ($model) {
            $companyId = Session::get('company_id');

            if (!$companyId) {
                throw new RuntimeException('company_id not found in session.');
            }

            // Only set if not already set manually
            if (empty($model->company_id)) {
                $model->company_id = $companyId;
            }
        });

        // Optional: prevent changing company_id on update
        static::updating(function ($model) {
            if ($model->isDirty('company_id')) {
                $model->company_id = $model->getOriginal('company_id');
            }
        });
    }

    public static function withoutCompanyScope()
    {
        return static::withoutGlobalScope('company');
    }
}
