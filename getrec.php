<?php 
include('common.php');
function getCharAssistUsage ($db) {
		$exe = "SELECT player1, character1, COUNT(*) as matchcount, (wins/total*100) as wr FROM(
SELECT player1, character1 FROM matches
UNION ALL
SELECT player2, character2 FROM matches)c2 JOIN playerwinrate ON player1 = playername WHERE player1<>'-' GROUP BY player1, character1 HAVING matchcount > 10 AND wr > 45
ORDER BY character1 ASC, matchcount DESC, wr DESC";
	$sth = $db->prepare($exe);
	$sth->execute();
	$res = $sth->fetchAll();
	return $res;
}
$res = getCharAssistUsage($db);
echo json_encode($res);
