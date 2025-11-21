<?php

class Master extends AdminController
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
        redirect('master/admin');
    }


    public function admin(){
        $data = [];
        // GLBL
        $data['title'] = 'Master Admin';
        $data['subtitle'] = 'Manajemen akun admin';

        // LOAD JS
        $data['js'][] = '<script>var page = "master/admin"</script>';
        $data['js'][] = '<script src="'.assets_url('admin/js/modul/master/admin.js').'"></script>';

        // DISPLAY
        $this->display('master/admin',$data);
    }

    public function product(){
        $data = [];
        // GLBL
        $data['title'] = 'Master Produk';
        $data['subtitle'] = 'Manajemen produk';

        // LOAD JS
        $data['js'][] = '<script>var page = "master/product"</script>';
        $data['js'][] = '<script src="'.assets_url('admin/js/modul/master/product.js').'"></script>';

        // GET DATA
        $category = $this->action->get_all('category',['status' => 'Y','delete' => 'N']);
        
        // SET DATA
        $data['category'] = $category;


        // DISPLAY
        $this->display('master/product',$data);
    }

    public function category(){
        $data = [];
        // GLBL
        $data['title'] = 'Master Kategori';
        $data['subtitle'] = 'Manajemen data kategori';

        // LOAD JS
        $data['js'][] = '<script>var page = "master/category"</script>';
        $data['js'][] = '<script src="'.assets_url('admin/js/modul/master/category.js').'"></script>';

        // DISPLAY
        $this->display('master/category',$data);
    }



    // FUNCTION USER
    public function tambah($page = 'member')
    {
        // VARIABEL
        $arrVar['name']             = 'Nama user';
        $arrVar['phone']           = 'Nomor telepon';
        $arrVar['email']           = 'Alamat email';
        $arrVar['id_role']         = 'Role';
        $arrVar['password']         = 'Kata sandi';
        $arrVar['repassword']       = 'Konfirmasi kata sandi ';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                if (!in_array($var, ['password', 'repassword'])) {
                    $post[$var] = trim($$var);
                    $arrAccess[] = true;
                }
            }
        }
        if (!in_array(false, $arrAccess)) {
            if (!empty($_FILES['image']['tmp_name'])) {
                $tujuan = './data/user/';
                if (!file_exists('./data/')) {
                    mkdir('./data');
                }
                if (!file_exists('./data/user/')) {
                    mkdir('./data/user');
                }
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['image'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['image'] = $upload['data']['nama'];

                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }
            if (!validasi_email($email)) {
                $data['status'] = 700;
                $data['alert']['message'] = 'Email tidak valid! Silahkan cek dan coba lagi.';
                echo json_encode($data);
                exit;
            }
            $user_mail = $this->action->get_single('user', ['email' => $email]);
            if ($user_mail) {
                $data['status'] = false;
                $data['alert']['message'] = 'Email sudah terdaftar sebagai user!';
                echo json_encode($data);
                exit;
            }else{
                $user_mail = $this->action->get_single('user', ['email' => $email]);
                if ($user_mail) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Email sudah terdaftar sebagai member!';
                    echo json_encode($data);
                    exit;
                }
            }
             $user_telp = $this->action->get_single('user', ['phone' => $phone]);
            if ($user_telp) {
                $data['status'] = false;
                $data['alert']['message'] = 'Nomor telepon sudah terdaftar!';
                echo json_encode($data);
                exit;
            }

            if ($password != $repassword) {
                $data['status'] = false;
                $data['alert']['message'] = 'Konfirmasi password tidak sesuai!';
                echo json_encode($data);
                exit;
            } else {
                $post['password'] = hash_my_password($email . $password);
            }
            if ($this->id_user) {
                $post['create_by'] = $this->id_user;
            }
            
            $insert = $this->action->insert('user', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data '.$page.' berhasil di tambahkan!';
                $data['datatable'] = 'table_'.$page;
                $data['modal']['id'] = '#kt_modal_'.$page;
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function update($page = 'member')
    {
        // VARIABEL
        $arrVar['id_user']          = 'Id user';
        $arrVar['id_role'] = 'Role';
        $arrVar['name']             = 'Nama user';
        $arrVar['phone']           = 'Nomor telepon';
        $arrVar['email']            = 'Alamat email';
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var];
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        $result = $this->action->get_single('user', ['id_user' => $id_user]);
        $password = $_POST['password'] ?? '';
        $repassword = $_POST['repassword'] ?? '';
        $name_image = $_POST['name_image'] ?? '';
        $tujuan = './data/user/';
        if ($result->email != $email) {
            if (!validasi_email($email)) {
                $data['status'] = 700;
                $data['alert']['message'] = 'Email tidak valid! Silahkan cek dan coba lagi.';
                echo json_encode($data);
                exit;
            }
            $user_mail = $this->action->get_single('user', ['email' => $email,'id_user !=' => $id_user]);
            if ($user_mail) {
                $data['status'] = false;
                $data['alert']['message'] = 'Email sudah terdaftar sebagai user!';
                echo json_encode($data);
                exit;
            }else{
                $user_mail = $this->action->get_single('user', ['email' => $email]);
                if ($user_mail) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Email sudah terdaftar sebagai user!';
                    echo json_encode($data);
                    exit;
                }
            } 
            if (!$password) {
                $data['required'][] = ['req_password', 'Kata sandi tidak boleh kosong ! Karena email berubah'];
                $arrAccess[] = false;
            } 
            if (!$repassword) {
                $data['required'][] = ['req_repassword', 'Konfirmasi kata sandi tidak boleh kosong ! Karena email berubah'];
                $arrAccess[] = false;
            }   
             
        }
        if (!in_array(false, $arrAccess)) {
            if ($result->phone != $phone) {
                $cek_phone = $this->action->get_single('user', ['phone' => $phone,'id_user !=' => $id_user]);
                if ($cek_phone) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Nomor telepon sudah terdaftar!';
                    echo json_encode($data);
                    exit;
                }      
            }

            if ($password) {
                if ($password != $repassword) {
                    $data['status'] = false;
                    $data['alert']['message'] = 'Konfirmasi password tidak sesuai!';
                    echo json_encode($data);
                    exit;
                } else {
                    $post['password'] = hash_my_password($email . $password);
                }
            } 

            if (!empty($_FILES['image']['tmp_name'])) {
                if (!file_exists('./data/')) {
                    mkdir('./data');
                }
                if (!file_exists('./data/user/')) {
                    mkdir('./data/user');
                }
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['image'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['image'] = $upload['data']['nama'];
                    if ($name_image) {
                        if (file_exists($tujuan.$name_image)) {
                            unlink($tujuan.$name_image);
                        }
                    }
                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }else{
                 if (!$name_image) {
                    if ($result->image != '' && file_exists($tujuan.$result->image)) {
                        unlink($tujuan.$result->image);
                    }
                    $post['image'] = '';
                }
            }
            
            $update = $this->action->update('user', $post, ['id_user' => $id_user]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data '.$page.' berhasil di rubah!';
                $data['datatable'] = 'table_'.$page;
                $data['modal']['id'] = '#kt_modal_'.$page;
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }



    // FUNCTION CATEGORY
    public function insert_category()
    {
        // VARIABEL
        $arrVar['name']             = 'Nama kategori';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        if (!in_array(false, $arrAccess)) {
            if ($this->id_user) {
                $post['create_by'] = $this->id_user;
            }
            
            $insert = $this->action->insert('category', $post);
            if ($insert) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data kategori berhasil di tambahkan!';
                $data['datatable'] = 'table_category';
                $data['modal']['id'] = '#kt_modal_category';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function update_category()
    {
        // VARIABEL
        $arrVar['id_category']          = 'Id category';
        $arrVar['name']             = 'Nama kategori';
        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var];
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                $post[$var] = trim($$var);
                $arrAccess[] = true;
            }
        }
        $result = $this->action->get_single('category', ['id_category' => $id_category]);
        if (!in_array(false, $arrAccess)) {
            
            $update = $this->action->update('category', $post, ['id_category' => $id_category]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data kategori berhasil di rubah!';
                $data['datatable'] = 'table_category';
                $data['modal']['id'] = '#kt_modal_category';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }


    // FUNCTION product
    public function insert_product()
    {
        // VARIABEL
        $arrVar['title']                 = 'Judul produk';
        $arrVar['id_category']           = 'Kategori';
        $arrVar['price']     = 'Harga';
        $arrVar['stock']     = 'Stok';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                if ($$var === '') {
                    $data['required'][] = ['req_' . $var, $value." tidak boleh kosong!"];
                    $arrAccess[] = false;
                } else {
                    if (!in_array($var,['stock'])) {
                        $post[$var] = $$var;
                    }
                    $arrAccess[] = true;
                }
            }
        }
        if (!in_array(false, $arrAccess)) {
            if (!empty($_FILES['image']['tmp_name'])) {
                $tujuan = './data/product/';
                if (!file_exists('./data/')) {
                    mkdir('./data');
                }
                if (!file_exists('./data/product/')) {
                    mkdir('./data/product');
                }
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['image'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['image'] = $upload['data']['nama'];

                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }else{
                $data['status'] = false;
                $data['alert']['message'] ='Gambar tidak boleh kosong!';
                echo json_encode($data);
                exit;
            }
            
            if ($stock <= 0) {
                $data['status'] = false;
                $data['alert']['message'] ='Stok tidak boleh kurang dari 0!';
                echo json_encode($data);
                exit;
            }
            if ($this->id_user) {
                $post['create_by'] = $this->id_user;
            }
            
            $insert = $this->action->insert('product', $post);
            if ($insert) {
                if ($stock > 0) {
                    $in['qty'] = $stock;
                    $in['id_product'] = $insert;
                    $this->action->insert('stock',$in);
                }
                $data['status'] = true;
                $data['alert']['message'] = 'Data produk berhasil di tambahkan!';
                $data['datatable'] = 'table_product';
                $data['modal']['id'] = '#kt_modal_product';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function insert_stock()
    {
        // VARIABEL
        $arrVar['id_product']           = 'Product';
        $arrVar['qty']     = 'Stok';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_add_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                if ($$var === '') {
                    $data['required'][] = ['req_add_' . $var, $value." tidak boleh kosong!"];
                    $arrAccess[] = false;
                } else {
                    $post[$var] = $$var;
                    $arrAccess[] = true;
                }
            }
        }
        if (!in_array(false, $arrAccess)) {
            
            if ($qty <= 0) {
                $data['status'] = false;
                $data['alert']['message'] ='Stok tidak boleh kurang dari 0!';
                echo json_encode($data);
                exit;
            }
            $insert = $this->action->insert('stock', $post);
            if ($insert) {
                $table = '<tr>';
                $table .= '<td>'.date('d M Y H:i').'</td>';
                $table .= '<td>'.$qty.' Item</td>';
                $table .= '</tr>';
                $data['status'] = true;
                $data['alert']['message'] = 'Data stock berhasil di tambahkan!';
                $data['datatable'] = 'table_product';
                $data['input']['all'] = true;
                $data['tumpuk_bawah'][0]['parent'] = '#display_list_stock';
                $data['tumpuk_bawah'][0]['value'] = $table;
                $data['add_class'][0]['target'] = '#no_stock';
                $data['add_class'][0]['class'] = 'd-none';
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function update_product()
    {
        // VARIABEL
        $arrVar['id_product']                 = 'ID product';
        $arrVar['title']                 = 'Judul produk';
        $arrVar['id_category']           = 'Kategori';
        $arrVar['price']     = 'Harga';

        // INFORMASI UMUM
        foreach ($arrVar as $var => $value) {
            $$var = $_POST[$var] ?? '';
            if (!$$var) {
                $data['required'][] = ['req_' . $var, $value . ' tidak boleh kosong !'];
                $arrAccess[] = false;
            } else {
                if ($$var === '') {
                    $data['required'][] = ['req_' . $var, $value." tidak boleh kosong!"];
                    $arrAccess[] = false;
                } else {
                    $post[$var] = $$var;
                    $arrAccess[] = true;
                }
            }
        }
        $result = $this->action->get_single('product', ['id_product' => $id_product]);
        $name_image = $_POST['name_image'] ?? '';
        $tujuan = './data/product/';
        if (!in_array(false, $arrAccess)) {

            if (!empty($_FILES['image']['tmp_name'])) {
                if (!file_exists('./data/')) {
                    mkdir('./data');
                }
                if (!file_exists('./data/product/')) {
                    mkdir('./data/product');
                }
                $config['upload_path'] = $tujuan;
                $config['allowed_types'] = array('png','jpg','jpeg','PNG','JPEG','JPG');
                $config['file'] = $_FILES['image'];

                $upload = upload_file($config);
                if ($upload['status'] == true) {
                    $post['image'] = $upload['data']['nama'];
                    if ($name_image) {
                        if (file_exists($tujuan.$name_image)) {
                            unlink($tujuan.$name_image);
                        }
                    }
                } else {
                
                    $data['status'] = false;
                    $data['alert']['message'] = $upload['message'];
                    echo json_encode($data);
                    exit;
                }
            }else{
                if (!$name_image) {
                    $data['status'] = false;
                    $data['alert']['message'] ='Gambar tidak boleh kosong!';
                    echo json_encode($data);
                    exit;
                }else{
                    if ($result->image == '' || !file_exists($tujuan.$result->image)) {
                        $data['status'] = false;
                        $data['alert']['message'] ='Gambar tidak boleh kosong!';
                        echo json_encode($data);
                        exit;
                    }
                }
            }
            
            $update = $this->action->update('product', $post, ['id_product' => $id_product]);
            if ($update) {
                $data['status'] = true;
                $data['alert']['message'] = 'Data produk berhasil di rubah!';
                $data['datatable'] = 'table_product';
                $data['modal']['id'] = '#kt_modal_product';
                $data['modal']['action'] = 'hide';
                $data['input']['all'] = true;
            } else {
                $data['status'] = false;
            }
        } else {
            $data['status'] = false;
        }
        sleep(1.5);
        echo json_encode($data);
        exit;
    }

    public function get_stock()
    {
        $id = $_POST['id'] ?? 0;
        $result = $this->action->get_all('stock',['id_product' => $id]);
        $table = '';
        if ($result) {
            foreach ($result as $row) {
                $table .= '<tr>';
                $table .= '<td>'.date('d M Y H:i',strtotime($row->create_date)).'</td>';
                $table .= '<td>'.$row->qty.' Item</td>';
                $table .= '</tr>';
            }
        }else{
            $table .= '<tr id="no_stock">';
            $table .= '<td colspan="2"><center>Tidak ada riwayat stok<center></td>';
            $table .= '</tr>';
        }

        $data['table'] = $table;
        echo json_encode($data);
        exit;
    }
}

