<?php
    $city = $_GET["city"];
    switch ($city){
        case '서울':{
            echo "서울지역의 소액임차인 보증한도 1.5억";
            break;
        }
        case '인천':case '경기':{
            echo "경인지역의 소액임차인 보증한도 1.3억";
            break;
        }
        case '부산':case '대구':case '광주':case '대전':{
            echo "광역시의 소액임차인 보증한도 0.7억";
            break;
        }
        default:
            echo "기타지역의 소액임차인 보증한도는 0.6억";
            break;
    }