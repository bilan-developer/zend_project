<?php
  namespace Administer\Form;

  
  use Zend\Form\Element;
  use Zend\Form\Form;

  class EditUserForm extends Form{
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
      // role
      $this->add(array(
        'name' => 'role', 
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
      // Пароль
      $this->add(array(
        'name' => 'password', 
        'type'  => 'Zend\Form\Element\Password', 
         'attributes' => array(              
              'class' => 'form-control',
              'placeholder' => 'Пароль',
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