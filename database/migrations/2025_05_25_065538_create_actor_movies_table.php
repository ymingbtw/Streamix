<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('actor_movies', function (Blueprint $table) {
            $table->foreignUuid('actor_id')->constrained()->onDelete('cascade');
            $table->foreignUuid('movie_id')->constrained()->onDelete('cascade');
            $table->string('character');
            $table->primary(['actor_id', 'movie_id']); // composite PK
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actor_movies');
    }
};
