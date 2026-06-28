<?php

use App\Models\Cashup;
use PHPUnit\Framework\TestCase;

class CashupOpenSessionTest extends TestCase
{
    public function testOpenSessionWhenClosedAmountsAreZero(): void
    {
        $row = (object) [
            'deleted'             => 0,
            'closed_amount_cash'  => 0,
            'closed_amount_due'   => 0,
            'closed_amount_card'  => 0,
            'closed_amount_check' => 0,
        ];

        $this->assertTrue(Cashup::is_open_session_row($row));
    }

    public function testClosedSessionWhenAnyClosedAmountIsNonZero(): void
    {
        $row = (object) [
            'deleted'             => 0,
            'closed_amount_cash'  => 100,
            'closed_amount_due'   => 0,
            'closed_amount_card'  => 0,
            'closed_amount_check' => 0,
        ];

        $this->assertFalse(Cashup::is_open_session_row($row));
    }

    public function testDeletedSessionIsNotOpen(): void
    {
        $row = (object) [
            'deleted'             => 1,
            'closed_amount_cash'  => 0,
            'closed_amount_due'   => 0,
            'closed_amount_card'  => 0,
            'closed_amount_check' => 0,
        ];

        $this->assertFalse(Cashup::is_open_session_row($row));
    }
}
