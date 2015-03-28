<h2>Add / Edit Role</h2>
<?php $this->plugin ( 'form' , 'start', array('name'=>'editRole', 'action'=>$this->post_url) );?>
<?php
		$this->plugin ( 'form' , 'label' , "Name" );
		$rolename = isset($this->record['rolename']) ? $this->record['rolename'] : '';
		$this->plugin ( 'form' , 'text' , "$this->defName[rolename]" , $rolename );
		$this->plugin ( 'form' , 'label' , "Access" );
		$dirValues = isset($this->dirValues) ? $this->dirValues: '';
		$this->plugin ( 'form' , 'select' , "$this->defName[access][]",
		$dirValues,
		'',
		$this->dirs,
		'size="20" multiple="multiple"'
		);
		$this->plugin ( 'form' , 'label' , "Description" );
		$description = isset($this->record['description']) ? $this->record['description'] : '';
		$this->plugin ( 'form' , 'textarea' , "$this->defName[description]" , $description );

		$this->plugin ( 'form' , 'submit' , "1", $this->submit_value);
		$this->plugin ( 'form' , 'hidden' , "Confirm", "1");
		$id = isset($this->id) ? $this->id : '';
		$this->plugin ( 'form' , 'hidden' , "id", $id);
		$this->plugin ( 'form' , 'hidden' , "defName", $this->defName);
?>
<?php  $this->plugin ( 'form' , 'end' ); ?>