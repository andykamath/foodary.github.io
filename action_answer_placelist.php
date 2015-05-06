<!DOCTYPE html>
<html>
  <head>
    <title>Place searches</title>
    <meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <script src="js/jQuery.min.js"></script>
    <meta charset="utf-8">
    <style>
      html, body, #map-canvas {
        height: 100%;
        margin: 0px;
        padding: 0px
      }
    </style>
    <script src="http://code.jquery.com/mobile/1.3.0/jquery.mobile-1.3.0.min.js" type="text/javascript"></script>
    <script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true&libraries=places"></script>
    <script>
      if( navigator.geolocation )
      {
       // Call getCurrentPosition with success and failure callbacks
       navigator.geolocation.getCurrentPosition( success, fail );
      }
      else
      {
       alert("Sorry, your browser does not support geolocation services.");
      }
      function success(position)
      {
        var longitude = position.coords.longitude;
        var latitude = position.coords.latitude;
        text = latitude+","+longitude;
        sende(text);
      }
      function createRequestObject() {
        var o;     
        o = (window.ActiveXObject) ? new ActiveXObject("Microsoft.XMLHTTP") : new XMLHttpRequest();
        return o;
      }
      var http = createRequestObject(); 
      function sende(text) {
        http.open('get', 'action_answer_placelist.php?action='+text);
        http.onreadystatechange = handleResponse;
        http.send(null);
      }
      function handleResponse() {
        if(http.readyState == 4){
          var response = http.responseText;
          //      document.writeln(response);
          $.each(response, function(bb) {
            console.log (bb);
            console.log (a[bb]);
            console.log (a[bb].name);
          });
        }
      }
      function fail()
      {
        alert("Oops something went wrong. Please check your device's location settings");
      }
    </script>
  </head>
  <body>
    <div id="message"></div>
  </body>
</html>
