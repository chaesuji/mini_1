<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); 
    define( "URL_DB", DOC_ROOT."src/mini_board/common/db_common.php");
    define( "URL_HEADER", DOC_ROOT."src/mini_board/board_header.php");
    include_once( URL_DB );
    // var_dump($_SERVER, $_GET, $_POST);

    // request method를 획득
    $http_method = $_SERVER["REQUEST_METHOD"];
    // var_dump($_SESSION);
    // $_SESSION : session에 관련된 모든 젇보 포함
    // session : 필요한 데이터를 서버에 저장하는 것
    // print_r($http_method);

    $board_no = 1;
    // get check
    if($http_method === "GET"){ // 전송 방식이 get 일 때
        if(array_key_exists( "board_no", $_GET )){
            $board_no = $_GET["board_no"];
        }
        $result_info = select_board_info_no( $board_no );
    }else{ // 전송 방식이 post 일 때
        $arr_post = $_POST; // $_POST -> 원본 데이터 / $arr_post : 원본 데이터를 복사하는 변수
        $arr_info = 
            array(
                "board_no" => $arr_post["board_no"] 
                ,"board_title" => $arr_post["board_title"]
                ,"board_contents" => $arr_post["board_contents"]
            );

        // update 
        $result_cnt = update_board_info_no( $arr_info );

        // select 
        // $result_info = select_board_info_no( $arr_post["board_no"] ); // 0412 del

        header( "Location: board_detail.php?board_no=".$arr_post["board_no"] ); // 수정을 한 후 디테일 페이지로 넘어감
        exit(); // 위의 행에서 redirect를 했기 때문에 이후의 소스코드는 실행할 필요가 없음 
    }

    //print_r($result_info);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/board_r.css">
    <script src="./JS/board.js"></script>
    <title>수정</title>
</head>
<body>
    <form action="board_update.php" method="post" class="form_cu">
        <div class="board_modify">
            <?php include("./board_header.php"); ?>
            <hr>
            <label for="bno">게시글 번호 : </label>
            <input type="text" name="board_no" id="bno" value="<?php echo $result_info['board_no'] ?>" readonly>
            <br>
            <label for="title">게시글 제목 : </label>
            <input type="text" name="board_title" id="title" value="<?php echo $result_info['board_title'] ?>">
            <br>
            <label for="content" class="text_area_label_u">게시글 내용 : </label>
            <textarea name="board_contents" id="contents" cols="50" rows="10"><?php echo $result_info['board_contents'] ?></textarea>
            <!-- <input type="text" name="board_contents" id="contents" value="<?php echo $result_info['board_contents'] ?>"> -->
            <br>
            <div class="btn_div">
                <!-- <button type="button" onclick="history.back();">이전</button> -->
                <button type="button">
                    <a class="btn_a" href="board_detail.php?board_no=<?php echo $result_info["board_no"] ?>">취소</a>
                </button>
                <button type="submit">확인</button>
            </div>
        </div>
    </form>
</body>
</html>