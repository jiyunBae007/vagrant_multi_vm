<?php


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

#database1이 고장나더라도 database2 server를 기반으로 서비스 운영을 가능하게 함
} catch(PDOException $ex) {  
	$db = new PDO($dsnB, $username, $password);
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

echo "</table>";
?>
