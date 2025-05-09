<?php
// includes/logger.php

function write_log($action, $ip, $evidenceFile = null) {
    $date = date('Y-m-d');
    $time = date('H:i:s');
    $logDir = __DIR__ . '/../logs/';
    if (!is_dir($logDir)) mkdir($logDir, 0777, true);

    $logFile = $logDir . "log_$date.txt";
    $logLine = "[$time] - $ip - $action";
    if ($evidenceFile) {
        $logLine .= " - File: $evidenceFile";
    }
    $logLine .= PHP_EOL;

    file_put_contents($logFile, $logLine, FILE_APPEND);
}
?>
