<?php 
function goBack()  {
    echo "<button onClick='goBack()'>回上一頁</button>";
    echo "<script>
    const goBack=()=>{
        window.history.back()
    }
    </script>";
}
function timeoutGoBack($time=2000) {
echo "<script>
setTimeout(()=>window.location='./pageMsgsList.php',$time)
</script>";
}

function alertGoTo($msg="",$url="./index.php") {
echo "<script>
    alert('$msg');
    window.location='$url';
    </script>";
}
function alertGoBack($msg="") {
echo "<script>
alert('$msg');
window.location='./index.php';
</script>";
}

function alertAndBack($msg="") {
echo "<script>
alert('$msg');
window.history.back();
</script>";
}

?>