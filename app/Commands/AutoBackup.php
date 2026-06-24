<?php

namespace App\Commands;

use CodeIgniter\CLI\BaseCommand;
use CodeIgniter\CLI\CLI;
use App\Models\Backup;
use App\Models\Appconfig;

class AutoBackup extends BaseCommand
{
    protected $group       = 'Database';
    protected $name        = 'backup:auto';
    protected $description = 'Automatically create database backup and clean old backups';

    public function run(array $params)
    {
        CLI::write('Starting automatic backup...', 'yellow');

        $backupModel = model(Backup::class);
        $configModel = model(Appconfig::class);

        // Check if auto backup is enabled
        $enabled = $configModel->get_value('auto_backup_enabled') ?? '0';
        
        if ($enabled !== '1') {
            CLI::write('Auto backup is disabled', 'red');
            return;
        }

        // Create backup
        CLI::write('Creating backup...', 'yellow');
        $result = $backupModel->create_backup('auto', 1, 'Automatic backup');

        if ($result['success']) {
            CLI::write('✓ Backup created successfully: ' . $result['filename'], 'green');
            CLI::write('  Size: ' . number_format($result['file_size'] / 1024 / 1024, 2) . ' MB', 'green');
            
            // Update last backup time
            $configModel->save_value('last_auto_backup', date('Y-m-d H:i:s'));
            
            // Clean old backups
            $keep_count = (int)($configModel->get_value('keep_backups') ?? 10);
            CLI::write('Cleaning old backups (keeping ' . $keep_count . ')...', 'yellow');
            
            $clean_result = $backupModel->clean_old_backups($keep_count);
            
            if ($clean_result['deleted'] > 0) {
                CLI::write('✓ Cleaned ' . $clean_result['deleted'] . ' old backup(s)', 'green');
            } else {
                CLI::write('No old backups to clean', 'green');
            }
            
            CLI::write('Auto backup completed successfully', 'green');
        } else {
            CLI::write('✗ Backup failed: ' . $result['message'], 'red');
        }
    }
}
