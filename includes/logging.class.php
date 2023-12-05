<?php

    class my_logger {

        private $date_format = "M d H:m:s";
        private $hostname = "";
        private $program = "php";
        private $pid = -1;
        public $error;

        function __construct() {
            $this->hostname = gethostname();
            $this->pid = getmypid();
            $this->log_msg("Starting logger...");
        }

        public function log_msg(string $msg) {
            try{
                $now = date($this->date_format);
                $message = "{$now} {$this->hostname} {$this->program}[{$this->pid}] {$msg}";
                error_log($message);
            } catch(Exception $e) {
                file_put_contents("/tmp/error", $e, FILE_APPEND | LOCK_EX);
            }
        }

    }

?>