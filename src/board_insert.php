<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); 
    define( "URL_DB", DOC_ROOT."src/mini_board/common/db_common.php");
    define( "URL_HEADER", DOC_ROOT."src/mini_board/board_header.php");
    include_once( URL_DB );

    $http_method = $_SERVER["REQUEST_METHOD"];
    if($http_method === "POST"){
        $arr_post = $_POST;
        // $arr_info = array(
        //     "board_title" => $arr_post["board_title"],
        //     "board_contents" => $arr_post["board_contents"]
        // );
        $result_cnt = insert_board_info( $arr_post );

        header( "Location: board_list.php" );
        exit();
    }

    
?>
<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/board_r.css">
    <script src="./JS/board.js"></script>
    <title>입력</title>
</head>
<body>
    <form action="board_insert.php" method="post" class="form_cu">
        <div class="board_insert">
            <?php include("./board_header.php"); ?>
            <hr>
            <!-- <h1></h1> -->
            <label for="title">제목 : </label>
            <input type="text" id="title" name="board_title" required >
            <br>
            <label for="contents" class="textarea_label_cu">내용 : </label>
            <textarea name="board_contents" id="contents" cols="50" rows="10" class="insert_textarea" required></textarea>
            <br>
            <div class="btn_div">
                <button type="submit">입력</button>
                <button type="button" onclick="location.href='board_list.php'">이전</button>
            </div>
        </div>
    </form>
</body>
</html>