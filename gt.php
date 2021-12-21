<?php
$ask = $_GET['ask'];
$link = @mysqli_connect('localhost', 'root', 'root', 'avds', '3306'); // @ per
if ( !$link ){
	$ans = [ 'error' => 'нет доступа к БД' ] ;
	$jsonans = json_encode($ans);
	header ('Content-Type: application/json; charset=UTF-8');
	echo $jsonans;
    exit;
}
$ans = [];
if ( $_GET['ask'] === 'all' ) {
    $query = "select * FROM avds.person";
    $result = mysqli_query($link, $query);
    if ( $result === FALSE ) {
        $ans = [ 'error' => 'нет такой таблицы' ] ;
    } elseif ( $result->num_rows == 0 ) {
        $ans = [ 'error' => 'пустая таблица' ] ;
    } else {
        while ( $row = mysqli_fetch_array ( $result, MYSQLI_ASSOC ) ) {
            $ans[] = $row;
        }
    }
}
elseif ( $_GET['ask'] === 'id' ) {
    $id = $_GET['id'];
    $query = "select * FROM avds.person where id=$id";  // avds.user
    $result = mysqli_query($link, $query);
    if ( $result === FALSE ) {
        $ans = [ 'error' => 'нет такой таблицы' ] ;
    } elseif ( $result->num_rows == 0 ) {
        $ans = [ 'error' => 'нет такой персоны' ] ;
    } else {
        $ans[] = mysqli_fetch_array ( $result, MYSQLI_ASSOC );
    }

} else {
    $ans = [ 'error' => 'запрос API не опознан' ] ;
}
$jsonans = json_encode($ans);
header ('Content-Type: application/json; charset=UTF-8');
echo $jsonans;
exit();
