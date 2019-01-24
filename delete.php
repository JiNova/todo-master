<?php

include "config.php";

$bind = "";
$var1 = "";

if(isset($_GET['op']))
{
    switch($_GET['op'])
    {
        case 'task_delete':
            $query = "DELETE FROM tasks WHERE task_id=?";
            $bind = "i";
            $var1 = $_GET['id'];
        break;
    }

    if (!($stmt = $mysqli->prepare($query))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
   }

   if (!$stmt->bind_param($bind, $var1)) {
      echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
  }

   if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
   }

   $stmt->close();
}

?>