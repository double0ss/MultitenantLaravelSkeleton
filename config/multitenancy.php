<?php

use Illuminate\Database\Eloquent\Model;

return [
    'tenant_finder' => null,
    'tenant_model' => App\Models\Company::class,
    'current_tenant_container_key' => 'currentCompany',
    'switch_tenant_tasks' => [
        Spatie\Multitenancy\Tasks\SwitchTenantDatabaseTask::class,
    ],
];