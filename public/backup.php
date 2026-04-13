<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

/*
|--------------------------------------------------------------------------
| MySQL Multi-Database Backup Script (Compressed + No Delete)
|--------------------------------------------------------------------------
| Creates a gzipped .sql.gz backup for each database.
| Files are stored permanently (no deletion).
| Safe for cron execution.
*/

date_default_timezone_set('Asia/Karachi');

// ==== CONFIGURATION ====
$host = "localhost";
$username = "realerp_probox";
$password = "S@ftix786";

// Databases to back up
$databases = [
    'realerp_flux',
    'realerp_probox',
];

// Backup folder
$backupDir = __DIR__ . '/backups';
if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

// ❌ Removed deletion block COMPLETELY
// (You asked for no deletion)

// Backup process
foreach ($databases as $database) {
    try {
        $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $date = date('Y-m-d_H-i-s');
        $sqlFile = "{$backupDir}/{$database}_backup_{$date}.sql";
        $gzFile  = "{$sqlFile}.gz";

        // Create SQL dump
        $handle = fopen($sqlFile, 'w+');

        fwrite($handle, "-- Backup of {$database} on {$date}\n\n");

        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);

        foreach ($tables as $table) {
            fwrite($handle, "DROP TABLE IF EXISTS `$table`;\n");

            $create = $pdo->query("SHOW CREATE TABLE `$table`")->fetch(PDO::FETCH_ASSOC);
            fwrite($handle, $create['Create Table'] . ";\n\n");

            $rows = $pdo->query("SELECT * FROM `$table`");
            while ($row = $rows->fetch(PDO::FETCH_ASSOC)) {
                $vals = array_map([$pdo, 'quote'], array_values($row));
                fwrite($handle, "INSERT INTO `$table` VALUES (" . implode(',', $vals) . ");\n");
            }

            fwrite($handle, "\n\n");
        }

        fclose($handle);

        // Compress the SQL file → .gz
        $gz = gzopen($gzFile, 'w9'); // max compression
        gzwrite($gz, file_get_contents($sqlFile));
        gzclose($gz);

        // Remove uncompressed .sql
        unlink($sqlFile);

        echo "✅ Compressed backup created for: {$database}<br>";

    } catch (Exception $e) {
        echo "❌ Error backing up {$database}: " . $e->getMessage() . "<br>";
    }
}

echo "<br>All backups stored in: {$backupDir}";
?>
