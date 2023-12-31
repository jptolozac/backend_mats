<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            //$table->timestamp('email_verified_at')->nullable();
            $table->string('password');

            $table->unsignedBigInteger('permiso_id');
            $table->unsignedBigInteger('tipo_usuario_id');

            $table->rememberToken();
            $table->timestamps();

            $table->foreign('permiso_id')->references('id')->on('permisos');
            $table->foreign('tipo_usuario_id')->references('id')->on('tipo_usuarios');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
