<?php

    class myRedis {

        private $file = __DIR__ . "/.creds.ini";
        private $host = "";
        private $port = 0;
        public $error;
        private $redis;

        function __construct() {
            if(!is_file($this->file)) {
                echo "ERROR: Unable to read credentials file!";
                exit(1);
            } else {
                $arr = parse_ini_file($this->file, TRUE);
            }

            if(isset($arr["redis"])) {
                $this->host = $arr["redis"]["host"];
                $this->port = $arr["redis"]["port"];
            } else {
                echo "ERROR: Unable to get Redis details!";
                exit(1);
            }

            try {
                $this->redis = new Redis();
                $this->redis->connect($this->host, $this->port);
            } catch(Exception $e) {
                $this->error = $e;
            }
        }

        public function get(string $key) {
            try {
                return $this->redis->get($key);
            } catch(Exception $e) {
                $this->error = $e;
                exit($this->error);
            }
        }

        public function set(string $key, string $value) {
            try {
                return $this->redis->set($key, $value);
            } catch(Exception $e) {
                $this->error = $e;
                exit($this->error);
            }
        }

        public function del(string $key) {
            try {
                return $this->redis->del($key);
            } catch(Exception $e) {
                $this->error = $e;
                exit($this->error);
            }
        }

    }

?>