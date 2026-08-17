<?php

namespace Database\Seeders;

use App\Models\Module;
use Illuminate\Database\Seeder;

class UnlockModulesSeeder extends Seeder
{
    /**
     * Libera os módulos principais para acesso
     */
    public function run(): void
    {
        $modules = ['fundamentos', 'condicoes', 'loops', 'arrays', 'funcoes', 'strings'];

        foreach ($modules as $slug) {
            Module::where('slug', $slug)->update(['is_available' => true]);
        }

        echo "\n✓ Módulos liberados: ".implode(', ', $modules)."\n";
    }
}
