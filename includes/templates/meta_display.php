<table style="clear:both; margin-top:5px" id="flymetadisplay">
<tr>
	<?php
		if (TITLE_EDIT) {
		print "<td>";
		print "<label>";
		print $this->plugin ( 'translate' ,"Title");
		print "</label>";
		echo '&nbsp;';
		$this->plugin ( 'input' , 'text' , 'title' , $this->title, array('id'=>'fly_title'));
		print "</td>";
		}
		if (META_KEYWORDS_EDIT) {
		print "<td>";
		print "<label>";
		print $this->plugin ( 'translate' ,"Meta Keywords");
		print "</label>";
		echo '&nbsp;';
		$this->plugin ( 'form' , 'textarea' , 'Meta[keywords]' , $this->meta['keywords'], '', array('id'=>'fly_meta_key','rows'=>3, 'cols'=>30, 'style'=>'height:22px', 'onmouseover'=>'_t = setTimeout(\'$("fly_meta_key").style.height="auto"\', 1000)', 'onmouseout'=>'clearTimeout(_t);this.style.height="22px"') );
		print "</td>";
		}
		if (META_DESC_EDIT) {
		print "<td>";
		print "<label>";
		echo $this->plugin( 'translate' , "Meta Description");
		echo "</label>";
		echo '&nbsp;';
		$this->plugin ( 'form' , 'textarea' , 'Meta[description]' , $this->meta['description'] ,'', array('id'=>'fly_meta_desc', 'rows'=>3, 'cols'=>30, 'style'=>'height:22px', 'onmouseover'=>'_t = setTimeout(\'$("fly_meta_desc").style.height="auto"\', 1000)', 'onmouseout'=>'clearTimeout(_t);this.style.height="22px"'));
		print "</td>";
		}
	?>
</tr>
</table>
