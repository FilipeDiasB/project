<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePropertiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->boolean('sale')->nullable();
            $table->boolean('rent')->nullable();
            $table->string('category');
            $table->string('type');
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');


            // Price and values
            $table->decimal('sale_price', 10, 2)->nullable();
            $table->decimal('rent_price', 10, 2)->nullable();
            $table->decimal('tribute', 10, 2)->nullable();
            $table->decimal('condominium', 10, 2)->nullable();

            // Description
            $table->string('description');
            $table->string('bedrooms')->default('0');
            $table->string('suites')->default('0');
            $table->string('bathrooms')->default('0');
            $table->string('rooms')->default('0');
            $table->string('garage')->default('0');
            $table->string('garage_covered')->default('0');
            $table->string('area_total')->default('0');
            $table->string('area_util')->default('0');

            // Address
            $table->string('zipcode')->nullable();
            $table->string('street')->nullable();
            $table->string('number')->nullable();
            $table->string('complement')->nullable();
            $table->string('neighborhood')->nullable();
            $table->string('state')->nullable();
            $table->string('city')->nullable();

            // Structure
            $table->boolean('air_conditioning')->nullable();
            $table->boolean('bar')->nullable();
            $table->boolean('library')->nullable();
            $table->boolean('barbecue_grill')->nullable();
            $table->boolean('american_kitchen')->nullable();
            $table->boolean('fitted_kitchen')->nullable();
            $table->boolean('pantry')->nullable();
            $table->boolean('edicule')->nullable();
            $table->boolean('office')->nullable();
            $table->boolean('bathtub')->nullable();
            $table->boolean('fireplace')->nullable();
            $table->boolean('lavatory')->nullable();
            $table->boolean('furnished')->nullable();
            $table->boolean('pool')->nullable();
            $table->boolean('steam_room')->nullable();
            $table->boolean('view_of_the_sea')->nullable();

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
        Schema::dropIfExists('properties');
    }
}
