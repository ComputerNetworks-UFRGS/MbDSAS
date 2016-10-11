<?php
/* @var $this yii\web\View */

?>
<h1>Pull Script</h1>

<div id="first-step">
	<p>Select the scripts to be pulled</p>
	<table id="table1" class="table table-hover col-sm-12">
		<thead>
			<tr><th>Name</th></tr>	
		</thead>
		<tbody>
			<?php foreach($scripts as $script): ?>
			<tr value="<?= $script ?>" ><td class="script-name"><?= $script ?></td></tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div >
		<button style="float:right" id="script-next-btn" type="button" class="btn btn-success">Next</button>
	</div>
</div>

<div id="second-step" style="display:none">
	<p>Select the MLMs to be pulled</p>
	<table id="table2" class="table table-hover col-sm-12">
		<thead>
			<tr><th>Label</th><th>Url</th></tr>	
		</thead>
		<tbody>
			<?php foreach($mlms as $mlm): ?>
			<tr value="<?= $mlm->url ?>" ><td><?= $mlm->label ?></td><td><?= $mlm->url ?></td></tr>
			<?php endforeach; ?>
		</tbody>
	</table>

	<div >
		<button style="float:left" id="script-back-btn" type="button" class="btn btn-info">Back</button>
		<button style="float:right" id="script-execute-btn" type="button" class="btn btn-success">Execute</button>
	</div>
</div>