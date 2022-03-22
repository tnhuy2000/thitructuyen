<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateThongBaosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('thongbao', function (Blueprint $table) {
            $table->id();
            $table->string('macanbo');
            $table->foreign('macanbo') //cột khóa ngoại là cột `makhoa` trong table `sanpham`
            ->references('macanbo')->on('hoidongthi')//cột sẽ tham chiếu đến là cột `makhoa` trong table `khoa`   
            ->onDelete('RESTRICT')
            ->onUpdate('CASCADE');
            $table->string('tieude');
            $table->string('noidung');
            $table->date('ngaydang');
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
        Schema::dropIfExists('thong_baos');
    }
}
