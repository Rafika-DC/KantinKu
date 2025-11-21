<?php

class Table extends AdminController
{
   var $id_user = '';
   public function __construct()
   {
      $this->action = $this->model('M_action');
      $this->id_user = session(WEB_NAME.'_id_user');
      $this->db = new Database;
   }


    public function admin()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $filter_status = $_POST['filter_status'] ?? '';

        $id_user = $this->id_user;

        $where = [];
        $params = [];
        $columns = [
            null,
            'user.name',
            'user.phone',
            'user.status'
        ];

        if ($search) {
            $params['columnsearch'][] = 'user.name';
            $params['columnsearch'][] = 'user.email';
            $params['columnsearch'][] = 'user.phone';
            $params['search'] = $search;
        }

        $where['user.delete'] = 'N';
        $where['user.id_role'] = 1;
        $where['user.id_user !='] = $this->id_user;
        // $where['user.id_user !='] = $this->id_user;

        if ($filter_status !== null && $filter_status !== '') {
            if ($filter_status != 'all') {
                $where['status'] = $filter_status;
            }
        }

        $totalRecords = $this->action->cnt_where_params('user', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $kolom = 'user.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        // Ambil data
        $result = $this->action->get_where_params('user',$where,'*',$params);

        $html = [];
        if ($result) {
            foreach ($result as $item) {
                $image = image_check($item->image, 'user', 'user');

                $user = '<div class="d-flex align-items-center">';
                $user .= '<a role="button" class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$image.');"></span></a>';
                $user .= '<div class="ms-5">';
                $user .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">'.$item->name.'</a>';
                $user .= '</div></div>';

                $kontak = '';
                if ($item->email || $item->phone){
                    $kontak .= '<div class="d-flex justify-content-start flex-column">';
                    if ($item->email) {
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-envelope" style="margin-right : 10px;"></i>'.$item->email.'</span>';
                    }
                    if ($item->phone){
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-phone" style="margin-right : 10px;"></i>'.$item->phone.'</span>';
                    }
                    $kontak .= '</div>';
                }else{
                    $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"> - </span>';
                }

                $checked = ($item->status == 'Y') ? 'checked' : '';
                $status = '<div class="d-flex justify-content-center align-items-center">';
                $status .= '<div class="form-check form-switch">';
                $status .= '<input onchange="switching(this,event,'.$item->id_user.')" data-url="'.base_url('setting/switch/user',true).'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_user.'" '.$checked.'>';
                $status .= '</div></div>';

                $fl = '';
                if ($item->image && file_exists('./data/user/'.$item->image)) {
                    $fl = './data/user/'.$item->image;
                }
                
                $action = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_user.')" data-image="'.$image.'" data-bs-toggle="modal" data-bs-target="#kt_modal_admin">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_user.',`user`,`id_user`,`'.$fl.'`)" data-datatable="table_admin" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

                $html[] = [
                    $user,
                    $kontak,
                    $status,
                    $action
                ];
            }
        }
       

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }


    public function member()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $filter_status = $_POST['filter_status'] ?? '';

        $id_user = $this->id_user;

        $where = [];
        $params = [];
        $columns = [
            null,
            'user.name',
            'user.phone',
            'user.status'
        ];

        if ($search) {
            $params['columnsearch'][] = 'user.name';
            $params['columnsearch'][] = 'user.email';
            $params['columnsearch'][] = 'user.phone';
            $params['search'] = $search;
        }

        $where['user.delete'] = 'N';
        $where['user.id_role'] = 2;
        $where['user.id_user !='] = $this->id_user;
        // $where['user.id_user !='] = $this->id_user;

        if ($filter_status !== null && $filter_status !== '') {
            if ($filter_status != 'all') {
                $where['status'] = $filter_status;
            }
        }

        $totalRecords = $this->action->cnt_where_params('user', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $kolom = 'user.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        // Ambil data
        $result = $this->action->get_where_params('user',$where,'*',$params);

        $html = [];
        if ($result) {
            foreach ($result as $item) {
                $image = image_check($item->image, 'user', 'user');

                $user = '<div class="d-flex align-items-center">';
                $user .= '<a role="button" class="symbol symbol-50px"><span class="symbol-label" style="background-image:url('.$image.');"></span></a>';
                $user .= '<div class="ms-5">';
                $user .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">'.$item->name.'</a>';
                $user .= '</div></div>';

                $kontak = '';
                if ($item->email || $item->phone){
                    $kontak .= '<div class="d-flex justify-content-start flex-column">';
                    if ($item->email) {
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-envelope" style="margin-right : 10px;"></i>'.$item->email.'</span>';
                    }
                    if ($item->phone){
                        $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"><i class="fa-solid fa-phone" style="margin-right : 10px;"></i>'.$item->phone.'</span>';
                    }
                    $kontak .= '</div>';
                }else{
                    $kontak .= '<span class="text-dark fw-bold text-hover-primary d-block fs-6"> - </span>';
                }

                $checked = ($item->status == 'Y') ? 'checked' : '';
                $status = '<div class="d-flex justify-content-center align-items-center">';
                $status .= '<div class="form-check form-switch">';
                $status .= '<input onchange="switching(this,event,'.$item->id_user.')" data-url="'.base_url('setting/switch/user',true).'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_user.'" '.$checked.'>';
                $status .= '</div></div>';

                $fl = '';
                if ($item->image && file_exists('./data/user/'.$item->image)) {
                    $fl = './data/user/'.$item->image;
                }
                
                $action = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_user.')" data-image="'.$image.'" data-bs-toggle="modal" data-bs-target="#kt_modal_member">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_user.',`user`,`id_user`,`'.$fl.'`)" data-datatable="table_member" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

                $html[] = [
                    $user,
                    $kontak,
                    $status,
                    $action
                ];
            }
        }
       

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }

    public function category()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $filter_status = $_POST['filter_status'] ?? '';

        $id_user = $this->id_user;

        $where = [];
        $params = [];
        $columns = [
            null,
            'category.name',
        ];

        if ($search) {
            $params['columnsearch'][] = 'category.name';
            $params['search'] = $search;
        }

        $where['category.delete'] = 'N';

        if ($filter_status !== null && $filter_status !== '') {
            if ($filter_status != 'all') {
                $where['status'] = $filter_status;
            }
        }

        $totalRecords = $this->action->cnt_where_params('category', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $kolom = 'category.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        // Ambil data
        $result = $this->action->get_where_params('category',$where,'*',$params);

        $html = [];
        if ($result) {
            foreach ($result as $item) {
                $category = '<div class="d-flex align-items-center">';
                $category .= '<div class="ms-5">';
                $category .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">'.$item->name.'</a>';
                $category .= '</div></div>';


                $checked = ($item->status == 'Y') ? 'checked' : '';
                $status = '<div class="d-flex justify-content-center align-items-center">';
                $status .= '<div class="form-check form-switch">';
                $status .= '<input onchange="switching(this,event,'.$item->id_category.')" data-url="'.base_url('setting/switch/category',true).'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_category.'" '.$checked.'>';
                $status .= '</div></div>';

                
                $action = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_category.')" data-bs-toggle="modal" data-bs-target="#kt_modal_category">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_category.',`category`,`id_category`)" data-message="Seluruh data produk yang terkait dengan kategori ini akan ikut di hapus! Apakah anda yakin akan menghapus kategori ini?" data-datatable="table_category" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

                $html[] = [
                    $category,
                    $status,
                    $action
                ];
            }
        }
       

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }

    public function product()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $filter_status = $_POST['filter_status'] ?? '';
        $filter_category = $_POST['filter_category'] ?? '';

        $id_user = $this->id_user;

        $where = [];
        $params = [];
        $columns = [
            null,
            null,
            'product.title',
            'category.name',
            'product.price',
            'sisa_stock',
            'cnt_trx',
            'product.status'
        ];

        if ($search) {
            $params['columnsearch'][] = 'product.title';
            $params['columnsearch'][] = 'category.name';
            $params['columnsearch'][] = 'product.short_description';
            $params['search'] = $search;
        }

        $where['product.delete'] = 'N';

        if ($filter_status !== null && $filter_status !== '') {
            if ($filter_status != 'all') {
                $where['product.status'] = $filter_status;
            }
        }
        if ($filter_category !== null && $filter_category !== '') {
            if ($filter_category != 'all') {
                $where['product.id_category'] = $filter_category;
            }
        }

        $totalRecords = $this->action->cnt_where_params('product', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }

        $kolom = 'product.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        $params['arrjoin']['category']['statement'] = 'category.id_category = product.id_category';
        $params['arrjoin']['category']['type'] = 'LEFT';

        // SELECT yang sudah diperbaiki
        $select = 'product.*, 
            category.name AS category, 
            category.color,
            (SELECT IFNULL(SUM(qty),0) FROM transaction_detail WHERE transaction_detail.id_product = product.id_product) AS cnt_trx,
            (SELECT IFNULL(SUM(qty),0) FROM stock WHERE stock.id_product = product.id_product) AS cnt_stock,
            ((SELECT IFNULL(SUM(qty),0) FROM stock WHERE stock.id_product = product.id_product) -
            (SELECT IFNULL(SUM(qty),0) FROM transaction_detail WHERE transaction_detail.id_product = product.id_product)) AS sisa_stock';

        // Ambil data
        $result = $this->action->get_where_params('product', $where, $select, $params);

        $html = [];
        if ($result) {
            foreach ($result as $item) {
                $image = image_check($item->image, 'product');

                $img = '<div class="d-flex align-items-center">';
                $img .= '<a role="button" class="symbol symbol-100px"><span class="symbol-label" style="background-image:url('.$image.');"></span></a>';
                $img .= '</div>';

                $product = '<div class="d-flex align-items-center">';
                $product .= '<div>';
                $product .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">'.$item->title.'</a>';
                $product .= '</div></div>';

                $cat = '<span class="badge" style="background-color : '.$item->color.'">'.$item->category.'</span>';

                $checked = ($item->status == 'Y') ? 'checked' : '';
                $status = '<div class="d-flex justify-content-center align-items-center">';
                $status .= '<div class="form-check form-switch">';
                $status .= '<input onchange="switching(this,event,'.$item->id_product.')" data-url="'.base_url('setting/switch/product',true).'" class="form-check-input cursor-pointer focus-info" type="checkbox" role="switch" id="switch-'.$item->id_product.'" '.$checked.'>';
                $status .= '</div></div>';

                $fl = '';
                if ($item->image && file_exists('./data/product/'.$item->image)) {
                    $fl = './data/product/'.$item->image;
                }

                $action = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" class="btn btn-icon btn-info btn-sm me-1" title="Stock" onclick="tambah_stock(this,'.$item->id_product.')" data-name="'.$item->title.'" data-bs-toggle="modal" data-bs-target="#kt_modal_stock">
                                <i class="ki-outline ki-plus fs-2"></i>
                            </button>
                            <button type="button" class="btn btn-icon btn-warning btn-sm me-1" title="Update" onclick="ubah_data(this,'.$item->id_product.')" data-image="'.$image.'" data-bs-toggle="modal" data-bs-target="#kt_modal_product">
                                <i class="ki-outline ki-pencil fs-2"></i>
                            </button>
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_product.',`product`,`id_product`,`'.$fl.'`)" data-datatable="table_product" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

                $buying = $item->cnt_trx ?? 0;
                $stock = $item->sisa_stock ?? 0;
                if ($stock < 0) {
                    $stock = 0;
                }

                $html[] = [
                    $img,
                    $product,
                    $cat,
                    'Rp. '.number_format($item->price,0,',','.'),
                    '<span class="badge badge-info">'.number_format($stock,0,',','.').' Item</span>',
                    '<span class="badge badge-primary">'.number_format($buying,0,',','.').' Pembelian</span>',
                    $status,
                    $action
                ];
            }
        }

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }


    public function contact()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $filter_status = $_POST['filter_status'] ?? '';

        $id_user = $this->id_user;

        $where = [];
        $params = [];
        $columns = [
            null,
            'contact.first_name',
            'contact.last_name',
            'contact.email',
            'contact.description',
        ];

        if ($search) {
            $params['columnsearch'][] = 'contact.first_name';
            $params['columnsearch'][] = 'contact.last_name';
            $params['columnsearch'][] = 'contact.email';
            $params['columnsearch'][] = 'contact.description';
            $params['search'] = $search;
        }

        $totalRecords = $this->action->cnt_where_params('contact', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $kolom = 'contact.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        // Ambil data
        $result = $this->action->get_where_params('contact',$where,'*',$params);

        $html = [];
        if ($result) {
            foreach ($result as $item) {
                
                $action = '<div class="d-flex justify-content-end flex-shrink-0">
                            <button type="button" onclick="hapus_data(this,event,'.$item->id_contact.',`contact`,`id_contact`)" data-message="Seluruh data produk yang terkait dengan kategori ini akan ikut di hapus! Apakah anda yakin akan menghapus kategori ini?" data-datatable="table_contact" class="btn btn-icon btn-danger btn-sm" title="Delete">
                                <i class="ki-outline ki-trash fs-2"></i>
                            </button>
                        </div>';

                $html[] = [
                    $item->first_name,
                    $item->last_name,
                    $item->email,
                    $item->description,
                    $action
                ];
            }
        }
       

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }

    public function transaction()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $firstDate = date('Y-m-01');
        $lastDate = date('Y-m-t');
        $filter_start_date = $_POST['filter_start_date'] ?? $firstDate;
        $filter_end_date = $_POST['filter_end_date'] ?? $lastDate;


        $where = [];
        $params = [];
        $columns = [
            null,
            'transaction.create_date',
            'user.name',
            null,
            null,
            null,
            'transaction.total'
        ];
        

        if ($search) {
            $params['columnsearch'][] = 'transaction.total';
            $params['columnsearch'][] = 'user.name';
            $params['search'] = $search;
        }

        if ($filter_start_date !== null && $filter_start_date !== '') {
            $where['DATE(transaction.create_date) >= '] = $filter_start_date;
        }
        if ($filter_end_date !== null && $filter_end_date !== '') {
            $where['DATE(transaction.create_date) <= '] = $filter_end_date;
        }

        $params['arrjoin']['user']['statement'] = 'user.id_user = transaction.create_by';
        $params['arrjoin']['user']['type'] = 'LEFT';
        $totalRecords = $this->action->cnt_where_params('transaction', $where, $params);

        $params['limit'] = $limit;
        if ($offset) {
            $params['offset'] = $offset;
        }
        $kolom = 'transaction.create_date';
        $odr = 'DESC';

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $kolom = $columns[$orderColumn];
            $odr = $orderDir;
        }

        $params['sort'] = $kolom;
        $params['order'] = $odr;

        // Ambil data
        $result = $this->action->get_where_params('transaction',$where,'transaction.*,user.name,user.email,user.image',$params);

        $params2['arrjoin']['product']['statement'] = 'product.id_product = transaction_detail.id_product';
        $params2['arrjoin']['product']['type'] = 'LEFT';
        $params2['sort'] = 'id_transaction';
        $params2['order'] = 'ASC';
        $td = $this->action->get_where_params('transaction_detail',[],'transaction_detail.*,product.title as product',$params2);
        $list = [];
        if ($td) {
            $id_td = 0;
            $no = 0;
            foreach ($td as $key) {
                if ($id_td != $key->id_transaction) {
                    $id_td = $key->id_transaction;
                    $no = 0;
                }
                $num = $no++;
                $list[$id_td][$num]['id_product'] = $key->id_product; 
                $list[$id_td][$num]['product'] = $key->product; 
                $list[$id_td][$num]['price'] = $key->price;
                $list[$id_td][$num]['qty'] = $key->qty;
                $list[$id_td][$num]['total'] = $key->total; 
            }
        }

        $html = [];
        if ($result) {
            foreach ($result as $item) {

                $image = image_check($item->image, 'user','user');

                $user = '<div class="d-flex align-items-center">';
                $user .= '<a role="button" class="symbol symbol-80px cursor-pointer" onclick="preview_image(this,`'.$image.'`)"><span class="symbol-label" style="background-image:url('.$image.');"></span></a>';
                $user .= '<div class="ms-5 d-flex flex-column">';
                $user .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">'.$item->name.'</a>';
                $user .= '<a role="button" class="text-primary fs-6">'.$item->email.'</a>';
                $user .= '</div></div>';


                $product = '';
                if (isset($list[$item->id_transaction])) {
                    $product .= '<div class="d-flex flex-column text-gray-600">';
                    foreach ($list[$item->id_transaction] as $key) {
                        $product .= '<div class="d-flex align-items-center py-2"><span class="bullet bg-primary me-3"></span>' . $key['product'] . ' x '.$key['qty'].'</div>';
                    }
                    $product .= '</div>';
                }
                $price = '';
                if (isset($list[$item->id_transaction])) {
                    $price .= '<div class="d-flex flex-column text-gray-600">';
                    foreach ($list[$item->id_transaction] as $key) {
                        $price .= '<div class="d-flex align-items-center py-2"><span class="bullet bg-primary me-3"></span>Rp. ' . number_format($key['price'],0,',','.') . '</div>';
                    }
                    $price .= '</div>';
                }

                $total = '';
                if (isset($list[$item->id_transaction])) {
                    $total .= '<div class="d-flex flex-column text-gray-600">';
                    foreach ($list[$item->id_transaction] as $key) {
                        $total .= '<div class="d-flex align-items-center py-2"><span class="bullet bg-primary me-3"></span>Rp. ' . number_format($key['total'],0,',','.') . '</div>';
                    }
                    $total .= '</div>';
                }

                $html[] = [
                    date('d M Y H:i',strtotime($item->create_date)),
                    $user,
                    $product,
                    $price,
                    $total,
                    'Rp. '.number_format($item->total,0,',','.')
                ];
            }
        }
       

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }

    public function ma()
    {
        $search = $_POST['search']['value'] ?? '';
        $offset = (int)($_POST['start'] ?? 0);
        $limit = (int)($_POST['length'] ?? 10);
        $orderColumn = $_POST['order'][0]['column'] ?? null;
        $orderDir = $_POST['order'][0]['dir'] ?? 'asc';
        $draw = (int)($_POST['draw'] ?? 1);
        $id_product = $_POST['id_product'] ?? 0;

        $where = ['transaction_detail.id_product' => $id_product];

        $params = [];
        $columns = [
            null,
            'transaction.create_date',
            'product.title',
            'total_qty',
            'ma',
            'forecast',
            'stock_qty'
        ];

        if ($search) {
            $params['columnsearch'] = ['product.title', 'category.name'];
            $params['search'] = $search;
        }

        $params['arrjoin'] = [
            'product' => [
                'statement' => 'product.id_product = transaction_detail.id_product',
                'type' => 'LEFT'
            ],
            'category' => [
                'statement' => 'category.id_category = product.id_category',
                'type' => 'LEFT'
            ],
            'transaction' => [
                'statement' => 'transaction.id_transaction = transaction_detail.id_transaction',
                'type' => 'LEFT'
            ]
        ];

        $dateFrom = date('Y-m-d', strtotime('-2 days'));
        $params['where']['DATE(transaction.create_date) >='] = $dateFrom;

        $params['groupby'] = 'DATE(transaction.create_date), product.title, product.image, category.name';

        $select = '
            DATE(transaction.create_date) as create_date,
            product.title,
            product.image,
            category.name AS category_name,
            transaction_detail.id_product,
            SUM(transaction_detail.qty) AS total_qty
        ';

        $result = $this->action->get_where_params('transaction_detail', $where, $select, $params);

        $grouped = [];
        foreach ($result as $row) {
            $grouped[$row->title][] = $row;
        }

        $stk = $this->action->get_single('stock', ['id_product' => $id_product], 'SUM(qty) as total');
        $totalStock = $stk ? $stk->total : 0;

        $trx = $this->action->get_single('transaction_detail', ['id_product' => $id_product], 'SUM(qty) as total');
        $totalTransaction = $trx ? $trx->total : 0;

        $sisaStock = $totalStock - $totalTransaction;

        $finalResult = [];
        foreach ($grouped as $productName => $rows) {
            usort($rows, fn($a, $b) => strtotime($a->create_date) <=> strtotime($b->create_date));
            $qtyList = array_column($rows, 'total_qty');
            $maList = moving_average($qtyList, 3);
            $forecast = count($qtyList) >= 3 ? array_sum(array_slice($qtyList, -3)) / 3 : null;

            $stockMenurun = $sisaStock;

            foreach ($rows as $i => $r) {
                $r->ma = $maList[$i] ?? null;
                $r->forecast = $i === count($rows) - 1 ? $forecast : null;

                $r->stock_qty = max(0, $stockMenurun);
                $stockMenurun -= $r->total_qty;

                $finalResult[] = $r;
            }
        }

        if ($orderColumn !== null && isset($columns[$orderColumn])) {
            $col = $columns[$orderColumn];
            usort($finalResult, function ($a, $b) use ($col, $orderDir) {
                $valA = $a->$col ?? 0;
                $valB = $b->$col ?? 0;
                return $orderDir === 'asc' ? $valA <=> $valB : $valB <=> $valA;
            });
        }

        $totalRecords = count($finalResult);
        $pagedResult = array_slice($finalResult, $offset, $limit);

        $html = [];
        foreach ($pagedResult as $item) {
            $image = image_check($item->image, 'product');

            $product = '<div class="d-flex align-items-center">';
            $product .= '<a role="button" class="symbol symbol-80px cursor-pointer" onclick="preview_image(this,' . $image . ')">';
            $product .= '<span class="symbol-label" style="background-image:url(' . $image . ');"></span></a>';
            $product .= '<div class="ms-5 d-flex flex-column">';
            $product .= '<a role="button" class="text-gray-800 text-hover-primary fs-5 fw-bold">' . $item->title . '</a>';
            $product .= '<a role="button" class="text-primary fs-6">' . $item->category_name . '</a>';
            $product .= '</div></div>';

            $html[] = [
                date('d M Y', strtotime($item->create_date)),
                $product,
                number_format($item->total_qty, 0),
                isset($item->ma) ? number_format($item->ma, 2).' Item' : 'N/A',
                isset($item->forecast) ? '<b>' . number_format($item->forecast, 0) . ' Item</b>' : '-',
            ];
        }

        echo json_encode([
            'draw' => $draw,
            'recordsTotal' => $totalRecords,
            'recordsFiltered' => $totalRecords,
            'data' => $html
        ]);
    }









}

