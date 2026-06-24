<?php
/**
 * Add Missing Permissions to User
 * Run this once: php add_permissions.php
 */

require __DIR__ . '/vendor/autoload.php';

// Load database configuration
$db_config = include __DIR__ . '/app/Config/Database.php';
$config = $db_config->default;

// Connect to database
$conn = new mysqli($config['hostname'], $config['username'], $config['password'], $config['database']);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

echo "🔗 Connected to database...\n";

// SQL to add missing permissions
$sql = "INSERT IGNORE INTO `grants` (`permission_id`, `person_id`, `menu_group`) VALUES
('home', 1, 'both'),
('config', 1, 'office'),
('roles', 1, 'office'),
('employees', 1, 'office'),
('backups', 1, 'office'),
('taxes', 1, 'office'),
('attributes', 1, 'office'),
('expenses_categories', 1, 'office'),
('migrate', 1, 'office')";

if ($conn->multi_query($sql)) {
    echo "✅ Permissions added successfully!\n";
    
    // Clear any results
    while ($conn->next_result()) {;}
    
    // Count total permissions
    $result = $conn->query("SELECT COUNT(*) as total FROM grants WHERE person_id = 1");
    $row = $result->fetch_assoc();
    echo "📊 Total permissions for user 1: " . $row['total'] . "\n";
    
    // List all permissions
    echo "\n📋 All your permissions:\n";
    $result = $conn->query("SELECT permission_id, menu_group FROM grants WHERE person_id = 1 ORDER BY permission_id");
    while ($row = $result->fetch_assoc()) {
        echo "   - " . $row['permission_id'] . " (" . $row['menu_group'] . ")\n";
    }
    
    echo "\n✅ Done! Now logout and login again to see all modules.\n";
} else {
    echo "❌ Error: " . $conn->error . "\n";
}

$conn->close();
?>
