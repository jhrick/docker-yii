<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends RestController 
{
<?php if (is_array($actions)): ?>
<?php foreach($actions as $action): ?>
	public function action<?php echo ucfirst($action); ?>()
	{
		// TODO: implement <?php echo $action; ?> logic
	}
<?php endforeach; ?>
<?php endif; ?>
}
