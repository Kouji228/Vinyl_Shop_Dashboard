<?php 
function alertGoBack($msg=""){
  echo "<script>
    alert('$msg');
    window.history.back();
  </script>";
}

function alertGoTo($msg="", $url="index.php"){
  echo "<script>
    alert('$msg');
    window.location.href = '$url';
  </script>";
}

function clickGoBack($text="回上一頁"){
  echo "<button onclick='goBack()'>$text</button>";
  echo "<script>
  function goBack() {
    window.history.back();
  }
  </script>";
}

function clickGoTo($text="回上一頁", $url="index.php"){
  echo "<button onclick='goBack()'>$text</button>";
  echo "<script>
  function goBack() {
    window.location.href = '$url';
  }
  </script>";
}

function timeoutGoBack($time=1000){
  echo "<script>
  setTimeout(function() {
    window.history.back();
  }, $time);
  </script>";
}

function timeoutGoTo($url="index.php", $time=1000){
  echo "<script>
  setTimeout(function() {
    window.location.href = '$url';
  }, $time);
  </script>";
}


?>