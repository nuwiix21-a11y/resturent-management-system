<?php
// database/seeders/DatabaseSeeder.php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Category;
use App\Models\MenuItem;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Users ─────────────────────────────────────
        User::create([
            'name'     => 'Admin User',
            'email'    => 'admin@street160.lk',
            'password' => Hash::make('password'),
            'role'     => 'admin',
        ]);
        User::create([
            'name'     => 'Staff One',
            'email'    => 'staff1@street160.lk',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);
        User::create([
            'name'     => 'Staff Two',
            'email'    => 'staff2@street160.lk',
            'password' => Hash::make('password'),
            'role'     => 'staff',
        ]);

        // ── Categories ────────────────────────────────
        $cats = [
            ['name' => 'Rice & Curry',  'description' => 'Sri Lankan rice and curry dishes'],
            ['name' => 'Short Eats',    'description' => 'Snacks and light bites'],
            ['name' => 'Beverages',     'description' => 'Hot and cold drinks'],
            ['name' => 'Desserts',      'description' => 'Sweet treats and desserts'],
        ];
        foreach ($cats as $cat) {
            Category::create(array_merge($cat, ['is_active' => true]));
        }

        // ── Menu Items ────────────────────────────────
        $items = [
            // Rice & Curry (cat 1)
            ['category_id' => 1, 'name' => 'Chicken Rice & Curry',   'price' => 350, 'is_available' => true],
            ['category_id' => 1, 'name' => 'Fish Rice & Curry',      'price' => 320, 'is_available' => true],
            ['category_id' => 1, 'name' => 'Vegetable Rice',         'price' => 250, 'is_available' => true],
            ['category_id' => 1, 'name' => 'Beef Rice & Curry',      'price' => 380, 'is_available' => true],
            // Short Eats (cat 2)
            ['category_id' => 2, 'name' => 'Egg Roll',               'price' => 80,  'is_available' => true],
            ['category_id' => 2, 'name' => 'Patties',                'price' => 70,  'is_available' => false],
            ['category_id' => 2, 'name' => 'Fish Bun',               'price' => 60,  'is_available' => true],
            ['category_id' => 2, 'name' => 'Cutlets',                'price' => 75,  'is_available' => true],
            // Beverages (cat 3)
            ['category_id' => 3, 'name' => 'Tea',                    'price' => 50,  'is_available' => true],
            ['category_id' => 3, 'name' => 'Coffee',                 'price' => 60,  'is_available' => true],
            ['category_id' => 3, 'name' => 'Fresh Juice',            'price' => 120, 'is_available' => true],
            ['category_id' => 3, 'name' => 'Soft Drink',             'price' => 90,  'is_available' => true],
            // Desserts (cat 4)
            ['category_id' => 4, 'name' => 'Ice Cream',              'price' => 150, 'is_available' => true],
            ['category_id' => 4, 'name' => 'Watalappan',             'price' => 180, 'is_available' => true],
        ];
        foreach ($items as $item) {
            MenuItem::create($item);
        }

        $this->command->info('Database seeded successfully!');
        $this->command->info('Admin login: admin@street160.lk / password');
        $this->command->info('Staff login: staff1@street160.lk / password');
    }
}
