<?php
	namespace User\Storage;

	use Zend\Authentication\Storage;

	class AuthStorage extends Storage\Session{
		/**
	    * Запомнить пользователя в сессии
	    *@param $rememberMe
	    *@param $time
	    */
		public function setRememberMe($rememberMe = 0, $time = 1209600){
			if($rememberMe == 1){
				$this->session->getManager()->rememberMe($time);

			}
		}
		/**
	    * Разлогинить пользователя
	    *@param $rememberMe
	    *@param $time
	    */
		public function forgetMe(){
			$this->session->getManager()->forgetMe();		
		}
	}
?>