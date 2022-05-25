<?php
//phpinfo();
/* DISPLAYS THE SUBMITTED INFO (TESTING)
	echo $_POST['first'];
	echo " ";
echo $_POST['last'];
	echo '<br />';
	echo $_POST['email'];
*/

$username = 'root';
$password = 'rootpass';
$dsnA = 'mysql:host=192.168.3.6;dbname=formresponses';
$dsnB = 'mysql:host=192.168.3.7;dbname=formresponses';

# 데이터베이스 서버1과 데이터베이스 서버2 동시에 데이터를 
try{
	$db = new PDO($dsnA, $username, $password);
	$result=FALSE;

	if($_POST['first']!=null && $_POST['last']!=null && $_POST['email']!=null)
	{
		$first=filter_var(trim($_POST['first']),FILTER_SANITIZE_SPECIAL_CHARS);
		$last=filter_var(trim($_POST['last']),FILTER_SANITIZE_SPECIAL_CHARS);
		$email=filter_var(trim($_POST['email']),FILTER_SANITIZE_EMAIL);
		if(validSubmission($first,$last,$email))
			$result=insertInfo($db,$first,$last,$email);
	}

} catch(PDOException $ex) {
	echo $ex->getMessage();
}

try{
	$db2 = new PDO($dsnB, $username, $password);
	$result2=FALSE;

	if($_POST['first']!=null && $_POST['last']!=null && $_POST['email']!=null)
	{
		$first=filter_var(trim($_POST['first']),FILTER_SANITIZE_SPECIAL_CHARS);
		$last=filter_var(trim($_POST['last']),FILTER_SANITIZE_SPECIAL_CHARS);
		$email=filter_var(trim($_POST['email']),FILTER_SANITIZE_EMAIL);
		if(validSubmission($first,$last,$email))
			$result2=insertInfo($db2,$first,$last,$email);
	}
}catch(PDOException $ex) {
	echo $ex->getMessage();
}

header('Location: index.php?success='.$result);



//Return true if user info is valid (not empty, email syntax okay)
function validSubmission($first,$last,$email)
{
	$result=FALSE;
	if(nonempty($first) && nonempty($last) && nonempty($email) && validEmail($email))
		$result=TRUE;
	return $result;
}

//Return true if email contains '@' and at least one '.' after '@'
function validEmail($email)
{
	$valid=FALSE;
	$position=strpos($email,'@');
	if($position!=FALSE && strpos(substr($email,$position),'.')!=FALSE) //false if @ is first char too
		$valid=TRUE;
	return $valid;
}

//Return true if input is not null and not an empty string
function nonempty($input)
{
	$nonempty=FALSE;
	if($input!=null && $input!='')
		$nonempty=TRUE;
	return $nonempty;
}

//Insert entered form info into the database
function insertInfo($db,$first,$last,$email)
{
	$stmt = $db->prepare("INSERT INTO response(firstname, lastname, email, submitdate) VALUES (:first, :last, :email, :date)");
	$stmt->bindParam(':first', $first);
	$stmt->bindParam(':last', $last);
	$stmt->bindParam(':email', $email);
	$stmt->bindParam(':date', date_format(date_create("now",timezone_open("America/New_York")), "Y-m-d H:i:s"));
	
	return $stmt->execute();
}

?>
