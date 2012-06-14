<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?=$title?></title>
<link href="<?=Kohana::$base_url?>assets/admin/css/main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/jquery-1.7.1.min.js"></script>

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/spinner/jquery.mousewheel.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/spinner/ui.spinner.js"></script>

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/jquery-ui.min.js"></script> 

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/wysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/wysiwyg/wysiwyg.image.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/wysiwyg/wysiwyg.link.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/wysiwyg/wysiwyg.table.js"></script>

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/flot/jquery.flot.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/flot/jquery.flot.orderBars.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/flot/jquery.flot.pie.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/flot/excanvas.min.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/flot/jquery.flot.resize.js"></script>

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/tables/jquery.dataTables.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/tables/colResizable.min.js"></script>

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/forms/forms.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/forms/autogrowtextarea.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/forms/autotab.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/forms/jquery.validationEngine-en.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/forms/jquery.validationEngine.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/forms/jquery.dualListBox.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/forms/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/forms/jquery.maskedinput.min.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/forms/jquery.inputlimiter.min.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/forms/jquery.tagsinput.min.js"></script>

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/other/calendar.min.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/other/elfinder.min.js"></script>

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/uploader/plupload.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/uploader/plupload.html5.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/uploader/plupload.html4.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/uploader/jquery.plupload.queue.js"></script>

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.progress.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.jgrowl.js"></script>
<script type="texts/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.tipsy.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.alerts.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.colorpicker.js"></script>

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/wizards/jquery.form.wizard.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/wizards/jquery.validate.js"></script>

<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.breadcrumbs.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.collapsible.min.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.ToTop.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.listnav.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.sourcerer.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.timeentry.min.js"></script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/plugins/ui/jquery.prettyPhoto.js"></script>

<!-- jQuery Fancy Box -->
<script type="text/javascript" SRC="<?=Kohana::$base_url?>assets/admin/js/plugins/fancybox/jquery.mousewheel-3.0.4.pack.js"></script>
<script type="text/javascript" SRC="<?=Kohana::$base_url?>assets/admin/js/plugins/fancybox/jquery.fancybox-1.3.4.pack.js"></script>
<link rel="stylesheet" type="text/css" href="<?=Kohana::$base_url?>assets/admin/js/plugins/fancybox/jquery.fancybox-1.3.4.css" media="screen" />

<script>
var base_url = "<?=Kohana::$base_url?>" ;
</script>
<script type="text/javascript" src="<?=Kohana::$base_url?>assets/admin/js/custom.js"></script>

</head>

<body>

<!-- Top navigation bar -->
<div id="topNav">
    <div class="fixed">
        <div class="wrapper">
            <div class="welcome"><a href="#" title=""><img src="<?=Kohana::$base_url?>assets/admin/images/userPic.png" alt="" /></a><span>Howdy, Eugene!</span></div>
            <div class="userNav">
                <ul>
                    <li><a href="login.html" title=""><img src="<?=Kohana::$base_url?>assets/admin/images/icons/topnav/logout.png" alt="" /><span>Logout</span></a></li>
                </ul>
            </div>
            <div class="fix"></div>
        </div>
    </div>
</div>




<!-- Header -->
<div id="header" class="wrapper">
    <div class="logo"><a href="/" title=""><img src="<?=Kohana::$base_url?>assets/admin/images/loginLogo.png" alt="" /></a></div>
    <div class="middleNav">
       <ul>
            <!-- <li class="iMes"><a href="#" title=""><span>Support tickets</span></a><span class="numberMiddle">9</span></li>
            <li class="iStat"><a href="#" title=""><span>Statistics</span></a></li>
            <li class="iUser"><a href="#" title=""><span>User list</span></a></li>
            <li class="iOrders"><a href="#" title=""><span>Billing panel</span></a></li> -->
            <?if(isset($content)):?>
            <li class="iAdd"><a href="./add" title=""><span>添加新数据</span></a></li>
            <li class="iList"><a href="./list" title=""><span>返回数据列表</span></a><span class="numberMiddle"><?=$count?></span></li>
            <?endif;?>
        </ul>
    </div>
    <div class="fix"></div>
</div>

<!-- Main wrapper -->
<div class="wrapper">

	<!-- Left navigation -->
    <div class="leftNav">
    	<?=View::factory('menu')?>
    </div>
	
	<!-- Content -->
	
    <div class="content">
    <?=View::factory($content)?>	        
    </div>
    <div class="fix"></div>
</div>

<!-- Footer -->
<div id="footer">
    <div class="wrapper">
        <span>&copy; Copyright 2012. All rights reserved.</span>
    </div>
</div>

</body>
</html>