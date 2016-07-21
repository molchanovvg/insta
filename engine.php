<?php

class Engine {
    protected $ClientId = ' 066e9192b41747d4866709ad075a97b8';
    protected $access_token = '41595482.066e919.b8098befa4eb41a287ec8c11b1427e8c';
    protected $result;
    protected $login;
    public $data = array();
    protected $errors = array(
        103=>'Can\'t send request. You need the cURL extension OR set allow_url_fopen to "true" in php.ini and openssl extension',
        401=>'Can\'t get correct answer from Instagram API server.',
        402=>'Can\'t get data from Instagram API server. User OR CLIENT_ID not found.',
    );

    public function setLogin($login){
        $this->login = $login;
    }
    public function getPhoto(){
        //Try to get user ID and profile picture

        $this->result = $this->Send('https://api.instagram.com/v1/users/search?q='.$this->login.'&access_token='.$this->access_token);
        $result = json_decode($this->result);
        if(is_object($result)){
            if($result->meta->code == 200 AND !empty($result->data)){
                foreach ($result->data as $key=>$item){
                    if($item->username == $this->login){
                        $this->data['userid'] 	= $item->id;
                        $this->data['username'] = $item->username;
                        $this->data['avatar'] 	= $item->profile_picture;
                        break;
                    }
                }
                if(empty($this->data['userid'])) die($this->getError(402));
            }
            else die($this->getError(402));
        }
        else die($this->getError(401));

        //Try to get media recent
        $this->result = $this->send('https://api.instagram.com/v1/users/'.urlencode($this->data['userid']).'/media/recent/?access_token='.$this->access_token); //.'&count=10'
        $result = json_decode($this->result);
        if(is_object($result)){
            if($result->meta->code == 200){
                if(!empty($result->data)){
                    $images = array();
                    foreach ($result->data as $key=>$item){
                        $images[$key]['link'] 		= $item->link;
                        $images[$key]['large'] 		= $item->images->low_resolution->url;
                        $images[$key]['fullsize'] 	= $item->images->standard_resolution->url;
                        $images[$key]['small'] 		= $item->images->thumbnail->url;
                    }
                    $this->data['images'] = $images;
                }
                else $this->data['images'] = array();
            }
            else die($this->getError(402));
        }
        else die($this->getError(401));
    }

    public function Send($url){
        if(extension_loaded('curl')){
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($ch, CURLOPT_HEADER, false);
            curl_setopt($ch, CURLOPT_POST, false);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_TIMEOUT, 10);
            curl_setopt($ch, CURLOPT_URL, $url);
            $result = curl_exec($ch);
            curl_close($ch);
            return $result;
        }
        elseif(ini_get('allow_url_fopen') AND extension_loaded('openssl')){
            $result = file_get_contents($url);
            return $result;
        }
        else die($this->getError(103));
    }
    public function getError($code){
        $this->errors[$code] = str_replace('{$result}',strip_tags($this->result),$this->errors[$code]);
        $result = '<b>ERROR:</b> '.$this->errors[$code];
        return $result;
    }
}
