<?php
class M_action
{
   var $attr = [];
   public function __construct()
   {
      $this->db = new Database;
      $this->attr = ['>','>=','<','<=','!='];
   }

   public function get_single($tabel, $where = [],$select = '*'){
      $query = '';
      $query .= 'SELECT '.$select;
      $query .= ' FROM `'.$tabel.'`';
      if (count($where) > 0) {
         $query .= ' WHERE ';
         $query .= $this->_where_system($where);
      }
      // var_dump($query);die;
      $this->db->query($query);
      $this->_bind_system($where);

      return $this->db->single();
   }


   public function get_all($tabel, $where = [],$select = '*',$order = [],$limit = null){
      $query = '';
      $query .= 'SELECT '.$select;
      $query .= ' FROM '.$tabel;
      if (count($where) > 0) {
         $query .= ' WHERE ';
         $query .= $this->_where_system($where);
         if (count($order) > 0) {
            $query .= ' ORDER BY '.$order['field'];
            if (isset($order['order'])) {
               $query .= ' '.$order['order'];
            }
         }

         if ($limit) {
            $query .= ' LIMIT '.$limit;
         }
         $this->db->query($query);
         $this->_bind_system($where);
      }else{
          $this->db->query($query);
      }
      
      
      return $this->db->resultSet();
   }


   public function get_where_params($tabel, $where = [], $select = "*", $params = []){
      // var_dump($params);die;
      $query = '';
      $query .= 'SELECT '.$select;
      $query .= ' FROM `'.$tabel.'`';
      if (isset($params['arrjoin'])) {
         foreach ($params['arrjoin'] as $table => $statement) {
            $type = (isset($statement['type']) && $statement['type'] != '') ? $statement['type'] : 'INNER';
            // $this->db->join($table, $statement['statement'], $type);
            $query .= ' '.$type.' JOIN '.$table.' ON '.$statement['statement'];
         }
      }
      if (count($where) > 0 || isset($params['columnsearch']) && count($params['columnsearch']) > 0) {
         $query .= ' WHERE ';
      }
      
      $query .= $this->_where_system($where);

      if (isset($params['search']) && !empty($params['search'])) {
         
         if (count($params['columnsearch']) > 0) {
            $i = 1;
            if (count($where) > 0) {
               $query .= ' AND (';
            }else{
                $query .= ' (';
            }
            foreach ($params['columnsearch'] as $columnname) {
               if ($i == 1) {
                  $query .= " ".$columnname." LIKE '%".$params["search"]."%' ESCAPE '!'";
               } else {
                  $query .= " OR ".$columnname." LIKE '%".$params["search"]."%' ESCAPE '!'";
               }
               $i++;
            }
            $query .= ")";
         }
      }

      if (isset($params['groupby'])) {
         $query .= ' GROUP BY '.$params['groupby'];
      }

      if (isset($params['sort'])) {
         if ($params['sort'] != '') {
            if ($params['order'] == '') {
               $order = 'asc';
            } else {
               $order = $params['order'];
            }
            $query .= ' ORDER BY '.$params['sort'].' '.$order;
         }
      }

      if (isset($params['limit'])) {
         $query .= ' LIMIT '.$params['limit'];
         if (isset($params['offset'])) {
            $query .= ' OFFSET '.$params['offset'];
         }
      }
      // var_dump($query);die;
      $this->db->query($query);
      $this->_bind_system($where);
      return $this->db->resultSet();
   }

   public function cnt_where_params($tabel, $where = [], $params = []){
      // var_dump($params);die;
      $query = '';
      $query .= 'SELECT COUNT(*) AS jumlah';
      $query .= ' FROM `'.$tabel.'`';
      if (isset($params['arrjoin'])) {
         foreach ($params['arrjoin'] as $table => $statement) {
            $type = (isset($statement['type']) && $statement['type'] != '') ? $statement['type'] : 'INNER';
            // $this->db->join($table, $statement['statement'], $type);
            $query .= ' '.$type.' JOIN '.$table.' ON '.$statement['statement'];
         }
      }
      if (count($where) > 0 || isset($params['columnsearch']) && count($params['columnsearch']) > 0) {
         $query .= ' WHERE ';
      }
      
      $query .= $this->_where_system($where);

      if (isset($params['search']) && !empty($params['search'])) {
         
         if (count($params['columnsearch']) > 0) {
            $i = 1;
            if (count($where) > 0) {
               $query .= ' AND (';
            }else{
                $query .= ' (';
            }
            foreach ($params['columnsearch'] as $columnname) {
               if ($i == 1) {
                  $query .= " ".$columnname." LIKE '%".$params["search"]."%' ESCAPE '!'";
               } else {
                  $query .= " OR ".$columnname." LIKE '%".$params["search"]."%' ESCAPE '!'";
               }
               $i++;
            }
            $query .= ")";
         }
      }

      if (isset($params['groupby'])) {
         $query .= ' GROUP BY '.$params['groupby'];
      }

      if (isset($params['sort'])) {
         if ($params['sort'] != '') {
            if ($params['order'] == '') {
               $order = 'asc';
            } else {
               $order = $params['order'];
            }
            $query .= ' ORDER BY '.$params['sort'].' '.$order;
         }
      }

      if (isset($params['limit'])) {
         $query .= ' LIMIT '.$params['limit'];
         if (isset($params['offset'])) {
            $query .= ' OFFSET '.$params['offset'];
         }
      }
      // var_dump($query);die;
      $this->db->query($query);
      $this->_bind_system($where);
      $res = $this->db->single();
      return $res->jumlah ?? 0;
   }

   public function insert($tabel, $in = [])
   {
      $query = '';
      $query .= 'INSERT INTO `' . $tabel . '` ';

      if (count($in) > 0) {
         $fields = [];
         $placeholders = [];
         $i = 1;

         foreach ($in as $key => $value) {
               $fields[] = '`' . $key . '`';
               $placeholders[] = ':v' . $i++;
         }

         $query .= '(' . implode(',', $fields) . ') VALUES (' . implode(',', $placeholders) . ')';
      }

      $this->db->query($query);

      // Binding insert values
      $i = 1;
      foreach ($in as $key => $value) {
         $this->db->bind('v' . $i++, $value);
      }

      return $this->db->insert_id();
   }


   public function update($tabel, $set = [], $where = [])
   {
      if (empty($tabel) || empty($set)) {
         return false; // validasi awal
      }

      $query = 'UPDATE `' . $tabel . '` SET ';
      $setParts = [];
      $i = 1;
      foreach ($set as $key => $value) {
         $setParts[] = '`' . $key . '` = :set' . $i++;
      }
      $query .= implode(', ', $setParts);

      if (!empty($where)) {
         $query .= ' WHERE ' . $this->_where_system($where);
      }

      $this->db->query($query);

      // Binding SET values
      $i = 1;
      foreach ($set as $key => $value) {
         if (!is_array($value) && $value !== null && $key !== 'query') {
               $this->db->bind('set' . $i++, $value);
         }
      }

      // Binding WHERE values
      $this->_bind_system($where);

      return $this->db->execute();
   }



   public function delete($tabel,$where = [])
   {
      $query = '';
      $query .= 'DELETE FROM `'.$tabel.'` ';
      if (count($where) > 0) {
         $query .= ' WHERE ';
         $query .= $this->_where_system($where);
      }
      // var_dump($query);die;
      $this->db->query($query);
      $this->_bind_system($where);
      return $this->db->execute();
   }

   function update_batch($table, $data, $key) {
      // Pastikan ada data yang akan di-update
      if (empty($data) || empty($key)) {
         return false;
      }

      // Mulai query SQL
      $sql = "UPDATE `$table` SET ";
      $update_cases = [];
      $keys = [];

      // Ambil nama kolom selain $key untuk dibuatkan CASE
      foreach ($data as $row) {
         foreach ($row as $column => $value) {
               if ($column !== $key) {
                  $update_cases[$column][] = "WHEN `$key` = '{$row[$key]}' THEN '" . addslashes($value) . "'";
               } else {
                  $keys[] = $row[$key];
               }
         }
      }

      // Gabungkan semua kasus untuk tiap kolom
      $set_sql = [];
      foreach ($update_cases as $column => $cases) {
         $set_sql[] = "`$column` = CASE " . implode(" ", $cases) . " END";
      }

      // Gabungkan bagian SET dan WHERE untuk membentuk query akhir
      $sql .= implode(", ", $set_sql);
      $sql .= " WHERE `$key` IN ('" . implode("','", $keys) . "')";

      // Eksekusi query

      
      $res =  $this->db->query($sql);
      return $this->db->execute();
   }

   function insert_batch($table, $data) {
      // Pastikan data tidak kosong
      if (empty($data) || !is_array($data)) {
         return false;
      }

      // Ambil kolom dari array pertama
      $columns = array_keys($data[0]);
      
      // Buat query SQL untuk insert batch
      $sql = "INSERT INTO `$table` (`" . implode("`, `", $columns) . "`) VALUES ";
      $values = [];

      // Susun values untuk tiap row
      foreach ($data as $row) {
         $rowValues = array_map(function($value) {
            if ($value) {
               return "'" . addslashes($value) . "'";
            }else{
                return "NULL";
            }
              
         }, array_values($row));
         
         $values[] = "(" . implode(", ", $rowValues) . ")";
      }

      // Gabungkan values dan lengkapi query
      $sql .= implode(", ", $values);

      // Eksekusi query
      $this->db->query($sql);
      return $this->db->execute();
   }


   

   private function _where_system($where = [])
   {
      $result = '';
      if (count($where) > 0) {
         $no = 1;
         $vn = 1;
         foreach ($where as $row => $value) {
               $num = $no++;
               if ($num > 1) {
                  $result .= ' AND ';
               }
               if ($row == 'query') {
                  foreach ($value as $q) {
                     $result .= ' ' . $q;
                  }
               } else {
                  $cr = explode(" ", $row);
                  $s = '=';
                  $d = '';
                  if (isset($cr[1])) {
                     if (in_array(trim($cr[1]), $this->attr)) {
                           $s = trim($cr[1]);
                           if (in_array($s, ['!', '!='])) {
                              $d = ' NOT';
                           }
                     }
                  }
                  if (is_array($value)) {
                     $bts = $d . ' IN (' . implode(",", $value) . ')';
                  } else {
                     if ($value == NULL) {
                           $bts = ' IS NULL';
                     } else {
                           $v = 'where' . $vn++;
                           $bts = $s . ':' . $v;
                     }
                  }

                  $r = str_replace(['(', ')'], '|', $cr[0]);
                  $field = '';
                  if (strpos($r, "|")) {
                     $ct = explode('|', $r);
                     $attr = $ct[0];
                     $field .= $attr . '(';
                     $cb = explode('.', $ct[1]);

                     $field .= '`' . $cb[0] . '`';
                     if (isset($cb[1])) {
                           $field .= '.`' . $cb[1] . '`';
                     }
                     $field .= ')';
                  } else {
                     $ct = explode('.', $r);
                     $field .= '`' . $ct[0] . '`';
                     if (isset($ct[1])) {
                           $field .= '.`' . $ct[1] . '`';
                     }
                  }

                  $result .= $field . $bts;
               }
         }
      }

      return $result;
   }


   private function _bind_system($arr = [])
   {
      if (count($arr) > 0) {
         $vn = 1;
         $vor = [];
         foreach ($arr as $row => $value) {
               if (!is_array($value) && $value != NULL && $row != 'query') {
                  $v = 'where' . $vn++;
                  $vor[$v] = $value;
                  $this->db->bind($v, $value);
               }
         }
         // var_dump($vor); die; // Optional, hapus kalau udah ga debug
      }
   }


}
