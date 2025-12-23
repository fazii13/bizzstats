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
        Schema::table('transactions', function (Blueprint $table) {
            $table->unsignedBigInteger('recipe_id')->nullable()->after('id'); // Add recipe_id column

             $table->foreign('recipe_id')->references('id')->on('recipes')->onDelete('cascade');
      
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropForeign(['recipe_id']); // Drop the foreign key constraint
            $table->dropColumn('recipe_id'); // Drop the recipe_id column
        
        });
    }
};
