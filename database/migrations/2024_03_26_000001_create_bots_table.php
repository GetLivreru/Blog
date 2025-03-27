<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bots', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('type'); // Тип бота (например: 'user', 'admin', 'moderator')
            $table->boolean('is_active')->default(true);
            $table->json('settings')->nullable(); // Дополнительные настройки бота
            $table->timestamp('last_activity')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bots');
    }
}; 