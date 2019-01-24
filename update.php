<?php
include "config.php";

$bind = "";
$var1 = "";
$var2 = "";

if(isset($_GET['op']))
{
   switch($_GET['op'])
   {
      case 'project_change_title':
         $query = "UPDATE projects SET title=? WHERE project_id=?";
         $bind = "si";
         $var1 = $_GET['title'];
         $var2 = $_GET['id'];
      break;

      case 'project_change_completion':
         $query = "UPDATE projects SET completion_rate=? WHERE project_id=?";
         $bind = "ii";
         $var1 = $_GET['rate'];
         $var2 = $_GET['id'];
      break;

      case 'task_done':
         $query = "UPDATE tasks SET done=NOW() WHERE task_id=?";
         $bind = "i";
         $var1 = $_GET['id'];
      break;

      case 'task_change_title':
         $query = "UPDATE tasks SET title=? WHERE task_id=?";
         $bind = "si";
         $var1 = $_GET['title'];
         $var2 = $_GET['id'];
      break;

      case 'task_change_project':
         $query = "UPDATE tasks SET project_id=? WHERE task_id=?";
         $bind = "ii";
         $var1 = $_GET['pid'];
         $var2 = $_GET['id'];
      break;

      case 'task_schedule':
         $query = "UPDATE tasks SET scheduled=CURDATE() WHERE task_id=?";
         $bind = "i";
         $var1 = $_GET['id'];
    } 

    if (!($stmt = $mysqli->prepare($query))) {
      echo "Prepare failed: (" . $mysqli->errno . ") " . $mysqli->error;
   }

   if ($var2 != "")
   {
      if (!$stmt->bind_param($bind, $var1, $var2)) {
         echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      }
   }
   else
   {
      if (!$stmt->bind_param($bind, $var1)) {
         echo "Binding parameters failed: (" . $stmt->errno . ") " . $stmt->error;
      }
   }

   if (!$stmt->execute()) {
      echo "Execute failed: (" . $stmt->errno . ") " . $stmt->error;
   }

   $stmt->close();
}

?>