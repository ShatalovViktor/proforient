<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Примеры. Знакомство с JavaScript API. Простой вызов карты.</title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="http://api-maps.yandex.ru/1.1/index.xml?key=AMnPoVEBAAAA8ROUPgQAVElcq07FwAhaB4DA3GgSy7h7_oYAAAAAAAAAAAAcMlpper11z1KrRoxTbhuIVW-hSw=="
	type="text/javascript"></script>
    <script type="text/javascript">
        window.onload = function () {
            var map = new YMaps.Map(document.getElementById("YMapsID"));
            map.setCenter(new YMaps.GeoPoint(37.64, 55.76), 10);
        }
    </script>
</head>
<body>
    <div id="YMapsID" style="width:600px;height:400px"></div>
</body>
</html>