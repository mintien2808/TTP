<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('countries', function (Blueprint $table) {
            $table->string('code', 3)->primary();
            $table->string('name', 255);
            $table->jsonb('states')->nullable();
        });
    }

    public function down()
    {
        Schema::dropIfExists('countries');
    }
};
