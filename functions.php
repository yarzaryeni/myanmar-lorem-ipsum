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
 * @param $data
 * @param $filename
 * @param $path
 * @param int $append
 */
function saveFile($data, $filename, $path, $append=FILE_APPEND)
{
    if (!file_exists($path))
    {
        mkdir($path, 0777, true);
    }
    file_put_contents($path.$filename, $data, $append);
}


/**
 * @param int $utc
 * @return float|int
 */
function locTime($utc=0)
{
    return (time()*1)+(60*60*$utc);
}


/**
 * @param string $path
 * @return array
 */
function readEnv($path='.env')
{
    $env_ary = explode("\n",file_get_contents($path));
    $result = array();
    foreach($env_ary as $line){
        $line = trim($line);
        if($line=='')
        {
            //Do nothing for empty line
        }
        elseif(preg_match('/(#).+/', $line))
        {
            //Do nothing for comment line
        }
        elseif (strpos($line,"="))
        {
            $line = explode('=', $line);
            $result[trim($line[0])]=trim($line[1]);
        }
    }
    return $result;
}


/**
 * @param int $length
 * @param int $space
 * @return string
 */
function randStr($length = 10, $space = 0)
{
    if($space==0)
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    }
    else
    {
        $characters = '012 345 6789a bcdefghi jklmnopqrs tuvw xyzAB CDEFG HIJKL MNOPQ RSTU VW XYZ';
    }
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++)
    {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
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
