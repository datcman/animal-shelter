<?php

class Shelter
{
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