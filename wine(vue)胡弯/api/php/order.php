<?php
    header('Access-Control-Allow-Origin:*');
    include "connect.php";
    $username = isset($_GET["userName"]) ? $_GET["userName"] : "";
    $state = isset($_GET["state"]) ? $_GET["state"] : "";
    $orderid = isset($_GET["orderid"]) ? $_GET["orderid"] : "";
    $goodsid = isset($_GET["goodsid"]) ? $_GET["goodsid"] : "";
    
    // SELECT `order`.orderid,`order`.state,`orderlist`.goodsid FROM `order`,`orderlist` WHERE `order`.orderid = `orderlist`.orderid and state = 1 and `order`.userName = 123
    // 数组长度
    // echo count($data);
    // 查询数据
    if($username != "" && $state != "" && $orderid == ""){
        $sql = "SELECT `order`.orderid,`order`.state,`orderlist`.goodsid FROM `order`,`orderlist` WHERE `order`.orderid = `orderlist`.orderid and state = '$state'";
        $result = $conn->query($sql);
        //使用查询结果集
        $row = $result->fetch_all(MYSQLI_ASSOC);
        // var_dump($row);
        if($result->num_rows>0){
            $arr_1 = array();
            $arr_2 = array();
            for($y=0;$y<count($row);++$y){
                $arr_2[0] = $row[$y];
                $num = explode(",",$row[$y]['goodsid']);
                // var_dump($arr_2);
                for($i=0;$i<count($num);++$i){
                    $sql1 = "SELECT * FROM `goods` WHERE id = $num[$i]";
                    $result1 = $conn->query($sql1);
                    //使用查询结果集
                    $row1 = $result1->fetch_all(MYSQLI_ASSOC);
                    $arr_2[$i+1] = $row1[0];
                }
                $arr_1[$y] = $arr_2;
                $arr_2 = array();
            }
            echo json_encode($arr_1,JSON_UNESCAPED_UNICODE);
        }else{
            echo "error:" . $sql . "<br>" . $conn->error;
        }
    }else if($username != "" && $state != "" && $orderid != "" && $goodsid != ""){
        $sql = "select * from `order` where orderid = '$orderid'";
        $result = $conn->query($sql);
        //使用查询结果集
        $row = $result->fetch_all(MYSQLI_ASSOC);
        // 更新结果
        if($result->num_rows>0){
            $sql1 = "update  `order` SET state = '$state' where userName = '$username' and orderid = '$orderid'";
            $result1 = $conn->query($sql1);
            $sql2 = "update  `orderlist` SET goodsid = '$goodsid' where orderid = '$orderid'";
            $result2 = $conn->query($sql2);
            echo "update";
        }else{
            // 新增数据
            $sql = "insert  into `order` (orderid,userName,state) values ('$orderid','$username','$state')";
            //使用查询结果集
            $sql1 = "insert into `orderlist` (orderid,goodsid) values ('$orderid','$goodsid')";
            $result = $conn->query($sql);
            $result1 = $conn->query($sql1);
            // 插入成功
            echo "ok";
        }
        
    }
    // 关闭连接
    $conn->close();

?>