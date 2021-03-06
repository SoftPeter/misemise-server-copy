<?php

/* ******************   MiseMise   ****************** */
function locationSearch($location, $page) // 주소 검색 - KakaoAPI
{
    $path = "/v2/local/search/address.json";
    $api_server = 'https://dapi.kakao.com';
    $headers = array('Authorization: KakaoAK 0ffbef86df8174ccb10697480464f8dc ');
    $max_size = 30; // 카카오 API 주소 검색 최대치 : 30
    $opts = array(CURLOPT_URL => $api_server.$path."?query=".urlencode($location)."&page=".$page."&size=".$max_size,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPGET => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSLVERSION => true,
        CURLOPT_HEADER => false,
        CURLOPT_HTTPHEADER => $headers);
    $ch = curl_init();
    curl_setopt_array($ch, $opts);

    $response = curl_exec ($ch);

    curl_close ($ch);
    return $response;

}


function transFormation($tm_x, $tm_y)   //  좌표계 WGS84 를 TM 으로 변환
{
    //https://dapi.kakao.com/v2/local/geo/transcoord.json?x=160710.37729270622&y=-4388.879299157299&input_coord=WTM&output_coord=WGS84
    $path = "/v2/local/geo/transcoord.json";
    $api_server = 'https://dapi.kakao.com';
    $coord = "&input_coord=WGS84&output_coord=TM";
    $headers = array('Authorization: KakaoAK 0ffbef86df8174ccb10697480464f8dc');

    $opts = array(CURLOPT_URL => $api_server.$path."?x=".$tm_x."&y=".$tm_y.$coord,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPGET => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSLVERSION => true,
        CURLOPT_HEADER => false,
        CURLOPT_HTTPHEADER => $headers);
    $ch = curl_init();
    curl_setopt_array($ch, $opts);


    $response = curl_exec ($ch);

    curl_close ($ch);
    return $response;
}

function FindLocation($tm_x, $tm_y) //  x,y 값을 행정구역정보로 변환
{
    $path = "/v2/local/geo/coord2regioncode.json";
    $api_server = 'https://dapi.kakao.com';
    $headers = array('Authorization: KakaoAK 0ffbef86df8174ccb10697480464f8dc');

    $opts = array(CURLOPT_URL => $api_server.$path."?x=".$tm_x."&y=".$tm_y,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPGET => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSLVERSION => true,
        CURLOPT_HEADER => false,
        CURLOPT_HTTPHEADER => $headers);
    $ch = curl_init();
    curl_setopt_array($ch, $opts);

    $response = curl_exec ($ch);

    curl_close ($ch);
    return $response;
}

function findNearStation($tm_x, $tm_y)
{
    //http://openapi.airkorea.or.kr/openapi/services/rest/MsrstnInfoInqireSvc/getNearbyMsrstnList?tmX=210895.593623738&tmY=411629.47873038985&ServiceKey=5SLS29uFgnvXyqTaiULbagIAgjy82u6Gd%2BZOOumtbOPC7K9JoS%2B4Vg10CR5I%2BA019DHMRccq1x%2B8DnBdMA%2B7bA%3D%3D&_returnType=json
    //http://openapi.airkorea.or.kr/openapi/services/rest/MsrstnInfoInqireSvc/getNearbyMsrstnList?tmX=210895.593623738&tmY=411629.47873038985&ServiceKey=5SLS29uFgnvXyqTaiULbagIAgjy82u6Gd%2BZOOumtbOPC7K9JoS%2B4Vg10CR5I%2BA019DHMRccq1x%2B8DnBdMA%2B7bA%3D%3D&_returnType=json
    $api_server = 'http://openapi.airkorea.or.kr/openapi/services/rest/MsrstnInfoInqireSvc/getNearbyMsrstnList';
    $key = '5SLS29uFgnvXyqTaiULbagIAgjy82u6Gd%2BZOOumtbOPC7K9JoS%2B4Vg10CR5I%2BA019DHMRccq1x%2B8DnBdMA%2B7bA%3D%3D';
    $type = "&_returnType=json";

    $opts = array(CURLOPT_URL => $api_server."?tmX=".$tm_x."&tmY=".$tm_y."&ServiceKey=".$key.$type,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPGET => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSLVERSION => true,
        CURLOPT_HEADER => false);

    $ch = curl_init();
    curl_setopt_array($ch, $opts);


    $response = curl_exec ($ch);

    curl_close ($ch);
    return $response;
}

function findDust($stationName)
{

    $api_server = 'http://openapi.airkorea.or.kr/openapi/services/rest/ArpltnInforInqireSvc/getMsrstnAcctoRltmMesureDnsty';
//    $key = '5SLS29uFgnvXyqTaiULbagIAgjy82u6Gd%2BZOOumtbOPC7K9JoS%2B4Vg10CR5I%2BA019DHMRccq1x%2B8DnBdMA%2B7bA%3D%3D';
//    $key = 'bC8E3RFKTwl2QjJFJyYSRAbtQx836O4Xhe6oGxbLEOtifnKm14fx81tkv1Sra5Sgenm4RrRxbjCVjb2yGsbKjA%3D%3D';
    $key = 'ORVUQ7GgsWjq1R4bPXnKqMIUZCOPTTdaqgDb4eUrQTWxQi3cWpwggNbkEvkswAeb48zv51sFYuk59hUrh0VYOQ%3D%3D';

    $term = "DAILY";
    $pageNo = 1;
    $numOfRows = 1;
    $ver = "1.3";
    $type = "&_returnType=json";

    $opts = array(CURLOPT_URL => $api_server."?stationName=".$stationName."&dataTerm=".$term."&pageNo=".$pageNo."&numOfRows=".$numOfRows."&ServiceKey=".$key."&ver=".$ver.$type,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPGET => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSLVERSION => true,
        CURLOPT_HEADER => false);

    $ch = curl_init();
    curl_setopt_array($ch, $opts);


    $response = curl_exec ($ch);

    curl_close ($ch);
    return $response;
}

function StationValue($json_result, $station_result, $target){
    $Checking = "0";
    if(($json_result->list[0]->$target) != "-"){//} || ($json_result->list[0]->$target) != ""){
        return $json_result->list[0]->$target;
    } else {    //  '-' 일 경우 다음으로 가까운 측정소에서 탐색
        $nextStationName = $station_result->list[1]->stationName;
        $nextResult = findDust($nextStationName);
        $next_result = json_decode($nextResult);
        if(($next_result->list[0]->$target) != '-'){//} or ($json_result->list[0]->$target) != ''){
            return $next_result->list[0]->$target;
        } else {    //  '-' 일 경우 다음으로 가까운 측정소에서 탐색
            $nextStationName = $station_result->list[2]->stationName;
            $nextResult2 = findDust($nextStationName);
            $next_result2 = json_decode($nextResult2);
            if(($next_result2->list[0]->$target) != '-') {//} or ($json_result->list[0]->$target) != ''){
                return $next_result2->list[0]->$target;
            } else {
                return $Checking;
            }
        }
    }

}

function StationGrade($json_result, $station_result, $target){
    $Checking = "0";

    if(($json_result->list[0]->$target) != ""){//} || ($json_result->list[0]->$target) != ""){
        return $json_result->list[0]->$target;
    } else {    //  '-' 일 경우 다음으로 가까운 측정소에서 탐색
        $nextStationName = $station_result->list[1]->stationName;
        $nextResult = findDust($nextStationName);
        $next_result = json_decode($nextResult);
        if(($next_result->list[0]->$target) != ''){//} or ($json_result->list[0]->$target) != ''){
            return $next_result->list[0]->$target;
        } else {    //  '-' 일 경우 다음으로 가까운 측정소에서 탐색
            $nextStationName = $station_result->list[2]->stationName;
            $nextResult2 = findDust($nextStationName);
            $next_result2 = json_decode($nextResult2);
            if(($next_result2->list[0]->$target) != '') {//} or ($json_result->list[0]->$target) != ''){
                return $next_result2->list[0]->$target;
            } else {
                return $Checking;
            }
        }
    }
}

function StationName($json_result, $station_result, $target){
    $Checking = "0";
    if(($json_result->list[0]->$target) != '-'){
        return $station_result->list[0]->stationName;
    } else {    //  '-' 일 경우 다음으로 가까운 측정소에서 탐색
        $nextStationName = $station_result->list[1]->stationName;
        $nextResult = findDust($nextStationName);
        $next_result = json_decode($nextResult);
        if(($next_result->list[0]->$target) != '-'){
            return $station_result->list[1]->stationName;
        } else {    //  '-' 일 경우 다음으로 가까운 측정소에서 탐색
            $nextStationName = $station_result->list[2]->stationName;
            $nextResult2 = findDust($nextStationName);
            $next_result2 = json_decode($nextResult2);
            if(($next_result2->list[0]->$target) != '-'){
                return $station_result->list[2]->stationName;
            } else {
                return $Checking;
            }
        }
    }
}

function StationMang($json_result, $station_result, $target){
    $Checking = "0";
    if(($json_result->list[0]->$target) != '-'){//} || ($json_result->list[0]->mangName) != ''){
        return $json_result->list[0]->mangName;
    } else {    //  '-' 일 경우 다음으로 가까운 측정소에서 탐색
        $nextStationName = $station_result->list[1]->stationName;
        $nextResult = findDust($nextStationName);
        $next_result = json_decode($nextResult);
        if(($next_result->list[0]->$target) != '-'){//} || ($next_result->list[0]->mangName) != ''){
            return $next_result->list[0]->mangName;
        } else {    //  '-' 일 경우 다음으로 가까운 측정소에서 탐색
            $nextStationName = $station_result->list[2]->stationName;
            $nextResult2 = findDust($nextStationName);
            $next_result2 = json_decode($nextResult2);
            if(($next_result2->list[0]->$target) != '-'){//} || ($next_result2->list[0]->mangName) != ''){
                return $next_result2->list[0]->mangName;
            } else {
                return $Checking;
            }
        }
    }
}

function map()  //  데이터베이스에서 모든 측정소의 정보를 가져옴
{
    $pdo = pdoSqlConnect();
    $query = "Select no,
                    station_name,
                    tm_x,
                    tm_y
            from station;";
    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}


function MapValue($json_result, $target)    //  측정소의 미세먼지, 초미세먼지, 등급을 반환
{
    $Checking = 0;
    if (($json_result->list[0]->$target) != '-' && ($json_result->list[0]->$target) != '') {
        return $json_result->list[0]->$target;
    } else {    //  '-' 일 경우 다음으로 가까운 측정소에서 탐색
        return $Checking;
    }
}

function mapDetail($mapNo)
{
    $pdo = pdoSqlConnect();
    $query = "select station.no,
       station.station_name,
       station.x,
       station.y,
       case when map_status.pm10_value = 0
           then concat('점검중 ', -1, 'μg/m3')
           else concat(map_status.pm10_value, 'μg/m3')
        end as pm10_value,
       case when map_status.pm25_value = 0
           then concat('점검중 ', -1, 'μg/m3')
           else concat(map_status.pm25_value, 'μg/m3')
        end as pm25_value,
       case when map_status.current_grade = 0
           then '점검중'
           when map_status.current_grade = 1
           then '좋음'
           when map_status.current_grade = 2
           then '양호'
           when map_status.current_grade = 3
           then '보통'
           else '나쁨'
        end as current_grade
from station
left outer join (select map_status.no, pm10_value, pm25_value, current_grade from map_status) as map_status
on station.no = map_status.no
where station.no = ?;";

    $st = $pdo->prepare($query);
    $st->execute([$mapNo]);
    //    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function allMaps()
{
    $pdo = pdoSqlConnect();
    $query = "select station.no,
       station.station_name,
       station.x,
       station.y,
       case when map_status.pm10_value = 0
           then concat('점검중 ', -1, 'μg/m3')
           else concat(map_status.pm10_value, 'μg/m3')
        end as pm10_value,
       case when map_status.pm25_value = 0
           then concat('점검중 ', -1, 'μg/m3')
           else concat(map_status.pm25_value, 'μg/m3')
        end as pm25_value,
       case when map_status.current_grade = 0
           then '점검중'
           when map_status.current_grade = 1
           then '좋음'
           when map_status.current_grade = 2
           then '양호'
           when map_status.current_grade = 3
           then '보통'
           else '나쁨'
        end as current_grade
from station
left outer join (select map_status.no, pm10_value, pm25_value, current_grade from map_status) as map_status
on station.no = map_status.no;";
    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function fineDust_map($stationName) //  fineDust 와 Key 값이 다르고 map 스케줄러를 위한 함수
{
    $api_server = 'http://openapi.airkorea.or.kr/openapi/services/rest/ArpltnInforInqireSvc/getMsrstnAcctoRltmMesureDnsty';
    $key = 'bC8E3RFKTwl2QjJFJyYSRAbtQx836O4Xhe6oGxbLEOtifnKm14fx81tkv1Sra5Sgenm4RrRxbjCVjb2yGsbKjA%3D%3D';
    $term = "month";
    $ver = "1.3";
    $type = "&_returnType=json";

    $opts = array(CURLOPT_URL => $api_server."?stationName=".$stationName."&dataTerm=".$term."&ServiceKey=".$key."&ver=".$ver.$type,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPGET => true,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_SSL_VERIFYHOST => 0,
        CURLOPT_SSLVERSION => true,
        CURLOPT_HEADER => false);

    $ch = curl_init();
    curl_setopt_array($ch, $opts);


    $response = curl_exec ($ch);

    curl_close ($ch);
    return $response;
}


function notice()   //  공지사항 반환
{
    $pdo = pdoSqlConnect();
    $query = "select no,
                title,
                concat('Ver ', version) as version,
                content
            from notices
            order by created_at DESC
            LIMIT 1;";

    $st = $pdo->prepare($query);

    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res[0];
}

function hourForecast($hourNo)  //  현재시간 +12 시간까지의 정보 반환
{
    $pdo = pdoSqlConnect();

    $query = "select no,
       case when HOUR(hour) = 0
           then concat('오전12시')
           when HOUR(hour) < 12
           then concat('오전', HOUR(hour), '시')
           when HOUR(hour) = 12
           then concat('오후12시')
           else concat('오후', HOUR(hour)-12, '시')
           end as hour,
       case when current_grade = 1
           then '좋음'
           when current_grade = 2
           then '양호'
           when current_grade = 3
           then '보통'
           else '나쁨'
           end as current_grade
from hour_forecast
where no = $hourNo;";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;
    return $res[0];
}

function timeDistance($now, $yoil)  //  현재 시간과 요일을 활용해서 아침, 점심, 저녁 어디에 더 가까운지 찾기
{
    $pdo = pdoSqlConnect();

    $query = "select day_forecast.no,
       day,
       day_forecast.time,
       day_forecast.current_status_grade,
       ABS(?-HOUR(time)) as distance
from days
right outer join (select day_forecast.no, day_no,time, current_status_grade from day_forecast) day_forecast
    on days.no = day_forecast.day_no
where day=?
order by distance
limit 1";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$now, $yoil]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;
    return $res[0];
}


function dayForecast($time) //  현재 시간으로터 (아침[1]_[4], 점심[2]_[5], 저녁[3]_[6]) 단위로 14번째 후 까지 보여줌
{
    $pdo = pdoSqlConnect();

    $query = "select day_forecast.no,
       concat(day, '요일') as day,
       case when HOUR(day_forecast.time) = 0
            then '아침'
            when HOUR(day_forecast.time) = 9
            then '점심'
            when HOUR(day_forecast.time) = 17
            then '저녁'
        end as time,
       case when day_forecast.current_status_grade = 1
           then '좋음'
           when day_forecast.current_status_grade = 2
           then '양호'
           when day_forecast.current_status_grade = 3
           then '보통'
           else '나쁨'
        end as current_grade
from days
right outer join (select day_forecast.no, day_no,time, current_status_grade from day_forecast) day_forecast
    on days.no = day_forecast.day_no
where day_forecast.no = ?;";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute([$time]);
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;
    return $res[0];
}


function sendPushMapUpdate($to = ''){   //  Fcm Token 을 받아 알림 푸시
    $apiKey = 'AAAAKX9eur0:APA91bH0ybAgZWKjWxUnzJwFkVmFbRZnwwD1P30EhWzq0cj370-k5NaE80Kz9djoj-QO9aUiWsTp6fIBtGYoZW8PIJ2EuagQftUQI4disHFE4RzXdDZ7pFSY0gbYVVnlEExweqITbd8M';

    $title = "Map Update";
    $body = "Hello Map Update Seccess!";
    $notification = array('title' => $title, 'body' => $body, 'sound' => 'default', 'badge' => '1');
    $arrayToSend = array('to' =>  $to, 'notification' => $notification, 'priority' => 'high');

    $json = json_encode($arrayToSend);
    $headers = array('Authorization: key='.$apiKey, 'Content-Type: application/json');

    $url = 'https://fcm.googleapis.com/fcm/send';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST,"POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);
    $result = curl_exec($ch);
    curl_close($ch);
    return json_decode($result, true);

}

function fcmToken() //  fcm_users 테이블의 모든 token 을 가져옴
{
    $pdo = pdoSqlConnect();
    $query = "select idx, token from fcm_users;";

    $st = $pdo->prepare($query);
    //    $st->execute([$param,$param]);
    $st->execute();
    $st->setFetchMode(PDO::FETCH_ASSOC);
    $res = $st->fetchAll();

    $st = null;
    $pdo = null;

    return $res;
}

function grade_to_string($target){
    //1=좋음, 2=보통, 3=나쁨, 4=매우나쁨
    if($target == 1){
        return "좋음";
    } else if($target == 2){
        return "보통";
    } else if($target == 3){
        return "나쁨";
    } else if($target == 4){
        return "매우나쁨";
    } else{
        return "점검중";
    }
}

function deeplink()
{
    $deeplink = "https://dowellcomputer.page.link/Goto";
    return $deeplink;
}


function rtdbGet(){
//    https://fcm-example-8a076.firebaseio.com/notice
    // Constants
    $FIREBASE = "https://fcm-example-8a076.firebaseio.com/";
    $NODE_GET = "notice.json";

// Initialize cURL
    $curl = curl_init();

// Read
    curl_setopt( $curl, CURLOPT_URL, $FIREBASE . $NODE_GET );

// Get return value
    curl_setopt( $curl, CURLOPT_RETURNTRANSFER, true );
    curl_setopt($curl, CURLOPT_POST, false);
    curl_setopt ($curl, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);


// Make request
// Close connection
    $response = curl_exec( $curl );
    curl_close( $curl );
    $response = json_decode( $response );
// Show result
    return $response;
}

function rtdbPatch($title, $content, $version){
//    https://fcm-example-8a076.firebaseio.com/notice
    $FIREBASE = "https://fcm-example-8a076.firebaseio.com/";
    $NODE_PATCH = "notice.json";

    $boolean_result = true;
    if($version != "") {
        if ($title == "" and $content != "") {
            $data = array(
                "content" => $content,
                "version" => $version
            );
        } else if ($content == "" and $title != "") {
            $data = array(
                "title" => $title,
                "version" => $version
            );
        } else {
            $data = array(
                "title" => $title,
                "content" => $content,
                "version" => $version
            );
        }
    } else {
        $data = array();
        $boolean_result = false;
    }

// JSON encoded
    $json = json_encode( $data );

// Initialize cURL
    $curl = curl_init();

// Update
    curl_setopt( $curl, CURLOPT_URL, $FIREBASE . $NODE_PATCH );
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PATCH" );
    curl_setopt( $curl, CURLOPT_POSTFIELDS, $json );

// Make request
// Close connection
    $response = curl_exec( $curl );
    curl_close( $curl );
    return $boolean_result;
}


function dontLook($isShowNotice){
//    https://fcm-example-8a076.firebaseio.com/notice
    $FIREBASE = "https://fcm-example-8a076.firebaseio.com/";
    $NODE_PATCH = "notice.json";

    $boolean_result = true;

    $data = array(
        "isShowNotice" => $isShowNotice
    );


// JSON encoded
    $json = json_encode( $data );

// Initialize cURL
    $curl = curl_init();

// Update
    curl_setopt( $curl, CURLOPT_URL, $FIREBASE . $NODE_PATCH );
    curl_setopt( $curl, CURLOPT_CUSTOMREQUEST, "PATCH" );
    curl_setopt( $curl, CURLOPT_POSTFIELDS, $json );

// Make request
// Close connection
    $response = curl_exec( $curl );
    curl_close( $curl );
    return $boolean_result;
}