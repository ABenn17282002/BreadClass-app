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
            // 外部キー制約(管理者idに紐づくもの)
            $table->foreignId('administrators_id')
            ->references('id')
            ->on('administrators')
            ->constrained()
            // Delete時の対応で外部制約のため必要
            ->onUpdate('cascade')
            ->onDelete('cascade');
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
