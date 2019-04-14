<?php

require 'config.php';

class Model
{

    public $id;
    private $db;
    public $host = HOST;
    public $dbname = DBNAME;
    public $user = USER;
    public $pass = PASS;

    public function __construct()
    {
        $this->db = new PDO("mysql:host=$this->host;dbname=$this->dbname", "$this->user", "$this->pass");
    }

    public function lastId()  // последний id таблици БД
    {
        $id = $this->db->query('SELECT id FROM main ORDER BY id DESC LIMIT 1');
        $id = @implode($id->fetch(PDO::FETCH_ASSOC));
        return $id;
    }

    public function write($string, $time_code1, $count_item)// запись в БД
    {
        $this->id = $this->lastId();
        $this->id++;

        $data = $this->db->prepare('INSERT INTO `main` (`id`,`string`,`date`,`length`) VALUES (:id,:string,:time_code1,:count_item)');
        $data->execute(array(
            ':id' => $this->id,
            ':string' => $string,
            ':time_code1'=> $time_code1,
            ':count_item'=>$count_item
        ));

        return $this->id;
    }

    public function read($id)// получение данных с БД
    {
        $sql = "SELECT * FROM main WHERE id = $id";
        return $this->db->query($sql);
    }

    public function del($id) //удаление записи с БД
    {
        $data = $this->db->prepare('DELETE FROM main WHERE id = :id');
        $data->bindParam(':id', $id);
        $data->execute();
    }
}