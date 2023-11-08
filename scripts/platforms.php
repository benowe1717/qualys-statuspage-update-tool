<?php

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
            echo "<option value='{$value}'>{$option}</option>";
        }
    } else {
        echo "<option value=''>No platforms!</option>";
    }

?>