<?php

namespace KhanhIceTea\Xhprof\Collector;

class SimpleTemplate {
    private $template_dir;

    public function __construct(string $template_dir)
    {
        $this->template_dir = $template_dir;    
    }

    public function render($template, array $data = []) {
        $file_path = $this->template_dir.DIRECTORY_SEPARATOR.$template;
        foreach ($data as $key => $value) {
            ${$key} = $value;
        }
        require $file_path;
    }
}