<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->string('tipo');
            $table->decimal('monto', 10, 2); 
            $table->unsignedBigInteger('id_account'); 
            $table->decimal('saldo', 10, 2);
            $table->timestamps();

            // Establecer una clave foránea para el ID de usuario
            $table->foreign('id_account')->references('id')->on('accounts')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
