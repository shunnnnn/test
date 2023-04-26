<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン機能</title>
    <style>
        body {
            background-color: #FFFFCC;
        }
        h1 {
            text-align: center;
            color: #0000FF;            
        }
        .login_group{
            text-align: center;
            font-size: 20px;            
        }        
        p{
            text-align: center;
        }
    </style>
</head>
<body>
    <h1>ログイン画面</h1>
    <div class="login_group">
    <form action="login.php" method="post">
        <label>ユーザー名</label>
        <input type="text" name="name" required> 
        <br>
        <label>パスワード</label>
        <input type="password" name="pass" required>
        <br>
        <input type="submit" value="ログイン">
        <br>
    </form>
        <a href="register.php">新規登録画面へ</a>
    </div>
    <?php    
    $dsn="mysql:dbname=login_db;host=127.0.0.1;charset=utf8";
    $user="aaaaa";
    $password="???";
    try{
        #データベースへの接続
        $pdo=new PDO($dsn,$user,$password);
    }       
    catch(PDOException $e){
        echo "データベースへの接続失敗。".$e->getMessage();
        exit();
    }
    if(isset($_POST["name"])&&isset($_POST["pass"])){
        $name=$_POST["name"];
        $pass=$_POST["pass"];  
        $sql="SELECT * FROM login_tbl WHERE user_name=:user_name AND password=:password";
        $stmt = $pdo->prepare($sql);
        $stmt->bindvalue(":user_name",$name);
        $stmt->bindvalue(":password",$pass);
        $stmt->execute();
        $info=$stmt->fetch();
        if($info&&$info["user_name"]===$name&&$info["password"]===$pass){
            echo "<p>ログイン成功：<a href=","bbs.php",">電子掲示板へ</a></p>";
            session_start();
            $_SESSION['user_name'] = $name;
        }
        else{
            echo "ユーザー名またはパスワードが違います。";
            echo "<p><a href=","login.php",">戻る</a></p>";
        }
    }
    ?>

</body>
</html>