<?php
$data = json_decode(file_get_contents("php://input"));
if(!empty($data->char1)) {
	$char1 = $data->char1;
	if($char1 == 'any') {
	$char1 = '%';
	}
}
else {
	$char1 = '%';
}
if(!empty($data->char2)) {
	$char2 = $data->char2;
	if($char2 == 'any') {
	$char2 = '%';
	}
}
else {
	$char2 = '%';
}
//-------------------
if(!empty($data->assist1)) {
	$assist1= $data->assist1;
	if($assist1 == 'any') {
	$assist1 = '%';
	}
}
else {
	$assist1 = '%';
}
if(!empty($data->assist2)) {
	$assist2= $data->assist2;
	if($assist2 == 'any') {
	$assist2 = '%';
	}
}
else {
	$assist2 = '%';
}
//-------------------
if(!empty($data->grade1)) {
	$grade1= $data->grade1;
	if(!is_numeric($grade1)) {
	$grade1 = '0';
	}
}
else {
	$grade1 = '0';
}
if(!empty($data->grade2)) {
	$grade2= $data->grade2;
	if(!is_numeric($grade2)) {
	$grade2 = '0';
	}
}
else {
	$grade2 = '0';
}
//-------------------
if(!empty($data->player1)) {
	$player1 = $data->player1;
	if($player1 == '') {
		$player1 = '%';
	}
}
else {
	$player1 = '%';
}
if(!empty($data->player2)) {
	$player2 = $data->player2;
	if($player2 == '') {
		$player2 = '%';
	}
}
else {
	$player2 = '%';
}
//-------------------
if(!empty($data->winner)) {
	$winner = $data->winner;
	if($winner != 1 and $winner != 2) {
		$winner = '%';
	}
	if($winner == 1) {
	$nwinner = 2;
	}
	if($winner == 2) {
		$nwinner = 1;
	}
}
else {
	$winner = '%';
	$nwinner = '%';
}
//-------------------
if(!empty($data->locale)) {
	$locale = $data->locale;
	if($locale = 'any') {
		$locale = '%';
	}
}
else {
	$locale = '%';
}
include("common.php");
function checkUsr ($db, $char1, $char2, $page, $assist1, $assist2, $grade1, $grade2, $player1, $player2, $winner, $nwinner, $locale, $end) {
	$exe = "SELECT COUNT(*) as matchcount FROM matches WHERE (
			(character1 LIKE :char1 AND character2 LIKE :char2)
			AND (assist1 LIKE :a1 AND assist2 LIKE :a2)
			AND (grade1 >= :g1 AND grade2 >= :g2)
			AND (player1 LIKE :p1 AND player2 LIKE :p2)
			AND winner LIKE :w1)
		 OR (
		 	(character1 LIKE :char2 AND character2 LIKE :char1)
			AND (assist1 LIKE :a2 AND assist2 LIKE :a1)
			AND (grade1 >= :g2 AND grade2 >= :g1)
			AND (player1 LIKE :p2 AND player2 LIKE :p1)
			AND winner LIKE :w2)
		AND locale LIKE :loc";
	$sth = $db->prepare($exe);
	$sth->bindParam(':char1', $char1);
	$sth->bindParam(':char2', $char2);
	$sth->bindParam(':a1', $assist1);
	$sth->bindParam(':a2', $assist2);
	$sth->bindParam(':g1', $grade1);
	$sth->bindParam(':g2', $grade2);
	$sth->bindParam(':p1', $player1);
	$sth->bindParam(':p2', $player2);
	$sth->bindParam(':w1', $winner);
	$sth->bindParam(':w2', $nwinner);
	$sth->bindParam(':loc', $locale);

	$sth->execute();
	//echo($exe);
	$res = $sth->fetchAll();
	return $res;
}

$res = checkUsr($db, $char1, $char2, 0, $assist1, $assist2, $grade1, $grade2, $player1, $player2, $winner, $nwinner, $locale, 0);
//echo($char1.','.$char2.','.$page.','.$assist1.','.$assist2.','.$grade1.','.$grade2.','.$player1.','.$player2.','.$winner.','.$nwinner.','.$locale.',');
echo json_encode($res);
?>