<?php
/**
 * Created by PhpStorm.
 * User: saura_000
 * Date: 10/23/15
 * Time: 9:22 PM
 */

class DownloadUtil
{
    public function downloadFile($filePath, $fileDisplayName)
    {
        if (file_exists($filePath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$fileDisplayName.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));
            readfile($filePath);
            exit;
        }
    }
}