<?php


/**
 * @param $num
 * @return mixed
 */
function engToMMNum($num)
{
    $num = str_replace("1","၁", $num);
    $num = str_replace("2","၂", $num);
    $num = str_replace("3","၃", $num);
    $num = str_replace("4","၄", $num);
    $num = str_replace("5","၅", $num);
    $num = str_replace("6","၆", $num);
    $num = str_replace("7","၇", $num);
    $num = str_replace("8","၈", $num);
    $num = str_replace("9","၉", $num);
    $num = str_replace("0","၀", $num);

    return $num;
}


/**
 * @param $match
 * @return mixed
 */
function match2Word($match){
    $match = trim(strtolower($match));
    $match = str_replace("{","", $match);
    $match = str_replace("}","", $match);
    $result = "";
    $do = true;
    $fix="";

    $fix_file = $match."-fix.txt";

    //echo "$match ,";

    if(strpos($match,"_"))
    {
        $part = explode("_",$match);
        $chance = intval($part[1]);
        if(rand(0,$chance)!=$chance){
            $do = false;
        }
        $match = $part[0];
        $fix_file = trim($part[0])."-fix.txt";
    }


    if($do){
        if($match=="int1" || $match=="int2" || $match=="int3" || $match=="int4")
        {
            $c = str_replace("int","", $match);
            $n = '';
            for($i=0;$i<($c*1);$i++){
                $n .= rand(1,9);
            }
            $result = $n*1;
        }
        elseif(strpos($match,"rand"))
        {
            $nums = explode("rand", strtolower($match));
            if(intval($nums[0]) < intval($nums[1]))
            {
                $result = rand(intval($nums[0]), intval($nums[1]));
            }
            else
            {
                $result = rand(intval($nums[1]), intval($nums[0]));
            }
        }
        else
        {
            $matches = file_to_array(CONTEXT . $match . ".txt");
            $result = randElement($matches);
        }

        if(is_file(CONTEXT.$fix_file))
        {
            $fix_ary =  file_to_array(CONTEXT.$fix_file);
            $fix = randElement($fix_ary);
        }
    }

    $result = word2Meaning($result);
    return engToMMNum($result).$fix;
}


function word2Meaning($word)
{
    $result  = $word;
    $word = trim(strtolower($word));
    if($word=="female_name" || $word=="male_name"){
        $result = composeName($word);
    }
    elseif ($word=='time')
    {
        $result =date("H"). ' နာရီ '.date("i"). ' မိနစ် ';
    }
    return $result;
}


/**
 * @return string
 */
function makeSentence()
{
    $template = "template.txt";
    $templates = file_to_array(CONTEXT.$template);
    $line = trim(randElement($templates));
    $segments = explode("|",preg_replace(MATCH_PATTERN,"|", $line));
    $matches = getMatch($line);
    $sentence = "";
    for($i=0;$i<count($matches);$i++)
    {
        $sentence .= $segments[$i].match2Word($matches[$i]);
    }
    $sentence .= array_pop($segments);
    return trim($sentence);
}


/**
 * @param $str
 * @return mixed
 */
function getMatch($str){
    $vars = array();
    preg_match_all (MATCH_PATTERN, $str, $vars, PREG_PATTERN_ORDER  );
    return $vars[0];
}


/**
 * @param $line
 * @return bool
 */
function notComment($line)
{
    $line = preg_replace("/[\r]+/","\n", $line);
    if(preg_match('/(#).+/', trim($line)) || trim($line)=="")
    {
        return false;
    }else{
        return true;
    }
}


/**
 * @param $path
 * @return array
 */
function file_to_array($path)
{
    if(!is_file($path))
    {
        return array("Invalid File path - ".$path);
    }
    else
    {
        $file = file_get_contents($path);
        $file = explode("\n", $file);
        $ary = array();
        foreach ($file as $line)
        {
            if (notComment($line))
            {
                $ary[] = trim($line);
            }

        }
        return $ary;
    }
}


/**
 * @param $ary
 * @return string
 */
function randElement($ary)
{
    $ary_len = count($ary);
    $rdm = rand(0,($ary_len-1));
    return trim($ary[$rdm]);
}


function composeName($gender='x')
{
    if(strtolower($gender)!="m" && strtolower($gender)!="f" ){
        if(rand(0,1)==1){$gender='m';}else{$gender='f';}
    }
    $count = rand(2,4);
    $name = "";
    for($i=0;$i<$count;$i++){
        $name .= getName($gender);
    }

    $mr = array("ဦီး", "ကို", "မောင်","ဆရာ", "ဆရာကြီး", "ဒေါက်တာ");
    $mrs = array("ဒေါ်", "မ","မ","ဆရာမ", "ဆရာမကြီး", "ဒေါက်တာ");
    if($gender=="m") $title = randElement($mr); else $title = randElement($mrs);
    return $title.$name;
}



function getName($name='m')
{
    if($name=='f'){
        $nameAry =  file_to_array('data/_female.txt');
    }else{
        $nameAry =  file_to_array('data/_male.txt');
    }
    return randElement($nameAry);
}