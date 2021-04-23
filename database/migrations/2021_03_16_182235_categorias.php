<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class Categorias extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
        });
        $this->create();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('categorias');
    }

    /**
     * init population
     *
     * @return void
     */
    public function create(){
        $data = array(
            ['nome' => 'paquera'],
            ['nome' => 'encontros'],
            ['nome' => 'relacionamentos'],
            ['nome' => 'saude'],
            ['nome' => 'sexualidade'],
            ['nome' => 'fim de relacionamento'],
            ['nome' => 'comportamento'],
            ['nome' => 'estilo'],
            ['nome' => 'outros']
        );
        DB::table('categorias')->insert($data);
    }
}
