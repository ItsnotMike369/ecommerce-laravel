<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $electronics   = Category::where('name', 'Electronics')->first()->id;
        $clothing      = Category::where('name', 'Clothing')->first()->id;
        $homeGarden    = Category::where('name', 'Home & Garden')->first()->id;
        $sports        = Category::where('name', 'Sports & Outdoors')->first()->id;
        $giftBoxes     = Category::where('name', 'Gift Boxes')->first()->id;

        $products = [
            // Electronics (8)
            [
                'name'        => 'Wireless Headphones',
                'description' => 'Premium over-ear wireless headphones with noise cancellation.',
                'price'       => 4479.00,
                'image'       => 'https://images.unsplash.com/photo-1505740420928-5e560c06d30e?w=400',
                'stock'       => 45,
                'category_id' => $electronics,
            ],
            [
                'name'        => 'Smart Watch',
                'description' => 'Feature-packed smart watch with health tracking and notifications.',
                'price'       => 11199.00,
                'image'       => 'https://images.unsplash.com/photo-1523275335684-37898b6baf30?w=400',
                'stock'       => 32,
                'category_id' => $electronics,
            ],
            [
                'name'        => 'Laptop Backpack',
                'description' => 'Durable and spacious laptop backpack with USB charging port.',
                'price'       => 2239.00,
                'image'       => 'https://images.unsplash.com/photo-1553062407-98eeb64c6a62?w=400',
                'stock'       => 54,
                'category_id' => $electronics,
            ],
            [
                'name'        => 'Wireless Keyboard & Mouse',
                'description' => 'Ergonomic wireless keyboard and mouse combo for productivity.',
                'price'       => 3359.00,
                'image'       => 'https://images.unsplash.com/photo-1587829741301-dc798b83add3?w=400',
                'stock'       => 74,
                'category_id' => $electronics,
            ],
            [
                'name'        => 'Tablet Device',
                'description' => 'High-performance tablet with stunning display and long battery life.',
                'price'       => 15679.00,
                'image'       => 'https://images.unsplash.com/photo-1544244015-0df4b3ffc6b0?w=400',
                'stock'       => 29,
                'category_id' => $electronics,
            ],
            [
                'name'        => 'Gaming Controller',
                'description' => 'Precision gaming controller compatible with multiple platforms.',
                'price'       => 3919.00,
                'image'       => 'https://images.unsplash.com/photo-1593118247619-e2d6f056869e?w=400',
                'stock'       => 48,
                'category_id' => $electronics,
            ],
            [
                'name'        => 'Digital Camera',
                'description' => 'Professional-grade DSLR camera with interchangeable lens system.',
                'price'       => 33599.00,
                'image'       => 'https://images.unsplash.com/photo-1516035069371-29a1b244cc32?w=400',
                'stock'       => 19,
                'category_id' => $electronics,
            ],
            [
                'name'        => 'Wireless Earbuds',
                'description' => 'True wireless earbuds with active noise cancellation and 24hr battery.',
                'price'       => 5599.00,
                'image'       => 'https://images.unsplash.com/photo-1572569511254-d8f925fe2cbb?w=400',
                'stock'       => 85,
                'category_id' => $electronics,
            ],

            // Clothing (7)
            [
                'name'        => 'Cotton T-Shirt',
                'description' => 'Classic soft cotton t-shirt available in multiple colors.',
                'price'       => 1399.00,
                'image'       => 'https://images.unsplash.com/photo-1521572163474-6864f9cf17ab?w=400',
                'stock'       => 120,
                'category_id' => $clothing,
            ],
            [
                'name'        => 'Denim Jeans',
                'description' => 'Slim-fit denim jeans with stretch fabric for all-day comfort.',
                'price'       => 3359.00,
                'image'       => 'https://images.unsplash.com/photo-1542272454315-4c01d7abdf4a?w=400',
                'stock'       => 85,
                'category_id' => $clothing,
            ],
            [
                'name'        => 'Leather Jacket',
                'description' => 'Genuine leather jacket with a classic biker-inspired design.',
                'price'       => 8399.00,
                'image'       => 'https://images.unsplash.com/photo-1551028719-00167b16eac5?w=400',
                'stock'       => 22,
                'category_id' => $clothing,
            ],
            [
                'name'        => 'Summer Dress',
                'description' => 'Flowy summer dress perfect for warm weather and casual outings.',
                'price'       => 2519.00,
                'image'       => 'https://images.unsplash.com/photo-1496747611176-843222e1e57c?w=400',
                'stock'       => 64,
                'category_id' => $clothing,
            ],
            [
                'name'        => 'Wool Sweater',
                'description' => 'Cozy merino wool sweater for cool autumn and winter days.',
                'price'       => 3919.00,
                'image'       => 'https://images.unsplash.com/photo-1434389677669-e08b4cac3105?w=400',
                'stock'       => 47,
                'category_id' => $clothing,
            ],
            [
                'name'        => 'Pullover Hoodie',
                'description' => 'Comfortable fleece pullover hoodie for everyday casual wear.',
                'price'       => 2799.00,
                'image'       => 'https://images.unsplash.com/photo-1556821840-3a63f15732ce?w=400',
                'stock'       => 86,
                'category_id' => $clothing,
            ],
            [
                'name'        => 'Winter Puffer Coat',
                'description' => 'Warm insulated puffer coat designed for cold winter weather.',
                'price'       => 6719.00,
                'image'       => 'https://images.unsplash.com/photo-1539533018447-63fcce2678e3?w=400',
                'stock'       => 34,
                'category_id' => $clothing,
            ],

            // Home & Garden (7)
            [
                'name'        => 'Coffee Maker',
                'description' => 'Programmable drip coffee maker with built-in grinder.',
                'price'       => 2799.00,
                'image'       => 'https://images.unsplash.com/photo-1495474472287-4d71bcdd2085?w=400',
                'stock'       => 28,
                'category_id' => $homeGarden,
            ],
            [
                'name'        => 'Desk Lamp',
                'description' => 'LED desk lamp with adjustable brightness and USB charging port.',
                'price'       => 2519.00,
                'image'       => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?w=400',
                'stock'       => 61,
                'category_id' => $homeGarden,
            ],
            [
                'name'        => 'Indoor Plant Set',
                'description' => 'Set of 3 easy-care indoor plants perfect for home decoration.',
                'price'       => 1959.00,
                'image'       => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?w=400',
                'stock'       => 56,
                'category_id' => $homeGarden,
            ],
            [
                'name'        => 'Kitchen Knife Set',
                'description' => 'Professional 6-piece stainless steel kitchen knife set with block.',
                'price'       => 4479.00,
                'image'       => 'https://images.unsplash.com/photo-1593618998160-e34014e67546?w=400',
                'stock'       => 21,
                'category_id' => $homeGarden,
            ],
            [
                'name'        => 'Bedding Set',
                'description' => 'Luxurious 400-thread-count cotton bedding set with duvet cover.',
                'price'       => 5039.00,
                'image'       => 'https://images.unsplash.com/photo-1631049307264-da0ec9d70304?w=400',
                'stock'       => 44,
                'category_id' => $homeGarden,
            ],
            [
                'name'        => 'Vacuum Cleaner',
                'description' => 'Cordless stick vacuum cleaner with powerful suction and HEPA filter.',
                'price'       => 8959.00,
                'image'       => 'https://images.unsplash.com/photo-1558618666-fcd25c85cd64?w=400',
                'stock'       => 27,
                'category_id' => $homeGarden,
            ],
            [
                'name'        => 'Patio Furniture Set',
                'description' => 'Weather-resistant 4-piece outdoor patio furniture set.',
                'price'       => 27999.00,
                'image'       => 'https://images.unsplash.com/photo-1600210491369-e753d80a41f3?w=400',
                'stock'       => 12,
                'category_id' => $homeGarden,
            ],

            // Sports & Outdoors (8)
            [
                'name'        => 'High-Speed Blender',
                'description' => 'Professional high-speed blender for smoothies and food prep.',
                'price'       => 5599.00,
                'image'       => 'https://images.unsplash.com/photo-1570222094114-d054a817e56b?w=400',
                'stock'       => 55,
                'category_id' => $sports,
            ],
            [
                'name'        => 'Running Shoes',
                'description' => 'Lightweight and responsive running shoes for all surfaces.',
                'price'       => 5039.00,
                'image'       => 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=400',
                'stock'       => 87,
                'category_id' => $sports,
            ],
            [
                'name'        => 'Yoga Mat',
                'description' => 'Non-slip eco-friendly yoga mat with alignment lines.',
                'price'       => 1679.00,
                'image'       => 'https://images.unsplash.com/photo-1601925228008-51c8f5ef0cec?w=400',
                'stock'       => 78,
                'category_id' => $sports,
            ],
            [
                'name'        => 'Camping Tent',
                'description' => '4-person waterproof camping tent with easy setup.',
                'price'       => 7279.00,
                'image'       => 'https://images.unsplash.com/photo-1504280390367-361c6d9f38f4?w=400',
                'stock'       => 19,
                'category_id' => $sports,
            ],
            [
                'name'        => 'Mountain Bike',
                'description' => 'Full-suspension mountain bike with 21-speed gear system.',
                'price'       => 25199.00,
                'image'       => 'https://images.unsplash.com/photo-1576435728678-68d0fbf94e91?w=400',
                'stock'       => 15,
                'category_id' => $sports,
            ],
            [
                'name'        => 'Dumbbell Set',
                'description' => 'Adjustable dumbbell set ranging from 2kg to 24kg.',
                'price'       => 4479.00,
                'image'       => 'https://images.unsplash.com/photo-1571019613454-1cb2f99b2d8b?w=400',
                'stock'       => 52,
                'category_id' => $sports,
            ],
            [
                'name'        => 'Hiking Backpack',
                'description' => '45L hiking backpack with hydration system compatibility.',
                'price'       => 3919.00,
                'image'       => 'https://images.unsplash.com/photo-1551632811-561732d1e306?w=400',
                'stock'       => 38,
                'category_id' => $sports,
            ],
            [
                'name'        => 'Fitness Tracker',
                'description' => 'Advanced fitness tracker with heart rate monitor and GPS.',
                'price'       => 2799.00,
                'image'       => 'https://images.unsplash.com/photo-1575311373937-040b8e1fd5b6?w=400',
                'stock'       => 99,
                'category_id' => $sports,
            ],

            // Gift Boxes (6)
            [
                'name'        => 'Luxury Gift Box Set',
                'description' => 'Elegantly curated luxury gift box for any special occasion.',
                'price'       => 4999.00,
                'image'       => 'https://images.unsplash.com/photo-1549465220-1a8b9238cd48?w=400',
                'stock'       => 42,
                'category_id' => $giftBoxes,
            ],
            [
                'name'        => 'Chocolate Gift Basket',
                'description' => 'Assorted premium chocolates and sweets in a beautiful basket.',
                'price'       => 3599.00,
                'image'       => 'https://images.unsplash.com/photo-1606312619070-d48b4c652a52?w=400',
                'stock'       => 56,
                'category_id' => $giftBoxes,
            ],
            [
                'name'        => 'Spa & Wellness Gift Set',
                'description' => 'Relaxing spa gift set with bath salts, candles, and skincare.',
                'price'       => 4299.00,
                'image'       => 'https://images.unsplash.com/photo-1600428853876-fb6e159ffe39?w=400',
                'stock'       => 38,
                'category_id' => $giftBoxes,
            ],
            [
                'name'        => 'Premium Wine Gift Box',
                'description' => 'Curated selection of premium wines in an elegant gift box.',
                'price'       => 6799.00,
                'image'       => 'https://images.unsplash.com/photo-1510812431401-41d2bd2722f3?w=400',
                'stock'       => 24,
                'category_id' => $giftBoxes,
            ],
            [
                'name'        => 'Coffee & Tea Gift Hamper',
                'description' => 'Artisan coffee blends and specialty teas in a gift hamper.',
                'price'       => 3199.00,
                'image'       => 'https://images.unsplash.com/photo-1544787219-7f47ccb76574?w=400',
                'stock'       => 47,
                'category_id' => $giftBoxes,
            ],
            [
                'name'        => 'Baby Shower Gift Basket',
                'description' => 'Adorable baby shower gift basket with essentials for newborns.',
                'price'       => 4599.00,
                'image'       => 'https://images.unsplash.com/photo-1515488042361-ee00e0ddd4e4?w=400',
                'stock'       => 33,
                'category_id' => $giftBoxes,
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                $product
            );
        }
    }
}
