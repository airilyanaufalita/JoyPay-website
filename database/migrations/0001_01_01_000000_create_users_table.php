<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Check if columns don't exist before adding
            
            if (!Schema::hasColumn('users', 'address')) {
                $table->text('address')->nullable()->after('email_verified_at');
            }
            
            if (!Schema::hasColumn('users', 'phone')) {
                $table->string('phone', 15)->nullable()->after('address');
            }
            
            if (!Schema::hasColumn('users', 'emergency_phone')) {
                $table->string('emergency_phone', 15)->nullable()->after('phone');
            }
            
            if (!Schema::hasColumn('users', 'social_media')) {
                $table->string('social_media')->nullable()->after('emergency_phone');
            }
            
            if (!Schema::hasColumn('users', 'bank')) {
                $table->string('bank', 50)->nullable()->after('social_media');
            }
            
            if (!Schema::hasColumn('users', 'account_number')) {
                $table->string('account_number', 50)->nullable()->after('bank');
            }
            
            if (!Schema::hasColumn('users', 'status')) {
                $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('account_number');
            }
            
            if (!Schema::hasColumn('users', 'type')) {
                $table->string('type', 20)->default('regular')->after('status');
            }
            
            if (!Schema::hasColumn('users', 'approved_by')) {
                $table->unsignedBigInteger('approved_by')->nullable()->after('type');
            }
            
            if (!Schema::hasColumn('users', 'approved_at')) {
                $table->timestamp('approved_at')->nullable()->after('approved_by');
            }
            
            if (!Schema::hasColumn('users', 'rejected_by')) {
                $table->unsignedBigInteger('rejected_by')->nullable()->after('approved_at');
            }
            
            if (!Schema::hasColumn('users', 'rejected_at')) {
                $table->timestamp('rejected_at')->nullable()->after('rejected_by');
            }
            
            if (!Schema::hasColumn('users', 'rejection_reason')) {
                $table->text('rejection_reason')->nullable()->after('rejected_at');
            }
            
            if (!Schema::hasColumn('users', 'improvement_suggestion')) {
                $table->text('improvement_suggestion')->nullable()->after('rejection_reason');
            }
            
            if (!Schema::hasColumn('users', 'notes')) {
                $table->text('notes')->nullable()->after('improvement_suggestion');
            }
            
            if (!Schema::hasColumn('users', 'occupation')) {
                $table->string('occupation')->nullable()->after('notes');
            }
            
            if (!Schema::hasColumn('users', 'income')) {
                $table->string('income')->nullable()->after('occupation');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $columnsToCheck = [
                'username', 'address', 'phone', 'emergency_phone', 'social_media',
                'bank', 'account_number', 'status', 'type', 'approved_by', 
                'approved_at', 'rejected_by', 'rejected_at', 'rejection_reason',
                'improvement_suggestion', 'notes', 'occupation', 'income'
            ];
            
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('users', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};