<?php
$dbcon = @mysqli_connect('localhost', 'JaredFahad','Japula_112','members_baquirin');
if (!$dbcon) {
    die('Connection failed: ' . mysqli_connect_error());
}

if (!mysqli_set_charset($dbcon, 'utf8')) {
    die('Error loading character set utf8: ' . mysqli_error($dbcon));
}
?>