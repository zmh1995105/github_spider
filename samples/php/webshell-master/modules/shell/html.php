<textarea style="width: 900px;height: 450px;background-color: #e9ecf0;" id="result"></textarea>
<br><br>
<input type="text" name="command" style="width: 800px"/> <button id="exec">执行</button><button id="clear">清屏</button>
<input type="hidden" id="url" value="<?php echo Controller::url('shell', 'exec', array('ajax'=>1))?>" />

<script>
$("#exec").on("click",function(){
    $.post($("#url").val(),{'command':$("[name='command']").val()},function(data){
       if(data){
           if($("#result").val()){
               data = $("#result").val()+"\n"+data;
           };
           $("#result").val(data);
       }
    });
});
$("#clear").on("click",function(){
    $("#result").val("");
});
</script>