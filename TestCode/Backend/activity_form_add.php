<?php include('h.php');?>
<div class="container">
  <p> </p>
    <div class="row">
      <div class="col-md-12">
        <form  name="admin" action="activity_form_add_db.php" method="POST" id="admin" class="form-horizontal">
          <div class="form-group">
            <div class="col-sm-6" align="left">
              <input  name="activity_name" type="text" required class="form-control" id="activity_name" placeholder="ชื่อกิจกรรม" minlength="2"  />
            </div>
          </div>
          <div class="form-group">
            <div class="col-sm-6" align="right">
              <button type="submit" class="btn btn-success btn-sm" id="btn"> บันทึก </button>      
            </div> 
          </div>
        </form>
      </div>
    </div>
</div>