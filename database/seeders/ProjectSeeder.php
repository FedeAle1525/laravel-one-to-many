<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Faker $faker)
    {
        for ($i = 0; $i < 50; $i++) {

            $project = new Project();

            $project->name = $faker->unique()->words($faker->numberBetween(2, 6), true);
            // Grazie a una 'helper function' di Laravel posso generare slug da un metodo statico
            $project->slug = Str::slug($project->name, '-');
            $project->description = $faker->optional()->text(300);
            $project->client = $faker->name($gender = 'male' | 'female');
            $project->url = $faker->optional()->url();

            $project->save();
        }
    }
}
