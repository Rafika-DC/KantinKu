<?php

class Controller
{
   public function view($view, $data = [], $template = 'base', $return = false)
   {
      extract($data);

      // 1. Tangkap isi view sebagai string
      ob_start();
      if (file_exists('./app/views/' . $view . '.php')) {
         include './app/views/' . $view . '.php';
      } else {
         include './app/config/error/notfound.php';
      }
      $content = ob_get_clean(); // $content berisi HTML dari view

      // 2. Render layout dengan $content ditanam
      if ($return) {
         ob_start();
      }

      include "./app/themes/{$template}/base.php"; // layout pakai $content

      if ($return) {
         return ob_get_clean();
      }
   }



   public function model($model)
   {
      require_once "./app/models/$model.php";
      return new $model;
   }
}

class AdminController extends Controller
{

   public function display($view, $data = [])
   {
      $id_user = session(WEB_NAME.'_id_user');
      $id_role = session(WEB_NAME.'_id_role');
      
      // PROFILE
      $profile = [];
      if ($this->id_user) {
         $pro = $this->action->get_single('user',['id_user' => $this->id_user,'status' => 'Y','delete' => 'N']);
         if (!$pro) {
            redirect('logout');
         }
         $profile = $pro;

         if ($pro->id_role != 1) {
            redirect('home');
         }
      }

      $where['id_setting'] = 1;
      // SETTING
      $setting = $this->action->get_single('setting',$where);

      // SET DATA
      $data['setting'] = $setting;
      $data['profile'] = $profile;
      
      $themes = 'admin';

      $this->view('admin/'.$view, $data,$themes);

   }
    
}

class AuthController extends Controller
{

   public function display($view, $data = [])
   {
      $id_user = session(WEB_NAME.'_id_user');
      $id_role = session(WEB_NAME.'_id_role');
      
      // PROFILE
      $profile = [];
      if ($this->id_user) {
         $pro = $this->action->get_single('user',['id_user' => $this->id_user,'status' => 'Y','delete' => 'N']);
         if (!$pro) {
            redirect('logout');
         }else{
            redirect('dashboard');
         }
         $profile = $pro;
      }

      $where['id_setting'] = 1;
      // SETTING
      $setting = $this->action->get_single('setting',$where);

      // SET DATA
      $data['setting'] = $setting;

      $themes = 'auth';
      $this->view('auth/'.$view, $data,$themes);

   }
    
}
