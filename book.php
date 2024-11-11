<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" required id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
<!------ Include the above in your HEAD tag ---------->
<form method="post" action="" class="col-md-12">


        <div class="col-xs-12">
            <div class="col-md-12" >
                <h3> Booking</h3>
                <div required id="field">

                <div required id="field0">
                	
<div class="form-group">
  <label class="col-md-4 control-label" for="action_id">Name</label>  
  <div class="col-md-5">
  <input required id="action_id" name="user_name[]" type="text" placeholder="" class="form-control input-md" required>

  </div>
</div>
<br><br>
<!-- Text input-->
<div class="form-group">
  <label class="col-md-4 control-label" for="user_age">Age</label>  
  <div class="col-md-5">
  <input required id="action_name" name="user_age[]" type="text" placeholder="" class="form-control input-md" required>
  
  </div>
</div>
<br><br>
       <!-- File Button --> 
<div class="form-group">
  <label class="col-md-4 control-label" for="action_json" >Select Gender</label>
  <div class="col-md-3">
            <select class="form-control" required id="action_json" name="user_gender[]">
                                <option>Male</option>
                                <option>Female</option>
                                 <option>Others</option>
                            </select>
  </div>
</div>

</div>
</div>
<!-- Button -->
<div class="form-group">
  <div class="col-md-4">
    <button required id="add-more" name="add-more" class="btn btn-warning" style="color: black;">Add More +</button>
  </div>
</div>
<br><br>
<div class="form-group" align="right">
  <div class="col-md-4">
    <input type="submit" name="submit" class="btn btn-success" value="Final Submit">
  </div>
</div>
           
            </div>
        </div>
    </div>
  

<script type="text/javascript">
	$(document).ready(function () {
    //@naresh action dynamic childs
    var next = 0;
    $("#add-more").click(function(e){
        e.preventDefault();
        var addto = "#field" + next;
        var addRemove = "#field" + (next);
        next = next + 1;
        var newIn = ' <div required id="field'+ next +'" name="field'+ next +'"><!-- Text input--><div class="form-group"> <label class="col-md-4 control-label" for="action_id">Name</label> <div class="col-md-5"> <input required id="action_id" name="user_name[]" type="text" placeholder="" class="form-control input-md"> </div></div><br><br> <!-- Text input--><div class="form-group"> <label class="col-md-4 control-label" for="action_name">Age</label> <div class="col-md-5"> <input required id="action_name" name="user_age[]" type="text" placeholder="" class="form-control input-md"> </div></div><br><br><!-- File Button --> <div class="form-group"> <label class="col-md-4 control-label" for="action_json">Select Gender</label> <div class="col-md-3"> <select class="form-control" required id="action_json" name="user_gender[]"><option>Male</option><option>Female</option><option>Others</option></select> </div></div></div>';
        var newInput = $(newIn);
        var removeBtn = '<button required id="remove' + (next - 1) + '" class="btn btn-danger remove-me" >Remove</button></div></div><div required id="field">';
        var removeButton = $(removeBtn);
        $(addto).after(newInput);
        $(addRemove).after(removeButton);
        $("#field" + next).attr('data-source',$(addto).attr('data-source'));
        $("#count").val(next);  
        
            $('.remove-me').click(function(e){
                e.preventDefault();
                var fieldNum = this.id.charAt(this.id.length-1);
                var fieldID = "#field" + fieldNum;
                $(this).remove();
                $(fieldID).remove();
            });
    });

});
</script>

	</form>
<?php
if (isset($_POST['submit'])) {

	$dates = date('Y-m-d');
	$query1 = "INSERT INTO `tbl_booking`(`room_id`, `user_id`, `booking_date`) VALUES ($room_id,$user_id,'$dates')";
	$run1 = mysqli_query($con,$query1);

	$booking_id = mysqli_insert_id($con);
	//echo "<pre>";
	$user_name = $_POST['user_name'];
	$user_age = $_POST['user_age'];
	$user_gender = $_POST['user_gender'];
	/* print_r($user_name);
	 print_r($user_age);
	 print_r($user_gender);
	 echo count($user_name);*/
	 for ($i=0; $i < count($user_name); $i++) { 
	 	$user_name_temp = $user_name[$i];
		$user_age_temp = $user_age[$i];
		$user_gender_temp = $user_gender[$i];

		$query2 = "INSERT INTO `tbl_booking_user`(`booking_id`, `user_name`, `user_age`, `user_gender`) VALUES ($booking_id,'$user_name_temp',$user_age_temp,'$user_gender_temp')";
		//echo $query2;exit;
		$run2 = mysqli_query($con,$query2);

      $query3="UPDATE tbl_room SET isBooked='1' where room_id = '".$room_id."'";
                        $run3=mysqli_query($con,$query3);

      $url = "profile.php";
      $_SESSION['msg'] = 'Booking Successful';
                header('Location: '.$url);
	 }
	//exit;
}
?>