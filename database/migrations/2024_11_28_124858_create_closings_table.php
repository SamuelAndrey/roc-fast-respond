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
            $table->string('group_name')->nullable(false);
            $table->text('requester_identity')->nullable(false);
            $table->text('approval_identity')->nullable(false);
            $table->string('category')->nullable(false);
            $table->string('ticket')->nullable(false);
            $table->string('witel')->nullable(false);
            $table->string('reason')->nullable(false);
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
