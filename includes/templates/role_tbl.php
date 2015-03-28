<h2>Manage Roles</h2>
<p>This is where you setup the roles for your users.<br>
Roles define which directories a user can edit. There are two by default, "Whole Site Editor" and "Admin".</p>
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
		echo "<td>".$arr[$col]."</td>";
	}
	print "<td><a href=\"$this->edit_url&id=$id\">Edit</a></td>";
	print "<td><a href=\"$this->delete_url&id=$id\">Delete</a></td>";
	print "</tr>";
}
?>

</table>
<p style="width:100px">
<a href="<?php echo $this->add_url?>">Add new Role</a>
</p>