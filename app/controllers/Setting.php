<?php

class Setting extends AdminController
{
    var $id_user = '';
    public function __construct()
    {
        $this->action = $this->model('M_action');
        $this->id_user = session(WEB_NAME.'_id_user');
        $this->db = new Database;
    }

    public function index(){

        $page = '';
        if (isset($_GET['page']) && $_GET['page'] != '') {
            $page = $_GET['page'];
        }
        $data = [];
        // GLBL
        $data['title'] = 'setting';
        $data['subtitle'] = 'setting lanjutan website';

        // LOAD JS
        $data['js'][] = '<script>var page = "dashboard"</script>';
        $data['js'][] = '<script src="'.assets_url('admin/js/modul/setting/logo.js').'"></script>';
        $data['js'][] = '<script src="'.assets_url('admin/js/modul/setting/umum.js').'"></script>';

        // GET DATA
        $setting = $this->action->get_single('setting',['id_setting' => 1]);
        $result = $setting;
        $phone = $this->action->get_all('web_phone',['id_setting' =>1]);
        $email = $this->action->get_all('web_email',['id_setting' =>1]);
        $sosmed = $this->action->get_where_params('sosmed',[],'sosmed.*,(SELECT url FROM sosmed_setting WHERE sosmed_setting.id_sosmed = sosmed.id_sosmed AND sosmed_setting.id_setting = 1) AS url,(SELECT name_sosmed FROM sosmed_setting WHERE sosmed_setting.id_sosmed = sosmed.id_sosmed AND sosmed_setting.id_setting = 1) AS name_sosmed',[]);


        // SET DATA
        $data['result'] = $result;
        $data['phone'] = $phone;
        $data['email'] = $email;
        $data['sosmed'] = $sosmed;
        $data['page'] = $page;
        
        // DISPLAY
        $this->display('setting/index',$data);
    }

    public function profile(){
        $data = [];
        // GLBL
        $data['title'] = 'Profil';
        $data['subtitle'] = 'Pengaturan data pribadi';

        // LOAD JS
        $data['js'][] = '<script>var page = "profile"</script>';
        $data['js'][] = '<script src="' . assets_url('admin/') . 'js/modul/setting/profile.js"></script>';

        $result = $this->action->get_single('user',['id_user' => $this->id_user]);

        $data['result'] = $result;

        $this->display('setting/profile',$data);
    }

    // FUNCTION SOSMED
    public function tambah_sosmed()
    {
        // VARIABEL
        $arrVar['icon']             = 'Icon';
        $arrVar['name']             = 'Nama';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_sosmed_' . $var, $value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        $url = $_POST['url'] ?? null;
        if (!in_array(false, $arrAccess)) {
            $insert = $this->action->insert('sosmed', $post);
            if ($insert) {
                if ($url) {
                    $cek = $this->action->get_single('sosmed_setting',['id_setting' => 1,'id_sosmed' => $insert]);
                    if ($cek) {
                        $this->action->delete('sosmed_setting',['id_sosmed_setting' => $cek->id_sosmed_setting]);
                    }
                    $in['id_sosmed'] = $insert;
                    $in['url'] = $url;
                    $in['id_setting'] = 1;
                    $this->action->insert('sosmed_setting',$in);
                    
                }
                $data['status'] = true;
                $data['alert']['message'] = 'Berhasil ditambahkan!';
                $data['reload'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Gagal ditambahkan!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function ubah_sosmed()
    {
        // VARIABEL
        $arrVar['id_sosmed']             = 'ID';
        $arrVar['icon']             = 'Icon';
        $arrVar['name']             = 'Nama';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_sosmed_' . $var, $value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }

        $url = $_POST['url'] ?? null;
        $result = $this->action->get_single('sosmed', ['id_sosmed' => $id_sosmed]);

        if (!in_array(false, $arrAccess)) {
            $update = $this->action->update('sosmed', $post, ['id_sosmed' => $id_sosmed]);
            if ($update) {
                if ($url) {
                    $cek = $this->action->get_single('sosmed_setting',['id_setting' => 1,'id_sosmed' => $result->id_sosmed]);
                    if ($cek) {
                        $this->action->delete('sosmed_setting',['id_sosmed_setting' => $cek->id_sosmed_setting]);
                    }
                    $in['id_sosmed'] = $result->id_sosmed;
                    $in['url'] = $url;
                    $in['id_setting'] = 1;
                    $this->action->insert('sosmed_setting',$in);
                    
                }
                $data['status'] = true;
                $data['alert']['message'] = 'Data berhasil dirubah!';
                $data['reload'] = true;
            } else {
                $data['status'] = false;
                $data['alert']['message'] = 'Data gagal dirubah!';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function hapus_sosmed()
    {
        $id = $_POST['id'] ?? 0;
        $res = $this->action->get_single('sosmed',['id_sosmed' => $id]);
        if ($res) {
            $hapus = $this->action->delete('sosmed',['id_sosmed' => $id]);
            if ($hapus) {
                $data['status'] = 200;
                $data['alert']['icon'] = 'success';
                $data['alert']['message'] = 'Data berhasil dihapus!';
                $data['reload'] = true;
            } else {
                $data['status'] = 500;
                $data['alert']['icon'] = 'warning';
                $data['alert']['message'] = 'Data gagal ditambahkan!';
            }
        }else{
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data tidak ditemukan!';
        }
        

        echo json_encode($data);
        exit;
    }

    public function setup_sosmed()
    {
        $sosmed = $_POST['sosmed'] ?? '';
        $name_sosmed = $_POST['name_sosmed'] ?? '';
        // var_dump($sosmed);die;
        if ($sosmed) {
            $this->action->delete('sosmed_setting', ['id_setting' => 1]);
            $set = [];
            $no = 0;
            foreach ($sosmed as $id => $value) {
                $num = $no++;
                $set[$num]['id_sosmed'] = $id;
                $set[$num]['id_setting'] = 1;
                $set[$num]['name_sosmed'] = (isset($name_sosmed[$id])) ? $name_sosmed[$id] : null;
                $set[$num]['url'] = $value ?? null;
            }

            $batch = $this->action->insert_batch('sosmed_setting', $set);
        }
        $data['status'] = true;
        $data['alert']['message'] = 'Data berhasil dirubah';
        $data['reload'] = true;
        echo json_encode($data);
        exit;
    }



    // FUNCTION SEO
    public function ubah_seo()
    {
        // VARIABEL
        $arrVar['meta_title']            = 'Judul website';
        $arrVar['meta_author']            = 'Nama author';
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_'.$var,$value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        $meta_keyword = $_POST['meta_keyword'] ?? '';
        $meta_description = $_POST['meta_description'] ??'';
        $meta_address = $_POST['meta_address'] ??'';
        $setting = $this->action->get_single('setting',['id_setting' => 1]);
        if ($meta_keyword) {
            $meta_keyword = json_decode($meta_keyword, true);
            $aru = [];
            foreach ($meta_keyword as $key) {
                $val = str_replace(["'",'"',"`"], "", $key['value']);
                $aru[] = $val;
            }
            $post['meta_keyword'] = implode(',',$aru);
        }else{
             $post['meta_keyword'] = '';
        }
        $post['meta_description'] = $meta_description;
        $post['meta_address'] = $meta_address;

        $phone = $_POST['phone'] ?? '';
        $email = $_POST['email'] ??'';
        $name_phone = $_POST['name_phone'] ?? '';

        $p = [];
        $e = [];
        if ($phone) {
            $no = 0;
            foreach ($phone as $id => $ph) {
                if ($ph !='') {
                    $num = $no++;
                    $p[$num]['id_setting'] = 1;
                    $p[$num]['phone'] = $ph;
                    $p[$num]['name'] =  (isset($name_phone[$id])) ? $name_phone[$id] : NULL;
                }
            }
        }
        if ($email) {
            $no = 0;
            foreach ($email as $id => $em) {
                if ($em !='') {
                    if (!validasi_email($em)) {
                        $data['status'] = false;
                        $data['alert']['message'] = '<b>'.$em.'</b> tidak valid! ';
                        echo json_encode($data);
                        exit;
                    }
                    $num = $no++;
                    $e[$num]['id_setting'] = 1;
                    $e[$num]['email'] = $em;
                }
            }
        }
        if (!in_array(false, $arrAccess)) {
            
            $update = $this->action->update('setting', $post, ['id_setting' => 1]);
            
            if ($update) {
                if ($p) {
                    $this->action->delete('web_phone',['id_setting' => 1]);
                    $this->action->insert_batch('web_phone',$p);
                }
                if ($e) {
                    $this->action->delete('web_email',['id_setting' => 1]);
                    $this->action->insert_batch('web_email',$e);
                }
                $data['status'] = true;
                $data['alert']['message'] = 'Data berhasil dirubah';
                $data['reload'] = true;
            } else {
                $data['status'] = false;
                 $data['alert']['message'] = 'Data gagal dirubah';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    // FUNCTION LOGO
    public function update_logo()
    {
        $setting = $this->action->get_single('setting',['id_setting' => 1]);

        $tujuan = './data/setting/';

        if (!file_exists($tujuan)) {
            mkdir($tujuan);
        }
        $arrAccess = [];

        $name_icon = $_POST['name_icon'] ?? '';
        $name_icon_white = $_POST['name_icon_white'] ?? '';
        $name_logo = $_POST['name_logo'] ?? '';
        $name_logo_white = $_POST['name_logo_white'] ?? '';

        if (!empty($_FILES['logo']['tmp_name'])) {
            $arrAccess[] = true;
        }else{
            if ($name_logo) {
                $arrAccess[] = true;
            }else{
                if ($setting->logo != '') {
                    $arrAccess[] = true;
                }else{
                    $arrAccess[] = false;
                }
                
            }
            
        }

        if (!empty($_FILES['logo_white']['tmp_name'])) {
            $arrAccess[] = true;
        }else{
            if ($name_logo_white) {
                $arrAccess[] = true;
            }else{
                if ($setting->logo_white != '') {
                    $arrAccess[] = true;
                }else{
                    $arrAccess[] = false;
                }
                
            }
        }

        if (!empty($_FILES['icon']['tmp_name'])) {
            $arrAccess[] = true;
        }else{
            if ($name_icon) {
                $arrAccess[] = true;
            }else{
                if ($setting->icon != '') {
                    $arrAccess[] = true;
                }else{
                    $arrAccess[] = false;
                }
                
            }
        }

        if (!empty($_FILES['icon_white']['tmp_name'])) {
            $arrAccess[] = true;
        }else{
            if ($name_icon_white) {
                $arrAccess[] = true;
            }else{
                if ($setting->icon_white != '') {
                    $arrAccess[] = true;
                }else{
                    $arrAccess[] = false;
                }
                
            }
        }

        if (in_array(true, $arrAccess)) {

            $post = [];
            // LOGO WARNA
            if (!empty($_FILES['logo']['tmp_name'])) {
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['logo'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['logo'] = $upload['data']['nama'];
                    if (file_exists($tujuan.$name_logo)) {
                        unlink($tujuan.$name_logo);
                    }
                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }else{
                if (!$name_logo) {
                    if ($setting->logo && file_exists($tujuan.$setting->logo)) {
                        unlink($tujuan.$setting->logo);
                    }
                    
                    $post['logo'] = '';
                }
            }


            // LOGO WHITE
            if (!empty($_FILES['logo_white']['tmp_name'])) {
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['logo_white'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['logo_white'] = $upload['data']['nama'];
                    if (file_exists($tujuan.$name_logo_white)) {
                            unlink($tujuan.$name_logo_white);
                        }
                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }else{
                if (!$name_logo_white) {
                    if ($setting->logo_white && file_exists($tujuan.$setting->logo_white)) {
                        unlink($tujuan.$setting->logo_white);
                    }
                    
                    $post['logo_white'] = '';
                }
            }

            // ICON WARNA

            $name_icon = $_POST['name_icon'] ?? '';
            if (!empty($_FILES['icon']['tmp_name'])) {
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['icon'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['icon'] = $upload['data']['nama'];
                    if (file_exists($tujuan.$name_icon)) {
                        unlink($tujuan.$name_icon);
                    }
                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }else{
                if (!$name_icon) {
                    if ($setting->icon && file_exists($tujuan.$setting->icon)) {
                        unlink($tujuan.$setting->icon);
                    }
                    
                    $post['icon'] = '';
                }
            }

            // ICON WHITE
            $name_icon_white = $_POST['name_icon_white'] ?? '';
            if (!empty($_FILES['icon_white']['tmp_name'])) {
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['icon_white'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['icon_white'] = $upload['data']['nama'];
                    if (file_exists($tujuan.$name_icon_white)) {
                        unlink($tujuan.$name_icon_white);
                    }
                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }else{
                if (!$name_icon_white) {
                    if ($setting->icon_white && file_exists($tujuan.$setting->icon_white)) {
                        unlink($tujuan.$setting->icon_white);
                    }
                    
                    $post['icon_white'] = '';
                }
            }

            if (count($post) > 0) {
                $update = $this->action->update('setting', $post, ['id_setting' => 1]);
                if ($update) {
                    $data['status'] = true;
                    $data['alert']['message'] = 'Data berhasil dirubah';
                    $data['reload'] = true;
                } else {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Data gagal dirubah';
                }
            }else{
                $data['status'] = false;
                $data['alert']['message'] = 'Tidak ada data di rubah';
            }
            
        } else {
            $data['status'] = false;
            $data['alert']['message'] = 'Tidak ada data di rubah';
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    // FUNCTION UPDATE PROFILE

    public function update()
    {
        // VARIABEL
        $arrVar['name']             = 'Nama lengkap';
        $arrVar['email']            = 'Alamat email';
        $arrVar['phone']           = 'Nomor telepon';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_'.$var,$value.' tidak boleh kosong!'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        $id_user = $this->id_user;

        $result = $this->action->get_single('user', ['id_user' => $id_user]);
        $password = $_POST['password'] ?? '';
        $new_password = $_POST['new_password'] ??'';
        $repassword = $_POST['repassword'] ??'';
        $name_image = $_POST['name_image'] ??'';

        if ($result->email != $email) {
            $cek_email = $this->action->get_single('user', ['email' => $email]);
            if ($cek_email) {
                $data['status'] = false;
                $data['alert']['message'] = 'Alamat email sudah terdaftar!';
                echo json_encode($data);
                exit;
            }      
        }
        if (!in_array(false, $arrAccess)) {
            $tujuan = './data/user/';
            if (!empty($_FILES['image']['tmp_name'])) {
                if (!file_exists('./data/')) {
                    mkdir('./data/');
                }
                if (!file_exists('./data/user/')) {
                    mkdir('./data/user/');
                }
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg');
                $config['file'] = $_FILES['image'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['image'] = $upload['data']['nama'];
                    $_SESSION[WEB_NAME.'_image'] = $upload['data']['nama'];
                    // if (file_exists($tujuan . $nama_image)) {
                    //     unlink($tujuan . $nama_image);
                    // }
                    

                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }
            if (!validasi_email($email)) {
                $data['status'] = false;
                $data['alert']['message'] = 'Alamat email tidak valid! ';
                echo json_encode($data);
                exit;
            }

            if ($result->phone != $phone) {
                $cek_phone = $this->action->get_single('user', ['phone' => $phone]);
                if ($cek_phone) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Nomor telepon telah terdaftar!';
                    echo json_encode($data);
                    exit;
                }
            }

            if ($password) {
                if (hash_my_password($password) == $result->password) {
                    if ($new_password != $repassword) {
                        $data['status'] = false;
                        $data['alert']['message'] = 'Konfirmasi kata sandi tidak valid!';
                        echo json_encode($data);
                        exit;
                    } else {
                        $post['password'] = hash_my_password($new_password);
                    }
                }else{
                    $data['status'] = false;
                    $data['alert']['message'] = 'Kata sandi tidak valid!';
                    echo json_encode($data);
                    exit;
                }
                
            }
            $update = $this->action->update('user', $post, ['id_user' => $id_user]);
            if ($update) {
                $_SESSION[WEB_NAME.'_name'] = $name;
                $_SESSION[WEB_NAME.'_email'] = $email;
                $_SESSION[WEB_NAME.'_phone'] = $phone;
                $data['status'] = true;
                $data['alert']['message'] = 'Data berhasil dirubah';
                $data['reload'] = true;
            } else {
                $data['status'] = false;
                 $data['alert']['message'] = 'Data gagal dirubah';
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }




    // FUNCTION UMUM
    public function switch($db = 'user')
    {
        $id = $_POST['id'];
        $action = $_POST['action'];
        $reason = $_POST['reason'] ?? '';
         $res = $this->action->get_single($db,['id_'.$db => $id]);
        if (!$res) {
             $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = 'Data '.$db.' tidak ditemukan';
            echo json_encode($data);
            exit;
        }
        $set['status'] = $action;
        if ($action == 'N') {
            $set['reason'] = $reason;
        } else {
            $set['reason'] = '';
        }
        // var_dump($db);var_dump($id);die;
        $update = $this->action->update($db, $set, ['id_'.$db => $id]);
        
        $alasan = '';
        if ($update) {
            $data['status'] = 200;
            $data['alert']['icon'] = 'success';
            if ($action == 'Y') {
                $data['alert']['message'] = 'Akses '.$db.' telah di aktifkan!';
            } else {
                if ($reason != '') {
                    $alasan .= ' Dengan alasan '.$reason;
                }
                $data['alert']['message'] = 'Akses '.$db.' telah di matikan!'.$alasan;
            }
        } else {
            $data['status'] = 500;
            $data['alert']['icon'] = 'warning';
            $data['alert']['message'] = $db.' gagal di update! Coba lagi setelah beberapa saat atau laporkan';
        }
        echo json_encode($data);
        exit;
    }

    public function drag($action = 'deleted',$db = 'user',$path = 'master|user')
    {
        $path = base64url_decode($path);
        $id = $_POST['id_batch'];
        $cek = $this->action->get_all($db,['id_'.$db => $id]);
        if (!$cek) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data '.$db.' tidak ditemukan';
            echo json_encode($data);
            exit;
        }
        if (!$id) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data '.$db.' belum terkait';
            echo json_encode($data);
            exit;
        }
        if ($action == 'block') {
            $no = 0;
            $set = [];
            foreach ($id as $value) {
                $num = $no++;
                $set[$num]['id_'.$db] = $value;
                $set[$num]['status'] = 'N';
                $set[$num]['block_by'] = $this->id_user;
                $set[$num]['block_date'] = date('Y-m-d H:i:s');
            }
            $block = $this->action->update_batch($db, $set, 'id_'.$db);
            if ($block) {
                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil mematikan akses pada sejumlah '.$db;
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url($path.' #reload_table',true);
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal mematikan akses pada sejumlah '.$db;
            }
        } elseif ($action == 'unblock') {
            $no = 0;
            $set = [];
            foreach ($id as $value) {
                $num = $no++;
                $set[$num]['id_'.$db] = $value;
                $set[$num]['status'] = 'Y';
                $set[$num]['block_by'] = NULL;
                $set[$num]['block_date'] = NULL;
            }
            $block = $this->action->update_batch($db, $set, 'id_'.$db);
            if ($block) {

                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil membuka akses sejumlah '.$db;
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url($path.' #reload_table',true);
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal membuka akses sejumlah '.$db;
            }
        } elseif ($action == 'deleted') {
            $ed = [];
            $no = 0;
            foreach ($id as $value) {
                $num = $no++;
                $ed[] = $value;
            }
            
            // var_dump($id);die;
            $delete = $this->action->delete($db,['id_'.$db => $ed]);
            if ($delete) {

                $data['status'] = 200;
                $data['alert']['message'] = 'Berhasil menghapus sejumlah '.$db;
                $data['load'][0]['parent'] = '#base_table';
                $data['load'][0]['reload'] = base_url($path.' #reload_table',true);
            } else {
                $data['status'] = 500;
                $data['alert']['message'] = 'Gagal menghapus sejumlah '.$db;
            }
        } else {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data aksi belum terkait';
        }
        echo json_encode($data);
        exit;
    }

    public function get_single($db = 'user')
    {
        $id = $_POST['id'];

        $result = $this->action->get_single($db, ['id_'.$db => $id]);
        echo json_encode($result);
        exit;
    }
    
    public function hapus_data()
    {
        $id = $_POST['id'] ?? '';
        $db = $_POST['db'] ?? '';
         $file = $_POST['file'] ?? '';
        $primary = $_POST['primary'] ?? "id_{$db}";
        $permanent = $_POST['permanent'];
        $reload = $_POST['reload'] ?? '';

        // Check if the table exists
        $cek = $this->db->tableExists($db);
        if (!$cek) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Database tidak ditemukan!';
            echo json_encode($data);
            exit;
        }

        if (!$id || !$db) {
            $data['status'] = 500;
            $data['alert']['message'] = 'permintaan tidak valid!';
            echo json_encode($data);
            exit;
        }

        // Check if the data exists
        $res = $this->action->get_single($db,[$primary => $id]);

        if (!$res) {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data tidak ditemukan!';
            echo json_encode($data);
            exit;
        }

        if ($permanent != 'none') {
            $aksi = $this->action->delete($db,[$primary => $id]);
        } else {
            $prefix = WEB_NAME;
            $idhps = $_SESSION[$prefix.'_id_user'];
            $set['delete'] = 'Y';
            $set['delete_date'] = date('Y-m-d H:i:s');
            $set['delete_by']  =$idhps;

            $aksi = $this->action->update($db,$set,[$primary => $id]);
        }

        if ($aksi) {
            if (isset($file) && $file != '') {
                unlink($file);
            }
            $data['status'] = 200;
            $data['alert']['message'] = 'Data berhasil dihapus!';
            if ($reload) {
                $data['reload'] = $reload;
            }
            echo json_encode($data);
            exit;
        } else {
            $data['status'] = 500;
            $data['alert']['message'] = 'Data gagal dihapus!';
            echo json_encode($data);
            exit;
        }
    }

}

