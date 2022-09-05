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
        // postsテーブル
        Schema::create('posts', function (Blueprint $table) {
            $table->string('id', 191)->primary();
            $table->string('title', 191);
            $table->mediumText('content');
            $table->dateTime('posted_at', 6);
            $table->dateTime('updated_at', 6);
            $table->softDeletes('deleted_at', 6);
        });
        DB::statement('ALTER TABLE `posts` ADD FULLTEXT (`title`) WITH PARSER ngram');

        // tagsテーブル
        Schema::create('tags', function (Blueprint $table) {
            $table->string('id', 191)->primary();
        });

        // posts_tagsテーブル
        Schema::create('posts_tags', function (Blueprint $table) {
            $table->string('tag_id', 191);
            $table->string('post_id', 191);
            $table->primary(['tag_id', 'post_id']);
            $table->foreign('tag_id')
                  ->references('id')
                  ->on('tags')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
            $table->foreign('post_id')
                  ->references('id')
                  ->on('posts')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts_tags');
        Schema::dropIfExists('tags');
        Schema::dropIfExists('posts');
    }
};
