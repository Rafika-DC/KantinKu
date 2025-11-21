<?php

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Dompdf\Dompdf;
use Dompdf\Options;

function redirect($url, $statusCode = 303)
{
   header('location: ' . base_url($url,true), true, $statusCode);
   die();
}

function base_url($url = '',$data = true)
{
  if ($data != true) {
    return BASEURL . $url;
  }else{
    return REDIRECT . $url;
  }
   
}

function session($val)
{
  if (isset($_SESSION[$val])) {
    return $_SESSION[$val];
  }else{
    return NULL;
  }
}
function assets_url($url = '')
{
   return ASSETSURL . $url;
}
function short_text($text, $batas = 5, $pengganti = '...', $link = '')
{
  if (strlen($text) > $batas) {
    $data = substr($text, 0, $batas) . $pengganti;
  } else {
    $data = $text;
  }

  return $data;
}
function image_check($image = null, $path = null, $rename = NULL)
{
  if ($path == null) {
    $path = 'error';
  }
  if ($rename != NULL) {
    $pt = $rename;
  } else {
    $pt = 'notfound';
  }
  if ($image == null) {
    $file = 'gaada';

    $file = 'default/' . $pt . '.jpg';
  } else {
    if (file_exists(base_data() . $path . '/' . $image)) {
      $file = $path . '/' . $image;
    } else {
      $file = 'default/' . $pt . '.jpg';
      // $file = 'gaada';
    }
  }

  return base_url('data/'.$file,TRUE);
}


function base_data($path = null)
{
  $p = './data/';
  if ($path == null) {
    return $p;
  } else {
    return $p . $path;
  }
}


function hash_my_password($pass)
{
  $data = hash('sha256', $pass);
  return $data;
}

function validasi_email($email)
{
  $r = true;
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $r = false;
  }

  return $r;
}

if (!function_exists('export_excel')) {

  function export_excel($filename = 'export.xlsx', $header = [], $data = [], $json = false)
  {
      $spreadsheet = new Spreadsheet();
      $sheet = $spreadsheet->getActiveSheet();

      // Set header
      $colIndex = 1;
      foreach ($header as $head) {
          $cell = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex) . '1';
          $sheet->setCellValue($cell, $head);
          $colIndex++;
      }

      // Set data
      $rowNum = 2;
      foreach ($data as $row) {
          $colIndex = 1;
          foreach ($row as $cell) {
              $cellAddress = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex) . $rowNum;
              $sheet->setCellValue($cellAddress, $cell);
              $colIndex++;
          }
          $rowNum++;
      }

      // Auto width & styling
      $lastCol = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(count($header));
      $cellRange = 'A1:' . $lastCol . ($rowNum - 1);

      foreach (range(1, count($header)) as $colIndex) {
          $colLetter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex($colIndex);
          $sheet->getColumnDimension($colLetter)->setAutoSize(true);
      }

      $styleArray = [
          'borders' => [
              'allBorders' => [
                  'borderStyle' => Border::BORDER_THIN,
                  'color' => ['argb' => 'FF000000'],
              ],
          ],
          'alignment' => [
              'horizontal' => Alignment::HORIZONTAL_LEFT,
              'vertical' => Alignment::VERTICAL_CENTER,
          ],
      ];
      $sheet->getStyle($cellRange)->applyFromArray($styleArray);

      // Output ke browser
      header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
      header("Content-Disposition: attachment; filename=\"$filename\"");
      header('Cache-Control: max-age=0');

      // Buang output buffer sebelumnya kalau ada
      if (ob_get_length()) {
          ob_end_clean();
      }

      flush();

      $writer = new Xlsx($spreadsheet);
      $writer->save('php://output');

      exit; // Hentikan script setelah output file

      // NOTE: bagian ini tidak akan pernah jalan karena sudah exit
      if ($json) {
          echo json_encode(true);
      }
  }

}

function parseUrl($url = '', $get_params = false)
{
  // Dapatkan path URL
  if ($url != '') {
    $val = '/' . explode('/', $_SERVER['REQUEST_URI'])[1] . '/' . $url;
  } else {
    $val = $_SERVER['REQUEST_URI'];
  }

  // Pisahkan antara path dan query string
  $val = str_replace("?", "|", $val);
  $val = explode("|", $val); // $val[0] = path, $val[1] = query string

  $arr = [];

  // Jika diminta ambil parameter GET
  if ($get_params === true) {
    $arr['params'] = [];

    if (isset($val[1])) {
      // Gunakan parse_str untuk langsung ubah query string menjadi array
      parse_str($val[1], $arr['params']);
    }
  }

  // Pecah path URL jadi array
  $segments = explode('/', $val[0]);

  if (count($segments) > 2) {
    for ($i = 2; $i < count($segments); $i++) {
      if ($segments[$i] != '') {
        if ($get_params === true) {
          $arr['url'][] = $segments[$i];
        } else {
          $arr[] = $segments[$i];
        }
      }
    }
  }

  return $arr;
}


function search_encode($text, $encode = '--')
{
  if (preg_match("/$encode/i", $text)) {
    $data = str_replace($encode, " ", $text);
  } else {
    $data = $text;
  }

  return $data;
}


function uri_segment($num = '')
{
  $cek = parseUrl();
  if ($num == '') {
    return parseUrl();
  }else{
    if ((count($cek) - 1) < $num) {
      return 0;
    }else{
      return parseUrl()[$num];
    }
    
  }
  
}
function price_format($harga, $format = 'none')
{
  $num = number_format($harga, 0, ",", ".");
  $first = '';
  $last = '';
  if ($format == 1) {
    $first = 'Rp. ';
    $last = '';
  }elseif($format == 2){
    $first = '';
    $last = ' IDR';
  }

  return $first.$num.$last;
}


function setmenuactive($current_url, $class)
{
  if ($current_url == $class) {
    return "active";
  } else {
    if ($current_url == $class . "/index") {
      return "active";
    }
    return "";
  }
}

function set_menu_active($controller, $arrtarget = array(), $class = 'active', $exc = '')
{
  if ($controller) {
    if (in_array($controller, $arrtarget)) {
      return $class;
    } else {
      return $exc;
    }
  } else {
    return $exc;
  }
}
function initials($nama, $jmlh = 1)
{
  $words = explode(" ", $nama);
  $initials = null;
  $no = 1;
  foreach ($words as $w) {
    $num = $no++;
    $initials .= $w[0];
    if ($num == $jmlh) {
      break;
    }
  }
  return strtoupper($initials);
}
function set_submenu_active($controller, $arrtarget = array(), $c2 = '', $arrtarget2 = array(), $class = 'active', $exc = ''){
  if ($controller) {
    if (in_array($controller, $arrtarget)) {
      if ($c2) {
        if (in_array($c2, $arrtarget2)) {
          return $class;
        } else {
          return $exc;
        }
      } else {
        return $exc;
      }
    } else {
      return $exc;
    }
  } else {
    return $exc;
  }
}

function day_from_number($nomor = NULL)
{
  switch ($nomor) {
    case 1:
      return "Senin";
    case 2:
      return "Selasa";
    case 3:
      return "Rabu";
    case 4:
      return "Kamis";
    case 5:
      return "Jumat";
    case 6:
      return "Sabtu";
    case 7:
      return "Minggu";
    default:
      return array(1 => "Senin", 2 => "Selasa", 3 => "Rabu", 4 => "Kamis", 5 => "Jumat", 6 => "Sabtu", 7 => "Minggu");
  }
}

function pagination($url = '', $total = 0, $limit = 10, $offset = 0,$parameter = '')
{
  $data['total'] = $total;
  $data['limit'] = $limit;
  $data['offset'] = $offset;
  $data['url'] = $url;
  $data['parameter'] = $parameter;
  extract($data);
  unset($data);
  if ($total == 0) {
    return false;
  }else{
    require_once "./app/views/Public/pagination.php";
  }
}


if (!function_exists('salamWaktu')) {
    function salamWaktu($jam = null)
    {
        // Jika tidak ada parameter, ambil jam sekarang
        if (is_null($jam)) {
            $jam = (int) date('H'); // native PHP untuk ambil jam dalam format 24 jam
        } else {
            $jam = (int) $jam;
        }

        $arr = [
            'message' => '',
            'dark' => false
        ];

        if ($jam >= 5 && $jam < 12) {
            $arr['message'] = 'Selamat Pagi';
        } elseif ($jam >= 12 && $jam < 15) {
            $arr['message'] = 'Selamat Siang';
        } elseif ($jam >= 15 && $jam < 18) {
            $arr['message'] = 'Selamat Sore';
        } else {
            $arr['message'] = 'Selamat Malam';
            $arr['dark'] = true;
        }

        return (object) $arr; // langsung ubah array ke object, tanpa encode/decode
    }
}


function phone_format($phoneNumber) {
    // Remove any non-numeric characters from the phone number
    $phoneNumber = preg_replace('/[^0-9]/', '', $phoneNumber);

    // Check if the phone number has 10 digits (assuming a standard US phone number)
    if (strlen($phoneNumber) >= 10) {
        // Format the phone number as (XXX) XXX-XXXX
        $formattedPhoneNumber = sprintf("(%s) %s-%s",
            substr($phoneNumber, 0, 4),
            substr($phoneNumber, 4, 4),
            substr($phoneNumber, 8, 6)
        );

        return $formattedPhoneNumber;
    } else {
        // If the phone number doesn't have 10 digits, return an error or handle accordingly
        return "Invalid phone number";
    }
}

if (!function_exists('date_selisih')) {
    function date_selisih($tanggal1, $tanggal2, $absolute = true,$full = true)
    {
        $date1 = new DateTime($tanggal1);
        $date2 = new DateTime($tanggal2);
        $diff = $date1->diff($date2);

        if ($full == true) {
            return $absolute ? ($diff->days + 1) : ((int)$diff->format('%R%a') + 1);
        }else{
            return $absolute ? $diff->days : (int)$diff->format('%R%a');
        }
        
    }
}

function moving_average(array $data, int $window = 3): array {
    $result = [];
    $count = count($data);
    for ($i = 0; $i < $count; $i++) {
        if ($i < $window - 1) {
            $result[] = null;
        } else {
            $slice = array_slice($data, $i - $window + 1, $window);
            $result[] = array_sum($slice) / $window;
        }
    }
    return $result;
}


function upload_file($config = [])
{
    $ext	= $config['allowed_types'] ?? array('jpg','png','jpeg');
    $batas = $config['size'] ?? 1044070;
    $file = $config['file'];
    // var_dump($file);die;
    $nama = $file['name'];
    $x = explode('.', $nama);
    $ekstensi = strtolower(end($x));
    $ukuran	= $file['size'];
    $file_tmp = $file['tmp_name'];	
    if(in_array($ekstensi, $ext) === true){
      if($ukuran < $batas){		
        $filename   = $config['file_rename'] ?? uniqid() . "-" . time(); 
        $basename   = $filename . "." . $ekstensi;
        move_uploaded_file($file_tmp, $config['upload_path'].$basename);
        $return['status'] = true;
        $return['data']['nama'] = $basename;
      }else{
        $return['status'] = false;
        $return['message'] = 'Ukuran file terlalu besar!';
      }
    }else{
        $return['status'] = false;
        $return['message'] = 'Tipe file tidak diijinkan!';
    }

    return $return;
}

function ckeditor_check($content = '')
{
  // Hapus semua tag HTML
  $clean_content = strip_tags($content, '<p><br>'); // Biarkan <p> dan <br> untuk diproses lebih lanjut
  // Hapus tag <p><br></p> yang sering muncul sebagai konten kosong
  $clean_content = preg_replace('/<p>(&nbsp;|\s|<br>|<\/?p>)*<\/p>/i', '', $clean_content);
  // Hapus whitespace yang tersisa
  $clean_content = trim($clean_content);

  return $clean_content;
}

function status_booking($id = 99,$ambil = [])
{
    $arr[0] = 'role tidak di ketahui';
    $arr[1] = 'batal';
    $arr[2] = 'menunggu konfirmasi';
    $arr[3] = 'suskes';
    if (isset($arr[$id])) {
      return $arr[$id];
    } else {
      if (is_array($ambil) && count($ambil) > 0) {
        $d = [];
        for ($i=0; $i < count($ambil) ; $i++) { 
          $d[$ambil[$i]] = $arr[$ambil[$i]];
        }
        return $d;
      }else{
        return $arr;
      }
      
    }
    return $arr[$role];

}

function base64url_encode($data)
{
  return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}
function base64url_decode($data)
{
  return base64_decode(str_pad(strtr($data, '-_', '+/'), strlen($data) % 4, '=', STR_PAD_RIGHT));
}


function get_role($role = 99,$ambil = [])
{
  $arr[0] = 'role tidak di ketahui';
  $arr[1] = 'admin';
  if (isset($arr[$role])) {
    return $arr[$role];
  } else {
    if (is_array($ambil) && count($ambil) > 0) {
      $d = [];
      for ($i=0; $i < count($ambil) ; $i++) { 
        $d[$ambil[$i]] = $arr[$ambil[$i]];
      }
      return $d;
    }else{
      return $arr;
    }
    
  }
  return $arr[$role];
}


function get_tipe_input($role = 99,$ambil = [])
{
  $arr[0] = 'input tidak di ketahui';
  $arr[1] = 'text';
  $arr[2] = 'number';
  $arr[3] = 'select';
  $arr[4] = 'textarea';
  $arr[5] = 'file';
  $arr[7] = 'true or false';
  if (isset($arr[$role])) {
    return $arr[$role];
  } else {
    if (is_array($ambil) && count($ambil) > 0) {
      $d = [];
      for ($i=0; $i < count($ambil) ; $i++) { 
        $d[$ambil[$i]] = $arr[$ambil[$i]];
      }
      return $d;
    }else{
      return $arr;
    }
    
  }
  return $arr[$role];

  
}


function load_view($view,$data = [])
{
  extract($data);
  unset($data);
  if (file_exists('./app/views/'.$view.'.php')) {
      require_once "./app/views/".$view.".php";
  }else{
      require_once "./app/config/error/notfound.php";
  }
}


function alphabet_number($var = 0,$type = '0toa')
{
  // var_dump($var);die;
  if ($type == '0toa') {
    $num = $var + 1;
      $alphabet = '';
    
      while ($num > 0) {
          $mod = ($num - 1) % 26;
          $alphabet = chr(65 + $mod) . $alphabet;
          $num = (int)(($num - $mod) / 26);
      }
      
      return $alphabet;
  }

  if ($type == 'ato0') {
      $alphabet = $var;
      $length = strlen($alphabet);
      $number = 0;

      for ($i = 0; $i < $length; $i++) {
          $number *= 26;
          $number += ord($alphabet[$i]) - 64;  // 64 karena 'A' = 1
      }

      return $number;
  }

}


function news_zigzag($i) {
    $current = 1;
    $step = 6;
    while ($current <= $i) {
        if ($i == $current) return true;
        $current += $step;
        $step = $step === 6 ? 4 : 6; // selang-seling 6 dan 4
    }
    return false;
}
