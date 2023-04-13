<?php
    define( "DOC_ROOT", $_SERVER["DOCUMENT_ROOT"]."/" ); 
    define( "URL_DB", DOC_ROOT."src/mini_board/common/db_common.php");
    define( "URL_HEADER", DOC_ROOT."src/mini_board/board_header.php");
    include_once( URL_DB );

    // request parameter 획득
    $arr_get = $_GET;
    
    // db에서 게시글 정보 획득
    $result_info = select_board_info_no( $arr_get["board_no"]);
?>

<!DOCTYPE html>
<html lang="ko">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./CSS/board_r.css">
    <script src="./JS/board.js"></script>
    <title>Detail</title>
</head>
<body>
    <form action="">
        <div class="board_detail">
            <?php include("./board_header.php"); ?>
            <hr>
            <p class="detail_p_title">게시글 번호 : <span class="detail_p_content"><?php echo $result_info["board_no"] ?></span></p>
            <p class="detail_p_title">게시글 작성일 : <span class="detail_p"><?php echo $result_info["board_write_date"] ?></span></p>
            <p class="detail_p_title">게시글 제목 : <span class="detail_p"><?php echo $result_info["board_title"] ?></span></p>
            <label for="textarea_label" class="text_area_label">게시글 내용 : </label>
                <textarea id="textarea_label" cols="50" rows="10" class="detail_p"><?php echo $result_info["board_contents"] ?></textarea>
            <div class="btn_div">
                <!-- <button type="button" onclick="history.back();">이전</button> -->
                <button type="button" onclick="location.href='board_list.php'">이전</button>
                <button type="button">
                    <a class="a_mo_del" href="board_update.php?board_no=<?php echo $result_info["board_no"] ?>">수정</a>
                </button>
                <button type="button">
                    <a class="a_mo_del" href="board_delete.php?board_no=<?php echo $result_info["board_no"] ?>">삭제</a>
                </button>
                <!-- <button type="button" onclick="location.href='board_list.php'" >리스트</button> -->
            </div>
        </div>
    </form>
</body>
</html>