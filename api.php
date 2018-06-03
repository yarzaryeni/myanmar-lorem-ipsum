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

if(!isset($_GET['min']) || intval($_GET['min'])<2) $_GET['min']=2;
$min_sentence  =intval($_GET['min']);

if(!isset($_GET['max']) || intval($_GET['max'])<2) $_GET['max']=2;
$max_sentence  =intval($_GET['max']);

if(!isset($_GET['enc']))
{
    $encoding = "zg";
} else {
    $encoding = $_GET['enc'];
}

if($encoding == "zg") $font = "Zawgyi-one, Zawgyi1"; else $font = 'Myanmar3, "Myanmar Text" , Myanmar2';

if(!isset($_GET['html'])) $html = "html"; else $html = strtolower($_GET['html']);


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

    if($html=="html")
    {
        $output .= "<p style='font-family: ".$font."'>".$paragraph."</p>\n";
    }
    else
    {
        $output .= $paragraph."\r\n\r\n";
    }

}

if($encoding=="zg") $output = Rabbit::uni2zg($output);

echo $output;

?>