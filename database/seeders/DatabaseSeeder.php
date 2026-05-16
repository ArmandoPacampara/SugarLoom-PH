<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Support\Facades\Schema; // Added this to safely truncate

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Safely clear out old products and testimonials so you don't get duplicates
        Schema::disableForeignKeyConstraints();
        Product::truncate();
        Testimonial::truncate();
        Schema::enableForeignKeyConstraints();

        // ── Test user ─────────────────────────────────
            User::updateOrCreate(
                ['email' => 'admin@sugarloom.test'],
                ['name' => 'SugarLoom Admin', 'password' => bcrypt('password'), 'role' => User::ROLE_ADMIN]
            );

            User::updateOrCreate(
                ['email' => 'test@example.com'],
                ['name' => 'Test Customer', 'password' => bcrypt('password'), 'role' => User::ROLE_CUSTOMER]
            );

        // ── Products ──────────────────────────────────
        $products = [
            [
                'name'             => 'Red Velvet',
                'description'      => 'Soft, chewy, and packed with that rich red velvet flavor — our Red Velvet Cookies are here to satisfy your cravings!',
                'short_description'=> 'Try our classic Red Velvet with cream cheese filling.',
                'price'            => 50,
                'category'         => 'sweet',
                'image' => 'images/Red Velvet Cookie.png',
                'rating'           => 5.0,
                'is_best_seller'   => true,
                'is_bakers_choice' => true,
                'sort_order'       => 1,
            ],
            [
                'name'        => 'Chocolate Chip',
                'description' => 'Freshly baked Chocolate Chip Cookies — perfectly sweet, chewy, and packed with rich chocolate chips!',
                'price'       => 50,
                'category'    => 'sweet',
                'image'       => 'images/Chocolate chip cookie.png',
                'rating'      => 4.9,
                'is_best_seller' => true,
                'sort_order'  => 2,
            ],
            [
                'name'        => 'Brownies',
                'description' => 'Rich brownies topped with a luscious white chocolate drizzle! Perfectly baked and packed with indulgent flavor.',
                'price'       => 480,
                'category'    => 'sweet',
                'image'       => 'images/Brownies.png',
                'rating'      => 4.8,
                'is_best_seller' => true,
                'sort_order'  => 3,
            ],
            [
                'name'        => 'Gourmet S\'mores',
                'description' => 'Toasted marshmallow fluff on a dark chocolate base. Our current bestseller.',
                'price'       => 55,
                'category'    => 'sweet',
                'image'       => 'images/smores.jpg',
                'rating'      => 4.9,
                'is_top_pick' => true,
                'sort_order'  => 4,
            ],
            [
                'name'        => 'Mocha',
                'description' => 'Infused with Arabica espresso beans and cocoa for the ultimate morning treat.',
                'price'       => 45,
                'category'    => 'sweet',
                'image'       => 'images/Mocha Cookie.png',
                'rating'      => 4.7,
                'sort_order'  => 5,
            ],
            [
                'name'        => 'Strawberry',
                'description' => 'Sweet and tangy strawberry swirls paired with creamy white chocolate bits.',
                'price'       => 45,
                'category'    => 'sweet',
                'image'       => 'images/Strawberry Cookie.png',
                'rating'      => 4.6,
                'sort_order'  => 6,
            ],
            [
                'name'        => 'Matcha',
                'description' => 'Ceremonial grade Uji matcha cookie with roasted macadamia nuts for crunch.',
                'price'       => 55,
                'category'    => 'specialty',
                'image'       => 'images/Matcha Cookie.png',
                'rating'      => 4.8,
                'sort_order'  => 7,
            ],
            [
                'name'        => 'S\'mores',
                'description' => 'Graham cracker dough with a hidden melted chocolate core and toasted topping.',
                'price'       => 55,
                'category'    => 'sweet',
                'image'       => 'images/S\'mores Cookie.png',
                'rating'      => 4.7,
                'sort_order'  => 8,
            ],
            [
                'name'        => 'Macaroons',
                'description' => 'Delicate coconut macaroons with a soft, chewy center and lightly golden edges.',
                'price'       => 240,
                'category'    => 'specialty',
                'image'       => 'images/Macaroons.png',
                'rating'      => 4.8,
                'sort_order'  => 9,
            ],
            [
                'name'        => 'Baked Sushi',
                'description' => 'Creamy, savory baked sushi tray layered with seasoned rice, seafood, and rich toppings.',
                'price'       => 650,
                'category'    => 'savory',
                'image'       => 'images/Baked Sushi.png',
                'rating'      => 4.9,
                'sort_order'  => 10,
            ],
        ];

        foreach ($products as $data) {
            Product::create(array_merge(['is_active' => true], $data));
        }

        // ── Testimonials ──────────────────────────────
        $testimonials = [
            [
                'name'    => 'Sofia M.',
                'label'   => 'Verified Buyer',
                'content' => 'The texture is simply out of this world. It\'s crispy on the edges and gooey in the middle, exactly how a perfect cookie should be.',
                'stars'   => 5,
                'sort_order' => 1,
            ],
            [
                'name'    => 'Marcus K.',
                'label'   => 'Gift Sender',
                'content' => 'Sent a box of Mocha cookies to my best friend and she hasn\'t stopped talking about them. The packaging is as artisanal as the cookies!',
                'stars'   => 5,
                'sort_order' => 2,
            ],
            [
                'name'    => 'Elena R.',
                'label'   => 'Loyal Customer',
                'content' => 'The Red Velvet is life-changing. It\'s not just a cookie; it\'s a gourmet experience delivered right to my doorstep.',
                'stars'   => 5,
                'sort_order' => 3,
            ],
        ];

        foreach ($testimonials as $data) {
            Testimonial::create(array_merge(['is_active' => true], $data));
        }
    }
}
