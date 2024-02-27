<?php
function __error__($code) {
	http_response_code($code);
	if (is_file(($file = ".error/$code").'.html')
	 || is_file(($file = substr($file, 0, -1).'x').'.html')
	 || is_file(($file = substr($file, 0, -2).'xx').'.html')) {
		include "$file.html";
	} else {
		echo "error. $code";
	}
	exit;
}
function __route__() {
	$_SERVER['PHP_SELF'] = $_SERVER['DOCUMENT_URI'].$_SERVER['SCRIPT_NAME'];
	$str = $_SERVER['SCRIPT_NAME'];
	if (str_ends_with($str, '/')) {
		$ext = 'index.php';
		if (is_file(".${str}index.php")) {
			$arg = '';
		}
	}
	if (!isset($arg)) {
		$arg = '';
		while (!empty($str)) {
			if (is_file(".$str.php")) {
				$ext = '.php';
				$_SERVER['SCRIPT_NAME'] = $str;
				break;
			}
			$pos = strrpos($str, '/');
			$arg = substr($str, $pos).$arg;
			$str = substr($str, 0, $pos);
		}
		if (empty($str)) {
			$arg = '';
			if (!isset($ext)) {
				$ext = '.php';
			}
			$err = true;
		}
	}
	$_SERVER['PATH_INFO'] = $arg;
	$_SERVER['PATH_ARGS'] = $arg ? explode('/', substr($arg, 1)) : [];
	$_SERVER['SCRIPT_FILENAME'] = $_SERVER['DOCUMENT_ROOT'].$_SERVER['SCRIPT_NAME'].$ext;
	return isset($err);
}
if (__route__()) {
	__error__(404);
}
include $_SERVER['SCRIPT_FILENAME'];
?>