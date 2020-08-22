<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriptionItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /**
         * Commented due to this app using a different structure from 
         * Laravel Cashier's default(using User model). This app uses 
         * Company instead of User.
         */
        // Schema::create('subscription_items', function (Blueprint $table) {
        //     $table->bigIncrements('id');
        //     $table->unsignedBigInteger('subscription_id');
        //     $table->string('stripe_id')->index();
        //     $table->string('stripe_plan');
        //     $table->integer('quantity');
        //     $table->timestamps();

        //     $table->unique(['subscription_id', 'stripe_plan']);
        // });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('subscription_items');
    }
}
