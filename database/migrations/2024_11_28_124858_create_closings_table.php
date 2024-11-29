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
        Schema::create('closings', function (Blueprint $table) {
            $table->id();
            $table->string('ticket_id')->unique()->nullable();
            $table->bigInteger('chat_id')->nullable();
            $table->bigInteger('message_id')->nullable();
            $table->string('group_name')->nullable();
            $table->text('requester_identity')->nullable();
            $table->text('approval_identity')->nullable();
            $table->text('message')->nullable();
            $table->string('category')->nullable();
            $table->string('ticket')->nullable();
            $table->string('witel')->nullable();
            $table->string('reason')->nullable();
            $table->tinyInteger('status')->nullable(false)->default(0);
            $table->string('solver')->nullable();
            $table->text('action')->nullable();
            $table->integer('duration')->nullable();
            $table->timestamps();
            $table->timestamp('solved_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('closings');
    }
};
