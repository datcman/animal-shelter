<?php

class Sql
{

    private $dbHost = "127.0.0.1";
    private $dbPort = 5432;
    private $dbName = "animal";
    private $dbUser = "postgres";
    private $dbPassword = "pass";
    private $_connect = false;

    public function __construct()
    {
        $this->_connect = $this->connect();
        $this->checkTable();
    }

    public function query($sql)
    {
        $result = pg_query($this->_connect, $sql) or die('Ошибка запроса: ' . pg_last_error());

        return pg_fetch_all($result);
    }

    private function connect()
    {
        $conn = "host={$this->dbHost} port={$this->dbPort} dbname={$this->dbName} user={$this->dbUser} password={$this->dbPassword}";
        $result = pg_connect($conn) or die("Невозможно соединиться с сервером {$this->dbHost}\n");

        return $result;
    }

    public function checkTable()
    {
        $sql = "
CREATE SEQUENCE IF NOT EXISTS public.animal_id_seq
              INCREMENT 1
              MINVALUE 1
              MAXVALUE 9223372036854775807
              START 1
              CACHE 1;
              
              ALTER TABLE public.animal_id_seq
              OWNER TO " . $this->dbUser . ";

CREATE TABLE IF NOT EXISTS public.animal (
              id integer NOT NULL DEFAULT nextval('animal_id_seq'::regclass),
              kind character varying(10) NOT NULL,
              name character varying(50) NOT NULL,
              age integer NOT NULL,
              brought integer NOT NULL)
              WITH (OIDS=FALSE);
              
              ALTER TABLE public.animal
              OWNER TO " . $this->dbUser . ";
              ";

        $this->query($sql);
    }
}
