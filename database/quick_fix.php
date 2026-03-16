<?php
require_once 'config.php';

try {
    $database = new Database();
    $pdo = $database->pdo;
    
    echo "<h2>Adding Company Column</h2>";
    
    // Add company column
    $sql = "ALTER TABLE `users` ADD COLUMN IF NOT EXISTS `company` varchar(255) DEFAULT NULL AFTER `phone`";
    $pdo->exec($sql);
    
    echo "<p style='color: green;'>✓ Company column added successfully</p>";
    
    // Verify column exists
    $stmt = $pdo->prepare("DESCRIBE users");
    $stmt->execute();
    $columns = $stmt->fetchAll();
    
    echo "<h3>Current table structure:</h3>";
    echo "<table border='1' cellpadding='5'>";
    echo "<tr><th>Field</th><th>Type</th></tr>";
    
    foreach ($columns as $column) {
        echo "<tr>";
        echo "<td>" . htmlspecialchars($column['Field']) . "</td>";
        echo "<td>" . htmlspecialchars($column['Type']) . "</td>";
        echo "</tr>";
    }
    
    echo "</table>";
    
} catch (Exception $e) {
    echo "<p style='color: red;'>Error: " . htmlspecialchars($e->getMessage()) . "</p>";
}

echo "<br><a href='../index.php'>← Back to website</a>";
?>
