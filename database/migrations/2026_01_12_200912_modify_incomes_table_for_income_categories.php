<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if income_categories table exists before modifying incomes table
        if (Schema::hasTable('income_categories')) {
            Schema::table('incomes', function (Blueprint $table) {
                // Drop old string columns if they exist
                if (Schema::hasColumn('incomes', 'income_category_id')) {
                    $table->dropColumn('income_category_id');
                }
                if (Schema::hasColumn('incomes', 'income_category_id_2')) {
                    $table->dropColumn('income_category_id_2');
                }
            });

            Schema::table('incomes', function (Blueprint $table) {
                // Add new integer column with foreign key
                $table->integer('income_category_id')->nullable()->unsigned()->after('location_id');
                $table->foreign('income_category_id')->references('id')->on('income_categories')->onDelete('cascade');
                $table->index('income_category_id');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('incomes') && Schema::hasColumn('incomes', 'income_category_id')) {
            Schema::table('incomes', function (Blueprint $table) {
                $table->dropForeign(['income_category_id']);
                $table->dropIndex(['income_category_id']);
                $table->dropColumn('income_category_id');
            });

            Schema::table('incomes', function (Blueprint $table) {
                $table->string('income_category_id')->nullable()->after('location_id');
            });
        }
    }
};
