<!DOCTYPE html>
<html lang="ja">
    <head>
    <meta charset="UTF-8">
    </head>
    
    <body style="background-color:#ffbf7f">
        <?php
        //DB接続設定
        $dsn = 'データベース名';
	    $user = 'ユーザー名';
	    $password = 'パスワード';
	    $pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
        
        //編集フォーム
        if(!empty($_POST["update"])){
            $sql ='SELECT * FROM tbtest WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $_POST["update"], PDO::PARAM_INT);
            $stmt->execute();
            $results = $stmt->fetchALL();
            foreach($results as $row);
        }
        ?>
    <h1 class style="gray #808080">掲示板</h1>
        <br>
    <h2 class style="slategray #708090">～皆様の座右の銘教えてください～</h2>
        <br>
    <h3>ちなみにわたくしの座右の銘は四字熟語は天真爛漫</h3>
    <h3>言葉では俺の敵はだいたい俺です</h3>
        <br>
        <br>
    
        〇投稿フォーム
        <br>
        <form action="" method="post">
        <input type="text" name="name" placeholder="名前"
        value="<?php if(empty($_POST["update"])){echo"";}else{echo $row['name'];}?>">
        <br>
        <input type="text" name="comment" placeholder="コメント"
        value="<?php if(empty($_POST["update"])){echo"";}else{echo $row['comment'];} ?>">
        <br>
        <input type="text" name="password" placeholder="パスワード">
        <input type="submit" name="submit">
        <input type="hidden" name="updatenum"
        value="<?php if($_POST["password"]==$pass){echo $_POST["update"];}?>">
        <br>
        〇削除フォーム
        <br>
        <input type="number" name="delete" placeholder="削除フォーム">
        <br>
        <input type="text" name="password" placeholder="パスワード">
        <input type="submit" name="submit" value="削除">
        <br>
        〇編集フォーム
        <br>
        <input type="number" name="update" placeholder="編集フォーム">
        <br>
        <input type="text" name="password" placeholder="パスワード">
        <input type="submit" name="submit" value="編集">
        <br>
        </form>
    
    <?php
    
        //編集モード
        if((!empty($_POST["name"]))&&(!empty($_POST["comment"]))&&(!empty($_POST["updatenum"]))){
            $sql = 'UPDATE tbtest SET name=:name,comment=:comment WHERE id=:id';
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':name', $_POST["name"], PDO::PARAM_STR);
            $stmt->bindParam(':comment', $_POST["comment"], PDO::PARAM_STR);
            $stmt->bindParam(':id', $_POST["updatenum"], PDO::PARAM_INT);
            $stmt->execute();
        }
    
        //新規投稿モード
        if((!empty($_POST["name"]))&&(!empty($_POST["comment"]))&&(!empty($_POST["updatenum"]))
            &&($_POST["password"])==$pass){
            //名前とコメントが送信されたときのファイル操作
            $sql = $pdo ->prepare("INSERT INTO tbtest (name, comment) VALUES(:name, :comment)");
            $sql -> bindParam(':name', $_POST["name"], PDO::PARAM_STR);
            $sql -> bindParam(':comment', $_POST["comment"], PDO::PARAM_STR);
            $sql -> execute();
        }
    
    //削除フォーム
        if(!empty($_POST["delete"]) && $_POST["password"]==$pass){
            //書き込み
            $id=$_POST["delete"];
            $sql = 'delete from tbtest where id=:id';
            $stmt = $pdo->prepare($sql);
	        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
	        $stmt->execute();
        }
	    
	        //データの取得・表示
	        $sql = 'SELECT * FROM tbtest';
	        $stmt= $pdo->query($sql);
	        $results = $stmt->fetchAll();
	        foreach ($results as $row){
            //$rowの中にはテーブルのカラム名が入る
                echo $row['id'].',';
		        echo $row['name'].',';
		        echo $row['comment'].'<br>';
		        echo "<hr>";
        }
    ?>
    </body>
</html>