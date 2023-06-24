<html>

<head>
  <script>
    var is_chrome = function() {
      return Boolean(window.chrome);
    }
    if (is_chrome) {
      window.print();
      setTimeout(function() {
        window.close();
      }, 10000);
      //give them 10 seconds to print, then close
    } else {
      window.print();
      // window.close();
    }
    // alert(is_chrome);
  </script>

<body onLoad="loadHandler();">