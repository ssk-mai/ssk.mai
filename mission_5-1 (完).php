<?php
 
// DB接続設定
    
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql='CREATE TABLE IF NOT EXISTS abctable'
            	." ("
            	. "id INT AUTO_INCREMENT PRIMARY KEY,"
            	. "name char(32),"
            	. "comment TEXT,"
            	. "date DATETIME,"
            	. "pass char(32)"
            	.");";
        $stmt = $pdo->query($sql);
	
	if(isset($_POST["submit"])){
	    if(!empty($_POST["name"])&&!empty($_POST["comment"])&&!empty($_POST["s_password"])){
	        if(!empty($_POST["editnum_show"])){
            
            //編集
            $editnum_show=$_POST["editnum_show"];
            $id=$editnum_show;
            $name=$_POST["name"];
            $comment=$_POST["comment"];
            $s_password=$_POST["s_password"];
            
            $sql='UPDATE abctable SET name=:name,comment=:comment, date=NOW(), pass=:pass WHERE id=:id';
            $stmt=$pdo->prepare($sql);
            
            
	        $stmt-> bindParam(':name', $name, PDO::PARAM_STR);
	        $stmt-> bindParam(':comment', $comment, PDO::PARAM_STR);
	        $stmt-> bindParam(':pass', $s_password, PDO::PARAM_STR);
	        $stmt-> bindParam(':id', $id, PDO::PARAM_INT);
	        date("Y/m/d H:i:s");
	        $stmt -> execute();
	        }
            else{
            //新規投稿
            $sql = $pdo -> prepare("INSERT INTO abctable (name, comment, date, pass) VALUES (:name, :comment, NOW(), :pass)");
	        $name = $_POST['name'];
	        $comment = $_POST['comment']; 
	        $s_password=$_POST['s_password'];
	        $sql-> bindParam(':name', $name, PDO::PARAM_STR);
	        $sql-> bindParam(':comment', $comment, PDO::PARAM_STR);
	        $sql-> bindParam(':pass', $s_password, PDO::PARAM_STR);
	        date("Y/m/d H:i:s");
	        $sql -> execute();	            
	        }
	    }
	    else{
        echo "名前またはコメントまたはパスワードが入力されていません";
	    }
	}
	
//削除機能
    if(isset($_POST["reset"])){
        if(!empty($_POST['resetnum'])&&!empty($_POST['r_password'])){
        
        $resetnum = $_POST["resetnum"];
        $r_password = $_POST["r_password"];
        $id=$resetnum;
        
        
        /*$sql = 'SELECT * FROM abctable WHERE id=id';
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_STR);
        $stmt->execute();
        $result=$stmt->fetch();
        $r_pass=$result['pass'];
            if($r_password==$r_pass){*/
        $sql = 'SELECT * FROM abctable where id='.$id;
	    $stmt = $pdo->query($sql);
	    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
	    $stmt->execute();
        $result=$stmt->fetch();
	    $r_pass=$result['pass'];
	        if($r_password==$r_pass){
            $id=$resetnum;
            $sql = 'delete from abctable  where id='.$id;
            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            }
            else{
            echo "パスワードが正しくありません";
            }
        }
        else{
        echo "削除番号またはパスワードが入力されていません";
        }
    }
    
 //編集機能
    if(isset($_POST['edit'])){
        if(!empty($_POST['editnum'])&&!empty($_POST['e_password'])){
        $id=$_POST['editnum'];
        $e_password=$_POST['e_password'];
        $editnum_show = $_POST['editnum_show'];
        
        $sql = 'SELECT * FROM abctable where id='.$id;
	    $stmt = $pdo->query($sql);
	    $stmt->bindParam(':id', $id, PDO::PARAM_STR);
	    $stmt->execute();
        $result=$stmt->fetch();
	    $e_pass=$result['pass'];
	        if($e_password==$e_pass){
            $editname=$result['name'];
            $edittext=$result['comment'];
            }
            else{
            echo "パスワードが正しく入力されていません";
            }
        }
        else{
        echo "編集番号またはパスワードが正しく入力されていません";
        }
    }
?>

<h1>好きな季節は？</h1>
<form action=""method="post">
    <label>名前（ニックネーム）＋好きな季節＋パスワードの入力お願いします！</br>（※名前はニックネームで)</label></br></br>
    <input type="name" name="name" placeholder="名前"  value="<?php if(!empty($editname)){echo $editname;} ?>"></br>
    <input type="text" name="comment" placeholder="コメント" value="<?php if(!empty($edittext)){echo $edittext;} ?>"></br>
    <input type="password" name="s_password"placeholder="パスワード" value="<?php if(!empty($e_pass)){echo $e_pass;} ?>">
    <input type="submit" name="submit"></br></br>
    <input type="hidden" name="editnum_show"placeholder="編集番号" value="<?php if(!empty($id)){echo $id;} ?>"><!--</br><br>-->
    <input type="text" name="resetnum"placeholder="削除対象番号"></br>
    <input type="password" name="r_password"placeholder="パスワード">
    <input type="submit" name="reset" value="削除"></br></br>
    <input type="text" name="editnum"placeholder="編集対象番号"></br>
    <input type="password" name="e_password"placeholder="パスワード">
    <input type="submit"name="edit" value="編集">
</form>

</body>
</html>

<?php

// DB接続設定
    
	$dsn = 'データベース名';
	$user = 'ユーザー名';
	$password = 'パスワード';
	$pdo = new PDO($dsn, $user, $password, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING));
	
	$sql='CREATE TABLE IF NOT EXISTS abctable'
            	." ("
            	. "id INT AUTO_INCREMENT PRIMARY KEY,"
            	. "name char(32),"
            	. "comment TEXT,"
            	. "date DATETIME,"
            	. "pass char(32)"
            	.");";
        $stmt = $pdo->query($sql); 

$sql = 'SELECT * FROM abctable';
	$stmt = $pdo->query($sql);
	$results = $stmt->fetchAll();
	        foreach ($results as $row){
		    //$rowの中にはテーブルのカラム名が入る
		    echo $row['id'].',';
		    echo $row['name'].',';
		    echo $row['comment'].',';
		    echo $row['date'].'<br>';
		    //echo $row['pass'].'<br>';
	        }
?>