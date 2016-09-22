<?php

include_once dirname(__FILE__).'/../config.php';
include_once dirname(__FILE__).'/../common.php';

$instance = ServerSocket::getInstance();

$instance->start();