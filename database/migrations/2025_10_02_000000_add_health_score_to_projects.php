<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            if (! Schema::hasColumn('projects', 'health_score')) {
                $table->float('health_score')->nullable();
            }
            if (! Schema::hasColumn('projects', 'health_score_calculated_at')) {
                $table->timestamp('health_score_calculated_at')->nullable()->after('health_score');
            }
            $table->index('health_score', 'projects_health_score_index');
        });
    }

    public function down(): void
    {
        Schema::table('projects', function (Blueprint $table) {
            // Drop index if exists
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            $indexes = $sm->listTableIndexes('projects');
            if (isset($indexes['projects_health_score_index'])) {
                $table->dropIndex('projects_health_score_index');
            }
            if (Schema::hasColumn('projects', 'health_score_calculated_at')) {
                $table->dropColumn('health_score_calculated_at');
            }
            if (Schema::hasColumn('projects', 'health_score')) {
                $table->dropColumn('health_score');
            }
        });
    }
};
