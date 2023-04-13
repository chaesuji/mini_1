<?php
    function db_conn( &$param_conn ){
        $host = "localhost";
        $user = "root";
        $password = "root506";
        $dbname = "board";
        $charset = "utf8mb4";
        $dns = "mysql:host=".$host."; dbname=".$dbname."; charset=".$charset;
        $pdo_option =  
        array(
            PDO::ATTR_EMULATE_PREPARES => false
            , PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            , PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        );

        try {
            $param_conn = new PDO( $dns, $user, $password, $pdo_option );
        } catch (Exception $e) {
            $param_conn = null;
            throw new Exception($e->getMessage());
        }
    }
    
    function select_board_info_paging( &$param_arr ){
        $sql = 
        " SELECT "
            ." board_no "
            ." ,board_title "
            ." ,board_write_date "
        ." FROM "
            ." board_info "
        ." WHERE "
            ." board_del_flg = '0' "
        ." ORDER BY "
            ." board_no DESC "
        ." LIMIT :limit_num OFFSET :offset ";

        $arr_prepare = array(
            ":limit_num" => $param_arr["limit_num"]
            ,":offset" => $param_arr["offset"]
        );

        $conn = null;

        try {
            db_conn( $conn );
            $stmt = $conn->prepare( $sql );
            $stmt->execute( $arr_prepare );
            $result = $stmt->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        } finally {
            $conn = null;
        }

        return $result;
    }

    // 게시글의 총 카운트 가져오기
    function select_board_info_cnt(){
        $sql = 
        " SELECT "
            ." COUNT(board_no) cnt "
        ." FROM "
            ." board_info "
        ." WHERE "
            ." board_del_flg = '0' ";
        
        $arr_prepare = array();
        $conn = null;
        try {
            db_conn( $conn );
            $stmt = $conn->prepare( $sql );
            $stmt->execute( $arr_prepare );
            $result = $stmt->fetchAll();
        } catch (Exception $e) {
            return $e->getMessage();
        } finally {
            $conn = null;
        }
        return $result;
    }

        // 특정 게시글 정보 검색
        function select_board_info_no( &$param_no ){
            $sql = 
            " SELECT "
                ." board_no "
                ." ,board_title "
                ." ,board_contents "
                ." ,board_write_date "
            ." FROM "
                ." board_info "
            ." WHERE "
                ." board_no = :board_no ";
            
            $arr_prepare = array(
                ":board_no" => $param_no
            );
            $conn = null;
            try {
                db_conn( $conn );
                $stmt = $conn->prepare( $sql );
                $stmt->execute( $arr_prepare );
                $result = $stmt->fetchAll();
            } catch (Exception $e) {
                return $e->getMessage();
            } finally {
                $conn = null;
            }
            return $result[0];
        }
    // TODO : test Start
    $i = 1;
        // print_r(select_board_info_no( $i ));
    // TODO : test End

    // 게시판 특정 게시물 정보 수정
    function update_board_info_no( &$param_arr ){
        $sql = 
            " UPDATE "
                ." board_info "
            ." SET "
                ." board_title = :board_title "
                ." ,board_contents = :board_contents "
            ." WHERE "
                ." board_no = :board_no ";

        $arr_prepare = 
            array(
                ":board_title" => $param_arr["board_title"]
                ,":board_contents" => $param_arr["board_contents"]
                ,":board_no" => $param_arr["board_no"]
            );
        $conn = null;
        try {
            db_conn( $conn ); // PDO object set(=DB 연결)
            $conn->beginTransaction(); // Transcation 시작
            $stmt = $conn->prepare( $sql ); // statement object set
            $stmt->execute( $arr_prepare ); // DB request
            $result_cnt = $stmt->rowCount(); // rowCount() : update된 컬럼의 갯수를 나타냄
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            return $e->getMessage();
        } finally {
            $conn = null;
        }
        return $result_cnt;
    }
    // $arr =
    //     array(
    //         "board_no" => 1
    //         ,"board_title" => "test1"
    //         ,"board_contents" => "test1"
    //     );

    // echo update_board_info_no( $arr );

    // 게시판 특정 게시물 삭제
    function delete_board_info_no( &$param_no ){
        $sql =
            " UPDATE "
                ." board_info "
            ." SET "
                ." board_del_flg = '1' "
                ." ,board_del_date = NOW() "
            ." WHERE "
                ." board_no = :board_no ";

        $arr_prepare = 
            array(
                ":board_no" => $param_no
            );
        $conn = null;
        try {
            db_conn( $conn ); 
            $conn->beginTransaction(); 
            $stmt = $conn->prepare( $sql ); 
            $stmt->execute( $arr_prepare ); 
            $result_cnt = $stmt->rowCount(); 
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            return $e->getMessage();
        } finally {
            $conn = null;
        }
        return $result_cnt;
    }

    // 게시판 게시물 입력 
    function insert_board_info( &$param_arr ){
        $sql = 
            " INSERT INTO "
                ." board_info "
            ." ( "
                ." board_title "
                ." ,board_contents "
                ." ,board_write_date "
            ." ) "
            ." VALUES "
            ." ( "
                ." :board_title "
                ." ,:board_contents "
                ." ,NOW() "
            ." ) ";

        $arr_prepare =
            array(
                ":board_title" => $param_arr["board_title"]
                ,":board_contents" => $param_arr["board_contents"]
            );
        
        $conn = null;
        try {
            db_conn( $conn ); 
            $conn->beginTransaction(); 
            $stmt = $conn->prepare( $sql ); 
            $stmt->execute( $arr_prepare ); 
            $result_cnt = $stmt->rowCount(); 
            $conn->commit();
        } catch (Exception $e) {
            $conn->rollback();
            return $e->getMessage();
        } finally {
            $conn = null;
        }
        return $result_cnt;
    }

    // TO DO 
    // $arr = array(
    //     "board_title" => "test", 
    //     "board_contents" => "test"
    // );
    // echo insert_board_info($arr);
?>