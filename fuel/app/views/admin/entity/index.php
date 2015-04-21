<h2>Listing Entities</h2>
<br>
<?php if ($entities): ?>
<table class="table table-striped">
	<thead>
		<tr>
			<th>Name</th>
			<th></th>
		</tr>
	</thead>
	<tbody>
<?php foreach ($entities as $item): ?>		<tr>

			<td><?php echo $item->name; ?></td>
			<td>
				<?php echo Html::anchor('admin/entity/view/'.$item->id, 'View'); ?> |
				<?php echo Html::anchor('admin/entity/edit/'.$item->id, 'Edit'); ?> |
				<?php echo Html::anchor('admin/entity/delete/'.$item->id, 'Delete', array('onclick' => "return confirm('Are you sure?')")); ?>

			</td>
		</tr>
<?php endforeach; ?>	</tbody>
</table>

<?php else: ?>
<p>No Entities.</p>

<?php endif; ?><p>
	<?php echo Html::anchor('admin/entity/create', 'Add new Entity', array('class' => 'btn btn-success')); ?>

</p>
