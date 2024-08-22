<?php

class AppController {

    public function __construct() {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool {
        return $this->request === 'GET';
    }

    protected function isPost(): bool {
        return $this->request === 'POST';
    }

    protected function redirect($path) {
        $url = "http://$_SERVER[HTTP_HOST]";
        header("location: {$url}{$path}");
        die();
    }
    
    public function render(string $template = null, array $variables = [])
    {
        $templatePath = 'public/views/'. $template.'.html';
        $output = 'File not found';
                
        if(file_exists($templatePath)){
            extract($variables);
            
            ob_start();
            include $templatePath;
            $output = ob_get_clean();
        }
        print $output;
    }
}