<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('notes', function (Blueprint $table) {
            $table->id();
            $table->boolean('private')->default(false);
            $table->unsignedBigInteger("noteof_id")->nullable();
            $table->string("noteof_type")->nullable();
            $table->string('title')->nullable();
            $table->string('author');
            $table->text('note')->nullable();
            $table->timestamps();

            $table->index(['noteof_id', 'noteof_type'], 'ix_notes_noteof_id_noteof_type_index');

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('notes', function (Blueprint $table) {
            $table->dropIndex('ix_notes_noteof_id_noteof_type_index');

            $table->dropSoftDeletes();
        });

        Schema::dropIfExists('notes');
    }
}
