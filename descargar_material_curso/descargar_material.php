<?php
// Locate.
$file_name = 'Probusiness_Material_Curso_Importacion.zip';
$file_url = $file_name;

/*
// Configure.
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header('Content-Type: application/force-download');
header("Content-disposition: attachment; filename=\"".$file_name."\"");

// Actual download.
readfile($file_url);

// Finally, just to be sure that remaining script does not output anything.
exit;
*/

header("Content-Type: " . mime_content_type($file_name));
header("Content-Length: " . filesize($file_url));
header('Pragma: public');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Expires: 0');
header('Connection: Keep-Alive');
header("Content-Transfer-Encoding: Binary");
header('Content-Type: application/force-download');
header('Content-Description: File Transfer');
header("Content-disposition: attachment; filename=\"".$file_name."\"");

// Actual download.
readfile($file_url);

// Finally, just to be sure that remaining script does not output anything.
exit;