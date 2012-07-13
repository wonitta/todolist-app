<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);

require_once 'engine.php';
include 'header.php';
?>

		<?php if(isset($_SESSION["user"])): ?>
		<form method="post">
			<input id="logout" name="logout" type="submit" value="logout" />
		</form>
		<hr/>

		<?php echo $form; ?>
		<hr/>
		<?php endif; ?>
		
		<?php
		$q = mysql_query('SELECT * FROM todo ORDER BY id ASC');
		if((mysql_num_rows($q) != 0) && isset($_SESSION["user"])):
		?>
		<table id="list" cellspacing='0'>
			<thead>
				<tr>
				<th valign = "top" width="20">#</th>
				<th valign = "top" width="400">Task</th>
				<th valign = "top" width="200">Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				$out = '';
				$i = 1;
				while($row = mysql_fetch_assoc($q))
				{
					$status = $row['status'];
					$id = $row['id'];
					
					$out .= '<tr'.(($status==1)?' class="check"':'').'>';
					$out .= '<td valign = "top">'.$i++.'</td>';
					$out .= '<td valign = "top">'.htmlspecialchars(stripslashes($row['task'])).'</td>';
		
					$out .= '<td valign = "top">';
					// done - undone
					$out .= '<a '.(($status==1)?'title="undone"':'title="done"').'href="./todolist.php?action=mark&id='.$id.'">'.(($status==1)?'<img src="./images/done.gif" alt="done" />':'<img src="./images/undone.gif" alt="undone" />').'</a>';
					// edit
					$out .= '<a title="edit" href="./todolist.php?action=edit&id='.$id.'"><img src="./images/edit.gif" alt="edit" /></a>';
					// delete
					$out .= '<a OnClick="return confirm(\'Are you sure?\');" title="delete" href="./todolist.php?action=delete&id='.$id.'"><img src="./images/delete.gif" alt="delete" /></a>';
					$out .= '</td>';
		
					$out .= '</tr>';
				}
				echo $out;
				?>
			</tbody>
		</table>
		<?php endif; ?>

<?php include 'footer.php'; ?>