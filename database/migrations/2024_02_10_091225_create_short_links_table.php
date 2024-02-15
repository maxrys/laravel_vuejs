<?php

use App\Models\ShortLinks as ShortLinksModel;
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
        Schema::create('short_links', function (Blueprint $table) {
            $table->char('id', 6)->charset('binary')->primary();
            $table->string('link', ShortLinksModel::LINK_MAX_LENGTH)->charset('latin1');
            $table->boolean('safe_status_bool')->nullable();
            $table->string('safe_status_text', 20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('short_links');
    }
};
