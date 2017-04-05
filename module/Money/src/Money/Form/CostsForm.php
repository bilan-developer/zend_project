<?php
	namespace Money\Form;

	
	use Zend\Form\Element;
	use Zend\Form\Form;

	class CostsForm extends Form{
		// Функция добавления элементов (ОБЯЗАТЕЛьНАЯ)
		public function prepareElements(){
      $this->setAttribute('method', 'post');
      // Сумма расходов
      $this->add(array(
        'name' => 'sum',
        'class'=>'form-control', 
        'type'  => 'Zend\Form\Element\Text',
         'attributes' => array(              
              'class' => 'form-control',
              'placeholder' => 'Введите сумму',
          ),   
      ));
       // Id Категории
      $this->add(array(
        'name' => 'id_category',
        'class'=>'hidden', 
        'type'  => 'Zend\Form\Element\Hidden',
        'attributes' => array(              
          'value' => '0',                
          ),    
      ));
      

      // Кнопка отправки формы
     $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Добавить',
                'id' => 'submitAdd',
                'class' => 'btn btn-success'
            ),
      ));
		}
	}
?>