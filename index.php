<?php

include('common/autoload.php');

$action = $argv[1] ?? false;
$animal = $argv[2] ?? false;
$name   = $argv[3] ?? false;
$age    = $argv[4] ?? false;

switch ($action) {
    case 'place':
        $obj = Shelter::factory($animal);
        $obj->setName($name);
        $obj->setAge($age);
        $obj->save();
        echo "animal placed.\r\n";
        break;
    case 'find':
        $animals = Shelter::find($animal);
        echo "animals findding.\r\n";
        print_r($animals);
        break;
    case 'give':
        if ($animal) {
            $obj         = Shelter::factory($animal);
            $animalGived = Shelter::give($obj->getKind());
        } else {
            $animalGived = Shelter::give();
        }
        echo "animal give away\r\n";
        print_r($animalGived);
        break;
    default:
        throw new Exception("Don't know what to do.");
}
