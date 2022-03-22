<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSinhVienPhongThisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sinhvien_phongthi', function (Blueprint $table) {
            $table->id();
            $table->string('masinhvien');
            $table->foreign('masinhvien') //cột khóa ngoại là cột `makhoa` trong table `sanpham`
            ->references('masinhvien')->on('sinhvien')//cột sẽ tham chiếu đến là cột `makhoa` trong table `khoa`   
            ->onDelete('RESTRICT')
            ->onUpdate('CASCADE');  
            $table->foreignId('phongthi_id')->constrained('phongthi'); 
            $table->integer('diemdanh');
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
        Schema::dropIfExists('sinhvien_phongthi');
    }
}
