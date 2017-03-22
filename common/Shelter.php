<?php

class Shelter
{
    public static function action($params)
    {
        switch ($params['action']) {
            case 'place':
                if (self::place($params)) {
                    echo "animal placed.\r\n";
                }
                break;
            case 'find':
                $animals = self::find($params['animal']);
                if ($animals) {
                    echo "animals findding.\r\n";
                    print_r($animals);
                }
                break;
            case 'give':
                if ($params['animal']) {
                    $obj         = self::factory($params['animal']);
                    $animal = self::give($obj->getKind());
                } else {
                    $animal = self::give();
                }
                if ($animal) {
                    echo "animal give away\r\n";
                    print_r($animal);
                }
                break;
            default:
                throw new Exception("Don't know what to do.");
        }
    }

    public static function place($params)
    {
        $obj = Shelter::factory($params['animal']);
        $obj->setName($params['name']);
        $obj->setAge($params['age']);

        return $obj->save();
    }

    public static function find($kind)
    {
        $obj    = self::factory($kind);
        $sql    = "SELECT * from animal WHERE kind = '" . $obj->getKind() . "' order by name;";
        $db     = new Sql();
        $result = $db->query($sql);

        return $result;
    }

    public static function give($kind = false)
    {
        $where = '';
        if ($kind) {
            $obj   = self::factory($kind);
            $where = " WHERE kind = '" . $obj->getKind() . "'";
        }
        $sql    = "SELECT * from animal" . $where . " order by brought LIMIT 1;";
        $db     = new Sql();
        $result = $db->query($sql);

        if (!empty($result)) {
            $sql = "DELETE from animal WHERE id = " . $result[0]['id'];
            $db->query($sql);
        }

        return $result;
    }

    public static function factory($animal)
    {
        switch ($animal) {
            case 'cat':
                $obj = new Cat();
                break;
            case 'dog':
                $obj = new Dog();
                break;
            case 'turtle':
                $obj = new Turtle();
                break;
            default:
                throw new Exception("I don't know the '" . $animal . "' animal.");
        }

        return $obj;
    }
}