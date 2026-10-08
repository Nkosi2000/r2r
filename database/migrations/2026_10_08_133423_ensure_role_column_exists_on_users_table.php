<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * On the Neon production branch (Postgres 18) the previous migration was recorded as run, but its ALTER TABLE
 * was silently discarded: a schema lookup inside the migration's transaction failed behind the scenes and
 * aborted the transaction. This adds the column only where it is missing, outside a transaction.
 */
return new class extends Migration
{
    /**
     * Schema lookups can abort a Postgres transaction without raising, which silently discards the ALTER TABLE.
     */
    public $withinTransaction = false;

    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (Schema::hasColumn('users', 'role')) {
            return;
        }

        Schema::table('users', function (Blueprint $table) {
            $table->string('role')->default('editor');
        });
    }

    /**
     * Reverse the migrations. The column belongs to the previous migration, which drops it.
     */
    public function down(): void
    {
        //
    }
};
