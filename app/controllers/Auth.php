<?php

class Auth extends AuthController
{
    var $id_user = '';
    public function __construct()
    {
        $this->action = $this->model('M_action');
        $this->id_user = session(WEB_NAME.'_id_user');
        $this->db = new Database;
    }

    public function index()
    {
            $data = [];
            
            // GLOBAL VARIABEL
            $data['title'] = 'Masuk untuk menerima akses';

            // LOAD VIEW
            $this->display('login',$data);
    }
    // FUNGSI AUTH
    public function login_proses()
    {
        // Ambil data dari input
        $email = strtolower($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';

        // Validasi input
        if (!$email || !$password) {
            $data['status'] = 700;
            $data['message'] = 'Data tidak terdeteksi! Silahkan cek data anda';
            echo json_encode($data);
            exit;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['status' => 700, 'message' => 'Invalid email! Please enter a valid email']);
            $data['status'] = 700;
            $data['message'] = 'Alamat email tidak valid! Silahkan cek format emails';
            echo json_encode($data);
            exit;
        }

        // Cek user berdasarkan email
        $user = $this->action->get_single('user',['email' => $email,'delete' => 'N']);

        if ($user) {
            // Cek apakah user diblokir
            if ($user->status == 'N') {
                $reason = $user->reason ? ' dengan alasan </br></br><b>"' . $user->reason . '!"</b></br></br>' : '!';
                $data['status'] = 700;
                $data['message'] = 'Akun mu telah dinonaktifkan! ' . $reason . ' Hubungi admin jika terjadi kesalahan';
                echo json_encode($data);
                exit;

            }

            // Cek password
            if ($user->password == hash_my_password($password)) {
                $_SESSION[WEB_NAME.'_id_user'] = $user->id_user;
                $_SESSION[WEB_NAME.'_name'] = $user->name;
                $_SESSION[WEB_NAME.'_id_role'] = $user->id_role;
                $_SESSION[WEB_NAME.'_email'] = $user->email;
                $_SESSION[WEB_NAME.'_phone'] = $user->phone;
                $_SESSION[WEB_NAME.'_image'] = $user->image;

                $data['status'] = 200;
                $data['message'] = 'Anda berhasil masuk! Selamat datang <b>'. $user->name.'</b>';
                $data['redirect'] = base_url('dashboard');
                echo json_encode($data);
                exit;
            } else {
                $data['status'] = 500;
                $data['message'] = 'Kata sandi salah! Silahkan coba kembali';
                echo json_encode($data);
                exit;
            }
        }else{
            $data['status'] = 500;
            $data['message'] = 'Email tidak terdaftar';
            echo json_encode($data);
            exit;
        }
    }

   public function logout()
   {

      unset($_SESSION[WEB_NAME.'_id_user']);
      unset($_SESSION[WEB_NAME.'_id_role']);
      unset($_SESSION[WEB_NAME.'_nama']);
      unset($_SESSION[WEB_NAME.'_email']);
      unset($_SESSION[WEB_NAME.'_notelp']);
      unset($_SESSION[WEB_NAME.'_image']);

      redirect('home');
   }
}

