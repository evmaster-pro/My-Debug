# My-Debug
My PHP debug functions.

dtr($echo = true) - debug trace displays call stack.

dvar($var, $line, $echo = 1) - debug variable - displays arrays, strings & objects.

darr($var, $name = 'var') - debug array - displays array or object structure so easy as piece of cake. For arrays with up to 5 levels.

err_tr($line = 0) - error trace - trace for debuging.

pr($s1 = 'test', $s2 = 'test', $s3 = 'test', $s4 = 'test', $s5 = 'test', $s6 = 'test', $s7 = 'test', $s8 = 'test', $s9 = 'test', $s10 = 'test') - print - dispalys up to 10 debug variables, strings, arrays or objects.

dpr($s1 = 'test', $s2 = 'test', $s3 = 'test', $s4 = 'test', $s5 = 'test', $s6 = 'test', $s7 = 'test', $s8 = 'test', $s9 = 'test', $s10 = 'test') - date print - dispalys up to 10 dates from unix timestamps.

el($s1 = 'test', $s2 = 'test', $s3 = 'test', $s4 = 'test', $s5 = 'test', $s6 = 'test', $s7 = 'test', $s8 = 'test', $s9 = 'test', $s10 = 'test') - error log - writes up to 10 debug variables, strings, arrays or objects to server log file.

cl($s1 = 'test', $s2 = 'test', $s3 = 'test', $s4 = 'test', $s5 = 'test', $s6 = 'test', $s7 = 'test', $s8 = 'test', $s9 = 'test', $s10 = 'test') console log - writes up to 10 debug variables, strings, arrays or objects to borswer debug bar.

derr($echo = true) - debug error - displays last PHP error.

dStart($str = 'prof', $line = 1) - debug start - start perfomance monitor.

dPrint($log = 1) - debug print - ends monitoring and displays results - time of executing code.
Example:

dStart('start');
//some code
dStart('point1');
//some code
dStart('point1');
//some code
dStart('point1');
//some code
dPrint();

LA() - Load Average - gets server load average for 1 minute, 5 minutes and 15 minutes.
