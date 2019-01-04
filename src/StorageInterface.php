<?php

namespace KhanhIceTea\Xhprof\Collector;

interface StorageInterface {
    public function write(array $data, string $request_uri);
}