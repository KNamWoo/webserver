<?php
    $a = $_GET["birth"];
    $calc = $a%12;
    echo calc_jodiac($calc);

    function calc_jodiac($b){
        switch ($b) {
            case 0:{
                return '원숭이 띠 입니다.';
            }
            case 1:{
                return '닭 띠 입니다.';
            }
            case 2:{
                return '개 띠 입니다.';
            }
            case 3:{
                return '돼지 띠 입니다.';
            }
            case 4:{
                return '쥐 띠 입니다.';
            }
            case 5:{
                return '소 띠 입니다.';
            }
            case 6:{
                return '호랑이 띠 입니다.';
            }
            case 7:{
                return '토끼 띠 입니다.';
            }
            case 8:{
                return '용 띠 입니다.';
            }
            case 9:{
                return '뱀 띠 입니다.';
            }
            case 10:{
                return '말 띠 입니다.';
            }
            case 11:{
                return '양 띠 입니다.';
            }
        }
    }