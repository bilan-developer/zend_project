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
use Money\Form\ShoppingListForm;
use Money\Form\GoodsForm;

use Money\Model\CostsValid;
use Money\Model\ShoppingListValid;
use Money\Model\GoodsValid;


use Money\Model\Category;
use Money\Model\Costs;
use Money\Model\ShoppingList;
use Money\Model\Goods;


use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
	protected $categoryTable;
	protected $shoppingListTable;
	protected $goodsTable;	
	protected $costsTable;
	protected $authService;

    
    /**
    * Вывод расходов
    *@return ViewModel
    */
    public function costsAction()
    {   
    	$authService = $this->getAuthService();
        $userInfo = $authService->getIdentity();
        $userId = $userInfo->id;
    	$category = $this->getCategoryTable()->fetchAll();
    	$costsUser = $this->getCostsTable()->getCostsIdUser($userInfo->id);
    	$shoppingList = $this->getShoppingListTable()->getShoppingListIdUser($userId);
        $form = new CostsForm;
        $form->prepareElements();
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$costs = $request->getPost();
        	$validator = new CostsValid;
            $form->setInputFilter($validator->getInputFilter());
            $val = $form->getInputFilter()->setData($request->getPost())->getValues(); 
            $form->setData($val);
            if ($form->isValid()) {            	
            	if($costs->id_category != 0){        		  	
            		$costs = new Costs(); 
            		$costs->exchangeArray($form->getData());
            		$costs->date = date("Y-m-d");
            		$costs->id_user = $userId;
            		$this->getCostsTable()->saveCosts($costs); 
            		return  $this->redirect()->toRoute('money/default', array('controller'=> 'index', 'action'=>'costs'));
            	}else{
            		$error = "Выберите категорию расхода"; 
            		return array('form' => $form, 'category' => $category,'error' => $error,'costsUser'=>$costsUser,'shoppingList' => $shoppingList,);
            	}           
            }
            return array('form' => $form, 'category' => $category,'costsUser'=>$costsUser,'shoppingList' => $shoppingList,);
        }else{           
            $view = new ViewModel([
                'form' => $form,
                'category' => $category,
                'costsUser'=>$costsUser,
                'shoppingList' => $shoppingList,
            ]);
            return $view;
        }
    }
    /**
    * Обновление поля расходов
    *@param userId
    */
    public function updateAmountField($userId){
    	$lists = $this->getShoppingListTable()->getShoppingListIdUser($userId);
    	foreach ($lists as $key => $value) {
    		$id_list = $value->id;
    		$goods =  $this->getGoodsTable()->getGoodsIdList($id_list); 
    		$sum = 0;
    		foreach ($goods as $k => $v) {
    			$sum += $v->sum;   			
    		}
    		$value->sum = $sum;
    		$this->getShoppingListTable()->saveShoppingList($value);    		
    	}

    }
    /**
    * Вывод списка покупок
    *@param ViewModel
    */
    public function shoppingListAction(){  
    	$authService = $this->getAuthService();
        $userInfo = $authService->getIdentity();
        $userId = $userInfo->id;
        $this->updateAmountField($userId);
    	$shoppingList = $this->getShoppingListTable()->getShoppingListIdUser($userId);
    	$form = new ShoppingListForm;
        $form->prepareElements();
        $request = $this->getRequest();
        if ($request->isPost()) {
        	$validator = new ShoppingListValid;
            $form->setInputFilter($validator->getInputFilter());
            $val = $form->getInputFilter()->setData($request->getPost())->getValues(); 
            $form->setData($val);
            if ($form->isValid()) {    		  	
        		$list = new ShoppingList(); 
        		$list->exchangeArray($form->getData());
        		$list->id_user = $userId;        		
        		$this->getShoppingListTable()->saveShoppingList($list);
        		return  $this->redirect()->toRoute('money/default', array('controller'=> 'index', 'action'=>'shopping-list'));
        	} 
            return 	array(
		            	'form' 			=> $form,
		                'shoppingList' 	=> $shoppingList,
                	);
        }else{           
            $view = new ViewModel([
                'form' 			=> $form,
                'shoppingList' 	=> $shoppingList,
            ]);
            return $view;
        }
    }
    /**
    * Редактирование списка покупок
    *@param GET[id]
    *@return ViewModel
    */
    public function editShoppingListAction(){    	
		$form = new ShoppingListForm;            
   		$form->prepareElements();            
     	$request = $this->getRequest(); 
    	if($this->getRequest()->isGet()){  
            $id = $this->getRequest()->getQuery();           
            $shoppingList = $this->getShoppingListTable()->getShoppingList($id->id);
        }
        if ($request->isPost()) {
        	$validator = new ShoppingListValid;
            $form->setInputFilter($validator->getInputFilter());
            $val = $form->getInputFilter()->setData($request->getPost())->getValues(); 
            $form->setData($val);;
            if ($form->isValid()) {	    		  	
	        		$list = new ShoppingList(); 
	        		$list->exchangeArray($form->getData());	        		
	        		$this->getShoppingListTable()->saveShoppingList($list);	        		
	        		return  $this->redirect()->toRoute('money/default', array('controller'=> 'index', 'action'=>'shopping-list'));
	        }else{
				$view = new ViewModel([					
					'form' => $form,					
				]);
				return $view;
	        } 
        }else{
        	$val['id'] = $shoppingList->id;
            $val['name_list'] = $shoppingList->name_list;
            $val['sum'] = $shoppingList->sum;            
            $val['id_user'] = $shoppingList->id_user;
            $form->setData($val);
        	$view = new ViewModel([
                'form' => $form,
            ]);
            return $view;
        }
	}
    /**
    * Удаление списка покупок
    *@param GET[id]
    *@return $this->redirect()
    */
    public function deleteShoppingListAction(){
    	if($this->getRequest()->isGet())
        {  
            $id = $this->getRequest()->getQuery();
            $this->getShoppingListTable()->deleteShoppingList($id->id);
            $this->getGoodsTable()->deleteGoodsList($id->id);
            return  $this->redirect()->toRoute('money/default', array('controller'=> 'index', 'action'=>'shopping-list'));            
            
        } 
    }
    /**
    * Активирование статуса списка покупок
    *@param GET[id]
    *@return $this->redirect()
    */
    public function bayShoppingListAction(){
        if($this->getRequest()->isGet()) {
            $id = $this->getRequest()->getQuery();
            $shoppingList = $this->getShoppingListTable()->getShoppingList($id->id);
            $shoppingList->date = date("Y-m-d");
            $shoppingList->status = 1;
            $this->getShoppingListTable()->saveShoppingList($shoppingList);
            return  $this->redirect()->toRoute('money/default', array('controller'=> 'index', 'action'=>'shopping-list')); 
        } 
    }
    /**
    * Вывод товаров 
    *@param GET[id]   
    *@return ViewModel
    */
    public function GoodsAction(){

		$form = new GoodsForm;            
   		$form->prepareElements();            
     	$request = $this->getRequest(); 
    	if($this->getRequest()->isGet()){  
            $id_list = $this->getRequest()->getQuery();
            $goods = $this->getGoodsTable()->getGoodsIdList($id_list->id);                   	
			$view = new ViewModel([
				'goods' => $goods,
				'form' => $form,
				'id_list' => $id_list->id,
			]);
			return $view;
		}
	 	if ($request->isPost()) {	 		
	 		$id_list = $request->getPost('id_list');	 		
            $goods = $this->getGoodsTable()->getGoodsIdList($id_list);

	 		$validator = new GoodsValid;
            $form->setInputFilter($validator->getInputFilter());
            $val = $form->getInputFilter()->setData($request->getPost())->getValues(); 
            $form->setData($val);
            if ($form->isValid()) {	    		  	
	        		$newGoods = new Goods(); 
	        		$newGoods->exchangeArray($form->getData());	        		
	        		$this->getGoodsTable()->saveGoods($newGoods); 
	        		return  $this->redirect()->toRoute('money/default', array('controller'=> 'index', 'action'=>'goods'),array('query' => array('id' => "$id_list")));
	        }else{
				$view = new ViewModel([
					'goods' => $goods,
					'form' => $form,
					'id_list' => $id_list,
				]);
				return $view;
	        } 
     	}		 
    }
    /**
    * Удаление расхода 
    *@param GET[id]   
    *@return ViewModel
    */
    public function deleteCostsAction(){
    	if($this->getRequest()->isGet())        {  
            $getParam = $this->getRequest()->getQuery();
            $this->getCostsTable()->deleteCosts($getParam->id);
           	return  $this->redirect()->toRoute('money/default', array('controller'=> 'index', 'action'=>'costs'));
        } 
    }
    /**
    * Удаление товара 
    *@param GET[id]   
    *@return redirect
    */
    public function deleteGoodsAction(){
    	if($this->getRequest()->isGet())        {  
            $getParam = $this->getRequest()->getQuery();
            $this->getGoodsTable()->deleteGoods($getParam->id);
           	return  $this->redirect()->toRoute('money/default', array('controller'=> 'index', 'action'=>'goods'),array('query' => array('id' => "$getParam->id_list")));
        } 
    }
    /**
    * Редактирование товара 
    *@param GET[id]   
    *@return ViewModel
    */
    public function editGoodsAction(){
    	$form = new GoodsForm;            
   		$form->prepareElements();            
     	$request = $this->getRequest(); 
    	if($this->getRequest()->isGet()){  
            $getParam = $this->getRequest()->getQuery();           
            $goods = $this->getGoodsTable()->getGoods($getParam->id); 
        }
        if ($request->isPost()) {
        	$validator = new GoodsValid;
            $form->setInputFilter($validator->getInputFilter());
            $val = $form->getInputFilter()->setData($request->getPost())->getValues(); 
            $form->setData($val);
            $id_list = $val["id_list"];
            if ($form->isValid()) {	    		  	
	        		$goods = new Goods(); 
	        		$goods->exchangeArray($form->getData());	        		
	        		$this->getGoodsTable()->saveGoods($goods);	        		
	        		return  $this->redirect()->toRoute('money/default', array('controller'=> 'index', 'action'=>'goods'),array('query' => array('id' => "$id_list")));
	        }else{
				$view = new ViewModel([					
					'form' => $form,
					'id_list' => $id_list,					
				]);
				return $view;
	        } 
        }else{
        	$val['id'] = $goods->id;
            $val['name_goods'] = $goods->name_goods;
            $val['sum'] = $goods->sum;            
            $val['id_list'] = $goods->id_list;
            $form->setData($val);
        	$view = new ViewModel([
                'form' => $form,
                'id_list' => $goods->id_list,
            ]);
            return $view;
        }
	}
    /**
    * Просмотр расходов 
    *@return ViewModel
    */
	public function lookCostsAction(){
		$authService = $this->getAuthService();
        $userInfo = $authService->getIdentity();
        $userId = $userInfo->id;
		$category = $this->getCategoryTable()->fetchAll();
    	$costsUser = $this->getCostsTable()->fetchAll();
    	$shoppingList = $this->getShoppingListTable()->getShoppingListIdUser($userId);
		$form = new CostsForm;
        $form->prepareElements();
        $request = $this->getRequest();

        $val = $request->getPost();
        $id_category = $val->id_category;
        if($id_category == 0){
        	$view = new ViewModel([
	            'form' => $form,
	            'category' => $category,            
	            'shoppingList' => $shoppingList,
	        ]);
	        return $view;
        }        
        $costsUser = $this->getCostsTable()->getCostsIdCategory($id_category,$userId);        
    	$form->setData($val);
        $view = new ViewModel([
            'form' => $form,
            'category' => $category,
            'costsUser'=>$costsUser,            
        ]);
        return $view;
    }
    /**
    * Инициализация таблицы Category
    *@return $this->categoryTable;
    */   
    public function getCategoryTable(){
        if (!$this->categoryTable) 
        {
            $sm = $this->getServiceLocator();
            $this->categoryTable = $sm->get('Money\Model\CategoryTable');
        }
        return $this->categoryTable;
    }
    /**
    * Инициализация таблицы ShoppingList
    *@return $this->shoppingListTable;
    */   
    public function getShoppingListTable(){
        if (!$this->shoppingListTable) 
        {
            $sm = $this->getServiceLocator();
            $this->shoppingListTable = $sm->get('Money\Model\ShoppingListTable');
        }
        return $this->shoppingListTable;
    }
    /**
    * Инициализация таблицы Goods
    *@return $this->goodsTable;
    */  
    public function getGoodsTable(){
        if (!$this->goodsTable) 
        {
            $sm = $this->getServiceLocator();
            $this->goodsTable = $sm->get('Money\Model\GoodsTable');
        }
        return $this->goodsTable;
    }
    /**
    * Инициализация таблицы Costs
    *@return $this->costsTable;
    */  
    public function getCostsTable(){
        if (!$this->costsTable) 
        {
            $sm = $this->getServiceLocator();
            $this->costsTable = $sm->get('Money\Model\CostsTable');
        }
        return $this->costsTable;
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
