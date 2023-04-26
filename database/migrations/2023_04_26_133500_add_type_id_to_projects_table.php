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
        Schema::table('projects', function (Blueprint $table) {

            // 1 - Creazione Colonna 'type_id' (FK)
            $table->unsignedBigInteger('type_id')->nullable()->after('id');

            // 2 - Indicazione Contenuto [Relazione tra 'type_id' (FK) e 'id' (PK Tabella "Types")]
            $table->foreign('type_id')->references('id')->on('types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {

            // 2 - Eliminazione Relazione
            $table->dropForeign(['type_id']);

            // 1 - Eliminazione Colonna FK
            $table->dropColumn('type_id');
        });
    }
};
