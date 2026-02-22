<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class FileController extends Controller
{
    public function serve($type, $filename)
    {
        $basePath = WRITEPATH . 'uploads\\';
        // whitelist folder
        $allowed = [
            'image' => $basePath . 'image\\',
            'audio' => $basePath . 'audio\\',
        ];
        if (!isset($allowed[$type])) {
            return $this->response->setStatusCode(404);
        }
        $baseDir = realpath($allowed[$type]);
        $path = realpath($baseDir . '/' . $filename);

        if (!$path || strpos($path, $baseDir) !== 0 || !is_file($path)) {
            return $this->response->setStatusCode(404);
        }
        if (!is_file($path)) {
            return $this->response->setStatusCode(404);
        }
        $this->response->setContentType(mime_content_type($path));

        $this->response->setBody(file_get_contents($path));
        $this->response->send();
        return $this->response;
    }
}
