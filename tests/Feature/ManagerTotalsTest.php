<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ManagerTotalsTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_totals_endpoint_returns_expected_sums(): void
    {
        // Simulate a manager session
        $session = [
            'role' => 'manager',
            'username' => 'manager1',
        ];

        // Seed data: funds and expenses for this manager
        DB::table('manager_funds')->insert([
            'manager_username' => 'manager1',
            'amount' => 1000,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('manager_funds')->insert([
            'manager_username' => 'manager1',
            'amount' => 500,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('expenses')->insert([
            'manager_username' => 'manager1',
            'amount' => 400,
            'note' => 'Supplies',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        DB::table('expenses')->insert([
            'manager_username' => 'manager1',
            'amount' => 50,
            'note' => 'Snacks',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $resp = $this->withSession($session)->get(route('manager.totals'));
        $resp->assertOk();
        $resp->assertJsonStructure([
            'fundBalance', 'expensesTotal', 'availableBalance'
        ]);

        $data = $resp->json();
        $this->assertSame(1500.0, (float) $data['fundBalance']);
        $this->assertSame(450.0, (float) $data['expensesTotal']);
        $this->assertSame(1050.0, (float) $data['availableBalance']);
    }

    public function test_unauthorized_without_manager_role(): void
    {
        $resp = $this->withSession(['role' => 'owner', 'username' => 'owner1'])->get(route('manager.totals'));
        $resp->assertStatus(401);
    }
}
