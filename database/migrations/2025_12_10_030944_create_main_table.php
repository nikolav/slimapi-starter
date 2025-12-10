<?php

use Illuminate\Database\Capsule\Manager as Capsule;
use Illuminate\Database\Schema\Blueprint;

return new class () {
  public function up()
  {
    Capsule::schema()->create('main', function (Blueprint $table) {
      $table->increments('id');
      $table->string('key')->unique();
      $table->json('data')->nullable();
      $table->timestamps();
    });
  }

  public function down()
  {
    Capsule::schema()->dropIfExists('main');
  }
};
