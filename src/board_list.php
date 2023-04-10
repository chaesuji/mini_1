<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); 
    // $_SERVER['DOCUMENT_ROOT'] : 서버의 기본 경로를 확인, 
    // httpd.conf 파일에 설정된 웹 서버의 루트 디렉터리(= 현재 실행되고 있는 위치)를 의미
    // htdocs가 루트 디렉토리로 $_SERVER['DOCUMENT_ROOT'] 함수를 사용 
    define( "URL_DB", DOC_ROOT."src/common/db_common.php"); // 상수를 선언해 db_common.php 파일과 연결
    // echo DOC_ROOT;
    include_once( URL_DB );
    // $arr_get = $_GET;
    // $http_method = $_SERVER["REQUEST_METHOD"];
    // REQUEST_METHOD : 서버에게 네트워크로 어떤 명령을 보낼 때의 방식

    // $page_num = $arr_get["page_num"];
    // if( $http_method === "GET" ){
    //     $arr_get = $_GET;
    //     $page_num = $arr_get["page_num"];
    // }else{
    //     $page_num = 1;
    // }

    if( array_key_exists( "page_num", $_GET )){ // $_GET에 page_num이라는 값이 있으면
        // $_GET : get 방식으로 전송한 데이터를 자동으로 배열 형식으로 저장
        // array_key_exists : 배열의 키가 존재하는지 확인하는 함수 
        // array_key_exists("확인하고자 하는 키", [배열 명])
        $page_num = $_GET["page_num"]; // 해당 배열 값을 page_num에 저장
    }else{
        $page_num = 1; // 없다면 page_num에 1 저장해서 첫 번째 페이지부터 나타나도록 함
    }

    $limit_num = 5; // 한 페이지 당 게시물의 갯수

    // 게시판 정보 테이블 전체 카운트 획득
    $result_cnt = select_board_info_cnt(); // -> 2차원 연상 배열 : array ( [0] => Array ( [cnt] => 20 ) )

    // max page number / 전체 페이지 수 계산
    $max_page_num = ceil((int)$result_cnt[0]["cnt"] / $limit_num);

    // 1페이지 0, 2페이지 5, 3페이지 일 때 10 ... / offset(페이지 당 게시물이 시작하는 번호)
    $offset = ( $page_num * $limit_num ) - $limit_num;

    $arr_prepare = // statement 배열으로 값 넣기
    array(
        "limit_num" => $limit_num,
        "offset" => $offset
    );
    $result_paging = select_board_info_paging( $arr_prepare ); // 함수 -> sql 실행
    // print_r( $result_paging );
    // print_r($result_cnt);
    // print_r($max_page_num);

    // 터미널 + 옆 ▽(화살표) -> Command Prompt
    // xcopy D:\WorkSpace\mini_board\src C:\Apache24\htdocs\src \E \H \F \Y
    // 명령어(파일 복사) 복사할 파일의 경로 복사한 파일을 붙여넣기할 경로
    // /E : 디렉터리와 하위 디렉터리를 (비어 있어도) 복사한다.
    // /F : 복사하는 동안 원본과 대상 파일의 전체 경로 를 표시한다.
    // /H : 숨겨진 파일과 시스템 파일도 복사한다.
    // /Y : 이미 있는 대상 파일을 덮어쓸지를 확인하기 위해 묻는 것을 금한다.
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>게시판</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" 
    rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" 
    crossorigin="anonymous">
    <style>
        a{text-decoration: none;
    text-color:#96b3f0;}
    </style>
</head>
<body>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>게시글 번호</th>
                <th>게시글 제목</th>
                <th>작성일</th>
            </tr>
        </thead>
        <tbody class="table-group-divider">
            <?php
                foreach ($result_paging as $recode) {
            ?>
                <tr>
                    <td><?php echo $recode["board_no"]?></td>
                    <td><?php echo $recode["board_title"]?></td>
                    <td><?php echo $recode["board_write_date"]?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
    <?php
    for ($i=1; $i<=$max_page_num; $i++) { 
    ?>
        <a href='board_list.php?page_num=<?php echo $i ?>'>
            <?php echo $i ?>
        </a>
    <?php
    }
    ?>
</body>
</html>