<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

class shipyard {

    function autn($login, $passwd, $url) {
        $data = json_encode(array("username" => "$login", "password" => "$passwd"));
        $url = $url . '/auth/login';
        $data = $this->curlpostjson($data, $url);

        return $data->auth_token;
    }

    function containerscreate($serviceid, $template, $login, $token, $url, $prefix) {
        $data = '{"HostConfig":'
                . '{"RestartPolicy":{"Name":"always"},'
                . '"NetworkMode":"bridge",'
                . '"Links":[],'
                . '"Binds":[],'
                . '"Privileged":false,'
                . '"PublishAllPorts":true,'
                . '"PortBindings":{},'
                . '"Dns":[]},'
                . '"Links":[],'
                . '"ExposedPorts":{},'
                . '"Volumes":{},'
                . '"Env":[],'
                . '"AttachStdin":false,'
                . '"Tty":true,'
                . '"Image":"' . $template . '",'
                . '"CpuShares":null,'
                . '"Memory":null}';

        $url = $url . '/containers/create?name=' . $prefix . $serviceid;

        $data = $this->curlpostjson($data, $url, array('login' => $login, 'token' => $token));
        return $data->Id;
    }

    function containersrestart($id, $login, $token, $url) {
        $url = $url . '/containers/' . $id . '/restart';

        $this->curlpostjson(null, $url, array('login' => $login, 'token' => $token));
        return;
    }

    function containerslogs($id, $login, $token, $url) {
        $url = $url . '/containers/' . $id . '/logs?stderr=1&stdout=1&timestamps=1';
        $result = $this->curlget($url, array('login' => $login, 'token' => $token));
        return $result;
    }

    function containersjson($id, $login, $token, $url) {
        $url = $url . '/containers/' . $id . '/json';
        $result = $this->curlget($url, array('login' => $login, 'token' => $token));
        $data = json_decode($result);

        return $data;
    }

    function containersstop($id, $login, $token, $url) {
        $url = $url . '/containers/' . $id . '/stop?t10';

        $this->curlpostjson(NULL, $url, array('token' => $token, 'login' => $login));

        return TRUE;
    }

    function containersdelete($id, $login, $token, $url) {
        $ch = curl_init($url . '/containers/' . $id . '?v=1&force=1');
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLINFO_HEADER_OUT, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'X-Access-Token:' . $login . ':' . $token)
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $result = curl_exec($ch);
        return $result;
    }

    function statuscheck($code) {
        switch ($code) {
            case 200:
                return TRUE;
                break;
            case 400 :
                throw new Exception('bad parameter');
                break;
            case 403 :
                throw new Exception('operation not supported for swarm scoped networks');
                break;
            case 404:
                throw new Exception('no such container');

                break;
            case 409 :
                throw new Exception('container is paused');
                break;
            case 500 :
                throw new Exception('server error');
                break;
        }
    }

    function curlpostjson($data, $url, $autn) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if (empty($autn)) {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data))
            );
        } else {
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data),
                'X-Access-Token:' . $autn['login'] . ':' . $autn['token'])
            );
        }

        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        $this->statuscheck($info['http_code']);
        $data = json_decode($result);

        return $data;
    }

    function curlget($url, $autn) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data),
            'X-Access-Token:' . $autn['login'] . ':' . $autn['token'])
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);

        $result = curl_exec($ch);
        $info = curl_getinfo($ch);

        curl_close($ch);

        $this->statuscheck($info['http_code']);

        return $result;
    }

}
