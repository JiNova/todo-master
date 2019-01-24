<?php

include "config.php";

if(isset($_GET['new_title']))
{
    $query = "INSERT INTO tasks(title,priority_id,project_id) VALUES(?,?,?)";

    if (!($stmt = $mysqli->prepare($query))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
   }

   if (!$stmt->bind_param("sii", $_GET['new_title'], $_GET['prio_id'], $_GET['project_id'])) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }

   if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
   }

   $stmt->close();
}

?>