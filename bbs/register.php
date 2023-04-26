<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>登録</title>
    <style>
        body {
            background-color: #FFFFCC;
        }
        h1 {
            text-align: center;
            color: #0000FF;
            
        }
        .register_group{
            text-align: center;
            font-size: 20px;          
        }
        p{
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>新規登録画面</h1>
    <div class="register_group">
        <form action="register.php" method="post">
        <label>ユーザー名</label>
        <input type="text" name="name" required> 
        <br>
        <label>パスワード</label>
        <input type="password" name="pass" required>
        <br>
        <input type="submit" value="登録">
        <br>
        </form>           
        <a href="login.php" id="transition">登録済の方はこちら</a>
    </div>

    <?php
    $dsn="mysql:dbname=login_db;host=127.0.0.1;charset=utf8";
    $user="aaaaa";
    $password="???";
    try{
        $pdo=new PDO($dsn,$user,$password);
    }
    catch(PDOException $e){
        echo "データベースへの接続失敗".$e->getMessage();
        exit();
    }

    #データベースへの書き込み
    if(isset($_POST["name"]) && isset($_POST["pass"])){
        $name=$_POST["name"];
        $pass=$_POST["pass"]; 
        $sql="SELECT * FROM login_tbl WHERE user_name=:user_name";
        $stmt = $pdo->prepare($sql);
        $stmt -> bindValue(":user_name", $name);
        $stmt->execute();
        $info=$stmt->fetch();
        if($info&&$info["user_name"]===$name){
            echo "<p>そのユーザー名はすでに他のユーザーに使用されているため、使用できません。</p>";
            echo "<p><a href=","register.php",">戻る</a></p>";
        }
        else{
            $sql="INSERT INTO login_tbl (user_name,password) VALUES(:user_name,:password)";
            $stmt = $pdo->prepare($sql);
            $stmt -> bindValue(":user_name", $name);
            $stmt -> bindValue(":password", $pass);
            $stmt->execute();
            echo "<p>登録完了：<a href=","login.php",">ログイン画面へ</a></p>";
            
        }   
    }
    ?>
</body>

</html>