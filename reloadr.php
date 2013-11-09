<?php
$filename_lists = array_map('glob_recursive', explode(',', $_SERVER['QUERY_STRING']));
$files = array();
foreach( $filename_lists as $filename_list ) $files = array_merge($files, $filename_list);
foreach ( $files as &$file ) $file = filemtime($file);
header('Last-Modified: '. date('r', @max($files)));

function glob_recursive($pattern, $flags = 0) {
    $files = glob($pattern, $flags);
    foreach (glob(dirname($pattern).'/*', GLOB_ONLYDIR|GLOB_NOSORT) as $dir) {
        $files = array_merge($files, glob_recursive($dir.'/'.basename($pattern), $flags));
    }
    return $files;
}
?>
