<h2>Viewing <span class='muted'>#<?php echo $job->id; ?></span></h2>

<p>
	<strong>Job title:</strong>
	<?php echo $job->job_title; ?></p>
<p>
	<strong>Jcat id:</strong>
	<?php echo $job->jcat_id; ?></p>
<p>
	<strong>Job desc:</strong>
	<?php echo $job->job_desc; ?></p>

<?php echo Html::anchor('job/edit/'.$job->id, 'Edit'); ?> |
<?php echo Html::anchor('job','Back'); ?>