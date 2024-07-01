<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\User;
use App\Models\Grade;
use App\Models\Section;
use App\Models\Classroom;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();
        DB::table('bus_coordinates')->insert([
            'latitude' => 0,
            'longitude' => 0
        ]);
        $grades =
            [
                ['name' => 'Primary'],
                ['name' => 'Secondary'],
                ['name' => 'preparatory'],
            ];
        $classrooms = [
            ['name' => 'First Class', 'grade_id' => 1],
            ['name' => 'Second Class', 'grade_id' => 1],
            ['name' => 'Third Class', 'grade_id' => 1],
            ['name' => 'Fourth Class', 'grade_id' => 1],
            ['name' => 'Fifth Class', 'grade_id' => 1],
            ['name' => 'Sixth Class', 'grade_id' => 1],
            ['name' => 'First Class', 'grade_id' => 2],
            ['name' => 'Second Class', 'grade_id' => 2],
            ['name' => 'Third Class', 'grade_id' => 2],
            ['name' => 'First Class', 'grade_id' => 3],
            ['name' => 'Second Class', 'grade_id' => 3],
            ['name' => 'Third Class', 'grade_id' => 3],
        ];

        User::factory()->create([
            'name' => 'Admin',
            'email' => 'bus.tracking6@gmail.com',
            'phone' => '01116796790',
            'password' => Hash::make('admin1234'),
            'email_verified_at' => now(),
            'role' => 'admin'
        ]);
        foreach ($grades as $grade) {
            Grade::create($grade);
        }
        foreach ($classrooms as $classroom) {
            Classroom::create($classroom);
        }
        for ($i = 1; $i <= 12; $i++) {
            Section::create(
                ['name' => 'A', 'classroom_id' => $i]
            );
            Section::create(
                ['name' => 'B', 'classroom_id' => $i]
            );
            Section::create(
                ['name' => 'C', 'classroom_id' => $i]
            );
        }
    }
}
