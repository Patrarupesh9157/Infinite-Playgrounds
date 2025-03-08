<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Concept;
use App\Models\Yarn;
use App\Models\Area;
use App\Models\Fabric;
use App\Models\TechnicallyConcept;
use App\Models\Panna;
use App\Models\UseIn;

class CategorySeeder extends Seeder
{
    public function run()
    {
        // Data for each category
        $concepts = [
            ['name' => 'Allover'],
            ['name' => 'Daman'],
            ['name' => 'Butta'],
            ['name' => 'Butti'],
            ['name' => 'Patta'],
        ];

        $yarns = [
            ['name' => 'Bright polyester'],
            ['name' => 'Full dull'],
            ['name' => 'Semi dull'],
            ['name' => 'Cottan'],
            ['name' => 'Viscose'],
            ['name' => 'Color'],
        ];

        $areas = [
            ['name' => '4/4'],
            ['name' => '8/4'],
            ['name' => '12/4'],
            ['name' => '16/4'],
            ['name' => '20/4'],
        ];

        $fabrics = [
            ['name' => 'Net'],
            ['name' => 'p.c. Cottan'],
            ['name' => 'Cottan'],
            ['name' => 'Rayon'],
            ['name' => 'Georget'],
            ['name' => 'Nazmin'],
        ];

        $technicallyConcepts = [
            ['name' => 'Plain'],
            ['name' => 'Sequence'],
            ['name' => 'Borer'],
        ];

        $pannas = [
            ['name' => 'Small'],
            ['name' => 'Medium'],
            ['name' => 'Big'],
        ];

        $useIns = [
            ['name' => 'Saree'],
            ['name' => 'Suit'],
            ['name' => 'Kurti'],
            ['name' => 'Kurta Men’s'],
            ['name' => 'Top'],
            ['name' => 'Plazo'],
            ['name' => 'Baby Garment'],
            ['name' => 'Inner Wear'],
        ];

        // Insert or update data for each category using Eloquent models
        foreach ($concepts as $concept) {
            Concept::updateOrCreate(['name' => $concept['name']], $concept);
        }

        foreach ($yarns as $yarn) {
            Yarn::updateOrCreate(['name' => $yarn['name']], $yarn);
        }

        foreach ($areas as $area) {
            Area::updateOrCreate(['name' => $area['name']], $area);
        }

        foreach ($fabrics as $fabric) {
            Fabric::updateOrCreate(['name' => $fabric['name']], $fabric);
        }

        foreach ($technicallyConcepts as $technicallyConcept) {
            TechnicallyConcept::updateOrCreate(['name' => $technicallyConcept['name']], $technicallyConcept);
        }

        foreach ($pannas as $panna) {
            Panna::updateOrCreate(['name' => $panna['name']], $panna);
        }

        foreach ($useIns as $useIn) {
            UseIn::updateOrCreate(['name' => $useIn['name']], $useIn);
        }

        $this->command->info('All categories seeded successfully using models!');
    }
}
