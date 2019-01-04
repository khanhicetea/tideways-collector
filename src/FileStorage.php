<?php

namespace KhanhIceTea\Xhprof\Collector;

class FileStorage implements StorageInterface {
    private $file_path;

    public function __construct(string $file_path)
    {
        $this->file_path = $file_path;
    }

    public function write(array $data, string $request_uri) {
        $f = fopen($this->file_path, 'w');
        fwrite($f, json_encode($data));
        fclose($f);
    }
}