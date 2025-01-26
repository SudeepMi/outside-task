<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Cities Data
        $cities = [
            ['name' => 'Kathmandu'],
            ['name' => 'Pokhara'],
            ['name' => 'Lalitpur'],
            ['name' => 'Bhaktapur'],
            ['name' => 'Chitwan'],
            ['name' => 'Dharan'],
            ['name' => 'Butwal'],
            ['name' => 'Biratnagar'],
            ['name' => 'Janakpur'],
            ['name' => 'Hetauda']
        ];

        // Insert cities into the database
        DB::table('cities')->insert($cities);

        // Project Types Data
        $projectTypes = [
            ['name' => 'Residential Building'],
            ['name' => 'Commercial Complex'],
            ['name' => 'Road Construction'],
            ['name' => 'Bridge Construction'],
            ['name' => 'Hydropower Project'],
            ['name' => 'Hospital Project'],
            ['name' => 'School/College'],
            ['name' => 'Government Office'],
            ['name' => 'Shopping Mall'],
            ['name' => 'Heritage Site Restoration']
        ];

        // Insert project types into the database
        DB::table('project_types')->insert($projectTypes);

        // Project Categories Data
        $categories = [
            ['name' => 'Infrastructure'],
            ['name' => 'Education'],
            ['name' => 'Healthcare'],
            ['name' => 'Energy'],
            ['name' => 'Residential'],
            ['name' => 'Commercial'],
            ['name' => 'Heritage'],
        ];

        // Insert project categories into the database
        DB::table('categories')->insert($categories);

        // Projects Data
        $projects = [
            [
                'title' => 'Kathmandu Ring Road Expansion',
                'description' => 'The expansion of the ring road in Kathmandu to improve traffic flow.',
                'featured' => true
            ],
            [
                'title' => 'Pokhara International Airport',
                'description' => 'A newly constructed international airport to boost tourism in Pokhara.',
                'featured' => true
            ],
            [
                'title' => 'Lalitpur Smart City Initiative',
                'description' => 'A smart city project with modern infrastructure and technology-driven services.',
                'featured' => false
            ],
            [
                'title' => 'Chitwan Hydropower Project',
                'description' => 'A hydropower project aimed at increasing energy production in Nepal.',
                'featured' => true
            ],
            [
                'title' => 'Dharan Medical College',
                'description' => 'Construction of a new medical college and hospital in Dharan.',
                'featured' => false
            ]
        ];

        // Insert projects into the database
        DB::table('projects')->insert($projects);

        // Attach projects to cities
        $cityIds = DB::table('cities')->pluck('id')->toArray();
        $projectIds = DB::table('projects')->pluck('id')->toArray();

        foreach ($projectIds as $projectId) {
            // Attach each project to 1-3 random cities
            $randomCities = array_rand($cityIds, rand(1, 3));
            foreach ((array) $randomCities as $cityIndex) {
                DB::table('city_project')->insert([
                    'project_id' => $projectId,
                    'city_id' => $cityIds[$cityIndex]
                ]);
            }
        }

        // Attach projects to categories
        $categoryIds = DB::table('categories')->pluck('id')->toArray();

        foreach ($projectIds as $projectId) {
            // Attach each project to a random category (1-2 categories per project)
            $randomCategories = array_rand($categoryIds, rand(1, 2));
            foreach ((array) $randomCategories as $categoryIndex) {
                DB::table('category_project')->insert([
                    'project_id' => $projectId,
                    'category_id' => $categoryIds[$categoryIndex]
                ]);
            }
        }

        // Attach projects to project types
        $projectTypeIds = DB::table('project_types')->pluck('id')->toArray();

        foreach ($projectIds as $projectId) {
            // Attach each project to 1-2 random project types
            $randomTypes = array_rand($projectTypeIds, rand(1, 2));
            foreach ((array) $randomTypes as $typeIndex) {
                DB::table('project_project_type')->insert([
                    'project_id' => $projectId,
                    'project_type_id' => $projectTypeIds[$typeIndex]
                ]);
            }
        }
    }
}
