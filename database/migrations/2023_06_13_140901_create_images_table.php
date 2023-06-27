<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('images', function (Blueprint $table) {
            $table->id();
            // 画像名
            $table->string('filename');
            // title:null可
            $table->string('title')->nullable();
            // altkey:null可
            $table->string('alt')->nullable();
            // 管理者ID:null可
            $table->unsignedBigInteger('administrators_id')->nullable();
            // 外部キー制約(管理者idに紐づくもの)
            $table->foreign('administrators_id')
            ->nullable()->references('id')
            ->on('administrators')
            // 削除、更新時対応
            ->onDelete('set null')->onUpdate('cascade');
            // 講師ID:null可
            $table->unsignedBigInteger('teachers_id')->nullable();
            $table->foreign('teachers_id')->nullable()
            ->references('id')->on('teachers')
            ->onDelete('set null')->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('images');
    }
};
