<?php
namespace Money\Model;

use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Zend\Validator\StringLength;
 
class CostsValid implements InputFilterAwareInterface {
    public $amount_expenses;
    
    protected $inputFilter;
    public function exchangeArray($data) {
        $this->amount_expenses = (isset($data['amount_expenses'])) ? $data['amount_expenses'] : null;
    }
    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new Exception("Not used");
    }
    /**
    * Приминение фильтров и валидаторов к форме расходов
    */
    public function getInputFilter() {
        $validator = new StringLength();
        $validator->setMessage(
            'Please enter a lower value',
           StringLength::TOO_SHORT);
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();
            $factory     = new InputFactory();            
            $inputFilter->add($factory->createInput(array(      // Проверка введённой суммы
                'name'     => 'sum',
                'required' => true,
                'filters'  => array(
                    array('name' => 'StripTags'),
                    array('name' => 'StringTrim'),
                ),
                'validators' => array(                    
                    array(
                        'name'    => 'NotEmpty',
                        'options' => array(                            
                            'messages' => array(                                
                                \Zend\Validator\NotEmpty::IS_EMPTY => 'Введите значение',
                            )
                        ),
                    ),
                     array(
                        'name'    => 'IsFloat',
                        'options' => array(                            
                            'messages' => array(                                
                                \Zend\I18n\Validator\IsFloat::NOT_FLOAT => 'Допускается только целые и десятчные числа',
                            )
                        ),
                        
                    ),                           
                ),
            )));
            $inputFilter->add($factory->createInput(array(      
                'name'     => 'id_category',                   
            )));      
            $this->inputFilter = $inputFilter;
        }
        return $this->inputFilter;
    }
}
?>