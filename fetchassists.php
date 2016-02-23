<?php
$data = json_decode(file_get_contents("php://input"));
$char = $data->char;
if($char == 'any') {
    $char = '%';
}

include("common.php");
function checkUsr ($db, $char) {
    $exe = "SELECT DISTINCT assist1 FROM (
    		SELECT assist1 FROM matches WHERE character1 LIKE :char1
    		UNION
    		SELECT assist2 FROM matches WHERE character2 LIKE :char1) c2";
	$sth = $db->prepare($exe);
    $sth->bindParam(':char1', $char);
    $sth->execute();
    $res = $sth->fetchAll();
    return $res;
}
$res = checkUsr($db, $char);
echo json_encode($res);
?>