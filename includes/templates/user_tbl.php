<h2>Manage Users</h2>
<p>This is where you setup the usernames / passwords for your users.<br>
Users are assigned to roles, which define which directories a user can edit.</p>
<table border="0" cellspacing="0" cellpadding="0" width="80%" class="datatable">
<tr>
<?php 
$colnames = $this->contents->getColumnNames();
foreach ($colnames as $col) {
	print "<th>$col</th>";	
}
?>
<th>&nbsp;</th><th>&nbsp;</th>
</tr>
<?php 
while($this->contents->next()) {
	$arr=$this->contents->getCurrentValuesAsHash();
	$id = $arr['id'];
	print "<tr>";
	foreach ($colnames as $col) {
		echo "<td>".$arr[$col]."&nbsp;</td>";
	}
	print "<td><a href=\"$this->edit_url&id=$id\">Edit</a></td>";
	print "<td><a href=\"$this->delete_url&id=$id\">Delete</a></td>";
	print "</tr>";
}
?>

</table>
<p style="width:150px">
<a href="<?php echo $this->add_url?>">Add new user</a>
</p>