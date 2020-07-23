<?php

/**
 * Plugin Name: Team
 * Description: A WordPress CPT for teams.
 * Version: 0.1
 * Author: James Boynton
 */

namespace Xzito\Team;

$autoload_path = __DIR__ . '/vendor/autoload.php';

if (file_exists($autoload_path)) {
  require_once($autoload_path);
}

new Team();
