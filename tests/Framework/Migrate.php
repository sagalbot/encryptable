<?php

namespace Tests\Framework;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

/**
 * Class Migrate
 *
 * Creates the 'encryptable_models' table
 * used for integration testing.
 */
class Migrate extends Migration
{

    protected $connection = 'default';


    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Capsule::schema('default')->create('encryptable_models', function (Blueprint $table) {
            $table->increments('id');
            $table->string('secret');
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
        Capsule::schema('default')->dropIfExists('encryptable_models');
    }
}
