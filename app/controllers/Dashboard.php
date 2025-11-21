<?php

class Dashboard extends AdminController
{
   var $id_user = '';
   public function __construct()
   {
      $this->action = $this->model('M_action');
      $this->id_user = session(WEB_NAME.'_id_user');
      $this->db = new Database;
   }

   public function index(){
      $data = [];

      // GLBL
      $data['title'] = 'Beranda';
      $data['subtitle'] = 'Pantau trafik dan Akses Cepat';

      // LOAD JS
      $data['js'][] = '<script>var page = "dashboard"</script>';
      $data['js'][] = '<script src="' . assets_url('admin/js/modul/dashboard/dashboard.js') . '"></script>';

      // GET DATA
      $today = new DateTime();
      $dates = [];

      for ($i = 0; $i < 7; $i++) {
         $date = clone $today;
         $date->sub(new DateInterval("P{$i}D"));
         $dates[] = $date->format('Y-m-d');
      }

      $arr = [];
      foreach ($dates as $date) {
         $arr[date('Ymd', strtotime($date))] = 0;
      }

      $product = $this->action->get_all('product', ['delete' => 'N']);
      $trx = $this->action->get_all('transaction');

      $min_date = min($dates);
      $trx2 = $this->action->get_all('transaction', [
         'DATE(create_date) <=' => $today->format('Y-m-d'),
         'DATE(create_date) >=' => $min_date
      ]);

      if ($trx2) {
         foreach ($trx2 as $key) {
            $arr[date('Ymd', strtotime($key->create_date))] += $key->total;
         }
      }

      // USER
      $user = $this->action->get_all('user', [
         'status' => 'Y',
         'delete' => 'N',
         'id_role' => 1
      ]);

      // COUNTING
      $jml_product = count($product ?? []);
      $jml_admin = count($user ?? []);
      $jml_trx = count($trx ?? []);

      // GRAFIK
      $grafik = [];
      foreach ($arr as $date => $total) {
         $grafik[] = [
            'tanggal' => date('d M Y', strtotime($date)),
            'value'   => $total
         ];
      }

      // SET DATA
      $data['jml_product'] = $jml_product;
      $data['jml_admin']   = $jml_admin;
      $data['jml_trx']     = $jml_trx;
      $data['grafik']      = $grafik;

      // DISPLAY
      $this->display('dashboard/index', $data);
   }


   public function pos(){
      $data = [];
      // PARAMETER
      $offset = (isset($_GET['offset'])) ? $_GET['offset'] : 1;
      $limit = 6;
      $start = ($offset - 1) * $limit;

      // GLBL
      $data['title'] = 'Beranda Penjualan';
      $data['subtitle'] = 'Formulir transaksi penjualan produk';

      // LOAD JS
      $data['js'][] = '<script>var page = "pos"</script>';
      $data['js'][] = '<script src="' . assets_url('admin/js/modul/dashboard/pos.js') . '"></script>';

      // GET DATA
      
      // WHERE
      $where['product.status'] = 'Y';
      $where['product.delete'] = 'N';
      $where['category.status'] = 'Y';
      $where['category.delete'] = 'N';

      // PARAMS
      $params['arrjoin']['category']['statement'] = 'category.id_category = product.id_category';
      $params['arrjoin']['category']['type'] = 'LEFT';
      $params['sort'] = 'product.create_date';
      $params['order'] = 'DESC';
      

      // SELECT
      $select = 'product.*, 
         category.name AS category, 
         category.color,
         (SELECT IFNULL(SUM(qty),0) FROM transaction_detail WHERE transaction_detail.id_product = product.id_product) AS cnt_trx,
         (SELECT IFNULL(SUM(qty),0) FROM stock WHERE stock.id_product = product.id_product) AS cnt_stock,
         ((SELECT IFNULL(SUM(qty),0) FROM stock WHERE stock.id_product = product.id_product) -
         (SELECT IFNULL(SUM(qty),0) FROM transaction_detail WHERE transaction_detail.id_product = product.id_product)) AS sisa_stock';

      $jumlah = $this->action->cnt_where_params('product',$where,$params);
      
      $params['limit'] = $limit;
      $params['offset'] = $start;

      $result = $this->action->get_where_params('product',$where,$select,$params);

      // SET DATA
      $data['result'] = $result;
      $data['jumlah'] = $jumlah;
      $data['offset'] = $offset;
      $data['start'] = $start;
      $data['total'] = ($jumlah > 0) ? ($jumlah / $limit) : 0;

      // DISPLAY
      $this->display('dashboard/pos', $data);
   }





   // POST

   public function insert_transaction()
   {
      $detail = $_POST['detail'] ?? [];

      if (!$detail || empty($detail)) {
         $data['status'] = false;
         $data['alert']['message'] = 'Pilih produk terlebih dahulu!';
         sleep(1);
         echo json_encode($data);
         exit;
      }

      $arr_id = [];
      foreach ($detail as $id_product => $qty) {
         $arr_id[] = $id_product;
      }

      $result = $this->action->get_all('product',['id_product' => $arr_id]);
      if (!$result) {
         $data['status'] = false;
         $data['alert']['message'] = 'Produk yang dipilih tidak valid!';
         sleep(1);
         echo json_encode($data);
         exit;
      }

      $total = 0;
      foreach ($result as $key) {
         $q = (isset($detail[$key->id_product])) ? $detail[$key->id_product] : 1; 
         $total += ((int)$key->price * (int)$q);
      }

      $post['total'] = $total;
      $post['create_by'] = $this->id_user;
      $insert = $this->action->insert('transaction',$post);
      if ($insert) {
         $post2 = [];
         $no = 0;
         foreach ($result as $key) {
            $num = $no++;
            $q = (isset($detail[$key->id_product])) ? $detail[$key->id_product] : 1; 
            $post2[$num]['id_transaction'] = $insert;
            $post2[$num]['id_product'] = $key->id_product;
            $post2[$num]['price'] = $key->price;
            $post2[$num]['qty'] = $q;
            $post2[$num]['total'] = ((int)$key->price * (int)$q);
         }
         $insert2 = $this->action->insert_batch('transaction_detail',$post2);
         if ($insert2) {
            $data['status'] = true;
            $data['alert']['message'] = 'Berhasil melakukan transaksi!';
            $data['reload'] = true;
            sleep(1);
            echo json_encode($data);
            exit;
         }else{
            $data['status'] = true;
            $data['alert']['message'] = 'Berhasil melakukan transaksi! Namun detail transaksi tidak tercatat';
            $data['reload'] = true;
            sleep(1);
            echo json_encode($data);
            exit;
         }
      }else{
         $data['status'] = false;
         $data['alert']['message'] = 'Gagal melakukan transaksi! Coba lagi nanti atau hubungi admin';
         sleep(1);
         echo json_encode($data);
         exit;
      }
   }

}

