<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        Schema::create('posts', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->string('title', 191);
            $table->mediumText('content');
            $table->dateTime('posted_at', 6);
            $table->dateTime('updated_at', 6);
            $table->softDeletes('deleted_at', 6);
        });
        DB::statement('ALTER TABLE `posts` ADD FULLTEXT (`title`) WITH PARSER ngram');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
};
