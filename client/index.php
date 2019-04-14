

<?php
$post_data = array(
    'pass' => $_POST['pass'],
);
$curl = curl_init();
curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
curl_setopt($curl, CURLOPT_POST, TRUE);
curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
curl_setopt($curl, CURLOPT_URL, 'http://ak-user.net/secret/index.php');
$return = curl_exec($curl);
curl_close($curl);


?>
<!DOCTYPE HTML>
<html>
<head>
    <meta charset="utf-8">
    <title>Пароль</title>
    <link rel="stylesheet" href="main.css">
</head>

<div class="centered">
    <h3 >Введите пароль</h3>
    <form action="" method="post">
        <p><input name="pass"> <input type="submit"></p>

    </form>
    <br><br>
Ваша ссылка:<br><br>
    <?php echo $return; ?>
</div>