<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TransactionTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_transactions()
    {
        $user = User::factory()->create();
        $transaction = $user->transactions()->create([
            'transaction_date' => now(),
            'amount' => 100000,
            'description' => 'Test transaction',
            'category' => 'income',
            'payment_method' => 'cash',
        ]);

        $response = $this->actingAs($user)
            ->get('/transactions');

        $response->assertStatus(200)
            ->assertSee($transaction->description);
    }

    public function test_user_can_create_transaction()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)
            ->post('/transactions', [
                'transaction_date' => now()->format('Y-m-d'),
                'amount' => 150000,
                'description' => 'New transaction',
                'category' => 'income',
                'payment_method' => 'transfer',
            ]);

        $response->assertRedirect('/transactions')
            ->assertSessionHas('success');

        $this->assertDatabaseHas('transactions', [
            'description' => 'New transaction',
            'amount' => 150000,
        ]);
    }
}