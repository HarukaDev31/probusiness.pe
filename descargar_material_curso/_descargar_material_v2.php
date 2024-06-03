<?php
// Locate.
$file_name = 'Probusiness_Material_Curso_Importacion.zip';
$file_url = $file_name;

// Configure.
header('Content-Type: application/octet-stream');
header("Content-Transfer-Encoding: Binary"); 
header("Content-disposition: attachment; filename=\"".$file_name."\"");

// Actual download.
readfile($file_url);

// Finally, just to be sure that remaining script does not output anything.
exit;