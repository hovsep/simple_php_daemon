<?php

#Start parent process and launch child

echo 'Parent process started', PHP_EOL;

$childPid = pcntl_fork();

if ($childPid) {
    echo 'Parent process terminated';
    exit;
}

posix_setsid();

echo 'Child process started', PHP_EOL;
echo 'You can stop me : kill -9 ' . posix_getpid(), PHP_EOL;

#Setup child process
$baseDir = dirname(__FILE__);
ini_set('error_log',$baseDir.'/error.log');
fclose(STDIN);
fclose(STDOUT);
fclose(STDERR);
$STDIN = fopen('/dev/null', 'r');
$STDOUT = fopen($baseDir.'/application.log', 'ab');
$STDERR = fopen($baseDir.'/daemon.log', 'ab');



while (true) {
    echo 'Going to run external script', PHP_EOL;
    exec('php external.php');
}