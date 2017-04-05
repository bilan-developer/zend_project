<?php
    namespace Money\Form;


    use Zend\Form\Element;
    use Zend\Form\Form;

    class ShoppingListForm extends Form{
        // Функция добавления элементов (ОБЯЗАТЕЛьНАЯ)
        public function prepareElements(){
            $this->setAttribute('method', 'post');
            $this->add(array(                                   // id
                'name' => 'id',                 
                'type'  => 'Zend\Form\Element\Hidden',                
            ));   
            $this->add(array(                                   // id_user
                'name' => 'id_user',                 
                'type'  => 'Zend\Form\Element\Hidden',                
            ));    
            $this->add(array(
                'name' => 'name_list',
                'class'=>'form-control', 
                'type'  => 'Zend\Form\Element\Text',
                'attributes' => array(              
                    'class' => 'form-control',
                    'placeholder' => 'Введите название списка',
                ),   
            ));            
            $this->add(array(                                      // Кнопка отправки формы
                'name' => 'submit',
                'attributes' => array(
                    'type'  => 'submit',
                    'value' => 'Добавить',
                    'class' => 'btn btn-success'
                ),
            ));
        }
    }
?>