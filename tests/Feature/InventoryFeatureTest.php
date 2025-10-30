<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class InventoryFeatureTest extends TestCase
{
    use RefreshDatabase;

    public function test_manager_can_create_inventory_item_and_adjust_quantity(): void
    {
        $session = ['role' => 'manager', 'username' => 'manager1'];

        // Create item
        $resp = $this->withSession($session)->post(route('manager.inventory.item'), [
            'name' => 'Flour',
            'category' => 'Baking',
            'unit' => 'kg',
            'quantity' => 5,
            'min_threshold' => 2,
        ]);
        $resp->assertRedirect(route('manager.home'));

        $item = DB::table('inventory_items')->where('name', 'Flour')->first();
        $this->assertNotNull($item);
        $this->assertSame(5, (int) $item->quantity);

        // Adjust +3
        $resp2 = $this->withSession($session)->post(route('manager.inventory.adjust', ['id' => $item->id]), [
            'delta' => 3,
            'reason' => 'Restock',
        ]);
        $resp2->assertRedirect(route('manager.home'));
        $item = DB::table('inventory_items')->where('id', $item->id)->first();
        $this->assertSame(8, (int) $item->quantity);

        // Adjust -10 (should floor at 0)
        $resp3 = $this->withSession($session)->post(route('manager.inventory.adjust', ['id' => $item->id]), [
            'delta' => -10,
            'reason' => 'Usage',
        ]);
        $resp3->assertRedirect(route('manager.home'));
        $item = DB::table('inventory_items')->where('id', $item->id)->first();
        $this->assertSame(0, (int) $item->quantity);

        // Adjustment record exists
        $adjCount = DB::table('inventory_adjustments')->where('item_id', $item->id)->count();
        $this->assertSame(2, (int) $adjCount);
    }
}
