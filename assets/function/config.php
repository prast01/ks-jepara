<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "pispk";

    $con = mysqli_connect($host, $user, $pass, $db);
    
    $sql_details = array(
        'user' => 'root',
        'pass' => '',
        'db'   => 'pispk',
        'host' => 'localhost'
    );
    
    try {
        // buat koneksi dengan database
        $db = new PDO(
                "mysql:host=$sql_details[host];dbname=$sql_details[db]",
                $sql_details['user'],
                $sql_details['pass']
            );
        
          
        // set error mode
        $db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
      
    }
    catch (PDOException $e) {
        // tampilkan pesan kesalahan jika koneksi gagal
        print "Koneksi atau query bermasalah: " . $e->getMessage() . "<br/>";
        die();
        exit;
    }

?>