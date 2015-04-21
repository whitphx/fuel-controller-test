<h2>Editing Entity</h2>
<br>

<?php echo render('admin/entity/_form'); ?>
<p>
	<?php echo Html::anchor('admin/entity/view/'.$entity->id, 'View'); ?> |
	<?php echo Html::anchor('admin/entity', 'Back'); ?></p>
