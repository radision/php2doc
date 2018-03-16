<?php

$file_name = isset($argv[1]) ? trim($argv[1]) : '';
$class_name = isset($argv[2]) ? trim($argv[2]) : '';

if (!$file_name || !$class_name) {
    echo "Usage: /path/to/php phpdoc.php /path/to/[class_file_name] [class_name_with_namespace]\n";
    echo "\n";
    echo "Example:\n";
    echo "php phpdoc.php class.php \\A\\B\\Foo";
    exit();
}

if (!file_exists($file_name)) {
    echo "class file not found.\n";
    exit();
}

/*
if (!class_exists($class_name)) {
    echo "class name not existed.\n";
    echo "Example: class name with namespace look like \\\\A\\\\B\\\\Foo\n";
    exit();
}
 */

/*
echo "file_name = $file_name\n";
echo "class_name = $class_name\n";
 */

require $file_name;
require "functions.php";

try {
    $function = new \ReflectionClass($class_name);
} catch (Exception $e) {
    echo $e->getMessage();
    exit();
}

/*
var_dump($function->inNamespace());
var_dump($function->getName());
var_dump($function->getNamespaceName());
var_dump($function->getShortName());
 */
// 只取public方法
$methods = $function->getMethods(\ReflectionMethod::IS_PUBLIC);
foreach ($methods as $method) {
    $method_name = $method->getName();
    // 忽略下划线开头的方法
    if (substr($method_name, 0, 1) == '_') {
        continue;
    }
    $comment = $method->getDocComment();
    $clean_comment = getCleanComment($comment);
    $params = getParams($comment);
    $return = getReturn($comment);

    $method_str = formatMethod($method_name);
    $comment_str = formatComment($clean_comment);
    $params_str = formatParams($params);
    $return_str = formatReturn($return);

    // echo "method_name = $method_name\n";
    echo "$method_str\n";

    // print_r($clean_comment);
    echo $comment_str."\n";

    // print_r($params);
    echo $params_str."\n";

    // print_r($return);
    echo $return_str."\n";

    echo "<br>\n";
}


