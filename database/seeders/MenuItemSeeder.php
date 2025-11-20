<?php

namespace Database\Seeders;

use App\Models\MenuItem;
use Illuminate\Database\Seeder;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menuItems = [
            // MENU PAKET
            ['name' => 'Paket Ayam Classic + Jasmine Ice Tea', 'category' => 'paket', 'price' => 51818, 'description' => 'Ayam classic dengan nasi dan teh jasmine'],
            ['name' => 'Paket Bebek Classic + Jasmine Ice Tea', 'category' => 'paket', 'price' => 55435],
            ['name' => 'Paket Malon Classic + Jasmine Ice Tea', 'category' => 'paket', 'price' => 52727],
            ['name' => 'Paket Empal Komplit + Jasmine Ice Tea', 'category' => 'paket', 'price' => 52727],
            ['name' => 'Paket Ayam Bumbu Bali + Jasmine Ice Tea', 'category' => 'paket', 'price' => 45000],
            ['name' => 'Chicken Katsu Curry Sauce + Jasmine Ice Tea', 'category' => 'paket', 'price' => 59000],
            ['name' => 'Chicken Crispy Omurice + Jasmine Ice Tea', 'category' => 'paket', 'price' => 50000],
            ['name' => 'Spicy Wings Omurice + Jasmine Ice Tea', 'category' => 'paket', 'price' => 39000],
            ['name' => 'Butter Chicken Omurice + Jasmine Ice Tea', 'category' => 'paket', 'price' => 50000],
            ['name' => 'Ayam Geprek + Nasi + Jasmine', 'category' => 'paket', 'price' => 40000],
            ['name' => 'Nugget Omurice + Jasmine Ice Tea', 'category' => 'paket', 'price' => 35000],
            ['name' => 'Blackpepper Beef Omurice + Jasmine Ice Tea', 'category' => 'paket', 'price' => 49091],
            ['name' => 'Sop Buntut + Jasmine Ice Tea', 'category' => 'paket', 'price' => 79091],
            ['name' => 'Bihun Bebek/Ayam Oriental + Jasmine Ice Tea', 'category' => 'paket', 'price' => 47273],
            ['name' => 'Mie Bakso Sapi + Jasmine Ice Tea', 'category' => 'paket', 'price' => 37273],
            ['name' => 'Nasi Putih', 'category' => 'paket', 'price' => 7000],

            // SPESIAL GYUTAN
            ['name' => 'Gyutan Rice + Jasmine Ice Tea', 'category' => 'gyutan', 'price' => 57000],
            ['name' => 'Gyutan Omurice + Jasmine Ice Tea', 'category' => 'gyutan', 'price' => 62000],
            ['name' => 'Gyutan With French Fries + Jasmine Ice Tea', 'category' => 'gyutan', 'price' => 59000],

            // SPESIAL DORI
            ['name' => 'Dori Blackpepper Omurice + Jasmine Ice Tea', 'category' => 'dori', 'price' => 42000],
            ['name' => 'Crispy Dori Omurice + Jasmine Ice Tea', 'category' => 'dori', 'price' => 42000],

            // SPESIAL SALMON
            ['name' => 'Salmon Teriyaki Omurice + Jasmine Ice Tea', 'category' => 'salmon', 'price' => 59000],
            ['name' => 'Salmon Blackpepper Omurice + Jasmine Ice Tea', 'category' => 'salmon', 'price' => 59091],

            // SPESIAL NASI GORENG
            ['name' => 'Nasi Goreng Yangzhou + Jasmine Ice Tea', 'category' => 'nasi_goreng', 'price' => 38182],
            ['name' => 'Nasi Goreng Seafood + Jasmine Ice Tea', 'category' => 'nasi_goreng', 'price' => 45455],
            ['name' => 'Nasi Goreng Sapi + Jasmine Ice Tea', 'category' => 'nasi_goreng', 'price' => 41818],
            ['name' => 'Nasi Goreng Babat + Jasmine Ice Tea', 'category' => 'nasi_goreng', 'price' => 40909],
            ['name' => 'Nasi Goreng Paru + Jasmine Ice Tea', 'category' => 'nasi_goreng', 'price' => 39545],
            ['name' => 'Nasi Goreng Kambing + Jasmine Ice Tea', 'category' => 'nasi_goreng', 'price' => 41818],
            ['name' => 'Nasi Goreng Ayam + Jasmine Ice Tea', 'category' => 'nasi_goreng', 'price' => 39545],
            ['name' => 'Nasi Goreng Teri+ Jasmine Ice Tea', 'category' => 'nasi_goreng', 'price' => 35909],
            ['name' => 'Nasi Goreng Bakso + Jasmine Ice Tea', 'category' => 'nasi_goreng', 'price' => 37273],
            ['name' => 'Nasi Goreng Pete + Jasmine Ice Tea', 'category' => 'nasi_goreng', 'price' => 34091],

            // SPESIAL MIE/BIHUN/SOHUN/KWETIAU
            ['name' => 'Mie Goreng Jawa + Jasmine Ice Tea', 'category' => 'mie_bihun', 'price' => 37273, 'notes' => 'Topping: Bakso 37.273, Ayam 41.364, Sapi 45.000, Seafood 45.455'],
            ['name' => 'Mie Godhog Jawa + Jasmine Ice Tea', 'category' => 'mie_bihun', 'price' => 41364, 'notes' => 'Topping: Ayam 41.364, Sapi 45.000, Seafood 45.455'],
            ['name' => 'Bihun Goreng / Kuah Jawa + Jasmine Ice Tea', 'category' => 'mie_bihun', 'price' => 41364, 'notes' => 'Topping: Ayam 41.364, Sapi 45.000, Seafood 45.455'],
            ['name' => 'Sohun Goreng / Siram Jawa + Jasmine Ice Tea', 'category' => 'mie_bihun', 'price' => 41364, 'notes' => 'Topping: Ayam 41.364, Sapi 45.000, Seafood 45.455'],
            ['name' => 'Kwetiau Goreng / Siram + Jasmine Ice Tea', 'category' => 'mie_bihun', 'price' => 44091, 'notes' => 'Topping: Ayam 44.091, Sapi 47.273, Seafood 47.727'],

            // SNACK
            ['name' => 'Mix Platter A + Jasmine Ice Tea', 'category' => 'snack', 'price' => 47273, 'description' => 'Kentang Goreng, Pundi-Pundi, Sosis'],
            ['name' => 'Mix Platter B + Jasmine Ice Tea', 'category' => 'snack', 'price' => 48182, 'description' => 'Kentang Goreng, Siomay, Lumpia'],
            ['name' => 'Mix Platter C + Jasmine Ice Tea', 'category' => 'snack', 'price' => 49091, 'description' => 'Kentang Goreng, Nugget, Otak-Otak'],
            ['name' => 'Mix Platter D + Jasmine Ice Tea', 'category' => 'snack', 'price' => 49091, 'description' => 'Kentang Goreng, Nugget, Pundi-Pundi'],
            ['name' => 'Gyoza + Jasmine Ice Tea', 'category' => 'snack', 'price' => 39546],
            ['name' => 'Tempe Crispy + Jasmine Ice Tea', 'category' => 'snack', 'price' => 29091],
            ['name' => 'Cheese Cassava + Jasmine Ice Tea', 'category' => 'snack', 'price' => 29546],
            ['name' => 'Thai Cassava + Jasmine Ice Tea', 'category' => 'snack', 'price' => 34091],
            ['name' => 'Banana Crispy + Jasmine Ice Tea', 'category' => 'snack', 'price' => 29091],
            ['name' => 'Roti Bakar + Jasmine Ice Tea', 'category' => 'snack', 'price' => 29091],
            ['name' => 'Bakpao Salted Egg', 'category' => 'snack', 'price' => 28000],
            ['name' => 'Bakpao Chicken Bbq', 'category' => 'snack', 'price' => 30000],
            ['name' => 'Bakpao Mix', 'category' => 'snack', 'price' => 28000],
            ['name' => 'Kentang Goreng Stik', 'category' => 'snack', 'price' => 20910],
            ['name' => 'Sosis Kentang', 'category' => 'snack', 'price' => 25000],

            // MINUMAN
            ['name' => 'Ice Tea Cup Jumbo', 'category' => 'minuman', 'price' => 10909],
            ['name' => 'Lemon Tea', 'category' => 'minuman', 'price' => 15909],
            ['name' => 'Milk Tea', 'category' => 'minuman', 'price' => 17273],
            ['name' => 'Strawberry Tea', 'category' => 'minuman', 'price' => 22273],
            ['name' => 'Lychee Tea', 'category' => 'minuman', 'price' => 22273],
            ['name' => 'Es Kopyor', 'category' => 'minuman', 'price' => 40909],
            ['name' => 'Black Coffee Ice/Hot', 'category' => 'minuman', 'price' => 20000],
            ['name' => 'Teh Jawa Poci', 'category' => 'minuman', 'price' => 24091],
            ['name' => 'Teh Jahe', 'category' => 'minuman', 'price' => 16818],
            ['name' => 'Teh Sereh', 'category' => 'minuman', 'price' => 16818],
            ['name' => 'Teh Uwuh', 'category' => 'minuman', 'price' => 20909],
            ['name' => 'Jus Sirsak', 'category' => 'minuman', 'price' => 25000],
            ['name' => 'Jus Mangga', 'category' => 'minuman', 'price' => 28182],
            ['name' => 'Jus Alpukat', 'category' => 'minuman', 'price' => 28182],
            ['name' => 'Jus Jambu', 'category' => 'minuman', 'price' => 23182],
            ['name' => 'Jus Jeruk', 'category' => 'minuman', 'price' => 24091],
            ['name' => 'Jus Melon', 'category' => 'minuman', 'price' => 24091],
            ['name' => 'Jus Strawberry', 'category' => 'minuman', 'price' => 26364],
            ['name' => 'Taro Fresh Milk', 'category' => 'minuman', 'price' => 23182, 'notes' => 'With Float Ice Cream +10.000'],
            ['name' => 'GreenTea Latte', 'category' => 'minuman', 'price' => 23182, 'notes' => 'With Float Ice Cream +10.000'],
            ['name' => 'Mango Fresh Milk', 'category' => 'minuman', 'price' => 23182, 'notes' => 'With Float Ice Cream +10.000'],
            ['name' => 'Chocolate Fresh Milk', 'category' => 'minuman', 'price' => 28182, 'notes' => 'With Float Ice Cream +10.000'],
            ['name' => 'Cappucino Fresh Milk', 'category' => 'minuman', 'price' => 27273, 'notes' => 'With Float Ice Cream +10.000'],
        ];

        foreach ($menuItems as $item) {
            MenuItem::create(array_merge($item, [
                'is_available' => true,
                'stock' => -1, // Unlimited
            ]));
        }
    }
}
