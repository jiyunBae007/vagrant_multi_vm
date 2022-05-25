<?php
error_reporting(E_ALL);
ini_set("display_errors",1);

$username = 'root';
$password = 'rootpass';
$dsnA = 'mysql:host=192.168.3.6;dbname=formresponses';
$dsnB = 'mysql:host=192.168.3.7;dbname=formresponses';

try{
	$db = new PDO($dsnA, $username, $password);
	$result=FALSE;

    $query = "SELECT * FROM response";

    $stmt = $db->query($query);
    
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    echo "<table border='1'>
    <tr>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>email</th>
    </tr>";

    foreach($rows as $row) {
        echo "<tr>";
        echo "<td>".$row['firstname']."</td>";
        echo "<td>".$row['lastname']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "</tr>";

        //printf("{$row['firstname']} {$row['secondname']} {$row['email']}\n");
    }
} catch(PDOException $ex) { 
	echo $ex->getMessage();
	#데이터베이스 서버1이 고장나더라도 데이터베이스 서버2를 기반으로 서비스 운영을 가능하게 함
	try{	
	$db2 = new PDO($dsnB, $username, $password);
	$result2 =FALSE;

    $query = "SELECT * FROM response";

    $stmt = $db2->query($query);
    
    $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

    
    echo "<table border='1'>
    <tr>
    <th>Firstname</th>
    <th>Lastname</th>
    <th>email</th>
    </tr>";

    foreach($rows as $row) {
        echo "<tr>";
        echo "<td>".$row['firstname']."</td>";
        echo "<td>".$row['lastname']."</td>";
        echo "<td>".$row['email']."</td>";
        echo "</tr>";}
	} catch(PDOException $ex){
		echo $ex->getMessage();
	}
}

echo "</table>";
?>
