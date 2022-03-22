<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHoiDongThisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hoidongthi', function (Blueprint $table) {
            $table->string('macanbo');
            $table->string('makhoa');
            $table->foreign('makhoa') //cột khóa ngoại là cột `makhoa` trong table `sanpham`
                ->references('makhoa')->on('khoa')//cột sẽ tham chiếu đến là cột `makhoa` trong table `khoa`   
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');  
            $table->string('holot');
            $table->string('ten');
            $table->string('email')->unique();
            $table->string('dienthoai');
            $table->string('vaitro');
            $table->primary(['macanbo']);
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
        Schema::dropIfExists('hoidongthi');
    }
}
