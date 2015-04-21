<h2>Viewing #<?php echo $entity->id; ?></h2>

<p>
	<strong>Name:</strong>
	<?php echo $entity->name; ?></p>

<?php echo Html::anchor('admin/entity/edit/'.$entity->id, 'Edit'); ?> |
<?php echo Html::anchor('admin/entity', 'Back'); ?>