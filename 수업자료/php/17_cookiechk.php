<?php
    if(isset($_COOKIE['regid'])){
        echo "my cookie is ".$_COOKIE['regid'];
    }else {
        echo "cookie not found";
    }
?>