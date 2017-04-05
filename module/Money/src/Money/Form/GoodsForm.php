<?php
    namespace Money\Form;


    use Zend\Form\Element;
    use Zend\Form\Form;

    class GoodsForm extends Form{
        // Функция добавления элементов (ОБЯЗАТЕЛьНАЯ)
        public function prepareElements(){
            $this->setAttribute('method', 'post');
            $this->add(array(                                   // Id
                'name' => 'id',                 
                'type'  => 'Zend\Form\Element\Hidden',                
            ));          
            $this->add(array(                                 // Название списка
                'name' => 'name_goods',
                'type'  => 'Zend\Form\Element\Text',
                'attributes' => array(              
                    'class' => 'form-control',
                    'placeholder' => 'Введите название товарв',
                ),   
            ));
            $this->add(array(
                'name' => 'sum',                              // Цена
                'type'  => 'Zend\Form\Element\Text',
                'attributes' => array(              
                    'class' => 'form-control',
                    'placeholder' => 'Введите стоимость товарв',
                ),   
            ));

            $this->add(array(                                   // Id списка
                'name' => 'id_list',                 
                'type'  => 'Zend\Form\Element\Hidden',                
            ));
            // Кнопка отправки формы
            $this->add(array(
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