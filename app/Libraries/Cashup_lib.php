<?php

namespace App\Libraries;

use App\Models\Cashup;

/**
 * Session helpers for linking POS sales to an open cashup register session.
 */
class Cashup_lib
{
    private const SESSION_KEY = 'active_cashup_id';

    public function get_active_cashup_id(): ?int
    {
        $id = session()->get(self::SESSION_KEY);

        return ($id !== null && (int) $id > 0) ? (int) $id : null;
    }

    public function set_active_cashup_id(int $cashup_id): void
    {
        session()->set(self::SESSION_KEY, $cashup_id);
    }

    public function clear_active_cashup_id(): void
    {
        session()->remove(self::SESSION_KEY);
    }

    public function clear_if_active(int $cashup_id): void
    {
        if ($this->get_active_cashup_id() === $cashup_id) {
            $this->clear_active_cashup_id();
        }
    }

    /**
     * Keep session cashup in sync with the employee's open register session.
     */
    public function ensure_active_cashup(int $employee_id): ?int
    {
        $cashup = model(Cashup::class);
        $active = $this->get_active_cashup_id();

        if ($active !== null && $cashup->is_open_session($active)) {
            return $active;
        }

        if ($active !== null) {
            $this->clear_active_cashup_id();
        }

        $open_id = $cashup->get_open_cashup_id_for_employee($employee_id);
        if ($open_id !== null) {
            $this->set_active_cashup_id($open_id);
        }

        return $open_id;
    }
}
