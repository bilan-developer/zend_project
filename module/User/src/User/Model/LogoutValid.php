<?php
namespace User\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
 
class LogoutValid implements InputFilterAwareInterface {
    public $login;
    public $password;   
    protected $inputFilter;
    public function exchangeArray($data) {
        $this->login = (isset($data['login'])) ? $data['login'] : null;
        $this->login = (isset($data['password'])) ? $data['password'] : null;       
    }
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Not used");
    }
    /**
    * Приминение фильтров и валидаторов к форме авторизации
    */
    public function getInputFilter() {
        $validator = new StringLength();
        $validator->setMessage(
            'Please enter a lower value',
           StringLength::TOO_SHORT);
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();
            // Проверка логина
            $inputFilter->add($factory->createInput(array(
                'name'     => 'login',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 6,
                            'max'      => 30,
                            'messages' => array(
                                \Zend\Validator\StringLength::TOO_SHORT => 'Не менее %min%-ти символов',
                                \Zend\Validator\StringLength::TOO_LONG => 'Не больше %max%-ти символов',
                            )
                        ),
                    ),
                    array(
                        'name'    => 'NotEmpty',
                        'options' => array(                            
                            'messages' => array(                                
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Поле должно быть заполнено',
                            )
                        ),
                    ),
                ),
            )));    
            // Проверка пароля
            $inputFilter->add($factory->createInput(array(
                'name'     => 'password',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(
                    array(
                        'name'    => 'StringLength',
                        'options' => array(
                            'encoding' => 'UTF-8',
                            'min'      => 6,
                            'max'      => 30,
                        ),
                    ),
                    array(
                        'name'    => 'NotEmpty',
                        'options' => array(                            
                            'messages' => array(                                
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Поле должно быть заполнено',
                            )
                        ),
                    ),
                ),
            ))); 
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}
?>