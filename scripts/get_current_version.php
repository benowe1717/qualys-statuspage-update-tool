<?php

    $current_version_file = __DIR__ . "/../current_version";

    if(is_file($current_version_file)) {
        $contents = file_get_contents($current_version_file);
        if($contents) {
            echo trim($contents);
        } else {
            echo "unknown";
        }
    } else {
        echo "unknown";
    }

?>