<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePetugasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('t_petugas', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('nip')->unsigned();
            $table->string('nama_petugas', 200);
            $table->string('email', 150)->unique();
            $table->string('password');
            $table->string('no_telp', 13)->nullable();
            $table->string('slug', 200);
            $table->string('profil')->nullable();
            $table->integer('role_id');
            $table->softDeletes();
            $table->rememberToken();
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
        Schema::dropIfExists('t_petugas');
    }
}
