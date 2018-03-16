<?php

function formatMethod($method) {
    return "> `函数：{$method}`\n";
}

function getCleanComment($comment) {
    $lines = explode("\n", $comment);
    $ignores = array('/**', '*', '*/');
    $clean_lines = array();
    if ($lines) {
        foreach ($lines as $line) {
            $line = trim($line);
            // 跳过无用行
            if (in_array($line, $ignores)) {
                continue;
            }
            // 跳过 @param 和 @return
            if ((strpos($line, '@param') !== false) || (strpos($line, '@return') !== false)) {
                continue;
            }
            $clean_lines[] = substr($line, 1);
        }
    }
    return $clean_lines;
}

function formatComment($comment_array) {
    $comment_str = "\n";
    if ($comment_array) {
        $comment_str .= implode("\n", $comment_array);;
    }
    $comment_str .= "\n";
    return $comment_str;
}

function getParams($comment) {
    $lines = explode("\n", $comment);
    $params = array();
    if ($lines) {
        foreach ($lines as $line) {
            $line = trim($line);
            if (strpos($line, '@param') !== false) {
                $line = trim(substr($line, 1));
                // 把多个空格替换成一个
                $line = preg_replace('/ +/',' ',$line);
                $line_parts = explode(' ', $line);
                $param = array(
                    'type' => isset($line_parts[1]) ? $line_parts[1] : '',
                    'name' => isset($line_parts[2]) ? $line_parts[2] : '',
                    'desc' => isset($line_parts[3]) ? $line_parts[3] : '',
                );
                $params[] = $param;
            }
        }
    }
    return $params;
}

function formatParams($params_array) {
    $params_str = "##### **参数说明**\n\n|类型|名称|说明|\n|----|----|----|\n";
    if ($params_array) {
        foreach ($params_array as $param) {
            $params_str .= "|".implode('|', $param)."|\n";
        }
    }
    return $params_str;
}

function getReturn($comment) {
    $lines = explode("\n", $comment);
    $return = array();
    if ($lines) {
        foreach ($lines as $line) {
            $line = trim($line);
            if (strpos($line, '@return') !== false) {
                $line = trim(substr($line, 1));
                // 把多个空格替换成一个
                $line = preg_replace('/ +/',' ',$line);
                $line_parts = explode(' ', $line);
                $return = array(
                    'type' => isset($line_parts[1]) ? $line_parts[1] : '',
                    'desc' => isset($line_parts[2]) ? $line_parts[2] : '',
                );
            }
        }
    }
    return $return;
}

function formatReturn($return_array) {
    $return_str = "##### **返回值说明**\n\n|类型|说明|\n|----|----|\n";
    if ($return_array) {
        $return_str .= "|".implode('|', $return_array)."|\n";
    }
    return $return_str;
}
