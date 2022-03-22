<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeThisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dethi', function (Blueprint $table) {
            $table->id();
            $table->string('mahocphan');
            $table->foreign('mahocphan') //cột khóa ngoại là cột `makhoa` trong table `sanpham`
            ->references('mahocphan')->on('hocphan')//cột sẽ tham chiếu đến là cột `makhoa` trong table `khoa`   
            ->onDelete('RESTRICT')
            ->onUpdate('CASCADE'); 
            $table->foreignId('kythi_id')->constrained('kythi'); 
            $table->string('thoigianlambai');
            $table->string('hinhthuc');
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
        Schema::dropIfExists('dethi');
    }
}
