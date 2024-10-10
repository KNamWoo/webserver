<?php
    function local_fcn(){
        $call_count;
        $call_count = $call_count + 1;
        echo "함수정의\$call_count = ".$call_count."<br>";
        return $call_count;
    }

    function static_fcn(){
        static $call_count;
        $call_count = $call_count + 1;
        echo "함수정의\$call_count = ".$call_count."<br>";
        return $call_count;
    }