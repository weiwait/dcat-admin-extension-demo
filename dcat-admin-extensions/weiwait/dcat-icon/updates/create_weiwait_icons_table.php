<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeiwaitIcon extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weiwait_icons', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->comment('名称');
            $table->text('icon')->comment('内容');
            $table->unsignedTinyInteger('type')->default(0)->comment('类型');
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
        Schema::dropIfExists('weiwait_icons');
    }
}
