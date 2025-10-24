<?php

namespace App\Models;

use CodeIgniter\Model;

class Backup extends Model
{
    protected $table            = 'backups';
    protected $primaryKey       = 'backup_id';
    protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['filename', 'file_size', 'backup_type', 'created_by', 'notes'];

    // Dates
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';

    /**
     * Get all backups ordered by date
     */
    public function get_all_backups()
    {
        return $this->db->table('backups')
            ->select('backups.*, people.first_name, people.last_name')
            ->join('people', 'people.person_id = backups.created_by', 'left')
            ->orderBy('backups.created_at', 'DESC')
            ->get()
            ->getResult();
    }

    /**
     * Create database backup
     */
    public function create_backup(string $backup_type = 'manual', int $created_by = 1, string $notes = ''): array
    {
        helper('filesystem');

        $backup_path = WRITEPATH . 'backups/';
        
        // Create backup directory if it doesn't exist
        if (!is_dir($backup_path)) {
            mkdir($backup_path, 0755, true);
        }

        $filename = 'backup_' . date('Y-m-d_H-i-s') . '.sql';
        $filepath = $backup_path . $filename;

        // Get database configuration
        $db_config = config('Database');
        $db = $db_config->default;

        $hostname = $db['hostname'];
        $username = $db['username'];
        $password = $db['password'];
        $database = $db['database'];

        // Create mysqldump command
        $command = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s 2>&1',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($hostname),
            escapeshellarg($database),
            escapeshellarg($filepath)
        );

        // Execute backup
        exec($command, $output, $return_var);

        if ($return_var !== 0 || !file_exists($filepath)) {
            return [
                'success' => false,
                'message' => 'Failed to create backup. Error: ' . implode("\n", $output)
            ];
        }

        $file_size = filesize($filepath);

        // Save backup record to database
        $backup_data = [
            'filename'    => $filename,
            'file_size'   => $file_size,
            'backup_type' => $backup_type,
            'created_by'  => $created_by,
            'notes'       => $notes
        ];

        $backup_id = $this->insert($backup_data);

        if ($backup_id) {
            return [
                'success'   => true,
                'message'   => 'Backup created successfully',
                'backup_id' => $backup_id,
                'filename'  => $filename,
                'file_size' => $file_size
            ];
        }

        return [
            'success' => false,
            'message' => 'Backup file created but failed to save record'
        ];
    }

    /**
     * Restore database from backup
     */
    public function restore_backup(int $backup_id): array
    {
        $backup = $this->find($backup_id);

        if (!$backup) {
            return ['success' => false, 'message' => 'Backup not found'];
        }

        $backup_path = WRITEPATH . 'backups/';
        $filepath = $backup_path . $backup->filename;

        if (!file_exists($filepath)) {
            return ['success' => false, 'message' => 'Backup file not found'];
        }

        // Get database configuration
        $db_config = config('Database');
        $db = $db_config->default;

        $hostname = $db['hostname'];
        $username = $db['username'];
        $password = $db['password'];
        $database = $db['database'];

        // Create restore command
        $command = sprintf(
            'mysql --user=%s --password=%s --host=%s %s < %s 2>&1',
            escapeshellarg($username),
            escapeshellarg($password),
            escapeshellarg($hostname),
            escapeshellarg($database),
            escapeshellarg($filepath)
        );

        // Execute restore
        exec($command, $output, $return_var);

        if ($return_var !== 0) {
            return [
                'success' => false,
                'message' => 'Failed to restore backup. Error: ' . implode("\n", $output)
            ];
        }

        // Clear all caches after restore
        cache()->clean();

        return [
            'success' => true,
            'message' => 'Database restored successfully from backup: ' . $backup->filename
        ];
    }

    /**
     * Delete backup
     */
    public function delete_backup(int $backup_id): array
    {
        $backup = $this->find($backup_id);

        if (!$backup) {
            return ['success' => false, 'message' => 'Backup not found'];
        }

        $backup_path = WRITEPATH . 'backups/';
        $filepath = $backup_path . $backup->filename;

        // Delete file
        if (file_exists($filepath)) {
            if (!unlink($filepath)) {
                return ['success' => false, 'message' => 'Failed to delete backup file'];
            }
        }

        // Delete record
        if ($this->delete($backup_id)) {
            return ['success' => true, 'message' => 'Backup deleted successfully'];
        }

        return ['success' => false, 'message' => 'Failed to delete backup record'];
    }

    /**
     * Clean old backups (keep only X most recent)
     */
    public function clean_old_backups(int $keep_count = 10): array
    {
        $backups = $this->orderBy('created_at', 'DESC')->findAll();

        if (count($backups) <= $keep_count) {
            return ['success' => true, 'message' => 'No old backups to clean', 'deleted' => 0];
        }

        $deleted = 0;
        $backups_to_delete = array_slice($backups, $keep_count);

        foreach ($backups_to_delete as $backup) {
            $result = $this->delete_backup($backup->backup_id);
            if ($result['success']) {
                $deleted++;
            }
        }

        return [
            'success' => true,
            'message' => "Cleaned $deleted old backup(s)",
            'deleted' => $deleted
        ];
    }

    /**
     * Get total backup size
     */
    public function get_total_backup_size(): int
    {
        $result = $this->selectSum('file_size')->first();
        return $result ? (int)$result->file_size : 0;
    }
}
