<script>
    $(function(){ 

        var validator = $("#formValidate").validate({
            rules: {
                <?php foreach($columns as $k=>$v):?>
                <?=$k?>: <?=$v['validate']['rules']?>  ,    
                <?php endforeach;?>         
            },
            messages: {
                <?php foreach($columns as $k=>$v):?>
                <?=$k?>:<?=$v['validate']['message']?>  ,    
                <?php endforeach;?>     
            },
            // the errorPlacement has to take the layout into account
            // errorPlacement: function(error, element) {
            //     error.insertAfter(element.parent().find('label:first'));
            // },
            // specifying a submitHandler prevents the default submit, good for the demo
            //submitHandler: function() {
            //  swfu.startUpload();
                //$("#vlcform").trigger('submit');
        //  },
            // set new class to error-labels to indicate valid fields
            // success: function(label) {
            //     // set &nbsp; as text for IE
            //     label.html("&nbsp;").addClass("ok");
            // }
        });
    })
</script>
<div class="title"><h5><?=$title?></h5></div>
<form id="formValidate" class="mainForm" method="post" action="<?=$pre_uri?>/save" enctype="multipart/form-data" >
        	<fieldset>
                <div class="widget">
                    <div class="head"><h5 class="iLocked">填写下面表单</h5></div>

                    <?php foreach($columns as $k=>$v):?>
                    <div class="rowElem">
                        <label><?=$v['name']?>:<span class="req">*</span></label>
                        <div class="formRight"><?=$v['field']?></div><div class="fix"></div>
                    </div>
                     <?php endforeach;?>
                    <div class="submitForm"><input type="submit" value="submit" class="redBtn" /></div>
                    <div class="fix"></div>
                </div>
                
            </fieldset>
        </form> 