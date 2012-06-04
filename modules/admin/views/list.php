<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" />
<title><?=$title?></title>
<?=View::factory('header')?>

<!-- Main wrapper -->
<div class="wrapper">

	<!-- Left navigation -->
    <div class="leftNav">
    	<?=View::factory('menu')?>
    </div>
	
	<!-- Content -->
	<script>
	$(function(){
        oTable = $('#datalist').dataTable({
        "aaSorting":[<?=$aasorting?>],
        "bJQueryUI": true,
        "sPaginationType": "full_numbers",
        "sDom": '<""f>t<"F"lp>'
         });
		//$('#datalist').dataTable();
	})
	</script>
    <div class="content">
    	<div class="title"><h5><?=$title?></h5></div>
        
       
        
        <!-- Dynamic table -->
        <div class="table">
            <div class="head"><h5 class="iFrames">Dynamic table</h5></div>
            <table cellpadding="0" cellspacing="0" border="0" class="display" id="datalist">
                <thead>
                   <tr>
                    	<? foreach($columns as $k=>$col):?>
                        <th><?=$col['name']?></th>
                        <? endforeach;?>
                        <th>操作</th>
                                
								
					</tr>
                </thead>
                <tbody>
                    <? foreach($data as $v):?>
                            <tr class="gradeA">
                            <? foreach($columns as $k=>$col):?>
                               <td><?=$obj::$col['func']($v->$k)?></td>
                            <? endforeach;?>
                           	   <td><?=$obj::handle($v->$pk)?></td>
                            </tr>
                        <? endforeach;?>
                </tbody>
            </table>
        </div>
        
    </div>
    <div class="fix"></div>
</div>

<!-- Footer -->
<?=View::factory('footer')?>

</body>
</html>
