<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->unsignedBigInteger('dosen_pembimbing_id_2')->nullable()->after('dosen_pembimbing_id');
        });
    }

    public function down()
    {
        Schema::table('proposals', function (Blueprint $table) {
            $table->dropColumn('dosen_pembimbing_id_2');
        });
    }
};
