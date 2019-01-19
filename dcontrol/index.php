<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title>File control</title>
<link href="css/control.css" rel="stylesheet" type="text/css" media="screen" />
<script src="jscript/control.js" type="text/javascript"></script>
<script src="jscript/fmsajax.js" type="text/javascript"></script>
</head>
<body onload="init();">
<div id="menu">
<div id="m_general" class="mbutt" onclick="selectMenu('general');" onmouseover="setStatus('general');" onmouseout="resetStatus();" > </div>
<div id="m_filter" class="mbutt" onclick="selectMenu('filter');" onmouseover="setStatus('filter');" onmouseout="resetStatus();" > </div>
</div>
<div id="main">
<div id="general">
general
</div>
<div id="filter">
filter
</div>
</div>
<div id="foot">
<div id="status" />
</div>
</body>
</html>
