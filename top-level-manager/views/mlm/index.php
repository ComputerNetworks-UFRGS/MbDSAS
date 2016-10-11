<?php
/* @var $this yii\web\View */

use yii\helpers\Url;

?>

<div class="container">
 	<h2>MLM</h2>
 	<p>Middle Level Manager Settings</p>
  	<div class="btn-group">
	  <a  class="btn btn-info" href="<?= Url::to(['mlm/create']); ?>">Create</a>
	  <button type="button" class="btn btn-danger">Delete</button>
	</div>
  <table class="table">
    <thead>
      <tr>
        <th></th>
        <th>Label</th>
        <th></th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <?php foreach($mlms as $mlm): ?>
      <tr>
        <td><input type="checkbox"></td>
        <td><?= $mlm->label ?></td>
        <td><a>View MD List</a></td>
        <td><button class="btn btn-success btn-sm" type="button">On</button></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
</div>