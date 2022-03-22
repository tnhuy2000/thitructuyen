<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCaThisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cathi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kythi_id')->constrained('kythi'); 
            $table->string('tenca');
            $table->date('ngaythi');
            $table->time('giobatdau');
            $table->string('matkhaucathi');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate();
            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('cathi');
    }
}
