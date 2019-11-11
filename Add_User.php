<?php

    $email = mysqli_real_escape_string($AWSCN, $_POST["EA"]);
    $sql1 = "SELECT * FROM " . PRE . "users where email_address = '" . $email . "'";
    $result = mysqli_query($AWSCN, $sql1);
    $row = mysqli_num_rows($result);

    if ($row > 0) {
        echo '<script>alert("Email Address Already Exists! Sorry two accounts cannot be created with same email address")</script>';
    } else {
        $UU = mysqli_real_escape_string($AWSCN, $_POST["UName"]);
        $UE = mysqli_real_escape_string($AWSCN, $_POST["EA"]);
        $UFN = mysqli_real_escape_string($AWSCN, $_POST["FName"]);
        $ULN = mysqli_real_escape_string($AWSCN, $_POST["LName"]);
        $UCN = mysqli_real_escape_string($AWSCN, $_POST["CN"]);
        $UDP = mysqli_real_escape_string($AWSCN, $_POST["Dep"]);
        $UPP = mysqli_real_escape_string($AWSCN, $_POST["Prof"]);
        $USI = mysqli_real_escape_string($AWSCN, $_POST["SID"]);
        $URI = mysqli_real_escape_string($AWSCN, $_POST["RID"]);
        $UST = mysqli_real_escape_string($AWSCN, $_POST["STA"]);
        $pd = random_password(PLength);
        $hash_password = hash('sha512', $pd);
        $h_pass = md5($hash_password . AUTH_KEY);
        $sql = "INSERT INTO " . PRE . "users (`Username`, `Password`, `Email_Address`, `First_Name`, `Last_Name`, `College_Name`, `Department`, `Profession`, `Student_Id`, `Role_Id`, `Last_Login`, `Created_Date`, `Created_By`, `Status`) VALUES ('$UU','$h_pass','$UE','$UFN','$ULN','$UCN','$UDP','$UPP','$USI','$URI',' ','$CDT','" . $_SESSION['uid'] . "','$UST')";
        $result2 = mysqli_query($AWSCN, $sql);
        $HP_ID = mysqli_insert_id($result2);
        if ($result2) {
            $message = "Dear " . $UFN . " " . $ULN . ",<br/>";
            $message .= "Your new " . Project_Name . " account has been created.<br/> Welcome to " . Project_Name . "<br/>";
            $message .= "The " . Project_Name . " Id for your account <br/> Email Address is: " . $UE . "<br/> Password is: " . $pd . " <br/> Kindly use the above details to access " . Project_Name . " Portal <br/>";
            $message .= "Hope you enjoy using " . Project_Name . ".";
            $message .= "<hr/><br/>";
            $message .= "<br/> Sincerely,<br/>";
            $message .= "<b>" . Project_Name . " Team</b>";
            require("PHPMailer/class.PHPMailer.php");
            $mail = new PHPMailer();
            $mail->IsSMTP();
            $mail->Host = SMTP; // specify main and backup server
            $mail->SMTPAuth = true; // turn on SMTP authentication
            $mail->Port = Port;
            $mail->SMTPSecure = Secure;
            $mail->Username = Username; // SMTP username
            $mail->Password = Password; // SMTP password
            $mail->From = From;
            $mail->FromName = From;
            $mail->AddAddress($UE);
            $mail->IsHTML(true);
            $mail->Subject = Subject;
            $mail->Body = $message;
            $mail->AltBody = $message;
            if (!$mail->Send()) {
//echo '<script>alert("Message could not be sent.")</script>';
                echo "Mailer Error: " . $mail->ErrorInfo;
                exit;
            } else {
                //echo '<script>alert("Message has been sent")</script>';
                header("location: Admin_Home");

            }
        }
   /*     if (isset($_POST["create_ids"]) == "true") {
            $que = "INSERT INTO" . PRE . "instances(`User_Id`, `Instance_Name`, `Instance_No`, `Instance_Status`, `IP_Address`, `Public_Url`, `Instance_Date`) VALUES ('$HP_ID','0','0','0','0','0','0')";
            $re = mysqli_query($AWSCN, $que);
         //   execInBackground('php Single_Instance.php?Email=' . $UE . '&User_Id=' . $HP_ID);
		//	$AE=sin_in($UE,$HP_ID);
			
	header("Location:Single_Instance.php");
        }
        else
        {
            $que = "INSERT INTO" . PRE . "instances(`User_Id`, `Instance_Name`, `Instance_No`, `Instance_Status`, `IP_Address`, `Public_Url`, `Instance_Date`) VALUES ('$HP_ID','0','0','0','0','0','0')";
            $re = mysqli_query($AWSCN, $que);
        }
*/    }
?>