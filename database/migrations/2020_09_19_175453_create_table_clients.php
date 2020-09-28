<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('cod')->index();
            $table->date('next_due_date');
            $table->enum('method_payment',['Transferencia','Boleto']);
            $table->enum('app',['SmartUp','SS IPTV','Duplex Iptv','Smart Iptv','BRTV P2P','XC IPTV']);
            $table->float('monthly_payment',18,2)->nullable()->default(35);
            $table->integer('number_points')->default(1);
            $table->string('code_ssiptv')->nullable();
            $table->string('code_duplex')->nullable();
            $table->string('email_smart_up')->nullable();
            $table->text('observations')->nullable();
            $table->integer('responsible');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('clients');
    }
}
