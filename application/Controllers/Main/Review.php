<?php

namespace Application\Main;

use Core\Base\Application;

class Review  extends Application{
    
    private $url = 'https://review.martireisen.at/';
    
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->getCurl();
    }
    
    public function complete() {
        $this->header();
        $reviewCurl = new ReviewCurl($this->url .'completed'. (isset($_GET) && count($_GET) ? '?' . http_build_query($_GET) : ''));
        $result = $reviewCurl->send();
        echo $result;
        $this->footer();
    }
    
    public function getFrame($query) {
        echo '<iframe src="'.$this->url.'?'.$query.'" frameborder="0" style="overflow:hidden;height:150%;width:100%" height="150%" width="100%"></iframe>';
    }
    
    public function getCurl() {
        
        $reviewCurl = new ReviewCurl($this->url . (isset($_GET) && count($_GET) ? '?' . http_build_query($_GET) : ''));
        if (isset($_POST) && count($_POST) > 0) {
            $result = $reviewCurl->send('POST', $_POST);
            if ($result && strlen($result) > 0) {
                header('Content-Type: application/json');
                print_r($result);
            } else {
                echo "Request Post Error";
            }
            exit;
        }
        $this->header();
        $result = $reviewCurl->send();

        if ($result && strlen($result) > 0) {
            print_r($result);
        } else {
            echo "Request Get Error";
        }
        $this->footer();
    }
    
  
}

class ReviewCurl
{
    public $url = '';

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function send($method = 'GET', $data = null)
    {

        $curl = curl_init();


        $header = [
            CURLOPT_URL => $this->url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_MAXREDIRS => 30,
            CURLOPT_TIMEOUT => 60,
            CURLOPT_TIMEOUT_MS => 5000,
            CURLOPT_CUSTOMREQUEST => $method,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_HTTPHEADER => array(
                'cache-control: no-cache',
                'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/56.0.2924.87 Safari/537.36'
            )
        ];

        if ($method == 'POST') {
            $header[CURLOPT_POST] = true;
            $header[CURLOPT_POSTFIELDS] = http_build_query($data);
        }

        curl_setopt_array($curl, $header);

        $response = curl_exec($curl);
        curl_close($curl);

        return $response;

    }

}


