
<div class="errorwindow"><span class="errorcode"><?php echo $VALUES['code'];?></span><span class="errortext"><?php echo $VALUES['text'];?></span></div>

<script type="text/javascript">
	jQuery(".errorwindow").dialog( { minHeight: 300, minWidth: 320, modal: true, title: "Error Message" });
</script>