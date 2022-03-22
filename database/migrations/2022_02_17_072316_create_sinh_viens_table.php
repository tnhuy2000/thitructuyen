<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSinhViensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinhvien', function (Blueprint $table) {
            $table->string('masinhvien');
            $table->string('malop');
            $table->foreign('malop') //cột khóa ngoại là cột `makhoa` trong table `sanpham`
                ->references('malop')->on('lop')//cột sẽ tham chiếu đến là cột `makhoa` trong table `khoa`   
                ->onDelete('RESTRICT')
                ->onUpdate('CASCADE');
            $table->string('holot');
            $table->string('ten');
            $table->string('email')->unique();
            $table->string('dienthoai');
            $table->primary(['masinhvien']);
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
        Schema::dropIfExists('sinhvien');
    }
}
