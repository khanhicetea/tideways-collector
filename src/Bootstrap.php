<?php

namespace KhanhIceTea\Xhprof\Collector;

// Array
// (
//     [ct] => 1                // number of calls.
//     [wt] => 419              // wall/wait time (ms).
//     [cpu] => 0               // cpu time.
//     [mu] => 8264             // memory usage (bytes).
//     [pmu] => 0               // peak memory usage.
// )

class Bootstrap {
    private $flag;
    private $storage;
    private $template;

    public function __construct(StorageInterface $storage = null) {
        if (!(function_exists('tideways_enable') && function_exists('tideways_disable'))) {
            throw new \RuntimeException('Please install tideways extension!');
        }

        $this->flag = 0;
        $this->setStorage($storage);
        $this->template = new SimpleTemplate(dirname(__DIR__).DIRECTORY_SEPARATOR.'templates');
    }

    public function noBuiltins() : self {
        $this->flag = $this->flag | TIDEWAYS_FLAGS_NO_BUILTINS;
        
        return $this;
    }

    public function enableCPU() : self {
        $this->flag = $this->flag | TIDEWAYS_FLAGS_CPU;
        
        return $this;
    }

    public function enableMemory() : self {
        $this->flag = $this->flag | TIDEWAYS_FLAGS_MEMORY;
        
        return $this;
    }

    public function setStorage(StorageInterface $storage = null) : self {
        $this->storage = $storage;

        return $this;
    }

    public function getStorage() : StorageInterface {
        return $this->storage;
    }

    public function start() {
        tideways_enable($this->flag);
    }

    public function stop() {
        $request_url = $this->currentURL();
        $data = tideways_disable();
        $this->storage->write($data, $request_url);
    }

    public function currentURL() {
        $scheme = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http");
        return sprintf("%s://%s%s", $scheme, $_SERVER['HTTP_HOST'], $_SERVER['REQUEST_URI']);
    }

    public function webUI() {
        if (!is_a($this->storage, DirectoryStorage::class)) {
            throw new \RuntimeException('Does not support this storage !');
        }

        $data = [];

        if ($id = $_GET['id'] ?? null) {
            $data['record'] = $record = $this->storage->readFile($id);
            $data['headers'] = $headers = array_keys(current($record));
            $caller_headers = array_filter($headers, function ($h) { return $h != 'ct'; });
            $data['caller_headers'] = $caller_headers;
            
            $calls = [];
            $callers = [];

            foreach ($record as $callstack => $values) {
                $parts = explode('==>', $callstack);
                $from = $parts[0] ?? 'main';
                $to = $parts[1] ?? 'main';

                if (!isset($calls[$to])) {
                    $calls[$to] = array_fill_keys($headers, 0);
                    $callers[$from] = array_fill_keys($headers, 0);
                }
                foreach ($headers as $header) {
                    $calls[$to][$header] += $values[$header];
                    $callers[$from][$header] += $values[$header];
                }
            }

            $data['calls'] = $calls;
            $data['callers'] = $callers;

            return $this->template->render('view.php', $data);
        }

        $data['reader'] = $this->storage->read();
        $data['url'] = $this->currentURL();

        return $this->template->render('index.php', $data);
    }
}