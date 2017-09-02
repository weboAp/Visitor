<?php

    use Illuminate\Database\Migrations\Migration;
    use Illuminate\Database\Schema\Blueprint;

    class CreateVisitorRegistry extends Migration
    {
        /**
         * Run the migrations.
         *
         * @return void
         */
        public function up()
        {
            Schema::create('visitor_registry', function (Blueprint $table) {
                $table->increments('id');
                $table->string('ip', 32);
                $table->string('country', 4)->nullable();
                $table->integer('clicks')->unsigned()->default(0);
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
            Schema::drop('visitor_registry');
        }
    }
