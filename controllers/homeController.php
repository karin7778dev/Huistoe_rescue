<?php
// homeController.php

// 1. Bootstrap & dependencies
require_once __DIR__ . '/../includes/db.php';

// any preloading data that need to be fetch from the DB queries in php should come here

     

$pageContent = __DIR__ . '/../pages/home.php';
require_once __DIR__ . '/../layout.php';