<?php
$_curr_controller_id = $this->getId();
if ($_curr_controller_id == "setting") {
    $this->breadcrumbs=array(
        'Mailers'=>array('mailer'),
        'Manage',
    );
} else {
    $this->breadcrumbs=array(
        'Mailers'=>array('index'),
        'Manage',
    );
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('mailer-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<div id="innermenu">
    <?php $this->renderPartial('/mailer/_menu',array('roles'=>$roles,)); ?>
</div>

<h2>Manage Mailers</h2>

<p>
You may optionally enter a comparison operator (<b>&lt;</b>, <b>&lt;=</b>, <b>&gt;</b>, <b>&gt;=</b>, <b>&lt;&gt;</b>
or <b>=</b>) at the beginning of each of your search values to specify how the comparison should be done.
</p>

<!-- search-form -->
<?php echo CHtml::link('Advanced Search','#',array('class'=>'search-button')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('/mailer/_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->

<div style="clear:both"></div>
<?php $this->widget('application.extensions.lkgrid.LinkmeGridView', array(
	'id'=>'mailer-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
	'columns'=>array(
		'id',
		'user_alias',
		'smtp_host',
		'smtp_port',
		'pop3_host',
		'pop3_port',
        array(
            'name' => 'mailbox',
            'type' => 'raw',
        ),
        array(
            'name' => 'synced',
            'type' => 'raw',
            'value' => '$data->synced ? date("Y-m-d H:i:s", $data->synced) : ""',
        ),
		/*
		'password',
		'username',
		'display_name',
		'email_from',
		'reply_to',
		'status',
		*/
		array(
			'class'=>'CButtonColumn',
            'template'=>'{view} {update} {delete}',
            'buttons' => array(
                'update' => array(
                    'url' => ($_curr_controller_id == "setting")? 'Yii::app()->createUrl("setting/updateMailer", array("id"=>$data->id))' : 'Yii::app()->createUrl("mailer/update", array("id"=>$data->id))',
                ),
            ),
		),
	),
)); ?>
