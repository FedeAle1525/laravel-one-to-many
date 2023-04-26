<?php

namespace Database\Seeders;

use App\Models\Type;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    // Uso un Array predefinito di Tipologie per popolare la Tabella Types 
    public function run()
    {
        $types = ['Informatico', 'Lettererale', 'Scientifico', 'Design', 'Musicale', 'Artistico'];

        foreach ($types as $type) {

            $newType = new Type();

            $newType->name = $type;
            $newType->slug = Str::slug($newType->name, '-');

            $newType->save();
        }
    }
}
