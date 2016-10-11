<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

?>

<div class="container">
 	<h2>Repositories</h2>
 	<p>Repositories Settings</p>
  	<div class="btn-group">
	  <a  class="btn btn-info" href="<?= Url::to(['repository/create']); ?>">Create</a>
	  <button type="button" class="btn btn-danger">Delete</button>
	</div>
  <table class="table">
    <thead>
      <tr>
        <th></th>
        <th>Label</th>
        <th></th>
        <th>Status</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($repositories as $repository): ?>
      <tr>
        <td><input type="checkbox"></td>
        <td><?= $repository->label ?></td>
        <td><a>View Script List</a></td>
        <td><span class="label label-success">Online</span></td>
      </tr>
    <?php endforeach; ?>
    </tbody>
  </table>
</div>