<?php echo "<?php\n"; ?>

class <?php echo $this->controllerClass; ?> extends RestController 
{
	public function actionIndex()
	{
		$dataProvider = new CActiveDataProvider('<?php echo $this->modelClass; ?>');
		$this->render('index', ['dataProvider' => $dataProvider]);
	}

	public function actionView($id)
	{
    $model = $this->loadModel($id);
    echo CJSON::encode($model);
	}

	public function actionCreate()
	{
		$model = new <?php echo $this->modelClass; ?>;

		if (isset($_POST['<?php echo $modelClass; ?>'])) {
			$model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
			if ($model->save()) {
				$this->redirect(['view', 'id' => $model->primaryKey]);
			}
		}

		$this->render('create', ['model' => $model]);
	}

	public function actionUpdate($id)
	{
		$model = $this->loadModel($id);

		if (isset($_POST['<?php echo $modelClass; ?>'])) {
			$model->attributes = $_POST['<?php echo $this->modelClass; ?>'];
			if ($model->save()) {
				$this->redirect(['view', 'id' => $model->primaryKey]);
			}
		}

		$this->render('update', ['model' => $model]);
	}

	public function actionDelete($id)
	{
		if (Yii::app()->request->isPostRequest) {
			$this->loadModel($id)->delete();

			if (!isset($_GET['ajax'])) {
				$this->redirect(['index']);
			}
		} else {
			throw new CHttpException(400, 'Invalid request.');
		}
	}

	protected function loadModel($id)
	{
		$model = <?php echo $this->modelClass; ?>::model()->findByPk($id);
		if ($model === null) {
			throw new CHttpException(404, 'Not found.');
		}
		return $model;
	}
}
