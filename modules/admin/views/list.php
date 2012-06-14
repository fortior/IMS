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


    <div class="title"><h5><?=$title?></h5></div>
        <!-- Dynamic table -->

        <div class="table">
            <div class="head"><h5 class="iFrames">Data table</h5></div>
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