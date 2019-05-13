<?php 
 include('../header.php'); 
 session_start();
include('../inc/connect.php');


function updateYinXiangMark($side, $competition_id){
    
        try {
                   
            $sql = "UPDATE Competition SET impression_ticket=1 
                    WHERE 
                        competion_id=$competition_id 
                        and
                        side=$side";
        
            // Prepare statement
            $stmt = $conn->prepare($sql);
        
            // execute the query
            $stmt->execute();
        
            // echo a message to say the UPDATE succeeded
            echo $stmt->rowCount() . " records UPDATED successfully";
            }
        catch(PDOException $e)
            {
            echo $sql . "<br>" . $e->getMessage();
            }
    
}

?>