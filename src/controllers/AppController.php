<?php

class AppController {
    private $request;

    public function __construct()
    {
        $this->request = $_SERVER['REQUEST_METHOD'];
    }

    protected function isGet(): bool
    {
        return $this->request === 'GET';
    }

    protected function isPost(): bool
    {
        return $this->request === 'POST';
    }

    protected function render(string $template = null, array $variables = [])
    {
        $templatePath = 'data/views/'. $template.'.php';
        $output = 'File not found';
                
        if(file_exists($templatePath)){
            extract($variables);
            
            ob_start();
            include $templatePath;
            $output = ob_get_clean();
            
        }
        header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
        header("Pragma: no-cache");
        header("Expires: 0");
        // header("Content-Type: text/css");
        // readfile('data/css/styles.css');    
        print $output;
    }

    protected function getUserFromCookies(): ?User{
        if (empty($_COOKIE['id_session'])){
            return null;
        }

        $userRepository = new UserRepository();
        return $userRepository->getUserFromCookies($_COOKIE['id_session']);
    }

    protected function redirect(string $url) : void {
        header("Location: ".$url);
        exit;
    }
}