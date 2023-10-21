<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListFilterConditionsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listfilterconditions', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('listfilter_id');            
            $table->string('connection',10);
            $table->string('field',50);
            $table->string('relation',20);
            $table->string('condition',50);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listfilterconditions');
    }
}
