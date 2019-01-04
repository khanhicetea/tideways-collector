<?php
namespace KhanhIceTea\Xhprof\Collector;

class CsvData {
    private static $headers = [
        'time',
        'hash',
        'url',
    ];
    private $values = [];

    public function __construct(array $values = null) {
        if ($values) {
            foreach (static::$headers as $idx => $key) {
                $this->values[$key] = $values[$idx] ?? null;
            }
        }
    }

    public function __get($name) {
        return $this->values[$name] ?? null;
    }

    public function __set($name, $value) {
        $this->values[$name] = $value;
    }

    public function toArray() {
        $values = [];
        foreach (static::$headers as $idx => $key) {
            $values[] = $this->values[$key] ?? null;
        }
        return $values;
    }
}