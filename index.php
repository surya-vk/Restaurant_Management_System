
<?php
// Check if setup has already been completed
if (file_exists('setup_completed.flag')) {
    echo "Setup has already been completed. The SQL setup won't run again.";
} else {
    define('DB_HOST', 'localhost');
    define('DB_USER', 'root');
    define('DB_PASS', '');

    // Create Connection
    $link = new mysqli(DB_HOST, DB_USER, DB_PASS);

    // Check Connection
    if ($link->connect_error) {
        die('Connection Failed: ' . $link->connect_error);
    }

    // Create the 'rmsdb' database if it doesn't exist
    $sqlCreateDB = "CREATE DATABASE IF NOT EXISTS rmsdb";
    if ($link->query($sqlCreateDB) === TRUE) {
        echo "Database 'rmsdb' created successfully.<br>";
    } else {
        echo "Error creating database: " . $link->error . "<br>";
    }

    // Switch to using the 'rmsdb' database
    $link->select_db('rmsdb');

    // Execute SQL statements from "rmsdb.txt"
    function executeSQLFromFile($filename, $link) {
        $sql = file_get_contents($filename);

        // Execute the SQL statements
        if ($link->multi_query($sql) === TRUE) {
            echo "SQL statements executed successfully.";
            // Set the flag to indicate setup is complete
            file_put_contents('setup_completed.flag', 'Setup completed successfully.');
        } else {
            echo "Error executing SQL statements: " . $link->error;
        }
    }

    // Execute SQL statements from "rmsdb.txt"
    executeSQLFromFile('rmsdb.txt', $link);

    // Close the database connection
    $link->close();
}
?>

<a href="customerSide/home/home.php">Home</a>
