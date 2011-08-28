<?
    require_once('definitions.php');
    
    header('Content-Type: text/html; charset=utf-8');
    
    $reg_id = g('reg_id', 1);
    $lang = g('lang');
    mysql_query("SET NAMES 'utf8'");
    $res = sql_do("SELECT name_{$lang} AS city_name, id FROM cities WHERE reg_id='$reg_id' ORDER BY id");
    while($arr = mysql_fetch_array($res)){
        $result[$arr['id']] = $arr['city_name'];
    }
    echo select_tag('city_id', $result);
?>