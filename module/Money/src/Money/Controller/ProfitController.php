<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Money\Controller;

use Money\Form\CostsForm;

use Money\Model\CostsValid;


use Money\Model\Profit;
use Money\Model\CategoryProfit;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class ProfitController extends AbstractActionController
{
	protected $profitTable;
	protected $categoryProfitTable;	
	protected $authService;

    
    /**
    * Вывод доходов
    *@return ViewModel
    */
    public function profitAction()
    {   
        $authService = $this->getAuthService();
        $userInfo = $authService->getIdentity();
        $userId = $userInfo->id;
        $categoryProfit = $this->getCategoryProfitTable()->fetchAll();
        $profitUser = $this->getProfitTable()->getProfitIdUser($userInfo->id);
        $form = new CostsForm;
        $form->prepareElements();
        $request = $this->getRequest();
        if ($request->isPost()) {
            $profit = $request->getPost();
            $validator = new CostsValid;
            $form->setInputFilter($validator->getInputFilter());
            $val = $form->getInputFilter()->setData($request->getPost())->getValues(); 
            $form->setData($val);
            if ($form->isValid()) {     
                if($profit->id_category != 0){                   
                    $profit = new Profit(); 
                    $profit->exchangeArray($form->getData());
                    $profit->date = date("Y-m-d");
                    $profit->id_user = $userId;
                    $this->getProfitTable()->saveProfit($profit); 
                    return  $this->redirect()->toRoute('money/default', array('controller'=> 'profit', 'action'=>'profit'));
                }else{
                    $error = "Выберите категорию дохода"; 
                    return array('form' => $form, 'categoryProfit' => $categoryProfit,'error' => $error,'profitUser'=>$profitUser,);
                }           
            }
            return array('form' => $form, 'categoryProfit' => $categoryProfit,'profitUser'=>$profitUser,);
        }else{           
            $view = new ViewModel([
                'form' => $form,
                'categoryProfit' => $categoryProfit,
                'profitUser'=>$profitUser,
            ]);
            return $view;
        }
    	
    }
    /**
    * Просмотр доходов по категориям
    *@return ViewModel
    */
    public function lookProfitAction(){
        $authService = $this->getAuthService();
        $userInfo = $authService->getIdentity();
        $userId = $userInfo->id;
        $category = $this->getCategoryProfitTable()->fetchAll();
        $profitUser = $this->getProfitTable()->fetchAll();
        $form = new CostsForm;
        $form->prepareElements();
        $request = $this->getRequest();
        $val = $request->getPost();
        $id_category = $val->id_category;
        $profitUser = $this->getProfitTable()->getProfitIdCategory($id_category,$userId);        
        $form->setData($val);
        $view = new ViewModel([
            'form' => $form,
            'category' => $category,
            'profitUser'=>$profitUser,            
        ]);
        return $view;
    }
    /**
    * Удаление доходов
    *@param GET[id]
    *@return $this->redirect()
    */
    public function deleteProfitAction(){
        if($this->getRequest()->isGet())        {  
            $getParam = $this->getRequest()->getQuery();
            $this->getProfitTable()->deleteProfit($getParam->id);
            return  $this->redirect()->toRoute('money/default', array('controller'=> 'profit', 'action'=>'profit'));
        } 
    }
    /**
    * Инициализация таблицы Profit
    *@return $this->profitTable;
    */  
    public function getProfitTable(){
        if (!$this->profitTable) 
        {
            $sm = $this->getServiceLocator();
            $this->profitTable = $sm->get('Money\Model\ProfitTable');
        }
        return $this->profitTable;
    }
    /**
    * Инициализация таблицы CategoryProfit
    *@return $this->categoryProfitTable;
    */  
    public function getCategoryProfitTable(){
        if (!$this->categoryProfitTable) 
        {
            $sm = $this->getServiceLocator();
            $this->categoryProfitTable = $sm->get('Money\Model\CategoryProfitTable');
        }
        return $this->categoryProfitTable;
    }
    /**
    * Связь с AuthService
    *@return $this->authService;
    */  
    public function getAuthService(){
        if(!$this->authService){
            $this->authService = $this->getServiceLocator()->get('AuthService');
        }
        return $this->authService;
    }    
    
}