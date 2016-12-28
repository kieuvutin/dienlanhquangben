<?php
// Include scss script here as 'use' can't be used in function
$path = dirname(__FILE__);
include 'php5.4_plus/scss.inc.php';
use Leafo\ScssPhp;
$scss = new Leafo\ScssPhp\Compiler();
