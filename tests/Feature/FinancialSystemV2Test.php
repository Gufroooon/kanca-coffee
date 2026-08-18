<?php

namespace Tests\Feature;

use App\Models\FinancialSubAccount;
use App\Models\GobizTransaction;
use App\Models\MajooCash;
use App\Models\User;
use App\Services\FinancialAggregationService;
use App\Services\ReferenceGenerator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FinancialSystemV2Test extends TestCase
{
    use RefreshDatabase;

    public function test_reference_generator_formats()
    {
        $subAccount = FinancialSubAccount::where('code', 'BAH')->first();
        $this->assertNotNull($subAccount);

        $refExp = ReferenceGenerator::generateExpenseRef('2026-08-01', $subAccount->id);
        $this->assertStringStartsWith('EXP/010826-01-01/OPS-BAH', $refExp);

        $refMjo = ReferenceGenerator::generateIncomeRef('2026-08-01', 'MJO');
        $this->assertEquals('INC/010826/MJO', $refMjo);

        $refGbz = ReferenceGenerator::generateIncomeRef('2026-08-01', 'GBZ');
        $this->assertEquals('INC/010826/GBZ', $refGbz);
    }

    public function test_expense_subtotal_calculations()
    {
        $item = [
            'qty' => 2,
            'price' => 100000,
            'delivery_fee' => 10000,
            'delivery_insurance' => 5000,
            'admin_app_fee' => 2000,
            'item_discount' => 5000,
            'delivery_discount' => 2000,
            'ppn' => 21000,
            'bank_admin' => 2500,
        ];

        $calc = FinancialAggregationService::calculateExpenseDetailAmounts($item);

        // Subtotal 1 = (2*100k) + 10k + 5k + 2k - 5k - 2k = 210000
        $this->assertEquals(210000, $calc['subtotal_1']);
        // Subtotal 2 = 210000 + 21000 = 231000
        $this->assertEquals(231000, $calc['subtotal_2']);
        // Subtotal 3 = 231000 + 2500 = 233500
        $this->assertEquals(233500, $calc['subtotal_3']);
    }

    public function test_majoo_cash_difference_calculation()
    {
        $cashier = 1000000;
        $actual = 980000;
        $difference = $actual - $cashier;

        $this->assertEquals(-20000, $difference);
    }
}
