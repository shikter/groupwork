﻿<?php

	//require another php file
	// ../../../ means > 3 folders back
	require_once("../../../config.php");
	
	//the variable does not exists in the URL
	if(!isset($_GET["edit"]) && !isset($_POST["edit"])){
		
		//redirect user
		echo "redirect";
		
		header("Location: tables.php");
		exit(); //don't execute further
		
	}else{
		
		//esli post to 
		if(isset($_POST["edit"])){
			$_GET["edit"] = $_POST["edit"];
		}
		
		
		echo "<h4>"."> <strong>You want to edit row: "."<span style='color: red;'>".$_GET["edit"]."</span></strong>"."</h4>" ;
		
		//ask for latest data for single row
		$mysql = new mysqli("localhost", $db_username, $db_password, "webpr2016_shikter");
		
		// maybe user wants to update data after clicking the button
		//echo $_GET["who"];
		if(isset($_POST["Login_id"])){
			//$name && $Login_id && $date && $genre
			echo "<br>User modified data...";
			
			//should be validation
			
			$stmt = $mysql->prepare("UPDATE Reservation SET Login=?, Name=?, reserv_date=?, label_genre=?, description=? WHERE id=?");
			
			echo $mysql->error;
			
			$stmt->bind_param("sssssi", $_POST["Login_id"], $_POST["name"], $_POST["date"], $_POST["genre"], $_POST["description"], $_POST["edit"]);
			
			if($stmt->execute()){
				
				echo "<br><h4><strong><span style='color:red'>Saved successfully</span></strong></h4>";
				
				// option one - redirect:
				
				//header("Location: tables.php");
				//exit();
				
				// option two - update variables:
				
				echo "<br><strong><span style='color:green'>Changed to:</span></strong><br>";
				
				
				echo "<br><strong>Name of recipient: </strong>".$Login = $_POST["Login_id"];
				echo "<br><strong>Message: </strong>".$Name = $_POST["name"];
				echo "<br><strong>Sender name: </strong>".$reserv_date = $_POST["date"];
				echo "<br><strong>Message: </strong>".$label_genre = $_POST["genre"];
				echo "<br><strong>Sender name: </strong>".$description = $_POST["description"];
				$id = $_POST["edit"];
				
				echo "<br>"."-------------------------------------";
				
				
				/*
				echo 
			
				'<div>
				
				<br><strong>Name of recipient: </strong> <span style="color: red;">.$recipient = $_GET["who"].</span>
				<br><strong>Message: </strong> <span style="color: red;">.$message = $_GET["message"].</span>
				<br><strong>Sender name: </strong> <span style="color: red;">.$sender = $_GET["from_who"].</span>
				<br>USER ID: $id = $_GET["edit"].
				
				</div>
				<br>
				';
				*/
				
			}else{
				
				echo $stmt->error;
			}
			
			
		}else{
			
					//user did not click any buttons yet,
					//give user latest data from db
					
					$stmt = $mysql->prepare("SELECT id, Login, Name, reserv_date, label_genre, description, time_created FROM Reservation WHERE id=?");
				
				echo $mysql->error;
				
				//replace the ? mark
				$stmt->bind_param("i", $_GET["edit"]);
				
				//bind result data
				$stmt->bind_result($id, $Login, $Name, $reserv_date, $label_genre, $description, $time_created);
				
				$stmt->execute();
				//we have only 1 row of data
				if($stmt->fetch()){
					
					//we had data
					echo "<h4>"."> <i>Filled field:</i> | "."<strong>[".$Login."] | [".$Name."] | [".$reserv_date."] | [".$label_genre."] | [".$description."]</strong>"." | <i>which was created:</i> "."<strong>".$time_created."</strong>"."</h4>";
					
				}else{
					
					//smth went wrong
					echo $stmt->error;
				}
		
			}
		
		
	}
?>

<?php require_once("header.php");?>

<figure id="tlu_logo"><img border=none src="http://www.tlu.ee/~shikter/ristmed2/images/TLU_logo.jpg" alt="TLU" width="200"></figure>
<br>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Little Estonia</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
	
      <ul class="nav navbar-nav">
	  
        <li><a href="app_message.php">Message APP</a></li>
		<li class="active"><a href="app_reservation.php">Order APP</a></li>
		<li><a href="tables.php">Tables</a></li>
		
      </ul>

    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>

<?php
	$current_time_with_fix = time() + (10 * 60 + 58);
		echo "<p />Today is " .date('l, jS \of F Y - H:i:s', $current_time_with_fix);
					   //.date("d.m.Y H:i:s");

?>
	
	
	<div class="container">
	<section id="application_reservation">
		
	<h2>Reservation form:</h2>
	<div id="errors" style="color: red;"></div>
	
	<div class="row">
	
	<form class="col-md-3 col-sm-6" id="dataForm" method="post" onsubmit="return validate();" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
	
		<input type="hidden" name="edit"  value="<?=$id;?>">
	
		<table border="0">
			<tr>
				<td width="185">
		<p />Login<span style="color: red;">*</span>: 
				</td>
				
				<td>
					<div class="row">
						<div class="form-group">
							<div class="col-md-3 col-sm-6">
		<input type="text" name="Login_id" id="Login_id" class="form-control" style="width: 300px;" value="<?=$Login?>">
							</div>
						</div>
					</div>
				</td>
			</tr>
			
			<tr>
				<td width="185">
		<p />Name<span style="color: red;">*</span>: 
				</td>
				
				<td>
					<div class="row">
						<div class="form-group">
							<div class="col-md-3 col-sm-6">
		<input type="text"  name="name" id="name" class="form-control" style="width: 300px;" value="<?=$Name?>">
							</div>
						</div>
					</div>
				</td>
			</tr>
			
			<tr>
				<td width="185">
		<p /><span title="Issue date">Issue date<span style="color: red;">*</span>: </span>
				</td>
				
				<td>
					<div class="row">
						<div class="form-group">
							<div class="col-md-3 col-sm-6">
		<input type="date" name="date" id="date" class="form-control" style="width: 300px;" value="<?=$reserv_date?>">
							</div>
						</div>
					</div>
				</td>
			</tr>
			
			<tr>
		<td width="185" >
		<p />What kind of movie<span style="color: red;">*</span>: 			
				</td>
				
				<td>
					<div class="row">
						<div class="form-group">
							<div>
								<select id="genre" name="genre" class="form-control" style="width: 300px;">
									<!-- <option value="notselected">Pick a category:</option>  NOT WORKING > without IF and ELSE. -->
									<?php 
									
										$genres = array("Clip movie", "Advertisement", "TV production (procedural, broadcasting...)", "Home movie (travel, wedding...)", "Documentary", "Short movie", "Feature film", "Silent film", "Blue movie (+18)", "Animation", "Other"); 
										foreach($genres as $genre){
											if($genre == $label_genre){
												echo "<option selected>".$genre."</option>";
											}else{
												echo "<option>".$genre."</option>";
											}
											
										}
									?>
									
								</select>
							</div>
						</div>
					</div>		
				</td>
			</tr>
		
			<tr>
				<td>
					<p>Description:</p>
				</td>

				<td>
					<div class="form-group">
						<textarea name="description" type="text" class="form-control" style="width: 300px; height: 120px;" ><?=$description?></textarea>
					</div>
				</td>
			</tr>
			
			<tr>
				<td width="185">
				&nbsp;
				</td>
				
				<td>	
	<br>	<div class="row">
						<div class="col-md-1 col-sm-4">
						<!-- btn-lg   visible-xs-inline  hidden-xs-->
							<input class="btn btn-primary hidden-xs" type="submit" value="Make a reservation">
							<input class="btn btn-primary btn-block visible-xs-inline" type="submit" value="Make a reservation">
							
						</div>
			</div>
				</td>
			</tr>
			
			
			
			
		</table>	
	</form>


		<br>
		<hr />
		
	</section>
</div>
</div>

	<div class="container">
		<section id="CopyRights">

			<br>
			<dl class="dl-horizontal">
				<dt>Beta Version 2.0</dt>
				<dd>© Vadim Kozlov and Dmitri Kabluchko</dd>
				<dt>Folders of</dt>
				<dd><div class="bkt"><a href="http://localhost:5555/~shikter/homeworks" target="_blank">Homework</a></div>
			</dl>
			<br>

		</section>
	</div>

	</body>
</html>