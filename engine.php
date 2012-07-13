<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);



session_start();

// database
require_once 'db.php';

// task form
$form  = '<form id="taskform" method="post" class="task">';
$form .= '<label for="task">Task</label>';
$form .= '<input id="task" type="text" name="task" />';
$form .= '<input name="add" type="submit" value="Add" class="button buttonsmall" />';
$form .= '</form>';


if(isset($_GET['action']) && isset($_GET['id']))
{
	$q = mysql_query('SELECT * FROM todo WHERE id = "'.$_GET['id'].'"');
	if(mysql_num_rows($q) != 0)
		$id = $_GET['id'];
	else
		$msg = "ERROR: id is not valid.";
}


if(isset($id))
{
	if(isset($_SESSION["user"]))
	{
		// task done/undone
		if($_GET['action'] == 'mark')
		{
			$row = mysql_fetch_assoc($q);
			$mark = ($row['status'] + 1) % 2;
			$q = mysql_query('UPDATE todo SET status = "'.$mark.'" WHERE id = "'.$row['id'].'"');
			if($q)
				header('Location: ./todolist.php');
			else
				$msg = 'ERROR: database issue';
		}
		// delete task
		elseif($_GET['action'] == 'delete')
		{
			$row = mysql_fetch_assoc($q);
			mysql_query('DELETE FROM todo WHERE id = "'.$id.'"');
			header('Location: ./todolist.php');
		}
		// edit form
		elseif($_GET['action'] == 'edit')
		{
			$row = mysql_fetch_assoc($q);
			$form = '';
			$form .= '<form id="taskform" method="post">';
			$form .= '<label for="task">Task</label>';
			$form .= '<input id="task" type="text" name="task" value="'.htmlspecialchars(stripslashes($row['task'])).'" />';
			$form .= '<input type="hidden" name="id" value="'.$row['id'].'" />';
			$form .= '<input name="edit" type="submit" value="edit" />';
			$form .= '</form>';
		}
	}
	// authentication fails
	else
	{
		$msg = "ERROR: You don't have permission"; 
	}
}

// add task
if(isset($_POST['add']))
{
	$task = trim($_POST['task']);
	if($task == '')
	{
		$msg = 'ERROR: task cannot be blank';
	}
	else
	{
		$q = mysql_query('INSERT INTO todo(task) VALUES ("'.mysql_real_escape_string($task).'")');
		if($q)
			header('Location: ./todolist.php');
		else
			$msg = 'ERROR: database issue';
	}
}

// task edit
if(isset($_POST['edit']))
{
	$task = trim($_POST['task']);
	$id = $_POST['id'];
	if($task == '')
	{
		$msg = 'ERROR: fill in the blank';
	}
	else
	{
		$q = mysql_query('UPDATE todo SET task = "'.mysql_real_escape_string($task).'" WHERE id = "'.$id.'"');
		header('Location: ./todolist.php');
	}
}


// user registration
if(isset($_POST['register']))
{
	$user = trim($_POST['username']);
	$pw = trim($_POST['password']);
	if($user == '' || $pw == '')
	{
		$msg = 'ERROR: fill in all blanks';
	}
	else
	{
		$q = mysql_query('INSERT INTO todo_admin (user, password) VALUES ("'.$user.'", "'.md5($pw).'");');
		header('Location: ./login.php');
	}
}

// user login
if(isset($_POST['login']))
{
	$user = trim($_POST['username']);
	$pw = trim($_POST['password']);
	if($user == '' || $pw == '')
	{
		$msg = 'ERROR: fill in all blanks';
	}
	else
	{
		$q = mysql_query('SELECT user FROM todo_admin WHERE user = "'.$user.'" AND password = "'.md5($pw).'"');
		// IF USER EXISTS
		if(mysql_num_rows($q) != 0)
		{
			$row = mysql_fetch_assoc($q);	
			$_SESSION["user"] = $row['user'];
			header('Location: ./todolist.php');
		}
		else
		{
			$msg = 'ERROR: wrong information, try again.';
		}
	}
}

// user logout
if(isset($_POST['logout']))
{
	// empty session
	$_SESSION = array();
	header('Location: ./index.php');
}
?>



