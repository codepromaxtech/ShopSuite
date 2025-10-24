<?php

namespace App\Controllers;

use App\Models\Backup;

class Backups extends Secure_Controller
{
    protected Backup $backup;

    public function __construct()
    {
        parent::__construct('backups', 'config', 'backups');
        $this->backup = model(Backup::class);
    }

    /**
     * List all backups
     */
    public function getIndex(): void
    {
        $data['backups'] = $this->backup->get_all_backups();
        $data['total_size'] = $this->backup->get_total_backup_size();
        echo view('backups/manage_modern', $data);
    }

    /**
     * Create new backup
     */
    public function postCreate(): void
    {
        $this->response->setContentType('application/json');

        $notes = $this->request->getPost('notes', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $created_by = $this->session->get('person_id') ?? 1;

        $result = $this->backup->create_backup('manual', $created_by, $notes);
        
        echo json_encode($result);
        exit;
    }

    /**
     * Download backup file
     */
    public function getDownload(int $backup_id)
    {
        $backup_record = $this->backup->find($backup_id);

        if (!$backup_record) {
            echo 'Backup not found';
            return;
        }

        $backup_path = WRITEPATH . 'backups/';
        $filepath = $backup_path . $backup_record->filename;

        if (!file_exists($filepath)) {
            echo 'Backup file not found';
            return;
        }

        return $this->response->download($filepath, null)->setFileName($backup_record->filename);
    }

    /**
     * Restore backup
     */
    public function postRestore(): void
    {
        $this->response->setContentType('application/json');

        $backup_id = $this->request->getPost('backup_id', FILTER_SANITIZE_NUMBER_INT);

        if (empty($backup_id)) {
            echo json_encode(['success' => false, 'message' => 'Backup ID is required']);
            exit;
        }

        $result = $this->backup->restore_backup($backup_id);
        
        echo json_encode($result);
        exit;
    }

    /**
     * Delete backup
     */
    public function postDelete(): void
    {
        $this->response->setContentType('application/json');

        $ids = $this->request->getPost('ids');

        if (empty($ids) || !is_array($ids)) {
            echo json_encode(['success' => false, 'message' => 'No backups selected']);
            exit;
        }

        $deleted = 0;
        $errors = [];

        foreach ($ids as $backup_id) {
            $result = $this->backup->delete_backup($backup_id);
            if ($result['success']) {
                $deleted++;
            } else {
                $errors[] = $result['message'];
            }
        }

        if ($deleted > 0 && empty($errors)) {
            echo json_encode(['success' => true, 'message' => "$deleted backup(s) deleted successfully"]);
        } elseif ($deleted > 0) {
            echo json_encode(['success' => true, 'message' => "$deleted backup(s) deleted. Errors: " . implode(', ', $errors)]);
        } else {
            echo json_encode(['success' => false, 'message' => implode(', ', $errors)]);
        }
        exit;
    }

    /**
     * Clean old backups
     */
    public function postClean(): void
    {
        $this->response->setContentType('application/json');

        $keep_count = $this->request->getPost('keep_count', FILTER_SANITIZE_NUMBER_INT) ?: 10;

        $result = $this->backup->clean_old_backups($keep_count);
        
        echo json_encode($result);
        exit;
    }

    /**
     * Auto backup settings
     */
    public function getSettings(): void
    {
        echo view('backups/settings_modern', $this->global_view_data);
    }

    /**
     * Save auto backup settings
     */
    public function postSaveSettings(): void
    {
        $this->response->setContentType('application/json');

        $auto_backup_enabled = $this->request->getPost('auto_backup_enabled') ? '1' : '0';
        $backup_frequency = $this->request->getPost('backup_frequency', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
        $keep_backups = $this->request->getPost('keep_backups', FILTER_SANITIZE_NUMBER_INT);

        // Save to config (you may want to create a settings table instead)
        $config_model = model(\App\Models\Appconfig::class);
        
        $config_model->save_value('auto_backup_enabled', $auto_backup_enabled);
        $config_model->save_value('backup_frequency', $backup_frequency);
        $config_model->save_value('keep_backups', $keep_backups);

        echo json_encode(['success' => true, 'message' => 'Auto backup settings saved']);
        exit;
    }
}
