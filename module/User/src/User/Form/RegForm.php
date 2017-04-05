<?php
  namespace User\Form;

  
  use Zend\Form\Element;
  use Zend\Form\Form;

  class RegForm extends Form{
    // Функция добавления элементов (ОБЯЗАТЕЛьНАЯ)
    public function prepareElements(){
      $this->setAttribute('method', 'post');
      // Id
      $this->add(array(
        'name' => 'id', 
        'type'  => 'Zend\Form\Element\Hidden', 
        'attributes' => array(              
          'value' => '0',                
          ),         
        'options' => array(                
            'label' => 'Name',
           ),  
      ));
      // active
      $this->add(array(
        'name' => 'active', 
        'type'  => 'Zend\Form\Element\Hidden', 
        'attributes' => array(              
          'value' => '0',                
          ),         
        'options' => array(                
            'label' => 'Name',
           ),  
      ));
      // logged
      $this->add(array(
        'name' => 'logged', 
        'type'  => 'Zend\Form\Element\Hidden', 
        'attributes' => array(              
          'value' => '0',                
          ),         
        'options' => array(                
            'label' => 'Name',
           ),  
      ));
      // Логин
      $this->add(array(
        'name' => 'login',
        'class'=>'form-control', 
        'type'  => 'Zend\Form\Element\Text',
         'attributes' => array(              
              'class' => 'form-control',
              'placeholder' => 'Логин',
          ),   
      ));
      // email
      $this->add(array(
        'name' => 'email', 
        'type'  => 'Zend\Form\Element\Email', 
         'attributes' => array(              
              'class' => 'form-control',
              'placeholder' => 'Email',
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
      // Повторный пароль
      $this->add(array(
        'name' => 'rep_password', 
        'type'  => 'Zend\Form\Element\Password', 
         'attributes' => array(              
              'class' => 'form-control',
              'placeholder' => 'Повторный пароль',
          ),  
      ));
      // Кнопка отправки формы
     $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Готово',
                'id' => 'submitAdd',
                'class' => 'tn btn-success btn-lg btn-block'
            ),
      ));
    }
  }
?>