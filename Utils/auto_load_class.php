<?php

declare(strict_types=1);

### ---------------------------------------------------------------------
spl_autoload_register(function (string $classNamespace) {
    $path = str_replace(['\\', 'Code/'], ['/', ''], $classNamespace);
    $path = "prg/$path.php";
    require_once($path);
  });