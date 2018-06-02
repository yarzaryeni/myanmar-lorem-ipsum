<?php
$base_url = "http://localhost/mmtxt/";
$url = $_SERVER['REQUEST_URI'];
$url = preg_replace('/[a-zA-Z0-9\/\.\-]+(api\/)/i','', $url);
$seg = explode("/", $url);

if(!isset($seg[3]) || strtolower(trim($seg[3]))!="zg") $seg[3]="un";

echo file_get_contents($base_url."api.php?p=".intval($seg[0])."&mins=".intval($seg[1])."&maxs=".intval($seg[2])."&enc=".$seg[3]);

?>


