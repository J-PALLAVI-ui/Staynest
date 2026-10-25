<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;

class AmenitySeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            // Safety
            ['name' => 'CCTV', 'slug' => 'cctv', 'category' => 'safety', 'icon' => 'camera'],
            ['name' => 'Security Guard', 'slug' => 'security-guard', 'category' => 'safety', 'icon' => 'shield'],
            ['name' => 'Biometric Entry', 'slug' => 'biometric-entry', 'category' => 'safety', 'icon' => 'finger-print'],
            ['name' => 'Fire Extinguisher', 'slug' => 'fire-extinguisher', 'category' => 'safety', 'icon' => 'fire'],

            // Room
            ['name' => 'Attached Bathroom', 'slug' => 'attached-bathroom', 'category' => 'room', 'icon' => 'bath'],
            ['name' => 'Air Conditioning', 'slug' => 'ac', 'category' => 'room', 'icon' => 'snowflake'],
            ['name' => 'Cupboard', 'slug' => 'cupboard', 'category' => 'room', 'icon' => 'squares-2x2'],
            ['name' => 'Cot and Mattress', 'slug' => 'cot-mattress', 'category' => 'room', 'icon' => 'bed'],

            // Food & Kitchen
            ['name' => 'Fridge', 'slug' => 'fridge', 'category' => 'food', 'icon' => 'cube'],
            ['name' => 'Microwave', 'slug' => 'microwave', 'category' => 'food', 'icon' => 'fire'],
            ['name' => 'RO Water', 'slug' => 'ro-water', 'category' => 'food', 'icon' => 'droplet'],
            ['name' => 'Meals Included', 'slug' => 'meals-included', 'category' => 'food', 'icon' => 'utensils'],

            // Utilities
            ['name' => 'WiFi', 'slug' => 'wifi', 'category' => 'utilities', 'icon' => 'wifi'],
            ['name' => 'Power Backup', 'slug' => 'power-backup', 'category' => 'utilities', 'icon' => 'battery'],
            ['name' => 'Washing Machine', 'slug' => 'washing-machine', 'category' => 'utilities', 'icon' => 'archive-box'],
            ['name' => 'Geyser', 'slug' => 'geyser', 'category' => 'utilities', 'icon' => 'beaker'],
            ['name' => 'Housekeeping', 'slug' => 'housekeeping', 'category' => 'utilities', 'icon' => 'sparkles'],

            // Rules
            ['name' => 'No Curfew', 'slug' => 'no-curfew', 'category' => 'rules', 'icon' => 'clock'],
            ['name' => 'Visitors Allowed', 'slug' => 'visitors-allowed', 'category' => 'rules', 'icon' => 'user-group'],
            ['name' => 'No Smoking', 'slug' => 'no-smoking', 'category' => 'rules', 'icon' => 'x-circle'],
        ];

        foreach ($amenities as $a) {
            Amenity::updateOrCreate(['slug' => $a['slug']], $a);
        }
    }
}
