<?php
class App
{
   protected $controller = 'Auth';
   protected $method = 'index';
   protected $params = [];

   public function __construct()
   {
      $url = parseUrl('',true);
      if (isset($url['url']) && count($url['url']) > 0) {
         $uri = '';
         for ($i=0; $i < count($url['url']); $i++) {
            if ($i == (count($url['url']) - 1)) {
               $uri .= $url['url'][$i];
            }else{
               $uri .= $url['url'][$i].'/'; 
            }  
         }
         if (isset(ROUTER[$uri])) {
            $url['url'] = parseUrl(ROUTER[$uri]);
         }
      }
      
      
      // cek controller
      if (isset($url['url'][0])) {
         if (file_exists("./app/controllers/" . ucfirst($url['url'][0]) . ".php")) {
            $this->controller = ucfirst($url['url'][0]);
            unset($url['url'][0]);
         }
      }
      

      require_once "./app/controllers/$this->controller.php";
      $this->controller = new $this->controller;

      // cek method
      // var_dump($url['url'][1]);die;
      if (isset($url['url'][1])) {
         if (method_exists($this->controller, $url['url'][1])) {
            $this->method = $url['url'][1];
            unset($url['url'][1]);
         }
      }
      
      
      // cek param
      if (!empty($url['url'])) {
         $this->params = array_values($url['url']);
      }

      if (!empty($url['params'])) {
         foreach ($url['params'] as $key => $value){
            $_GET[$key] = $value;
         }
         
      }
      // var_dump($this->params);die;
      // run controller,method, & param
      call_user_func_array([$this->controller, $this->method], $this->params);
   }
}
