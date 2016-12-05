<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Think\Controller;
use Home\Model\ItemInfoModel;
use Home\Model\SupInfoModel;
use Home\Model\ItemTypeModel;

class TestController extends Controller{
    function admin(){
        $item=new ItemInfoModel();
        $type=new ItemTypeModel();
        $sup=new SupInfoModel();
        if(isset($_GET['id']))
        {
            $itresult=$item->where('item_type='.$_GET['id'])->select();
        }
        else {
            $itresult=$item->select();
        }
        $tyresult=$type->select();
        for($i=0; $i<count($itresult); $i++)//取供应商名称
        {
            if($itresult[$i]['item_sup'])
            {
                $result=$sup->field('sup_name')->where('sup_no='.$itresult[0]['item_sup'])->find()['sup_name'];
                $itresult[$i]['item_sup']=$result;
            }
        }
        $this->assign('item', $itresult);
        $this->assign('type',$tyresult);
        $this->display();
    }
    
    function adminLogin(){
        $this->display();
    }
    
    function type(){
        print_r($_GET['_URL_']);
    }

}