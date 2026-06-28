<?php

namespace App\Models;

use CodeIgniter\Model;

/**
 * Class Notification
 * Manages CRUD operations for the notifications table.
 */
class Notification extends Model
{
    protected $table = 'notifications';
    protected $primaryKey = 'id';
    protected $useAutoIncrement = true;
    protected $returnType = 'object';
    protected $useSoftDeletes = false;

    // The fields that can be mass-assigned
    protected $allowedFields = [
        'person_id',
        'title',
        'message',
        'is_read',
        'link',
        'created_at'
    ];

    // Disable automatic timestamps since we only have created_at handled by MySQL default
    protected $useTimestamps = false;

    /**
     * Get unread notifications for a specific person.
     *
     * @param int $person_id the employee ID
     * @param int $limit maximum number of notifications to return
     * @return array array of unread notification objects
     */
    public function get_unread(int $person_id, int $limit = 10): array
    {
        return $this->where('person_id', $person_id)
                    ->where('is_read', 0)
                    ->orderBy('created_at', 'DESC')
                    ->findAll($limit);
    }

    /**
     * Mark a specific notification as read.
     *
     * @param int $notification_id
     * @param int $person_id to assure ownership
     * @return bool
     */
    public function mark_as_read(int $notification_id, int $person_id): bool
    {
        return $this->where('id', $notification_id)
                    ->where('person_id', $person_id)
                    ->set(['is_read' => 1])
                    ->update();
    }
    
    /**
     * Mark all notifications as read for a person.
     *
     * @param int $person_id
     * @return bool
     */
    public function mark_all_as_read(int $person_id): bool
    {
        return $this->where('person_id', $person_id)
                    ->where('is_read', 0)
                    ->set(['is_read' => 1])
                    ->update();
    }
}
