<?php
class RestController extends CController {
	protected $response = [];

	public function init() {
		parent::init();
		header('Content-Type: application/json; charset=UTF-8');
	}

	/**
	 * @param mixed $action
	 */
	protected function beforeAction($action) {
		$this->response = [
			'success' => true,
			'data' => null,
			'errors' => null,
		];
		return parent::beforeAction($action);
	}

	/**
	 * @param CAction $action
	 */
  protected function afterAction($action) {
		echo CJSON::encode($this->response);
		Yii::app()->end();
	}

	/**
	 * @param mixed $data
	 * @param bool $succes
	 */
	protected function setResponseData($data, $succes = true) {
		$this->response['success'] = $succes;
    $this->response['data'] = $data;
	}

	/**
	 * @param string|array $errors
	 */
	protected function addError($errors) {
		if (!is_array($errors)) {
			$errors = [$errors];
		}
		$this->reponse['success'] = false;
		$this->response['errors'] = array_merge($this->reponse['errors'], $errors);
	}

	/**
	 * @param CAction $action
	 * @throws CException
	 */
	public function runAction($action) {
		try {
			parent::runAction($action);
		} catch (Exception $e) {
			$this->addError($e->getMessage());
			$this->afterAction($action);
		}
	}

	public function actionIndex() {
		$this->setResponseData(['message' => 'Welcome to the API']);
	}
}

