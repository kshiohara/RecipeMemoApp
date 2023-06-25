<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRecipesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('recipes', function (Blueprint $table) {
            // 主キー
            $table->id('id');
            // ユーザーID
            $table->unsignedBigInteger('user_id');
            // レシピ名
            $table->string('name', 100);
            // リンク名
            $table->string('link', 2084);
            // 評価
            $table->tinyInteger('rating');
            // 作成状況
            $table->tinyInteger('status');
            // 感想
            $table->text('comment');
            // 作成日時
            $table->timestamps();

            // ユーザーID外部キー制約、onDelete('cascade'):ユーザーIDが削除されたら一緒にレシピも削除される
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');;
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('recipes');
    }
}
