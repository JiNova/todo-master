<?php
include "config.php";

$query = "";

if(isset($_GET['op']))
{
   switch($_GET['op'])
   {
      case 'today':
         $query = "select tasks.title, priorities.name AS priority, projects.title AS project
                  from tasks JOIN priorities ON tasks.priority_id = priorities.priority_id
                  JOIN projects ON tasks.project_id = projects.project_id
                  WHERE DATE(tasks.scheduled) = CURDATE() AND tasks.done is NULL";
      break;

      case 'project_overview':
         $query = "select project_id,title,due_date,completion_rate from projects;";
      break;

      case 'priority_list':
         $id = (int)$_GET['priority'];
         $query = "select tasks.title, priorities.name
                  from tasks JOIN priorities ON tasks.priority_id = priorities.priority_id
                  WHERE priorities.priority_id=".$id;
      break;

      case 'priorities_display':
         $query = "select priority_id, name from priorities";
      break;

      case 'tasks_by_tags':
         $query = "select tasks.title from tasks
                  JOIN taskstags ON tasks.task_id = taskstags.task_id
                  JOIN tags ON taskstags.tag_id = tags.tag_id
                  WHERE tags.description LIKE \"%".$_GET['tag_search']."%\"";
      break;

      case 'eisenhower_top_left':
         $query = "call eisenhower_left_top()";
      break;

      case 'schedule_suggestion':
         $query = "call task_suggest()";
      break;
   }
}
else
{
   if(isset($_GET['id']))
   {
      $id = (int)$_GET['id'];
      $query = "select t.task_id, t.title, prio.name AS priority, t.project_id, p.title AS project_title from tasks t
            JOIN projects p ON t.project_id = p.project_id 
            JOIN priorities prio oN t.priority_id = prio.priority_id
            WHERE t.task_id=".$id;
   }
   else
   {
      $query = "select t.task_id, t.title, prio.name AS priority, t.project_id, p.title AS project_title from tasks t
            JOIN projects p ON t.project_id = p.project_id 
            JOIN priorities prio oN t.priority_id = prio.priority_id WHERE t.done is NULL";
   }
}

$userData = $mysqli->query($query);

$response = array();

while($row = $userData->fetch_array(MYSQLI_ASSOC)){

   $response[] = $row;
}

$userData->close();

echo json_encode($response);
exit;
?>