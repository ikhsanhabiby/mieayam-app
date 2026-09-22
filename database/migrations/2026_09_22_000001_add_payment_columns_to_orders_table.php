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
        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'total_bayar')) {
                $table->integer('total_bayar')->default(0)->after('menu_pesanan');
            }
            if (!Schema::hasColumn('orders', 'status_pembayaran')) {
                $table->string('status_pembayaran')->default('menunggu_konfirmasi')->after('metode_pembayaran');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            if (Schema::hasColumn('orders', 'status_pembayaran')) {
                $table->dropColumn('status_pembayaran');
            }
            if (Schema::hasColumn('orders', 'total_bayar')) {
                $table->dropColumn('total_bayar');
            }
        });
    }
};
