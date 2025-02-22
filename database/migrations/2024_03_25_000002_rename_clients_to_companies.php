<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
                $table->uuid('id')->primary();
                $table->string('name');
                $table->string('domain')->unique();
                $table->string('database');
                $table->boolean('active')->default(true);
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('company_modules')) {
            Schema::create('company_modules', function (Blueprint $table) {
                $table->uuid('company_id');
                $table->uuid('module_id');
                $table->boolean('active')->default(true);
                $table->timestamps();

                $table->primary(['company_id', 'module_id']);
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
                $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            });
        }

        if (!Schema::hasColumn('users', 'company_id')) {
            Schema::table('users', function (Blueprint $table) {
                $table->uuid('company_id')->nullable();
                $table->boolean('is_company_admin')->default(false);
                $table->foreign('company_id')->references('id')->on('companies')->onDelete('set null');
            });
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['company_id']);
            $table->dropColumn(['company_id', 'is_company_admin']);
        });

        Schema::dropIfExists('company_modules');
        Schema::dropIfExists('companies');
    }
};