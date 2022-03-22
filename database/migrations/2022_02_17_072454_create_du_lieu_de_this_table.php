<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDuLieuDeThisTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dulieudethi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dethi_id')->constrained('dethi');
            
            $table->string('duongdan');
            $table->integer('thutuhienthi');
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
        Schema::dropIfExists('dulieudethi');
    }
}
