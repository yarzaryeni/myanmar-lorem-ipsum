<?php


/**
 * @param $str
 * @return mixed
 */
function getMatch($str){
    $vars = array();
    preg_match_all ("/{[a-zA-Z0-9\-]+}/", $str, $vars, PREG_PATTERN_ORDER  );
    return $vars[0];
}


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
    elseif(strpos($match,"|"))
    {
        $matchs = explode("|",$match);
        $result = $matchs[rand(0,count($matchs)-1)];
    }
    else
    {
        $matches = file_to_array(CONTEXT . $match . ".txt");
        $result = randElement($matches);
    }

    return engToMMNum($result);
}


/**
 * @return string
 */
function makeSentence()
{
    $template = "template1.txt";
    $templates = file_to_array(CONTEXT.$template);
    $line = randElement($templates);
    $segments = explode("|",preg_replace("/{[a-zA-Z0-9\-]+}/","|", $line));
    $matches = getMatch($line);
    $sentence = "";
    for($i=0;$i<count($matches);$i++)
    {
        $sentence .= $segments[$i].match2Word($matches[$i]);
    }
    $sentence .= array_pop($segments);
    return $sentence;
}


/**
 * @param $line
 * @return bool
 */
function notComment($line)
{
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
