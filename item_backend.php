<?php
session_start();
include('config.php');
include('functions.php');
	extract($_POST);
	$loginuserid=$_SESSION['id'];
    
// echo "Backend calling";
    //insert new Menu
    if(isset($_POST['itemname']) && isset($_POST['disc']) && isset($_POST['itemrate']) && 
	isset($_POST['slscategory']) && isset($_POST['slstaxrate']) && isset($_POST['slsunit']))
{
    $checksql="SELECT * FROM `itemmaster` WHERE `ItemName`='$itemname' AND `UnitId`='$slsunit' AND `Rate`='$itemrate'";

	$checkres=mysqli_query($con,$checksql);
	$output="";
	if(mysqli_num_rows($checkres)==0)
	{
        $insetitemsql="INSERT INTO `itemmaster`(`ItemName`, `Description`, `UnitId`, `Rate`, `ItemGroupId`,`Taxrate`,`Status`,`CreatedBy`)
        VALUES ('$itemname','$disc','$slsunit','$itemrate','$slscategory','$slstaxrate','0','$loginuserid')";
   
           echo $insetitemsql;
   
               if(mysqli_query($con,$insetitemsql))
               {			
   
               $output="Done";
   
               }
               echo $output;
    }
   

}
    if(isset($_POST['hidden_id']) && isset($_POST['upitemname']) && isset($_POST['updisc']) && isset($_POST['upitemrate']) && 
	isset($_POST['upslscategory']) && isset($_POST['upslstaxrate']) && isset($_POST['upslsunit']))
{
    
        $updatesql="UPDATE `itemmaster` SET`ItemName`='$upitemname',`Description`='$updisc',`UnitId`='$upslsunit',`Rate`='$upitemrate',`ItemGroupId`='$upslscategory',`Taxrate`='$upslstaxrate' WHERE  `ItemId`='$hidden_id'";
   
           echo $updatesql;
   
               if(mysqli_query($con,$updatesql))
               {			
   
               $output="Done";
   
               }
               echo $output;
 
   

}


if (isset($_POST['updateid']))
	{


		$itemid=$_POST['updateid'];
		$selectquery="SELECT * FROM `itemmaster` where `ItemId`='$itemid'";

		$result=mysqli_query($con,$selectquery);
		$responce=array();

            if(mysqli_num_rows($result)>0)
            {

                while ($row=mysqli_fetch_assoc($result))
                {
                    $responce =$row;
                }
            }
            else
            {
                        $responce['status']=200;
                        $responce['message']="No Record Found";

            }
			echo json_encode($responce);
		}
else
	{
			            $responce['status']=200;
						$responce['message']="Invalid Request";
	}



    		///delete data
		if(isset($_POST['deleteid']))
		{
				$deleteid=$_POST['deleteid'];
		  $sql="UPDATE `itemmaster` SET `Status`='1' WHERE `ItemId`='$deleteid' ";
        //   echo $sql;
		  mysqli_query($con,$sql);

		}


?>