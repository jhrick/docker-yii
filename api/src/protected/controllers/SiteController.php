<?php

class SiteController extends RestController
{
	public function actionIndex() {
		$this->setResponseData(['username' => $_ENV['MYSQL_USER'], 'password' => $_ENV['MYSQL_PASSWORD']]);
	}
}