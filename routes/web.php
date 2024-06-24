<?php

use Illuminate\Support\Facades\Route;

$idRegex = '[0-9]+';
$slugRegex = '[0-9a-z\-/]+';

/***************
 * /Admin ***
 * ************/
require __DIR__ . '/backend/index.php';


/***************
 * Front ***
 * ************/
require __DIR__ . '/frontend/index.php';
