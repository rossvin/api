<?php

require 'config.php';


spl_autoload_register('DeCode::myAutoloader');
class deCode
{
    static public function myAutoloader($className)
    {


        include $className .'.php';
    }
    public function getId()     // получение ссылки с ID пароля
    {
        $id = $_GET['id'];
        return $id;
    }

    public function verifi()                         // проверка актуальност пароля (текущий и следующий день) и наличия
    {
      $verifi_time_orig = substr($this->getCode()[0], 0,8);
      $verifi_time_orig2 = $verifi_time_orig + 1;
      $verifi_time_act=str_replace(':', '', date("Y:m:d"));
        if($verifi_time_act != $verifi_time_orig2 && $verifi_time_act != $verifi_time_orig ) {

            return true;
        }
    }

    public function getCode()               //получение данных
    {
        $id=$_GET['id'];

        $model= new Model();
        $res=$model->read($id);
        $res = $res->FETCH(PDO::FETCH_ASSOC);
         $data=[$res["date"],$res["string"],$res["length"]];

        return $data;

    }

    public function deCode1()   //декодирование
    {
        if(!$this->verifi()):
        $fin_item = [];

        $i = substr($this->getCode()[0],12,1);           // номер ключа значения для замены
        $string=str_split($this->getCode()[1]);
        $count = 0;                          // количество замен
        $count_item = $this->getCode()[2]-1;      //количество символов в пароле
        foreach ($string as $key => $item) {
            if ($key == $i && $count <= $count_item) {
                $fin_item[] = $item;
                $i += 4;
                $count++;
            }
        }
            $this->del();

        echo 'Ваш пароль <br><br>' . implode($fin_item);

        else:
            echo "Пароль устарел или просмотрен";
        endif;
    }


    public function del(){                            // удаление пароля после просмотра

        $model= new Model();
        $model->del($this->getId());
        
    }
}
?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Пароль</title>
    <link rel="stylesheet" href="main.css">
</head>

<div class="centered2">

<p>
    <?php

    $deCode = new deCode();
    echo $deCode->deCode1();

    ?>
</p>
</div>
