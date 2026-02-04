<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;

trait CompanyScoped
{
    protected static function bootCompanyScoped()
    {
        static::addGlobalScope('company', function (Builder $builder) {
            $companyId = session('company_id');

            // If no company in session, block results (safer than showing all)
            if (!$companyId) {
                $builder->whereRaw('1=0');
                return;
            }

            $builder->where($builder->getModel()->getTable() . '.company_id', $companyId);
        });
    }

    // Optional helper: bypass scope when needed (admin/system)
    public static function withoutCompanyScope()
    {
        return static::withoutGlobalScope('company');
    }
}
