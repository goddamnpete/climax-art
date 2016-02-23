<html ng-app='app'>
<head>
<title>CLIMAX-ART - Statistics</title>
<style type="text/css">
		body {
			font-family:'Arial';
			background-color: #0d0d0d;
			margin:0;
			padding:0;
		}
 table {
            width:50%;
            font-size:15px;
            font-weight: bold;
       		margin:auto;
            color:white;
            text-align: center;

        }
        h1 {
        	color:white;
        	text-align: center;
        }
        h2 {
        	color:white;
        	text-align: center;
        }
        th {
        	font-size:20pt;
        }
        a {
            color:white;
        }
        a:visited {
            color:lightgreen;
        }
        a:hover {
            color:lightblue;
        }
        tr:nth-child(odd) {
            background-color:#006699;
            margin-bottom:4px;
            border-bottom: 1px soad #0d0d0d;
        }
        tr:nth-child(even) {
            background-color:#003366;
            margin-bottom:4px;
            border-bottom: 1px soad #0d0d0d;
        }
        .close {
            float:right;
        }
        table tr:hover {
            background-color:#2E9E96;
        }
        table img {
            margin-bottom: 2px;
        }
        form a {
            float:right;
            color:white;
            margin:5px;
        }
        form a:visited{
            color:white;
        }
        @keyframes repot {
            0% {background-color:inherit;}
            50% {background-color:red;}
            100% {background-color:inherit;}
        }
        .reported {
            animation-name: repot;
            animation-duration: 4s;
            animation-iteration-count: infinite;
            animation-direction: reverse;
        }
        @keyframes lastseen {
            0% {opacity: 1;}
            50% {opacity: 0.5;}
            100% {opacity: 1;}
        }
        .watching {
            animation-name: lastseen;
            animation-duration: 4s;
            animation-iteration-count: infinite;
            animation-direction: reverse;
        }
        .header {
	        position:fixed;
        	top:0;
        	z-index: 200;
        	background: #353535;
        	height:55px;
        	width:100%;
        	text-align: center;
        	color:white;
        	font-size:18px;

        }
        .header a {
        	color:white;
        }
        a:visited {
        	color:white;
        }
        .topspacing {
        	margin-top:50px;
        }
        select {
            text-align: center;
        }
        p {
            text-align: center;
            color:white;
        }
        .b {
            font-weight: bold;
        }
</style>
<?php
include("common.php");
function getWinRates ($db) {
	$exe = "SELECT cname, wins, total-wins as loss, wins/total as wr FROM winrate ORDER BY wins/total DESC";
	$sth = $db->prepare($exe);
	$sth->execute();
	$res = $sth->fetchAll();
	return $res;
}
function getPlayerWinRates ($db) {
	$exe = "SELECT playername, wins, total-wins as loss, wins/total as pwr FROM playerwinrate WHERE playername <> '-' ORDER BY total DESC";
	$sth = $db->prepare($exe);
	$sth->execute();
	$res = $sth->fetchAll();
	return $res;
}
function getCharUsage ($db) {
		$exe = "SELECT character1, COUNT(*) as charactercount FROM (
	SELECT character1 FROM matches
	UNION ALL
	SELECT character2 FROM matches ) c2
	GROUP BY character1 ORDER BY charactercount DESC";
	$sth = $db->prepare($exe);
	$sth->execute();
	$res = $sth->fetchAll();
	return $res;
}
function getAssistUsage ($db) {
		$exe = "SELECT assist1, COUNT(*) as assistcount FROM (
SELECT assist1 FROM matches
UNION ALL
SELECT assist2 FROM matches ) c2
GROUP BY assist1 ORDER BY assistcount DESC";
	$sth = $db->prepare($exe);
	$sth->execute();
	$res = $sth->fetchAll();
	return $res;
}
function getCharAssistUsage ($db) {
		$exe = "SELECT character1, assist1, COUNT(*) as assistcount FROM (
SELECT character1, assist1 FROM matches
UNION ALL
SELECT character2, assist2 FROM matches ) c2
GROUP BY character1, assist1 ORDER BY assistcount DESC";
	$sth = $db->prepare($exe);
	$sth->execute();
	$res = $sth->fetchAll();
	return $res;
}
$wr = getWinRates($db);
$pwr = getPlayerWinRates($db);
$chars = getCharUsage($db);
$assists = getAssistUsage($db);
$ca = getCharAssistUsage($db);
?>
</head>
<body ng-controller='statsController'>
<div class='header'>
<a href='#charwin'>Character Win Rates</a> | 
<a href='#charuse'>Character Usage</a> | 
<a href='#assuse'>Assist Usage</a> | 
<a href='#charass'>Character-Assist Usage</a> | 
<a href='#playwin'>Player Win Rates</a> |
<a href='#rec'>Recommended Players per Character</a> | 
<a class='b' href='index.html'>Back To Datbase</a>
</div>

<h1 class='topspacing'> Database Statistics </h1>
<?php
echo('<h1 id="charwin">Character Win Percentages</h1>');
echo('<table ><thead><th>Character</th><th>Wins</th><th>Losses</th><th>Win %</th> <tbody>');
for($i=0; $i<count($wr); $i++) {
	echo('<tr>');
	echo('<td>'.$wr[$i]['cname'].'</td>');
	echo('<td>'.$wr[$i]['wins'].'</td>');
	echo('<td>'.$wr[$i]['loss'].'</td>');
	echo('<td>'.number_format($wr[$i]['wr']*100, 2).'%</td>');
	echo('</tr>');
};
echo('</tbody></table>');

echo('<h1 id="charuse">Character Usage Totals</h1>');
echo('<table><thead><th>Character</th><th>Match Count</th><tbody>');
for($i=0; $i<count($chars); $i++) {
	echo('<tr>');
	echo('<td>'.$chars[$i]['character1'].'</td>');
	echo('<td>'.$chars[$i]['charactercount'].'</td>');
	echo('</tr>');
};
echo('</tbody></table>');

echo('<h1 id="assuse">Assist Usage Totals</h1>');
echo('<table><thead><th>Assist</th><th>Match Count</th><tbody>');
for($i=0; $i<count($assists); $i++) {
	echo('<tr>');
	echo('<td>'.$assists[$i]['assist1'].'</td>');
	echo('<td>'.$assists[$i]['assistcount'].'</td>');
	echo('</tr>');
};
echo('</tbody></table>');

echo('<h1 id="charass">Character-Assist Distribution Totals</h1>');
echo('<table><thead><th>Character</th><th>Assist</th><th>Match Count</th><tbody>');
for($i=0; $i<count($ca); $i++) {
	echo('<tr>');
	echo('<td>'.$ca[$i]['character1'].'</td>');
	echo('<td>'.$ca[$i]['assist1'].'</td>');
	echo('<td>'.$ca[$i]['assistcount'].'</td>');
	echo('</tr>');
};
echo('</tbody></table>');

echo('<h1 id="playwin">Player Win Percentages</h1>');
echo('<table><thead><th>Player</th><th>Wins</th><th>Losses</th><th>Win %</th> <tbody>');
for($i=0; $i<count($pwr); $i++) {
	echo('<tr>');
	echo('<td>'.$pwr[$i]['playername'].'</td>');
	echo('<td>'.$pwr[$i]['wins'].'</td>');
	echo('<td>'.$pwr[$i]['loss'].'</td>');	
	echo('<td>'.number_format($pwr[$i]['pwr']*100, 2).'%</td>');
	echo('</tr>');
};
echo('</tbody></table>');

//$res = checkUsr($db, $char1, $char2, $page, $assist1, $assist2, $grade1, $grade2, $player1, $player2, $winner, $nwinner, $locale, $end);
//echo($char1.','.$char2.','.$page.','.$assist1.','.$assist2.','.$grade1.','.$grade2.','.$player1.','.$player2.','.$winner.','.$nwinner.','.$locale.',');
//echo json_encode($res);
?>
<h1 id='rec'> Recommended Players Per Character </h1>
<p> Select a character: 
<select name='char1' id='c1' ng-model='c1' placeholder='Character' width='80'>  
                    <option selected value='Asuna'>Asuna</option>
                    <option value='Akira'>Akira Yuki</option>
                        <option value='Emi'>Emi</option>
                        <option value='Kirino'>Kirino Kosaka</option>
                        <option value='Misaka'>Mikoto Misaka</option>
                        <option value='Kirito'>Kirito</option>
                        <option value='Kuroko'>Kuroko Shirai</option>                    
                        <option value='Kuroyukihime'>Kuroyukihime</option>
                        <option value='Miyuki'>Miyuki Shiba</option>
                        <option value='Quenser'>Quenser</option>
                        <option value='Rentaro'>Rentaro Satomi</option>
                        <option value='Selvaria'>Selvaria Bles</option>
                        <option value='Shana'>Shana</option>
                        <option value='Shizuo'>Shizuo Heiwajima</option>
                        <option value='Taiga'>Taiga Aisaka</option>
                        <option value='Tatsuya'>Tatsuya Shiba</option>
                        <option value='Tomoka'>Tomoka Minato</option>
                        <option value='Yukina'>Yukina Himeragi</option>
            </select>
            </select> </p>
<table>
    <thead>
        <th ng-click="predicate = 'player1'; reverse=!reverse"><a href=''>Player</a></th>
        <th ng-click="predicate = 'character1'; reverse=!reverse"><a href=''>Character</a></th>
        <th ng-click="predicate = 'wr'; reverse=!reverse"><a href=''>Win %</a></th>
        <th ng-click="predicate = 'matchcount'; reverse=!reverse"><a href=''>Match Count</a></th>
    </thead>
    <tbody>
    <tr ng-repeat='dbresult in dbresults | filter:c1 | orderBy:predicate:reverse'>
        <td><a href='http://www.climax-art.com/#/any/any/0/{{dbresult.player1}}/any/any/0/NONE/0/any' target='_blank'>{{dbresult.player1}}</a></td>
        <td>{{dbresult.character1}}</td>
        <td>{{dbresult.wr | number:2}}%</td>
        <td>{{dbresult.matchcount | number}}</td>
    </tr>
    </tbody>
</table>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.2.10/angular.js"></script>
<script src="statsController.js"></script>
</body>
</html>