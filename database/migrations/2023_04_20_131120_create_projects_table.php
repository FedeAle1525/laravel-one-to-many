<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name', 150)->unique();
            // Campo Univoco generato dal Nome come riconoscimento al posto di ID
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('client', 100);
            $table->text('url')->nullable();
            // Campo che serve per poter la gestione del recupero di elementi eliminati 
            // [DA RICORDARE: importare Traits 'SoftDeletes' nel Model]
            $table->softDeletes();
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
        Schema::dropIfExists('projects');
    }
};
