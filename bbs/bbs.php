<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>掲示板</title>
    <style>
        body {
            background-color: #FFFFCC;
        }
        h1 {
            color: #0000FF;            
        }
        .bbs_group{
            text-align: center;
        }
        table{
            margin: 0 auto;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="bbs_group">
        <h1>電子掲示板</h1>
        <?php
    
        session_start();
        $user_name = $_SESSION['user_name'];
        echo "<p>名前：".$user_name."</p>";    
        ?>
        <form action="bbs.php" method="post">
            <label>投稿内容</label>
            <input type="text" name="content">
            <button type="submit">送信</button>
            <br>
            <a href="login.php">ログアウト</a>
        </form>
    </div>
    <?php
        $dsn="mysql:dbname=bbs_db;host=127.0.0.1;charset=utf8";
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
        if(isset($_POST["delete_id"])){
            $delete_id = $_POST["delete_id"];
		    $sql  = "DELETE FROM bbs_tbl WHERE id = :delete_id";
		    $stmt = $pdo->prepare($sql);
		    $stmt -> bindValue(":delete_id", $delete_id);
		    $stmt -> execute();
        }

        if(isset($_POST["content"])){
            $content=$_POST["content"];
            $sql="INSERT INTO bbs_tbl (user_name,content,post_time) VALUES (:user_name,:content,NOW())";
            $stmt=$pdo->prepare($sql);
            $stmt->bindValue(":user_name",$user_name);
            $stmt->bindValue(":content",$content);
            $stmt->execute();
        }
        $sql = "SELECT * FROM bbs_tbl ORDER BY post_time";
        $stmt = $pdo->prepare($sql);
	    $stmt -> execute();  
        $row = $stmt->fetchAll(); 
    ?>
    <br>
    <table>
        <tr>
            <th>名前</th>
            <th>投稿内容</th>
            <th>投稿日</th>
        </tr>
        <?php
        foreach($row as $column){
        ?>
        <tr>
            <td><?php echo $column["user_name"];?></td>
            <td><?php echo $column["content"];?></td>
            <td><?php echo $column["post_time"];?></td>
            <td>
                <form action="bbs.php" method="post">
			        <input type="hidden" name="delete_id" value="<?php echo $column["id"];?>" >
			        <button type="submit">削除</button>
                </form>
            </td>
        </tr>
        <?php } ?>
    </table>
</body>
</html>