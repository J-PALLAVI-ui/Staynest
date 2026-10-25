<?php

namespace Database\Seeders;

use App\Models\College;
use App\Models\Pg;
use App\Models\PgPhoto;
use App\Models\RoomType;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            AmenitySeeder::class,
            CollegeSeeder::class,
        ]);

        $owner = User::firstOrCreate(
            ['email' => 'staynest-demo-owner@example.com'],
            [
                'name' => 'StayNest Demo Owner',
                'password' => Hash::make(bin2hex(random_bytes(16))),
            ]
        );

        $listings = [
            [
                'name' => 'Green Nest Boys PG',
                'slug' => 'green-nest-boys-demo',
                'gender_type' => 'boys',
                'area' => 'Koramangala',
                'rent1' => 15000,
                'rent2' => 11000,
                'lat' => 12.9352,
                'lng' => 77.6245,
                'colleges' => [
                    'christ-university' => 8,
                    'jain-university' => 5,
                    'dayananda-sagar-university' => 3,
                ],
                'image' => 'photo-1555854877-bab0e564b8d5',
            ],
            [
                'name' => 'City Comfort Boys PG',
                'slug' => 'city-comfort-boys-demo',
                'gender_type' => 'boys',
                'area' => 'BTM Layout',
                'rent1' => 12000,
                'rent2' => 9000,
                'lat' => 12.9166,
                'lng' => 77.6101,
                'colleges' => [
                    'christ-university' => 6,
                    'dayananda-sagar-university' => 7,
                    'jain-university' => 3,
                ],
                'image' => 'photo-1522708323590-d24dbb6b0267',
            ],
            [
                'name' => 'Urban Stay Boys PG',
                'slug' => 'urban-stay-boys-demo',
                'gender_type' => 'boys',
                'area' => 'HSR Layout',
                'rent1' => 18000,
                'rent2' => 13000,
                'lat' => 12.9116,
                'lng' => 77.6389,
                'colleges' => [
                    'christ-university' => 4,
                    'jain-university' => 6,
                    'dayananda-sagar-university' => 4,
                ],
                'image' => 'photo-1560185008-b033106af5c3',
            ],
            [
                'name' => 'Sunrise Girls PG',
                'slug' => 'sunrise-girls-demo',
                'gender_type' => 'girls',
                'area' => 'Jayanagar',
                'rent1' => 16000,
                'rent2' => 12000,
                'lat' => 12.9250,
                'lng' => 77.5838,
                'colleges' => [
                    'jain-university' => 9,
                    'dayananda-sagar-university' => 5,
                    'christ-university' => 4,
                ],
                'image' => 'photo-1522771739844-6a9f6d5f14af',
            ],
            [
                'name' => 'Comfort Living Girls PG',
                'slug' => 'comfort-living-girls-demo',
                'gender_type' => 'girls',
                'area' => 'BTM Layout',
                'rent1' => 14000,
                'rent2' => 10000,
                'lat' => 12.9166,
                'lng' => 77.6101,
                'colleges' => [
                    'christ-university' => 7,
                    'dayananda-sagar-university' => 6,
                    'jain-university' => 4,
                ],
                'image' => 'photo-1505693416388-ac5ce068fe85',
            ],
            [
                'name' => 'Lotus Residency Girls PG',
                'slug' => 'lotus-residency-girls-demo',
                'gender_type' => 'girls',
                'area' => 'Electronic City',
                'rent1' => 22000,
                'rent2' => 16000,
                'lat' => 12.8452,
                'lng' => 77.6602,
                'colleges' => [
                    'dayananda-sagar-university' => 4,
                    'christ-university' => 5,
                    'jain-university' => 3,
                ],
                'image' => 'photo-1616486338812-3dadae4b4ace',
            ],
            [
                'name' => 'Budget Living Boys PG',
                'slug' => 'budget-living-boys-demo',
                'gender_type' => 'boys',
                'area' => 'Electronic City',
                'rent1' => 10000,
                'rent2' => 8000,
                'lat' => 12.8452,
                'lng' => 77.6602,
                'colleges' => [
                    'dayananda-sagar-university' => 8,
                    'christ-university' => 3,
                    'jain-university' => 3,
                ],
                'image' => 'photo-1505693416388-ac5ce068fe85',
            ],
            [
                'name' => 'Premium Comfort Girls PG',
                'slug' => 'premium-comfort-girls-demo',
                'gender_type' => 'girls',
                'area' => 'Koramangala',
                'rent1' => 25000,
                'rent2' => 18000,
                'lat' => 12.9352,
                'lng' => 77.6245,
                'colleges' => [
                    'christ-university' => 6,
                    'jain-university' => 7,
                    'dayananda-sagar-university' => 3,
                ],
                'image' => 'photo-1600210492486-724fe5c67fb0',
            ],
        ];

        foreach ($listings as $data) {
            $isGirls = $data['gender_type'] === 'girls';

            $pg = Pg::withTrashed()->updateOrCreate(
                ['slug' => $data['slug']],
                [
                    'owner_id' => $owner->id,
                    'name' => $data['name'],
                    'gender_type' => $data['gender_type'],
                    'area' => $data['area'],
                    'city' => 'Bangalore',
                    'lat' => $data['lat'],
                    'lng' => $data['lng'],
                    'full_address' => $data['area'] . ', Bangalore, Karnataka',
                    'description' =>
                        $data['name'] . ' is a sample student accommodation listing in '
                        . $data['area'] . ', Bangalore. The demo property includes '
                        . 'multiple room-sharing options, study-friendly spaces, '
                        . 'storage, Wi-Fi availability, housekeeping arrangements, '
                        . 'and access to food and transport options nearby. '
                        . 'Residents can compare monthly rent, deposit, AC, meals, '
                        . 'and bed availability before choosing a room. '
                        . 'This is fictional demo content; facilities and distances '
                        . 'must be confirmed with the property owner.',
                    'status' => 'live',
                    'verified' => false,
                    'verification_note' => 'Demo listing — not independently verified',
                    'female_warden' => $isGirls,
                    'curfew_time' => $isGirls ? '10:00 PM' : null,
                    'visitor_policy' => 'Demo policy: visitors subject to property rules',
                    'security_24x7' => true,
                    'cctv_coverage' => 'Demo information: common areas',
                    'last_updated' => now(),
                    'is_stale' => false,
                    'deleted_at' => null,
                ]
            );

            // Create/update all four room-sharing options.
            $rentBySharing = [
                1 => $data['rent1'],
                2 => $data['rent2'],
                3 => (int) round($data['rent2'] * 0.82 / 100) * 100,
                4 => (int) round($data['rent2'] * 0.70 / 100) * 100,
            ];

            foreach ($rentBySharing as $sharing => $rent) {
                RoomType::updateOrCreate(
                    [
                        'pg_id' => $pg->id,
                        'sharing' => $sharing,
                    ],
                    [
                        'ac' => $sharing === 1 || $sharing === 3,
                        'rent' => $rent,
                        'deposit' => $rent * 2,
                        'beds_total' => $sharing * 2,
                        'beds_free' => max(1, $sharing),
                        'meals_included' => true,
                        'electricity_extra' => $sharing === 1 ? 500 : 300,
                        'laundry_extra' => 200,
                        'notes' => "Demo {$sharing}-sharing room. Sample rent and availability; confirm with owner.",
                    ]
                );
            }

            // Sample photo URLs. Replace these with actual property photos
            // before presenting a listing as a real accommodation.
            $photoUrls = [
                [
                    'url' => 'https://images.unsplash.com/' . $data['image']
                        . '?auto=format&fit=crop&w=1200&q=80',
                    'alt' => $data['name'] . ' — sample accommodation interior',
                ],
                [
                    'url' => 'https://images.unsplash.com/photo-1564078516393-cf04bd966897'
                        . '?auto=format&fit=crop&w=1200&q=80',
                    'alt' => $data['name'] . ' — sample bedroom',
                ],
            ];

            foreach ($photoUrls as $index => $photo) {
                PgPhoto::updateOrCreate(
                    [
                        'pg_id' => $pg->id,
                        's3_path' => $photo['url'],
                    ],
                    [
                        'alt_text' => $photo['alt'],
                        'is_cover' => $index === 0,
                        'sort_order' => $index,
                    ]
                );
            }

            // Attach relevant colleges with clearly labelled demo counts.
            foreach ($data['colleges'] as $collegeSlug => $count) {
                $college = College::where('slug', $collegeSlug)->first();

                if ($college) {
                    DB::table('pg_college_stats')->updateOrInsert(
                        [
                            'pg_id' => $pg->id,
                            'college_id' => $college->id,
                        ],
                        [
                            'resident_count' => $count,
                            'updated_at' => now(),
                        ]
                    );
                }
            }

            // Add/update house rules.
            DB::table('rules')->updateOrInsert(
                ['pg_id' => $pg->id],
                [
                    'curfew' => $isGirls ? '10:00 PM (demo)' : 'No fixed time specified (demo)',
                    'visitors' => 'Demo policy: visitors only according to house rules',
                    'smoking_allowed' => false,
                    'alcohol_allowed' => false,
                    'cooking_allowed' => false,
                    'pets_policy' => 'Please confirm with owner',
                    'noise_policy' => 'Keep noise low during study and sleeping hours',
                    'other_rules' => 'Sample demo rules only. Confirm all policies with the owner.',
                    'updated_at' => now(),
                    'created_at' => now(),
                ]
            );
        }

        $this->command?->info(
            'StayNest demo data updated: 8 listings, 4 sharing types, sample photos, college counts and rules.'
        );
    }
}
