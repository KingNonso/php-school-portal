<?php

class Download_Model extends Model {

    function __construct() {
        parent::__construct();
    }

    function infobip(){
        $request = new HttpRequest();
        $request->setUrl('https://api.infobip.com/sms/1/text/single');
        $request->setMethod(HTTP_METH_POST);

        $request->setHeaders(array(
            'accept' => 'application/json',
            'content-type' => 'application/json',
            'authorization' => 'Basic TW92ZVVwOmF1Z3VzdGluZTE='
        ));

        $request->setBody('{
   "from":"InfoSMS",
   "to":"2347036609386",
   "text":"Test SMS. Hey whats up"
}');

        try {
            $response = $request->send();

            echo $response->getBody();
        } catch (HttpException $ex) {
            echo $ex;
        }
    }

    public function json_timed_mysql_request() {
        header("Content-Type: application/json");
        if(isset($_POST['limit'])){
            $limit = preg_replace('#[^0-9]#', '', $_POST['limit']);
            $data = $this->db->get_limited('new_convert',$limit,NULL,'RAND')->results_assoc();
            $count = $this->db->count_assoc();
            if($count > 0){
            $i = 0;
            $jsonData = '{';
                foreach($data as $row){
                    $i++;
                    $id = $row["convert_id"];
                    $title = $row["convert_name"];
                    $cd  = $row["date_converted"];
                    $cd = strftime("%B %d, %Y", strtotime($cd));
                    $jsonData .= '"article'.$i.'":{ "id":"'.$id.'","title":"'.$title.'", "cd":"'.$cd.'" },';
                }
                $now = getdate();
                $timestamp = $now[0];
                $jsonData .= '"arbitrary":{"itemcount":'.$i.', "returntime":"'.$timestamp.'"}';
                $jsonData .= '}';
                echo $jsonData;
                //print_r($data) ;
            }else{
                //call error
                echo "Nothing to display";
            }

        }
    }

}

