<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::table('products')
            ->select(['id', 'options'])
            ->orderBy('id')
            ->get()
            ->each(function (object $product): void {
                $options = json_decode($product->options ?? '[]', true) ?: [];
                $flavors = array_is_list($options)
                    ? $options
                    : ($options['flavors'] ?? []);

                DB::table('products')
                    ->where('id', $product->id)
                    ->update([
                        'options' => json_encode([
                            'flavors' => array_values($flavors),
                            'sizes' => ['4-inch', '6-inch'],
                        ]),
                    ]);
            });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('products')
            ->select(['id', 'options'])
            ->orderBy('id')
            ->get()
            ->each(function (object $product): void {
                $options = json_decode($product->options ?? '[]', true) ?: [];

                DB::table('products')
                    ->where('id', $product->id)
                    ->update([
                        'options' => json_encode($options['flavors'] ?? []),
                    ]);
            });
    }
};
