<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\College;

class CollegeSeeder extends Seeder
{
    public function run(): void
    {
        $colleges = [
            ['name' => 'Jain University', 'short_name' => 'Jain', 'area' => 'Jayanagar', 'lat' => 12.9317, 'lng' => 77.5950, 'slug' => 'jain-university'],
            ['name' => 'Dayananda Sagar University', 'short_name' => 'DSU', 'area' => 'Kumaraswamy Layout', 'lat' => 12.8913, 'lng' => 77.5799, 'slug' => 'dayananda-sagar-university'],
            ['name' => 'Christ University', 'short_name' => 'Christ', 'area' => 'Hosur Road', 'lat' => 12.9360, 'lng' => 77.6069, 'slug' => 'christ-university'],
            ['name' => 'RV College of Engineering', 'short_name' => 'RVCE', 'area' => 'Mysore Road', 'lat' => 12.9231, 'lng' => 77.4988, 'slug' => 'rv-college-of-engineering'],
            ['name' => 'PES University', 'short_name' => 'PES', 'area' => 'Rajajinagar', 'lat' => 12.9720, 'lng' => 77.5531, 'slug' => 'pes-university'],
            ['name' => 'Bangalore Institute of Technology', 'short_name' => 'BIT', 'area' => 'Basavanagudi', 'lat' => 12.9360, 'lng' => 77.5717, 'slug' => 'bangalore-institute-of-technology'],
            ['name' => 'MS Ramaiah Institute of Technology', 'short_name' => 'MSRIT', 'area' => 'Mathikere', 'lat' => 13.0226, 'lng' => 77.5605, 'slug' => 'ms-ramaiah-institute-of-technology'],
            ['name' => 'Bangalore University (Central College)', 'short_name' => 'BU', 'area' => 'Shivajinagar', 'lat' => 12.9784, 'lng' => 77.5943, 'slug' => 'bangalore-university'],
            ['name' => 'National Law School of India University', 'short_name' => 'NLSIU', 'area' => 'Nagarbhavi', 'lat' => 12.9616, 'lng' => 77.5083, 'slug' => 'national-law-school'],
            ['name' => 'Indian Institute of Science', 'short_name' => 'IISc', 'area' => 'Malleswaram', 'lat' => 13.0219, 'lng' => 77.5671, 'slug' => 'indian-institute-of-science'],
            ['name' => 'BMS College of Engineering', 'short_name' => 'BMSCE', 'area' => 'Basavanagudi', 'lat' => 12.9365, 'lng' => 77.5706, 'slug' => 'bms-college-of-engineering'],
            ['name' => 'Garden City University', 'short_name' => 'GCU', 'area' => 'Belathur', 'lat' => 13.0197, 'lng' => 77.7162, 'slug' => 'garden-city-university'],
        ];

        foreach ($colleges as $c) {
            College::updateOrCreate(['slug' => $c['slug']], array_merge($c, ['city' => 'Bangalore']));
        }
    }
}
