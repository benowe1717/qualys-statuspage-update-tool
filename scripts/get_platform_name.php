<?php

    require_once __DIR__ . "/../includes/logging.class.php";
    $logger = new my_logger();

    $remote_ip = $_SERVER["REMOTE_ADDR"];

    if(isset($_POST["platform_id"])) {
        $platform_id = intval($_POST["platform_id"]);
        $logger->log_msg("[INFO] {$remote_ip} requested platform_id {$platform_id}");

        require_once __DIR__ . "/../includes/redis.class.php";
        $redis = new myRedis();
        if($redis->error) {
            echo "ERROR: Unable to connect to Redis!\n";
            echo "Error Details: " . $redis->error->getMessage() . "\n";
            exit(1);
        }

        $platforms = unserialize($redis->get("platforms"));
        if(is_array($platforms)) {
            foreach($platforms as $value => $option) {
                if($value === $platform_id) {
                    echo(json_encode(["platform_name" => $option]));
                    http_response_code(200);
                    exit(0);
                }
            }
            echo(json_encode(["platform_name" => "None"]));
            http_response_code(200);
            exit(0);
        }
    } else {
        http_response_code(405);
        exit(1);
    }

?>