<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateChatApps extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Many-to-many relationship with user_group
         * 
         */
        Schema::create('chat_apps', function (Blueprint $table) {
            $table->id();
            $table->string('hash');
            $table->foreignId('company_id')
                ->constrained()
                ->onDelete('cascade');
            $table->string('name');
            $table->string('domain');
            $table->timestamps();

            $table->index(['hash', 'company_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('chat_apps');
    }
}
