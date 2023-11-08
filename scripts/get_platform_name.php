<?php

    if(isset($_POST["platform_id"])) {
        $platform_id = intval($_POST["platform_id"]);

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
                    echo $option;
                    break;
                }
            }
        }
    } else {
        http_response_code(405);
    }

?>