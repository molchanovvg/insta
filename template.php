<!DOCTYPE HTML>
<html>
<head>
    <title>Фото инстаграм</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.css" rel="stylesheet">

</head>
<body>
<div class="container">
    <form class="form-signin" method="post" action="index.php" role="form">
        <h4 class="form-signin-heading">Input login Instagram</h4>
        <input type="text" class="form-control" name="login" value="there8back">
        <button type="submit" class="btn btn-md btn-block btn-primary" name="submit">Send</button>
    </form>
    <div class="jumbotron">
        <p>С 01.06.2016 Instagram ограничил доступ к своему API, с связи этим это веб-приложение не прошло модерацию и работает в т.н. "песочнице".
            Это означает, что приложение "видит" только аккаунт привязанный к выданному токену, либо аккаунты добавленные как разрешенные (не более 5).
            Поэтому протестировать приложение можно только на моем аккаунте "there8back", либо напишите мне на почту valeruko@gmail.com, я добавлю ваш аккаунт в разрешенные.</p>
    </div>
   <?php
    foreach ($Engine->data['images'] as $key=>$item){
        $thumbnail = $item['fullsize'];

        echo '<div class="jumbotron">';
        echo '<img src="'.$thumbnail.'" alt="" />';
        echo '<p><a class="btn btn-lg btn-success" href="'.$item['link'].'" role="button">View on instagram</a></p>';
        echo '</div>';
    }
    ?>
</div>
</body>
</html>






