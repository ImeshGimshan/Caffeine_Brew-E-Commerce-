<?php
// Quick MySQL connection test
echo "Testing MySQL connections...\n\n";

// Test 1: localhost
$conn1 = @new mysqli('localhost', 'root', '');
if ($conn1->connect_error) {
    echo "❌ localhost failed: " . $conn1->connect_error . "\n";
} else {
    echo "✅ localhost works!\n";
    $conn1->close();
}

// Test 2: 127.0.0.1
$conn2 = @new mysqli('127.0.0.1', 'root', '');
if ($conn2->connect_error) {
    echo "❌ 127.0.0.1 failed: " . $conn2->connect_error . "\n";
} else {
    echo "✅ 127.0.0.1 works!\n";
    $conn2->close();
}

// Test 3: Check if database exists
$conn3 = @new mysqli('127.0.0.1', 'root', '', 'caffienebrewdb');
if ($conn3->connect_error) {
    echo "❌ Database 'caffienebrewdb' doesn't exist or can't connect\n";
    echo "   Error: " . $conn3->connect_error . "\n";
} else {
    echo "✅ Database 'caffienebrewdb' exists and connected!\n";
    $conn3->close();
}

echo "\n";
echo "If 127.0.0.1 works but localhost doesn't, we'll fix the config.\n";
