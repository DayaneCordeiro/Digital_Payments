<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Wallet;
use App\Models\User;

class CreateLogWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('log_wallets', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Wallet::class);
            $table->foreignIdFor(User::class);
            $table->string('changed_column');
            $table->string('old_value');
            $table->string('new_value');
            $table->timestampTz('created_at')->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('log_wallets');
    }
}
