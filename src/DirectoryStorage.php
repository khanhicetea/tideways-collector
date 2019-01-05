<?php

namespace KhanhIceTea\Xhprof\Collector;

use League\Csv\Writer;
use League\Csv\Reader;


class DirectoryStorage implements StorageInterface {
    private $dir_path;

    public function __construct(string $dir_path)
    {
        $this->dir_path = $dir_path;

        if (!is_dir($this->dir_path)) {
            @mkdir($this->dir_path);
        }
    }

    public function write(array $data, string $request_uri) {
        $ts = time();
        $hash = substr(md5($request_uri.'||'.$ts), 0, 6);
        
        $file_path = $this->getFilePath($ts.'_'.$hash);
        $file = new FileStorage($file_path);
        $file->write($data, $request_uri);

        $csv_row = new CsvData();
        $csv_row->time = $ts;
        $csv_row->hash = $hash;
        $csv_row->url = $request_uri;
        
        $fh = $this->getCsvFileHandle();
        $csv = Writer::createFromStream($fh);
        $csv->insertOne($csv_row->toArray());
    }

    public function getCsvFileHandle() {
        $csv_path = $this->dir_path.DIRECTORY_SEPARATOR.'profiler.csv';
        return fopen($csv_path, 'a+');
    }

    public function read() {
        $fh = $this->getCsvFileHandle();
        $csv = Reader::createFromStream($fh);
        
        return $csv;
    }

    public function getFilePath($id) {
        return sprintf("%s%s%s", $this->dir_path, DIRECTORY_SEPARATOR, $id.'.json');
    }

    public function readFile($id) {
        $file_path = $this->getFilePath($id);
        
        return json_decode(file_get_contents($file_path), true);
    }
}
