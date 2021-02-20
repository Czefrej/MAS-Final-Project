<?php

namespace Database\Seeders;

use App\Models\ActiveOffer;
use App\Models\Category;
use App\Models\ComingSoonOffer;
use App\Models\Discount;
use App\Models\InactiveOffer;
use App\Models\User;
use App\Models\Offer;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        date_default_timezone_set('Europe/Warsaw');
        $currentDate = date('Y-m-d H:i:s');

        User::create([
            "name"=>"user",
            "email"=>"user@webstore.com",
            "password"=>Hash::make("user"),
            'role'=>"player"
        ]);

        $admin = User::create([
            "name"=>"admin",
            "email"=>"admin@webstore.com",
            "password"=>Hash::make("admin"),
            'role'=>"admin",
            "telephone_number"=>"+48123456789",
            "promotion_date" => date('Y-m-d H:i:s')
        ]);

        $comrades = Category::create([
            'name' => "Comrades",
            'parent_id' =>null
        ]);

        $pets = Category::create([
            'name' => "Pets",
            'parent_id' =>$comrades->id
        ]);

        $mounts = Category::create([
            'name' => "Mounts",
            'parent_id' =>$comrades->id
        ]);

        $consumables = Category::create([
            'name' => "Consumables",
            'parent_id' =>null
        ]);

        $potions = Category::create([
            'name' => "Potions",
            'parent_id' =>$consumables->id
        ]);

        $instant = Category::create([
            'name' => "Instant",
            'parent_id' =>$potions->id
        ]);

        $normal = Category::create([
            'name' => "Normal",
            'parent_id' =>$potions->id
        ]);

        $offers = array();

        $offers[sizeof($offers)] = ActiveOffer::create()->offer()->create([
            'name' => "Panda",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $mounts->id
        ]);


        $offers[sizeof($offers)] = ActiveOffer::create()->offer()->create([
            'name' => "Horse",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $mounts->id
        ]);

        $offers[sizeof($offers)] = ActiveOffer::create()->offer()->create([
            'name' => "Boar",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $mounts->id
        ]);

        $offers[sizeof($offers)] = ActiveOffer::create()->offer()->create([
            'name' => "Monkey",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $pets->id
        ]);

        $offers[sizeof($offers)] = ActiveOffer::create()->offer()->create([
            'name' => "Cat",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $pets->id
        ]);

        $offers[sizeof($offers)] = ActiveOffer::create()->offer()->create([
            'name' => "Dog",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $pets->id
        ]);

        $offers[sizeof($offers)] = ActiveOffer::create()->offer()->create([
            'name' => "Red instant potion",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $instant->id
        ]);

        $offers[sizeof($offers)] = ActiveOffer::create()->offer()->create([
            'name' => "Blue instant potion",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $instant->id
        ]);

        $offers[sizeof($offers)] = ActiveOffer::create()->offer()->create([
            'name' => "Purple instant potion",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $instant->id
        ]);

        $offers[sizeof($offers)] = ComingSoonOffer::create()->offer()->create([
            'name' => "Small health potion",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $normal->id
        ]);

        $offers[sizeof($offers)] = InactiveOffer::create()->offer()->create([
            'name' => "Small strength potion",
            'price' => rand(0, 1000) / 10,
            'description' => "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur mauris ex, auctor ac maximus vel, varius nec risus. Vestibulum mattis in lacus at tempus. Vestibulum tempor, nibh nec finibus iaculis, sem augue sagittis nibh, at tempus mi erat sed dui. Praesent in lectus metus. Donec blandit metus eu arcu venenatis, sed accumsan lectus lobortis. Vivamus posuere neque nec urna eleifend facilisis. Quisque feugiat ligula felis, et commodo felis interdum ac. Maecenas elementum tortor id tincidunt viverra. In hac habitasse platea dictumst. Integer nec volutpat tortor, sit amet semper mauris. Suspendisse in malesuada lectus. Ut felis orci, venenatis non cursus quis, sodales ac odio.",
            'stock'=> rand(0,500),
            'creator_id' => $admin->id,
            'category_id' => $normal->id
        ]);

        Discount::create([
            "type" => "category",
            "name" => "10 coins off on all normal potions",
            "category_id"=>$normal->id,
            "amount" => 10,
            "end_date"=> date('Y-m-d H:i:s', strtotime("$currentDate +7 day"))
        ]);

        $offer = $offers[rand(0,sizeof($offers)-1)];

        Discount::create([
            "type" => "offer",
            "name" => "Limited discount on $offer->name",
            "offer_id"=>$offer->id,
            "amount" => rand(1,$offer->price*10/2),
            "end_date"=> date('Y-m-d H:i:s', strtotime("$currentDate +5 day"))
        ]);



    }
}
