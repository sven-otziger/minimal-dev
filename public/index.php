<?php

$databaseConn = new mysqli('mariadb', $_ENV['MARIADB_USER'], $_ENV['MARIADB_PASSWORD'], $_ENV['MARIADB_DATABASE']);

if($databaseConn->connect_error) {
    die("Connection failed: " . $databaseConn->connect_error);
}
echo "Connected!";

$mysqliResult = $databaseConn->query("SELECT * FROM user");
while ($row = $mysqliResult->fetch_object()) {
    echo $row->id;
}