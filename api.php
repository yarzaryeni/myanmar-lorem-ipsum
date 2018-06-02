<?php
/**
 * User: Yarzar
 * Date: 1/6/2018
 * Time: 11:54 PM
 */

define("CONTEXT", "./sport/");
require "functions.php";
require "vendors/Rabbit.php";


/*
 * Set default values if not set.
 */
if(!isset($_GET['p']) || intval($_GET['p'])<1) $_GET['p']=rand(2,5);
$prg =intval($_GET['p']);

if(!isset($_GET['mins']) || intval($_GET['mins'])<2) $_GET['mins']=2;
$min_sentence  =intval($_GET['mins']);

if(!isset($_GET['maxs']) || intval($_GET['maxs'])<2) $_GET['maxs']=2;
$max_sentence  =intval($_GET['maxs']);

if(!isset($_GET['enc'])) $encoding = "zg"; else $encoding = $_GET['enc'];

if(!isset($_GET['enc'])) $encoding = "zg"; else $encoding = $_GET['enc'];


/*
 * Limit the max and min numbers
 */
if($min_sentence>29) $min_sentence=29;
if($max_sentence>30) $max_sentence=30;
if($prg>30) $prg=30;

/*
 * Correct of min is greater than max
 */
if($min_sentence > $max_sentence){
    $mx = $min_sentence;
    $min_sentence = $max_sentence;
    $max_sentence = $mx;
}


$output = "";
for($i=0;$i<$prg;$i++){
    $paragraph = "";
    $st_count = rand($min_sentence,$max_sentence);
    for($j=0;$j<$st_count;$j++){
        $paragraph .= makeSentence()." ";
    }
    $output .= "<p>".$paragraph."</p>\n";
}

if($encoding=="zg") $output = Rabbit::uni2zg($output);

echo $output;

?>