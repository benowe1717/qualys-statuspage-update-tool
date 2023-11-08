<?php

    function validate_number(string $number) {
        if(preg_match("/^\w{3}\-\d+$/", $number)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    function validate_url(string $url) {
        if(preg_match("/^(http|https)\:.*?$/", $url)) {
            return TRUE;
        } else {
            return FALSE;
        }
    }

    if(isset($_POST["ticket"])) {
        $arr = array("ticket_status" => -1, "ref_status" => -1);
        $ticket = $_POST["ticket"];
        $ref_link = $_POST["ref"];

        if(validate_number($ticket)) {
            $arr["ticket_status"] = 1;
        }

        if(validate_url($ref_link)) {
            $arr["ref_status"] = 1;
        }

        echo(json_encode($arr));
        http_response_code(200);
        exit(0);
    } else {
        http_response_code(405);
        exit(1);
    }

?>