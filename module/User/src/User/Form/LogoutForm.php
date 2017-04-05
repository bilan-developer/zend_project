<?php
	namespace User\Form;

	
	use Zend\Form\Element;
	use Zend\Form\Form;

	class LogoutForm extends Form{
		// Функция добавления элементов (ОБЯЗАТЕЛьНАЯ)
		public function prepareElements(){
      $this->setAttribute('method', 'post');
      // Логин
      $this->add(array(
        'name' => 'login', 
        'type'  => 'Zend\Form\Element\Text',
         'attributes' => array(              
              'class' => 'form-control',
              'placeholder' => 'Логин',
          ),   
      ));
      // Пароль
      $this->add(array(
      	'name' => 'password', 
      	'type'  => 'Zend\Form\Element\Password', 
         'attributes' => array(              
              'class' => 'form-control',
              'placeholder' => 'Пароль',
          ),  
      )); 
      $this->add(array(
        'name' => 'checkbox', 
        'type'  => 'Zend\Form\Element\Checkbox',        
      ));     

      // Кнопка отправки формы
     $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Вход',
                'id' => 'submitAdd',
                'class' => 'btn btn-success'
            ),
      ));
		}
	}
?>