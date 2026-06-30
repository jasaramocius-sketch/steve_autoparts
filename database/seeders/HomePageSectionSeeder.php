<?php

namespace Database\Seeders;

use App\Models\HomePageSection;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HomePageSectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Hero Section
        HomePageSection::create([
            'section_name' => 'hero',
            'title' => 'Start Shopping Now!',
            'subtitle' => 'Dive In and Explore',
            'description' => 'Explore our curated collections and find the perfect item that speaks to your style and needs. With just a click, begin your journey.',
            'button_text' => 'Shop Now',
            'button_url' => '/shop',
            'order' => 1,
            'status' => true,
        ]);

        // Banner 1
        HomePageSection::create([
            'section_name' => 'banner_1',
            'title' => 'Premium Auto Parts',
            'subtitle' => 'Quality Parts for Every Car',
            'button_text' => 'Shop Now',
            'button_url' => '/shop',
            'order' => 2,
            'status' => true,
        ]);

        // Banner 2
        HomePageSection::create([
            'section_name' => 'banner_2',
            'title' => 'Engine Components',
            'subtitle' => 'High Performance Parts',
            'button_text' => 'Explore Now',
            'button_url' => '/shop',
            'order' => 3,
            'status' => true,
        ]);

        // Banner 3
        HomePageSection::create([
            'section_name' => 'banner_3',
            'title' => 'Brake Systems',
            'subtitle' => 'Safety First — Premium Brakes',
            'button_text' => 'Buy Now',
            'button_url' => '/shop',
            'order' => 4,
            'status' => true,
        ]);

        // Offer Section
        HomePageSection::create([
            'section_name' => 'offers',
            'title' => 'Best Month Offer',
            'description' => 'Discover outstanding deals on high-quality auto parts. Upgraded selection and special savings this month only.',
            'order' => 5,
            'status' => true,
        ]);
    }
}
