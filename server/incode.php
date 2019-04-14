<?php

require 'config.php';




spl_autoload_register('InCode::myAutoloader');
class inCode
{


    static public function myAutoloader($className)
    {

        include $className .'.php';
    }

    public function cryptAlg()     // получение "соли" (массива случайных символов)
    {

        $str = 'vz;1Db[n2aR9xLc5sSdf4l4hH:GhgS{C]6!@h1j5JkXZ9FDdO*5j3FEP0M+Fj4RIlLk4jh:Ahg{]6!CS@h0LA15-*(f1l6D*Dg7lK6*t3h]M3h]{k*V6Wl(6g7l6*Nt3hQ]t{dg3Q^k7}k7d5(';
        $arr = str_split($str);
        shuffle($arr);
        return $arr;
    }

    public function getPass()  // получение пароля (данные не проверяются, упрощенная форма)
    {
        $get = $_POST['pass'];
        $pass = str_split($get);
        return $pass;
    }

    public function timeFunc()   // получение времени(секунд) для создания ключа шифрования
    {
    return date('s');
    }

    public function cryptFunc2()    // шифрование (добавление символов с пароля в строку со случайными символами)
    {
        $fin_item = [];
        $i = substr($this->timeFunc(), 0,1);           // номер ключа значения для замены
        $count = 0;       // количество замен
        $count_item = strlen(implode($this->getPass()));      //количество символов в пароле
        foreach ($this->cryptAlg() as $key => $item) {
            if ($key == $i && $count <= $count_item) {
                $fin_item[] = $this->getPass()[$count];
                $i += 4;
                $count++;
            } else {
                $fin_item[] = $item;
            }
        }
        $fin_item = implode('', $fin_item);
        return $fin_item;
    }

    public function onLoad()   // загрузка данных в таблицу БД
    {

        $time_code1 = str_replace(':', '', date("Y:m:d:H:i:s"));
        $string = $this->cryptFunc2();
        $count_item = strlen(implode($this->getPass()));

        $model= new Model();
        $model->write($string,$time_code1,$count_item);

    }
    public function link()            // формирование ссылки на пароль
    {

        $model= new Model();
        $link="http://" . $_SERVER['SERVER_NAME'] . "/secret/decode.php?id=" . $model->lastId();
        return $link;
    }

}
$inCode = new inCode();
$inCode->onLoad();
echo $inCode->link();

?>




