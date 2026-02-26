<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (Schema::hasTable('collection_banner')) {
            return;
        }

        Schema::create('collection_banner', function (Blueprint $table) {
            $table->id();
            $table->string('brand')->nullable();
            $table->string('title')->nullable();
            $table->string('image');
            $table->string('url')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrent()->useCurrentOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collection_banner');
    }
};
