<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhongThisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phongthi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cathi_id')->constrained('cathi'); 
            $table->string('maphong');
            $table->integer('soluongthisinh');
            $table->string('ma_meeting');
            $table->string('ghichu');
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
        Schema::dropIfExists('phongthi');
    }
}
