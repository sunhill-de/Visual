<?php
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateListFiltersTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listfilters', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('bestbefore')->nullable()->default(null);
            $table->string('name',40);
            $table->string('name_id',10);
            $table->string('list',40);
            $table->unique(['name_id','list']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('listfilters');
    }
}
