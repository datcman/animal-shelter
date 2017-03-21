<?php

abstract class AnimalAbstract
{
    protected $kind;
    protected $name;
    protected $age;
    protected $brought;

    public function getKind()
    {
        return $this->kind;
    }

    public function setName($name)
    {
        $this->name = !$this->name ? $name : $this->name;
    }

    public function setAge($age)
    {
        $this->age = !$this->age ? $age : $this->age;
    }

    private function setBrought()
    {
        return $this->brought = !$this->brought ? mktime() : $this->brought;
    }

    public function save()
    {
        $this->setBrought();

        $sql = "insert into 
                animal
                (kind, name, age, brought)
                values
                ('" . $this->kind . "', '" . $this->name . "', '" . $this->age . "', '" . $this->setBrought() . "')";

        $db = new Sql();
        $db->query($sql);

        return $this;
    }
}