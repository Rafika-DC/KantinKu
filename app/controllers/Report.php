<?php

class Report extends AdminController
{
   var $id_user = '';
   public function __construct()
   {
      $this->action = $this->model('M_action');
      $this->id_user = session(WEB_NAME.'_id_user');
      $this->db = new Database;
   }

    public function index(){
       redirect('transaction'); 
    }


   public function transaction(){
        $data = [];
        // PARAMETER
        $firstDate = date('Y-m-01');
        $lastDate = date('Y-m-t');

        // GLBL
        $data['title'] = 'Laporan Penjualan';
        $data['subtitle'] = 'Laporan transaksi penjualan oleh admin';

        // LOAD JS
        $data['js'][] = '<script>var page = "report/transaction"</script>';
        $data['js'][] = '<script src="' . assets_url('admin/js/modul/report/transaction.js') . '"></script>';

        // SET DATA
        $data['start_date'] = $firstDate;
        $data['end_date'] = $lastDate;
        // DISPLAY
        $this->display('report/transaction', $data);
   }


    public function ma(){
        $data = [];
        // GLBL
        $data['title'] = 'Laporan Moving Avarage';
        $data['subtitle'] = 'Laporan transaksi dengan metode Moving Avarage';

        // LOAD JS
        $data['js'][] = '<script>var page = "report/ma"</script>';
        $data['js'][] = '<script src="' . assets_url('admin/js/modul/report/ma.js') . '"></script>';

        // GET DATA
        $product = $this->action->get_all('product');
        // SET DATA
        $data['product'] = $product;
        // DISPLAY
        $this->display('report/ma', $data);
    }





    public function print_transaction()
    {
        $firstDate = date('Y-m-01');
        $lastDate = date('Y-m-t');
        $start_date = $_POST['start_date'] ?? $firstDate;
        $end_date = $_POST['end_date'] ?? $lastDate;
        $where = [];

        $filename = 'Laporan-transaksi';
        $header = [];
        $body = [];

        if (!empty($start_date)) {
            $filename .= '-' . date('d-m-Y', strtotime($start_date));
            $where['DATE(transaction.create_date) >= '] = $start_date;
        }
        if (!empty($end_date)) {
            $filename .= '-' . date('d-m-Y', strtotime($end_date));
            $where['DATE(transaction.create_date) <= '] = $end_date;
        }

        $filename .= '.xlsx';


        $params['arrjoin']['user']['statement'] = 'user.id_user = transaction.create_by';
        $params['arrjoin']['user']['type'] = 'LEFT';
        $kolom = 'transaction.create_date';
        $odr = 'DESC';

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
        // Header kolom
        $header = [
            'Tanggal', 'Nama Pembuat', 'Email Pembuat', 'Detail', 'Harga','Total Harga Produk', 'Total'
        ];

        // Body data
        if ($result) {
            foreach ($result as $key) {
                $detail = '';
                $total = '';
                $price = '';
                if (isset($list[$key->id_transaction])) {
                    $no = 0;
                    foreach ($list[$key->id_transaction] as $row) {
                        $num = $no++;
                        if ($num == 0) {
                            $price .= $row['price'];
                            $total .= $row['total'];
                            $detail .= $row['product'].'('.$row['qty'].')';
                        }else{
                            $price .= ','.$row['price'];
                            $total .= ','.$row['total'];
                            $detail .= ','.$row['product'].'('.$row['qty'].')';
                        }
                    }
                }
                $body[] = [
                    $key->create_date,
                    $key->name,
                    $key->email,
                    $detail,
                    $price,
                    $total,
                    $key->total
                ];
            }
        }

        export_excel($filename, $header, $body);
    }


    public function print_ma()
    {
        $firstDate = date('Y-m-01');
        $lastDate = date('Y-m-t');
        $start_date = $_POST['start_date'] ?? $firstDate;
        $end_date = $_POST['end_date'] ?? $lastDate;
        $where = [];

        $filename = 'Laporan-moving-avarage';
        $header = [];
        $body = [];

        if (!empty($start_date)) {
            $filename .= '-' . date('d-m-Y', strtotime($start_date));
            $where['DATE(transaction.create_date) >= '] = $start_date;
        }
        if (!empty($end_date)) {
            $filename .= '-' . date('d-m-Y', strtotime($end_date));
            $where['DATE(transaction.create_date) <= '] = $end_date;
        }
        $filename .= '.xlsx';

        // JOINs
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

        $params['groupby'] = 'transaction.create_date, product.title, product.image, category.name';

        // JANGAN gunakan limit di sini (pagination manual setelah sort MA)
        unset($params['limit'], $params['offset']);

        // SELECT utama
        $select = '
            transaction.create_date,
            product.title,
            product.image,
            category.name AS category_name,
            SUM(transaction_detail.qty) AS total_qty,
            SUM(transaction_detail.total) AS total
        ';

        $result = $this->action->get_where_params('transaction_detail', $where, $select, $params);

        // Hitung Moving Average
        $qty_data = !empty($result) ? array_column($result, 'total_qty') : [];
        $ma_qty = moving_average($qty_data, 3);

        // Tambahkan MA ke setiap objek hasil
        foreach ($result as $i => $row) {
            $result[$i]->ma = $ma_qty[$i] ?? null;
        }
        // Total semua data
        $totalRecords = count($result);

        // Lakukan pagination di PHP
        $pagedResult = array_slice($result, $offset, $limit);

        // Header kolom
        $header = [
            'Tanggal', 'Produk', 'Kategori', 'Total Jumlah', 'MA'
        ];

        // Body data
        if ($pagedResult) {
            foreach ($pagedResult as $key) {
                $body[] = [
                    $key->create_date,
                    $key->title,
                    $key->category_name,
                    number_format($key->total_qty, 0),
                    isset($key->ma) ? number_format($key->ma, 2) : 'N/A'
                ];
            }
        }

        export_excel($filename, $header, $body);
    }

}

