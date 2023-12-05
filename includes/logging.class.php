<?php

    class my_logger {

        private $date_format = "M d H:m:s";
        private $hostname = "";
        private $program = "php";
        private $pid = -1;
        public $error;
        public $file = "/var/log/statuspage.log";
        public $fp;
        public $log_levels = [
            1 => "DEBUG",
            2 => "INFO",
            3 => "WARN",
            4 => "ERROR"
        ];

        function __construct() {
            try {
                if($this->fp = fopen($this->file, "a")) {
                    $this->hostname = gethostname();
                    $this->pid = getmypid();
                    $this->log_msg("Starting logger...");
                }
            } catch(Exception $e) {
                $this->error = $e;
                file_put_contents("/tmp/error", $this->error);
            }
        }

        public function log_msg(string $msg, int $log_level = 2) {
            $now = date($this->date_format);
            $message = "{$now} {$this->hostname} {$this->program}[{$this->pid}] [{$this->log_levels[$log_level]}] {$msg}\n";
            try{
                fwrite($this->fp, $message);
            } catch(Exception $e) {
                $this->error = $e;
                file_put_contents("/tmp/fwrite_error", $this->error);
            }
        }

    }

?>