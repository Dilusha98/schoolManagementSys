<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Carbon\Carbon;

class addStudentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $studentBirthday = Carbon::createFromDate(2000, 1, 1);

        $guardianBirthday = Carbon::createFromDate(1975, 6, 15);

        DB::table('student_management_models')->insert([
            'studentFullName' => Str::random(10),
            'studentInitials' => Str::random(10),
            'studentBirthday' => Carbon::createFromDate(2000, 1, 1),
            'studentGender' => Str::random(10),
            'studentNationality' => Str::random(10),
            'guardianType' => Str::random(10),
            'guardianFullName' => Str::random(10),
            'guardianInitials' => Str::random(10),
            'guardianNIC' => Str::random(10),
            'guardianBirthday' => Carbon::createFromDate(1975, 6, 15),
            'guardianEmail' => Str::random(10).'@gmail.com',
            'guardianAddress' => Str::random(10),
            'guardianPostalCode' => 1234,
            'guardianOccupation' => Str::random(10),
        ]);
    }
}
