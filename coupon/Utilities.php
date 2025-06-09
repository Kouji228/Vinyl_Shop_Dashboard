<?php

function alertAndBack($msg = "")
{
    $jsMsg = json_encode($msg);
    echo "<script>
        alert($jsMsg);
        window.history.back();
    </script>";
}

function alertGoBack($msg = "")
{
    $jsMsg = json_encode($msg);
    echo "<script>
        alert($jsMsg);
        window.location='./pageMsgsList.php';
    </script>"; 
}

function alertGoTo($msg = "", $url = "./pageMsgsList.php")
{
    $jsMsg = json_encode($msg);
    $jsUrl = json_encode($url); // 同樣對 URL 進行處理以策安全
    echo "<script>
        alert($jsMsg);
        window.location=$jsUrl;
    </script>"; 
}


// 有預設值的參數要往最後放
function timeoutGoBack($time = 1000)
{
    echo "<script>
        setTimeout(()=>window.location='./pageMsgsList.php', $time);
    </script>";
}


function goBack()
{
    echo "<button onclick='goBack()'>回上一頁</button>";
    echo "<script>
            function goBack(){
                window.history.back();
            }
        </script>";
}
?>