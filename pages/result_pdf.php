<html>
<html>
<head>
<style>
table {
  width:100%;
}
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
}
th, td {
  padding: 15px;
  text-align: left;
}
#t01 tr:nth-child(even) {
  background-color: #eee;
}
#t01 tr:nth-child(odd) {
 background-color: #fff;
}
#t01 th {
  background-color: black;
  color: white;
}
</style>
<?php 
session_start();
$conn=mysqli_connect("localhost","root","root","online_examination");
if(isset($_POST['submit'])){
include  "pdf_vendor/autoload.php";

// $student_name=$_SESSION['name'];
// $student_id=$_GET['student_id'];
// $test_id=$_GET['test_id'];
$css=file_get_contents('./css/font-awesome.min.css');
$css.=file_get_contents('./css/jquery.mCustomScrollbar.css');
 $css.=file_get_contents('./css/ionicons.css');
$css.=file_get_contents('./css/bootsrap/css/bootstrap.min.css');


// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

//include  "./pdf_vendor/autoload.php";

$exmne_id = $_SESSION['examineeSession']['exmne_id'];


$seluser="SELECT * FROM `examinee_tbl` WHERE exmne_id='$exmne_id'";
$resuser = mysqli_query($conn,$seluser);
while ($rowdata = mysqli_fetch_array($resuser)) {

$exmneename = $rowdata['exmne_fullname'];

$department_id= $rowdata['department_id'];

$exmne_year_level= $rowdata['exmne_year_level'];
     
}
// $student_name=$_SESSION['name'];
// $student_id=$_GET['student_id'];
// $test_id=$_GET['test_id'];
$ex_id=$_SESSION['test_id'];

$innerjoin = "SELECT result.*,examinee_tbl.* FROM `result`,examinee_tbl WHERE result.exmne_id='$exmne_id' AND examinee_tbl.exmne_id=result.exmne_id";
 

$res = mysqli_query($conn,$innerjoin);
 $num=mysqli_num_rows($res);
while ($row = mysqli_fetch_array($res)) {
         $sum += $row['percentage'];

      
}
   $ans=$sum/$num; 
   $ans1 = $ans."%";

if($ans >= 90)
{
     $grade='A1';
} 
else if($ans >= 80){
     $grade='A2';
}
else if($ans >= 70){
     $grade='B1';
}
else if($ans >= 60){
     $grade='B2';
}
else if($ans >= 50){
     $grade='C1';
}
else if($ans >= 40){
     $grade='C2';
}
else if($ans >= 33){
     $grade='E';
}
else if($num==0){
     $grade='Pending....';
     $ans1=$grade;
}
else{
      $grade='FF';
}

$selectdep = "SELECT * from department WHERE department_id = $department_id";

$temp = mysqli_query($conn,$selectdep);
$row1 = mysqli_fetch_array($temp);
$depname=$row1['dep_name'];
$date=Date('Y-m-d');


$html='<head><style>
<div style="width:800px; height:600px; padding:20px; text-align:center; border: 10px solid #787878">
<div style="width:750px; height:550px; padding:20px; text-align:center; border: 5px solid #787878">
       <span style="font-size:40px; font-weight:bold">Certificate of Completion</span>
       <br><br>
       <img style="width:100px; height:100px;" src="https://www.graphicsprings.com/filestorage/stencils/31be89750522e2c3600a5e4fe2bbac92.png?width=500&height=500"><br><br>
       <span style="font-size:20px"><i>This is to certify that</i></span><br><br>
       <table width="400" border="1" cellpadding="0" cellspacing="0" style="margin-left:70px;">
		  <tr>
		    <td width="50" height="40" valign="top" rowspan="3">
		      <img alt="" src="https://www.graphicsprings.com/filestorage/stencils/31be89750522e2c3600a5e4fe2bbac92.png?width=500&height=500" width="60" height="60" style="margin: 0; border: 0; padding: 0; display: block;" style="margin:20px;">
		    </td>
		    <td width="350" height="40" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000;">
		<a href="" style="color: #D31145; font-weight: bold; text-decoration: none;">STUDENT NAME  :  </a>
		'.$exmneename.'
		    </td>
		    
		  </tr>
		  <tr>
		   <td width="350" height="40" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000;">
		<a href="" style="color: #D31145; font-weight: bold; text-decoration: none;">DEPARTMENT NAME  :  </a>
		'.$depname.'
		    </td>
		  </tr>
		  <tr>
		    <td width="350" height="40" style="font-family: Helvetica, Arial, sans-serif; font-size: 14px; color: #000000;">
		<a href="" style="color: #D31145; font-weight: bold; text-decoration: none;">YEAR LEVEL  :  </a>
		'.$exmne_year_level.'
		    </td>
		  </tr>
		</table><br/>
       <br><br>
       <span style="font-size:30px"><b>Student name : <u>'.$exmneename.'</u></b></span><br/><br/>
       <span style="font-size:25px"><i>has completed the course'.$id.'</i></span> <br/><br/>
       <span style="font-size:30px">'.$depname.'</span> <br/><br/>
       
       <span style="font-size:20px">with score of <b>'.$ans1.' Grade : '.$grade.'</b></span> <br/><br/><br/><br/>
       <span style="font-size:15px"><i>certificate genrated date</i></span><br>'.$date.'<br>
</div>
</div>';
//  echo $id;

//echo $html;
         
      

$mpdf=new \Mpdf\Mpdf();


$mpdf->WriteHTML($css,1);

$mpdf->WriteHTML($html,2);
$file1=$exmneename.'.pdf';

$file = $mpdf->Output(' ','S');

}  
//session_start();
$conn=mysqli_connect("localhost","root","root","online_examination");
$exmne_id = $_SESSION['examineeSession']['exmne_id'];
$seluser="SELECT * FROM `examinee_tbl` WHERE exmne_id='$exmne_id'";
$resuser = mysqli_query($conn,$seluser);
while ($rowdata = mysqli_fetch_array($resuser)) {

$exmneename = $rowdata['exmne_fullname'];

$department_id= $rowdata['department_id'];

$exmne_year_level= $rowdata['exmne_year_level'];
$exmne_email = $rowdata['exmne_email'];
     
}
                               


                 ini_set("display_errors", "1");
                 error_reporting(E_ALL);
            $erros= array();
       

     $email=mysqli_real_escape_string($conn,$exmne_email);
     //$subject=mysqli_real_escape_string($conn,$_POST['subject']);
     //$discription=mysqli_real_escape_string($conn,$_POST['discription']);
                 
                
   
    
    
    $html="hello this is your result ";
    
    include('./smtp/PHPMailerAutoload.php');
    $mail=new PHPMailer(true);
    $mail->isSMTP();
   
    $mail->Host="smtp.gmail.com";
    $mail->Port=587;
    $mail->SMTPSecure="tls";
    $mail->SMTPAuth=true;
    $mail->Username="youremail";
    $mail->Password="password";
    $mail->SetFrom("");
    $mail->addAddress($email);
    $mail->IsHTML(true);
    $mail->Subject="result";
    $mail->addStringAttachment($file,$file1);
    $mail->Body=$html;
    $mail->SMTPOptions=array('ssl'=>array(
        'verify_peer'=>false,
        'verify_peer_name'=>false,
        'allow_self_signed'=>false
    ));
    if($mail->send()){
        ?>
        <script type="text/javascript">
            alert("Mail Successfully Send");
        </script>
        <?php
    }else{
        //echo "Error occur";
    }
?>

