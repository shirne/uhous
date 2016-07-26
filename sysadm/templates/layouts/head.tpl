<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{{ get_app_inf key='appName' }} v{{ get_app_inf key='appVersion' }}</title>

{{ load_css label='sysadm' files='global, layout, ui, pagenav, effects, jquery.treeview' version='20100424' }}

{{ load_js label='sysadm' files='jquery, jquery-ui, jquery.layout, jquery.treeview, layout, functions, jquery.purr' version='20100521' }}

<!--[if IE]>
{{ load_css label='sysadm-ie' files='ie' version='20100424' }}
<![endif]-->

<!--[if IE 6]>
{{ load_js label='fixpng' files='fixpng' version='20100424' }}
<script type="text/javascript">
    DD_belatedPNG.fix('.pngicon, img');
</script>
<![endif]-->

</head>

<body>

