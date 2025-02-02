<?php 
// Ensure you enter your database credentials correctly. 
// The database user must have full permissions to interact with the database.
// Format: ['host', 'username', 'password', 'database_name']
$conn= new mysqli('localhost','root','','event_manager')or die("Could not connect to mysql".mysqli_error($con));
