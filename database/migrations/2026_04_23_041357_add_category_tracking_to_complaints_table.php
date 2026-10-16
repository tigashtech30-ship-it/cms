<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->foreignId('category_id')->nullable()->constrained('categories')->nullOnDelete()->after('branch_id');
            $table->string('tracking_number')->nullable()->unique()->after('id');
            $table->string('customer_id')->nullable()->after('tracking_number');
            $table->string('customer_name')->nullable()->after('customer_id');
            $table->string('attachment')->nullable()->after('admin_note');
        });
    }

    public function down(): void
    {
        Schema::table('complaints', function (Blueprint $table) {
            $table->dropForeign(['category_id']);
            $table->dropColumn(['category_id','tracking_number','customer_id','customer_name','attachment']);
        });
    }
};