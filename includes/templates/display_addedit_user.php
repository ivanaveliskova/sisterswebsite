<script type="text/javascript">
function validateForm(form)
{
	
	if(IsEmpty(form.elements['<?php echo $this->defName?>[fullname]'])) { 
      alert('You have not entered a name') 
      form.elements['<?php echo $this->defName?>[fullname]'].focus(); 
      return false; 
   } 
   
   if(IsEmpty(form.elements['<?php echo $this->defName?>[username]'])) { 
      alert('You have not entered a username') 
      form.elements['<?php echo $this->defName?>[username]'].focus(); 
      return false; 
   } 
   
   
   if(IsEmpty(form.elements['<?php echo $this->defName?>[password]'])) { 
      alert('You have not entered a password') 
      form.elements['<?php echo $this->defName?>[password]'].focus(); 
      return false; 
   } 
   
   return true
 




} 
</script>

<h2>Add / Edit User</h2>
<?php $this->plugin ( 'form' , 'start', array('name'=>'editUser', 'action'=>$this->post_url, 'onsubmit'=>'return validateForm(this)') )?>
<?php 

		$this->plugin ( 'form' , 'label' , "Name" );
		$fullname = isset($this->record['fullname'] ) ? $this->record['fullname']  : '';
		$this->plugin ( 'form' , 'text' , "$this->defName[fullname]" , $fullname );

		$this->plugin ( 'form' , 'label' , "Email" );
		$email = isset($this->record['email'] ) ? $this->record['email']  : '';
		$this->plugin ( 'form' , 'text' , "$this->defName[email]" , $email );
		
		$this->plugin ( 'form' , 'label' , "Role" );
		$role_id = isset($this->record['role_id']) ? $this->record['role_id'] : '';
		$this->plugin ( 'form' , 'select' , "$this->defName[role_id]",
		$role_id,
		'',
		$this->allroles
		);
		
		$this->plugin ( 'form' , 'label' , "Username" );
		$username = isset($this->record['username'] ) ? $this->record['username']  : '';
		$this->plugin ( 'form' , 'text' , "$this->defName[username]" , $username );
		
		$this->plugin ( 'form' , 'label' , "Password" );
		$password = isset($this->record['password'] ) ? $this->record['password']  : '';
		$this->plugin ( 'form' , 'text' , "$this->defName[password]" , $password );
		
		$id = isset($this->id) ? $this->id : '';
		$this->plugin ( 'form' , 'hidden' , "id", $id);
		$this->plugin ( 'form' , 'hidden' , "defName", $this->defName);
		
		$this->plugin ( 'form' , 'submit' , 1, $this->submit_value);

?>
<?php  $this->plugin ( 'form' , 'end' ); ?>