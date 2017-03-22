<?php

include('common/autoload.php');

$params = [
    'action' => $argv[1] ?? false,
    'animal' => $argv[2] ?? false,
    'name'   => $argv[3] ?? false,
    'age'    => $argv[4] ?? false,
];

Shelter::action($params);
