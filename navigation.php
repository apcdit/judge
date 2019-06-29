<?php
  
  $judge_name = $_SESSION['judge_name'];
?>

<nav aria-label="Page navigation" style="text-align: center;">
<div style="display:inline-block;">
  <ul class="pagination" >
    <li>
      <a href="#" aria-label="Previous">
        <span aria-hidden="true">&laquo;</span>
      </a>
    </li>
    <li><a href="index.php">分数票</a></li>
    <li><a href="mark2.php">印象票</a></li>
    <li><a href="voting.php">最佳三位候选辩手</a></li>
    <li><a href="mark3.php">总结票</a></li>
    <!-- <li><a href="votingResult.php">最佳辩手</a></li> -->
    <li><a href="bestParticipantAlgo.php">最佳辩手</a></li>
   
    <li> <a href="php/logout_process.php">登出</a></li>
    <li>
      <a href="#" aria-label="Next">
        <span aria-hidden="true">&raquo;</span>
      </a>
    </li>
  </ul>
    <h2>评审：<?php echo $judge_name; ?><h2>
  </div>
</nav>

<!-- <div class="pagination center" style="text-align:center;">
  
  <a href="index.php">分数票</a>
  <a href="mark2.php">印象票</a>
  <a href="voting.php">最佳人选</a>
  <a href="mark3.php">总结票</a>
  
  
</div> -->


<style>
/* Pagination links */
.pagination a {
  color: black;
  float: left;
  padding: 8px 16px;
  text-decoration: none;
  transition: background-color .3s;
  font-size:18px;
}

/* Style the active/current link */
.pagination a.active {
  background-color: dodgerblue;
  color: white;
}

/* Add a grey background color on mouse-over */
.pagination a:hover:not(.active) {background-color: #ddd;}

/* Add a black background color to the top navigation */

</style>

  