<?php
$this->breadcrumbs=array(
	'Task Ratings'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('task-rating-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<h1>Manage Task Ratings</h1>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<!-- search-form -->
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
<!-- search-form -->
<div style="clear:both"></div>
<?php $this->widget('application.extensions.lkgrid.LinkmeGridView', array(
	'id'=>'task-rating-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'task_id',
		'rating',
		'notes',
		'created',
		'created_by',
		array(
			'class'=>'CButtonColumn',
		),
	),
)); ?>
