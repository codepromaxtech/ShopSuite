<?php

namespace App\Models;

use CodeIgniter\Model;
use stdClass;

/**
 * Item_quantity class
 */
class Item_quantity extends Model
{
    protected $table = 'item_quantities';
    protected $primaryKey = 'item_id';
    protected $useAutoIncrement = false;
    protected $useSoftDeletes = false;
    protected $allowedFields = [
        'quantity'
    ];

    protected $item_id;
    protected $location_id;
    protected $quantity;

    /**
     * @param int $item_id
     * @param int $location_id
     * @return bool
     */
    public function exists(int $item_id, int $location_id): bool
    {
        $builder = $this->db->table('item_quantities');
        $builder->where('item_id', $item_id);
        $builder->where('location_id', $location_id);

        return ($builder->get()->getNumRows() == 1);    // TODO: ===
    }

    /**
     * @param array $location_detail
     * @param int $item_id
     * @param int $location_id
     * @return bool
     */
    public function save_value(array $location_detail, int $item_id, int $location_id): bool
    {
        if (!$this->exists($item_id, $location_id)) {
            $builder = $this->db->table('item_quantities');
            return $builder->insert($location_detail);
        }

        $builder = $this->db->table('item_quantities');
        $builder->where('item_id', $item_id);
        $builder->where('location_id', $location_id);

        return $builder->update($location_detail);
    }

    /**
     * @param int $item_id
     * @param int $location_id
     * @return array|Item_quantity|stdClass|null
     */
    public function get_item_quantity(int $item_id, int $location_id): array|Item_quantity|StdClass|null
    {
        $builder = $this->db->table('item_quantities');
        $builder->where('item_id', $item_id);
        $builder->where('location_id', $location_id);
        $result = $builder->get()->getRow();

        if (empty($result)) {
            // Get empty base parent object, as $item_id is NOT an item
            $result = model(Item_quantity::class);

            // Get all the fields from items table (TODO: to be reviewed)
            foreach ($this->db->getFieldNames('item_quantities') as $field) {
                $result->$field = '';
            }

            $result->quantity = 0;
        }

        return $result;
    }

    /**
     * Adjust stock for a completed sale line atomically.
     * Positive quantity_purchased decrements stock (sale); negative increments (return).
     */
    public function adjust_quantity_for_sale(int $item_id, int $location_id, float $quantity_purchased): bool
    {
        $prefix = $this->db->getPrefix();

        if ($quantity_purchased > 0) {
            $sql = "UPDATE {$prefix}item_quantities SET quantity = quantity - ?"
                . " WHERE item_id = ? AND location_id = ? AND quantity >= ?";
            $this->db->query($sql, [$quantity_purchased, $item_id, $location_id, $quantity_purchased]);

            return $this->db->affectedRows() > 0;
        }

        if ($quantity_purchased < 0) {
            $sql = "UPDATE {$prefix}item_quantities SET quantity = quantity + ?"
                . " WHERE item_id = ? AND location_id = ?";
            $this->db->query($sql, [abs($quantity_purchased), $item_id, $location_id]);

            if ($this->db->affectedRows() > 0) {
                return true;
            }

            return $this->save_value(
                [
                    'item_id'     => $item_id,
                    'location_id' => $location_id,
                    'quantity'    => abs($quantity_purchased),
                ],
                $item_id,
                $location_id
            );
        }

        return true;
    }

    /**
     * changes to quantity of an item according to the given amount.
     * if $quantity_change is negative, it will be subtracted,
     * if it is positive, it will be added to the current quantity
     */
    public function change_quantity(int $item_id, int $location_id, int $quantity_change): bool
    {
        $quantity_old = $this->get_item_quantity($item_id, $location_id);
        $quantity_new = $quantity_old->quantity + $quantity_change;
        $location_detail = ['item_id' => $item_id, 'location_id' => $location_id, 'quantity' => $quantity_new];

        return $this->save_value($location_detail, $item_id, $location_id);
    }

    /**
     * Set to 0 all quantity in the given item
     */
    public function reset_quantity(int $item_id): bool
    {
        $builder = $this->db->table('item_quantities');
        $builder->where('item_id', $item_id);

        return $builder->update(['quantity' => 0]);
    }

    /**
     * Set to 0 all quantity in the given list of items
     */
    public function reset_quantity_list(array $item_ids): bool
    {
        $builder = $this->db->table('item_quantities');
        $builder->whereIn('item_id', $item_ids);

        return $builder->update(['quantity' => 0]);
    }
}
