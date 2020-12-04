<?php
    function service($data)
    {
        $user = 'jepara';
        $password = 'PNILNS1X';
        $url = 'http://ks-interop.kemkes.go.id:9000/api/v1/survei/main';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL,$url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_USERPWD, "$user:$password");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        
        // Set HTTP Header for POST request 
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data))
        );

        $result = curl_exec($ch);
        curl_close($ch);  
        
        $hasil = json_decode($result, true);

        return $hasil;
    }

?>