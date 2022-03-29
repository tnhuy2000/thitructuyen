<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVanBansTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vanban', function (Blueprint $table) {
			$table->id('id');
			$table->foreignId('thongbao_id')->constrained()->on('thongbao');
			$table->string('tenvanban');
			$table->string('tenvanbankhongdau');
			$table->string('duongdan');
			$table->unsignedInteger('luotdownload')->default(0);
			$table->unsignedTinyInteger('kichhoat')->default(1);
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
        Schema::dropIfExists('vanban');
    }
}
