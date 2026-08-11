<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MenuSeeder extends Seeder
{
    public function run(): void
    {

        // Clear Existing Menus

        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        Menu::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1');


        Menu::create([
            'name' => 'Dashboard',
            'slug' => 'dasboard',
            'route' => 'dashboard',
            'icon' => 'bi bi-speedometer',
            'visible_for' => 'default',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        $userManagement = Menu::create([
            'name' => 'User Management',
            'slug' => 'user-management',
            'route' => null,
            'icon' => 'bi-people',
            'visible_for' => 'admin,verification',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $userManagement->id,
            'name' => 'All Users',
            'slug' => 'all-users',
            'route' => 'admin.all-users',
            'icon' => null,
            'visible_for' => 'admin,verification',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $userManagement->id,
            'name' => 'Load Money',
            'slug' => 'load-money',
            'route' => 'admin.load.money',
            'icon' => null,
            'visible_for' => 'admin',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $userManagement->id,
            'name' => 'Bank Update Request',
            'slug' => 'bank-update-request',
            'route' => 'admin.bank.update.request',
            'icon' => null,
            'visible_for' => 'admin',
            'sort_order' => 3,
            'is_active' => true,
        ]);


        $service = Menu::create([
            'name' => 'Service',
            'slug' => 'service',
            'route' => null,
            'icon' => 'bi-gear-fill',
            'visible_for' => 'admin,user',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $service->id,
            'name' => 'Global Services',
            'slug' => 'global-services',
            'route' => 'admin.global.services',
            'icon' => null,
            'visible_for' => 'admin',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $service->id,
            'name' => 'Service Request',
            'slug' => 'admiin-service-request',
            'route' => 'admin.service-request',
            'icon' => null,
            'visible_for' => 'admin,reseller',
            'sort_order' => 2,
            'is_active' => true,
        ]);


        Menu::create([
            'parent_id' => $service->id,
            'name' => 'Service Request',
            'slug' => 'user-service-request',
            'route' => 'user.service-request',
            'icon' => null,
            'visible_for' => 'user',
            'sort_order' => 3,
            'is_active' => true,
        ]);


        $upi = Menu::create([
            'name' => 'UPI Services',
            'slug' => 'upi-services',
            'route' => null,
            'icon' => 'bi-upc-scan',
            'visible_for' => 'admin',
            'sort_order' => 4,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $upi->id,
            'name' => 'UPI Initiation',
            'slug' => 'upi-initiation',
            'route' => 'admin.upi.initiation',
            'icon' => null,
            'visible_for' => 'admin',
            'sort_order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $upi->id,
            'name' => 'UPI Collection',
            'slug' => 'upi-collection',
            'route' => 'admin.upi.collection',
            'icon' => null,
            'visible_for' => 'admin',
            'sort_order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $upi->id,
            'name' => 'All UPI Transaction',
            'slug' => 'all-upi-transaction',
            'route' => 'admin.upi.transaction',
            'icon' => null,
            'visible_for' => 'admin',
            'sort_order' => 3,
            'is_active' => true,
        ]);

        $payout = Menu::create([
            'name' => 'Payout',
            'slug' => 'payout',
            'route' => null,
            'icon' => 'bi-cash-stack',
            'visible_for' => 'admin',
            'sort_order' => 5,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $payout->id,
            'name' => 'Payout Transactions',
            'slug' => 'payout-transactions',
            'route' => 'admin.payout.transaction',
            'icon' => null,
            'visible_for' => 'admin',
            'sort_order' => 1,
            'is_active' => true,
        ]);


        Menu::create([
            'name' => 'Cost Setup',
            'slug' => 'cost-setup',
            'route' => 'cost.setup',
            'icon' => 'bi-receipt',
            'visible_for' => 'admin',
            'sort_order' => 6,
            'is_active' => true,
        ]);

        Menu::create([
            'name' => 'Scheme',
            'slug' => 'scheme',
            'route' => 'scheme',
            'icon' => 'bi-wallet2',
            'visible_for' => 'admin',
            'sort_order' => 7,
            'is_active' => true,
        ]);

        Menu::create([
            'name' => 'Gateway & Switch',
            'slug' => 'gateway-routing',
            'route' => 'gateway.routing',
            'icon' => 'bi-shuffle',
            'visible_for' => 'admin',
            'sort_order' => 8,
            'is_active' => true,
        ]);

        Menu::create([
            'name' => 'Verification Officer',
            'slug' => 'verification-officer',
            'route' => 'verification.user',
            'icon' => 'bi-person-check-fill',
            'visible_for' => 'admin',
            'sort_order' => 9,
            'is_active' => true,
        ]);


        Menu::create([
            'name' => 'Sidebar Menu',
            'slug' => 'sidebar-menu',
            'route' => 'admin.menus',
            'icon' => 'bi bi-list',
            'visible_for' => 'admin',
            'sort_order' => 13,
            'is_active' => true,
        ]);


        Menu::create([
            'name' => 'Load Money',
            'slug' => 'user-load-money',
            'route' => 'user.load.money',
            'icon' => 'bi-wallet2',
            'visible_for' => 'user',
            'sort_order' => 11,
            'is_active' => true,
        ]);


        Menu::create([
            'name' => 'Bank Update Request',
            'slug' => 'user-bank-update-request',
            'route' => 'user.bank.update.request',
            'icon' => 'bi-bank',
            'visible_for' => 'user',
            'sort_order' => 12,
            'is_active' => true,
        ]);
    }
}
