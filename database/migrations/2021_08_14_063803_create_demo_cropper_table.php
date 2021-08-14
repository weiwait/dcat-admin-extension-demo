<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemoCropperTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('demo_cropper', function (Blueprint $table) {
            $table->increments('id');
            $table->string('cropper')->default('')->comment('裁剪');
            $table->string('cropper2')->default('')->comment('裁剪2');
            $table->string('image')->default('')->comment('图片');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('demo_cropper');
    }
}
