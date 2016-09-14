<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

 $ch = curl_init('http://sinus01.service-voice.local:8080/containers/dac1d14e120ed466748799446271076d70513e51758fe84db8d0a58d88607f51/logs?stderr=1&stdout=1&timestamps=1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: text/plain; charset=utf-8',
            'X-Access-Token:admin:$2a$10$DNsDbkE2OJ.c38RU0SizY.1LTS9ABq02sHYDGxxhdsc6NaBBtwtdy')
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $result = curl_exec($ch);

        var_dump($result);