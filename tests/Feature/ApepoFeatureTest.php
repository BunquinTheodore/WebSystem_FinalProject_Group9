<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ApepoFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_apepo_via_ajax_and_get_json(): void
    {
        $session = [ 'role' => 'manager', 'username' => 'manager1' ];

        $payload = [
            'audit' => 'Audit notes',
            'people' => 'People update',
            'equipment' => 'Equipment ok',
            'product' => 'Product is fine',
            'others' => 'Other notes',
            'notes' => 'Optional notes',
        ];

        $resp = $this->withSession($session)->post(
            route('manager.apepo'),
            $payload,
            [ 'X-Requested-With' => 'XMLHttpRequest' ]
        );

        $resp->assertOk();
        $resp->assertJsonStructure([
            'ok',
            'apepo' => [ 'id', 'manager_username', 'audit', 'people', 'equipment', 'product', 'others', 'notes', 'created_at' ]
        ]);

        $data = $resp->json('apepo');
        $this->assertSame('manager1', $data['manager_username']);
        $this->assertSame('Audit notes', $data['audit']);

        $this->assertDatabaseHas('apepo_reports', [
            'id' => $data['id'],
            'manager_username' => 'manager1',
            'audit' => 'Audit notes',
        ]);
    }

    public function test_manager_can_delete_own_apepo_via_ajax(): void
    {
        $session = [ 'role' => 'manager', 'username' => 'manager1' ];

        $id = DB::table('apepo_reports')->insertGetId([
            'manager_username' => 'manager1',
            'audit' => 'To delete',
            'people' => '',
            'equipment' => '',
            'product' => '',
            'others' => '',
            'notes' => '',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $resp = $this->withSession($session)->post(
            route('manager.apepo.delete', ['id' => $id]),
            [],
            [ 'X-Requested-With' => 'XMLHttpRequest' ]
        );

        $resp->assertOk();
        $resp->assertJson(['ok' => true]);
        $this->assertDatabaseMissing('apepo_reports', ['id' => $id]);
    }
}
