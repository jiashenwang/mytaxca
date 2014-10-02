<?php
  if( isset($_POST['Sdata']) ){
    $message = $_POST['Sdata'];
    $id = $_POST['Sid'];
    $view_id = "TASK" . $id;
    echo <<< HTML
      <tr id=$view_id>
        <td>
          $id
        </td>
        <td>
          $message
        </td>
        <td>
          <a onclick="task_delete('$view_id')">Delete</a>
        </td>
      </tr>
HTML;
  }else{
    echo "BROKE";
  }

?>