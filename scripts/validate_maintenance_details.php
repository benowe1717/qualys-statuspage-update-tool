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

    if(isset($_POST["ticket"]) && isset($_POST["ref"]) && isset($_POST["message"])) {
        $arr = array("ticket_status" => -1, "ref_status" => -1);
        $ticket = $_POST["ticket"];
        $ref_link = $_POST["ref"];
        $message = $_POST["message"];

        if(validate_number($ticket)) {
            $arr["ticket_status"] = 1;
        }

        if(strpos($ref_link, ",")) {
            $refs = explode(",", $ref_link);
            foreach($refs as $ref) {
                $url = trim($ref);
                if(!validate_url($url)) {
                    break;
                } else {
                    $urls[] = $url;
                }
            }
            $arr["ref_status"] = 1;
        } else {
            if(validate_url($ref_link)) {
                $arr["ref_status"] = 1;
                $urls[] = $ref_link;
            }
        }

        if($arr["ticket_status"] === 1 && $arr["ref_status"] === 1) {
            $msg = "<div class='scheduled_maintenance'>\n";
            $msg = $msg . "<p class='ticket_no'>{$ticket}</p>\n";
            $msg = $msg . "<p class='message'>{$message}</p>\n";
            foreach($urls as $url) {
                $msg = $msg . "<p class='reference_link'>{$url}</p>\n";
            }
            $msg = $msg . "</div>";
            $arr["message"] = $msg;
        }

        echo(json_encode($arr));
        http_response_code(200);
        exit(0);
    } else {
        $arr["status_code"] = 405;
        $arr["message"] = "Missing form values!";
        echo(json_encode($arr));
        http_response_code(405);
        exit(1);
    }

?>