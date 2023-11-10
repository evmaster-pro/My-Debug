<?php
//My debug functions

function dtr($echo = true)//Shows call stack
{
    $stack = ''; $i = 1;
    
    $trace = debug_backtrace();
    unset($trace[0]);

    foreach ($trace as $node)
    {
        $stack .= "#" . $i . ": " . basename($node['file']) . "(" . $node['line'] . "): ";
        if (isset($node['class'])) $stack .= $node['class'] . "->";
        $stack .= $node['function'] . "()" . PHP_EOL;
        $i++;
    }

    if ($echo) echo $stack;
    else return $stack;
}

function dvar($var, $line, $echo = 1)//Shows arrays, strings & objects
{
    if (is_array($var) || is_object($var)) $txt = darr($var);
    elseif (is_string($var)) $txt = "str(" . strlen($var) . ") \"" . htmlentities($var) . "\"\n";
    else $txt = var_dump($var);

    if ($echo) echo "<pre>" . err_tr($line) . nl2br($txt) . "\n</pre>";
    else return $txt;
}

function darr($var, $name = '')//Displays array or object structure so easy as piece of cake
{
    $out = '';
    $len = 250;

    if ($name) 
    {
        $out .= '<b>' . $name . ':</b><br>';
    }

    if (is_array($var) || is_object($var)) 
    {
        foreach ($var as $key => $val) 
        {
            $keyString = is_numeric($key) ? '[' . $key . ']' : "['" . $key . "']";
            $displayName = $name . $keyString;

            if (is_array($val) || is_object($val)) 
            {
                if (is_array($val) && count($val) > 1) $out .= '<br>';
                $out .= darr($val, $displayName);
            } else {
                $out .= $displayName . ' = ' . trim((mb_strlen($val) > $len ? mb_substr($val, 0, $len) . '...' : $val), " \n") . '<br>';
            }
        }
    }

    return $out;
}

function err_tr($line = 0)//Trace for debuging
{
    $trace = debug_backtrace();
    $result = "";

    for ($n = $line + 2; $n >= $line; $n--)
    {
        if ($trace[$n]['file'])
        {
            $trace[$n]['file'] = str_replace($_SERVER['DOCUMENT_ROOT'], '', $trace[$n]['file']);
            
            $result .= basename($trace[$n]['file']);
            $result .= '[' . $trace[$n]['line'] . '][' . $trace[$n]['function'] . '] => ';
        }
    }
    $result = rtrim($result, ' => ') . ': ';

    return $result;
}

//Debug printer
function pr($s1 = 'test', $s2 = 'test', $s3 = 'test', $s4 = 'test', $s5 = 'test', $s6 = 'test', $s7 = 'test', $s8 = 'test', $s9 = 'test', $s10 = 'test')
{
    for ($n = 1; $n <= 10; $n++)
    {
        if (${'s' . $n} != 'test' || $n == 1)
        {
            if (is_array(${'s' . $n}) || is_object(${'s' . $n})) dvar(${'s' . $n}, 2);
            else echo err_tr(1) . '[' . $n . '] ' . ${'s' . $n} . "<br>";
        }
    }
}

//Debug date printer
function dpr($s1 = 'test', $s2 = 'test', $s3 = 'test', $s4 = 'test', $s5 = 'test', $s6 = 'test', $s7 = 'test', $s8 = 'test', $s9 = 'test', $s10 = 'test')
{
    for ($n = 1; $n <= 10; $n++)
    {
        if (${'s' . $n} != 'test') echo err_tr(1) . date('d-m-Y H:i:s', ${'s' . $n}) . "<br>";
    }
}

//Debug error log writer
function el($s1 = 'test', $s2 = 'test', $s3 = 'test', $s4 = 'test', $s5 = 'test', $s6 = 'test', $s7 = 'test', $s8 = 'test', $s9 = 'test', $s10 = 'test')
{
    for ($n = 1; $n <= 10; $n++)
    {
        if (${'s' . $n} != 'test' || $n == 1)
        {
            if (is_array(${'s' . $n}) || is_object(${'s' . $n})) $str2 = print_r(${'s' . $n}, true);
            else $str2 = ${'s' . $n};

            error_log(strip_tags(err_tr(1, 1)) . '[' . $n . '] ' . $str2 . "\n");
        }
    }
}

//console log
function cl($s1 = 'test', $s2 = 'test', $s3 = 'test', $s4 = 'test', $s5 = 'test', $s6 = 'test', $s7 = 'test', $s8 = 'test', $s9 = 'test', $s10 = 'test')
{
    for ($n = 1; $n <= 10; $n++)
    {
        if (${'s' . $n} != 'test' || $n == 1)
        {
            if (is_array(${'s' . $n}) || is_object(${'s' . $n})) $txt = dvar(${'s' . $n}, 2, 0);
            else $txt = err_tr(1) . '[' . $n . '] ' . ${'s' . $n} . "\n";
            
            $txt = str_replace("\n", "", $txt);

            echo '<script>console.log("'.date('H:i:s').': '.json_encode($txt).'");</script>';
        }
    }
}


//Last PHP error printer
function derr($echo = true)
{
  $err = error_get_last();
  $text = err_tr(1)."<font color=red>PHP error: ".$err['type']."<br>".$err['message']."</font><br>";

  if($echo) echo $text;
  else return $text;
}

//Perfomance Monitor
function dStart($str = 'prof', $line = 1)
{
    global $prof_timing, $prof_names, $prof_line;

    $prof_timing[] = microtime(true);
    $prof_names[] = $str;
    $prof_line[] = err_tr($line, 1);
}

function dPrint($log = 1)
{
    global $prof_timing, $prof_names, $prof_line;

    $size = count($prof_timing);
    $total_time = $prof_timing[$size - 1] - $prof_timing[0];

    if ($size == 1)
    {
        dStart('all', 1);
        $size++;
    }

    for ($i = 0; $i <= $size - 1; $i++)
    {
        if ($prof_names[$i] == 'prof') $prof_names[$i] .= '[' . $i . ']';
        $per = ' (' . (($i && $total_time) ? round(($prof_timing[$i] - $prof_timing[$i - 1]) / ($total_time / 100), 2) : '0') . '%)';
        
        if ($log == 1) el($prof_names[$i] . ":" . sprintf(" %f", ($i == 0 ? 0 : $prof_timing[$i] - $prof_timing[$i - 1])) . $per); //$prof_line[$i]." ".
        else echo $prof_line[$i] . "&nbsp;<b>" . $prof_names[$i] . "</b>:" . sprintf("&nbsp;%f", ($i == 0 ? 0 : $prof_timing[$i] - $prof_timing[$i - 1])) . $per . "<br>";
    }

    if ($size > 2)
    {
        if ($log == 1) el(" all:" . sprintf(" %f", $prof_timing[$size - 1] - $prof_timing[0]) . ' (100%)');
        else echo err_tr(1) . "&nbsp;<b>all</b>:" . sprintf("&nbsp;%f", $prof_timing[$size - 1] - $prof_timing[0]) . ' (100%)<br><br>';
    }

    unset($GLOBALS['prof_timing'], $GLOBALS['prof_names'], $GLOBALS['prof_line']);
}

//Server Load Average
function LA()
{
    $la = sys_getloadavg();

    return [$la[0], $la[1], $la[2]];
}
