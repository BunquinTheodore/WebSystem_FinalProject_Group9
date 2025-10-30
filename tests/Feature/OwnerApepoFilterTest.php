<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class OwnerApepoFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_owner_can_filter_apepo_by_manager(): void
    {
        // Seed
        DB::table('apepo_reports')->insert([
            'manager_username' => 'alice',
            'audit' => 'Alice report',
            'people' => '', 'equipment' => '', 'product' => '', 'others' => '', 'notes' => '',
            'created_at' => now()->subDays(1),
            'updated_at' => now()->subDays(1),
        ]);
        DB::table('apepo_reports')->insert([
            'manager_username' => 'bob',
            'audit' => 'Bob report',
            'people' => '', 'equipment' => '', 'product' => '', 'others' => '', 'notes' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $resp = $this->withSession(['role' => 'owner', 'username' => 'owner1'])
                     ->get(route('owner.home', ['manager' => 'alice']));
        $resp->assertOk();
        $resp->assertSeeText('Alice report');
        $resp->assertDontSeeText('Bob report');
    }

    public function test_owner_can_filter_apepo_by_date_range(): void
    {
        DB::table('apepo_reports')->insert([
            'manager_username' => 'alice',
            'audit' => 'Old report',
            'people' => '', 'equipment' => '', 'product' => '', 'others' => '', 'notes' => '',
            'created_at' => now()->subDays(10),
            'updated_at' => now()->subDays(10),
        ]);
        DB::table('apepo_reports')->insert([
            'manager_username' => 'alice',
            'audit' => 'Recent report',
            'people' => '', 'equipment' => '', 'product' => '', 'others' => '', 'notes' => '',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(2),
        ]);

        $from = now()->subDays(3)->format('Y-m-d');
        $to = now()->format('Y-m-d');
        $resp = $this->withSession(['role' => 'owner', 'username' => 'owner1'])
                     ->get(route('owner.home', ['from' => $from, 'to' => $to]));
        $resp->assertOk();
        $resp->assertSeeText('Recent report');
        $resp->assertDontSeeText('Old report');
    }
}
