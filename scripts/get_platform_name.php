<?php

    require_once __DIR__ . "/../includes/logging.class.php";
    $logger = new my_logger();

    $headers = getallheaders();
    if(isset($headers["X-Real-IP"])) {
        $remote_ip = $headers["X-Real-IP"];
    } elseif(isset($headers["X-Forwarded-For"])) {
        $remote_ip = $headers["X-Forwarded-For"];
    } else {
        $remote_ip = $_SERVER["REMOTE_ADDR"];
    }

    if(isset($_POST["platform_id"])) {
        $platform_id = intval($_POST["platform_id"]);
        $logger->log_msg("{$remote_ip} requested platform_id {$platform_id}");

        require_once __DIR__ . "/../includes/redis.class.php";
        $redis = new myRedis();
        if($redis->error) {
            echo "ERROR: Unable to connect to Redis!\n";
            echo "Error Details: " . $redis->error->getMessage() . "\n";
            $logger->log_msg("Error Details: {$redis->error->getMessage()}", 4);
            exit(1);
        }

        $platforms = unserialize($redis->get("platforms"));
        if(is_array($platforms)) {
            foreach($platforms as $value => $option) {
                if($value === $platform_id) {
                    echo(json_encode(["platform_name" => $option]));
                    $logger->log_msg("Platform Name: {$option}");
                    http_response_code(200);
                    exit(0);
                }
            }
            echo(json_encode(["platform_name" => "None"]));
            $logger->log_msg("Platform Name: None", 3);
            http_response_code(200);
            exit(0);
        }
    } else {
        $logger->log_msg("Wrong HTTP Method of {$_SERVER['REQUEST_METHOD']} from {$_SERVER['REMOTE_ADDR']}", 3);
        http_response_code(405);
        exit(1);
    }

?>