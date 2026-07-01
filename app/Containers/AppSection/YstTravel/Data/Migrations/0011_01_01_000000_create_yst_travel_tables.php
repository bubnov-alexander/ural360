<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    protected $connection = 'yst_travel';

    public function up(): void
    {
        Schema::connection($this->connection)->create('admins', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
        });

        Schema::connection($this->connection)->create('routes', static function (Blueprint $table): void {
            $table->id();
            $table->text('point_a')->nullable();
            $table->text('point_b')->nullable();
        });

        Schema::connection($this->connection)->create('orders', static function (Blueprint $table): void {
            $table->id();
            $table->string('date_arrival', 32)->nullable();
            $table->string('time_arrival', 16)->nullable();
            $table->string('date_departure', 32)->nullable();
            $table->string('time_departure', 16)->nullable();
            $table->unsignedBigInteger('route_id')->nullable()->index();
            $table->text('customer_name')->nullable();
            $table->text('phone')->nullable();
            $table->boolean('prepayment_status')->default(false);
            $table->text('additional_wishes')->nullable();
        });

        Schema::connection($this->connection)->create('catamaran_services', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->integer('quantity')->nullable();
            $table->integer('price')->nullable();
        });

        Schema::connection($this->connection)->create('transfer_services', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->text('vehicle_type')->nullable();
            $table->unsignedBigInteger('route_id')->nullable()->index();
            $table->integer('persons_count')->nullable();
            $table->boolean('driver_included')->default(false);
            $table->integer('price')->nullable();
        });

        Schema::connection($this->connection)->create('supboard_services', static function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('order_id')->nullable()->index();
            $table->integer('supboards_count')->nullable();
            $table->integer('price')->nullable();
        });

        Schema::connection($this->connection)->create('settings', static function (Blueprint $table): void {
            $table->id();
            $table->text('key')->nullable();
            $table->text('value')->nullable();
        });
    }

    public function down(): void
    {
        Schema::connection($this->connection)->dropIfExists('settings');
        Schema::connection($this->connection)->dropIfExists('supboard_services');
        Schema::connection($this->connection)->dropIfExists('transfer_services');
        Schema::connection($this->connection)->dropIfExists('catamaran_services');
        Schema::connection($this->connection)->dropIfExists('orders');
        Schema::connection($this->connection)->dropIfExists('routes');
        Schema::connection($this->connection)->dropIfExists('admins');
    }
};
