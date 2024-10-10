<?php
    function global_fcn(){
        global $var;

        $var = $var + 10;
        echo "함수정의\$var = ".$var."<br>";
        return $var;
    }

    function GLOBALS_fcn(){
        $var = $GLOBALS["var"] + 10;

        echo "함수정의\$var = ".$var."<br>";
        return $var;
    }
?>