<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
    <link href="/uploadify/uploadify.css" type="text/css" rel="stylesheet" />
    <script type="text/javascript" src="/uploadify/jquery-1.4.2.min.js"></script>
    <script type="text/javascript" src="/uploadify/swfobject.js"></script>
    <script type="text/javascript" src="/uploadify/jquery.uploadify.v2.1.4.min.js"></script>
    <script type="text/javascript">
    $(document).ready(function() {
      $('#file_upload').uploadify({
        'uploader'  : '/uploadify/uploadify.swf',
        'script'    : '/uploadify/uploadify.php',
        'cancelImg' : '/uploadify/cancel.png',
        'folder'    : '/uploadify/uploads',
        'auto'      : true,
		'multi'       : true
      });
    });
    </script>

</head>

<body>
    <!-- input id="file_upload" name="file_upload" type="file" / -->

</body>
</html>
