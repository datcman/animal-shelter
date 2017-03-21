<?php

spl_autoload_register('autoload');
function autoload($name)
{
    $file = $name . '.php';
    include_once $file;
}
