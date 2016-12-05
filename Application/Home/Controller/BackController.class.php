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

class BackController extends Controller{
    
        function item(){
        $item=new ItemInfoModel();
        $type=new ItemTypeModel();
        $sup=new SupInfoModel();
        //增删查改操作
        if(isset($_POST['add'])){
            $data=$_POST;
            $map['type_name']=array('eq',$data['item_type']);
            $data['item_type']=$type->field('type_no')->where($map)->find()['type_no'];
            if($data['item_sup']!="")
            {
                $supmap['sup_name']=array('eq',$data['item_sup']);
                $data['item_sup']=$sup->field('sup_no')->where($supmap)->find()['sup_no'];           
            }
            else{
                $data['item_sup']=null;
            }
            dump($data);
            $item->data($data)->add();
        }
        //展示商品数据
        if(isset($_GET['id']))//展示特定类别的商品
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
        $supresult=$sup->select();
        $this->assign('sup', $supresult);
        $this->assign('item', $itresult);
        $this->assign('type',$tyresult);
        $this->display();
    }
    
}
