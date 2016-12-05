<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;
use Think\Controller;
use Home\Model\SysUserModel;
use Home\Model\SysUesrTypeModel;

class IndexController extends Controller{
    
     public function index()
		{	
			header("Content-Type:text/html; charset=utf-8");
			//登录
			if($_POST["submit"])
			{
				$username = $_POST["username"];
				$password = $_POST["password"];
                                //创建模型对象
				$st = new SysUserModel();
                                //查询数据库
                                //使用原生SQL命令                                 
                               //使用thinkphp中CRUD
                                $result = $st->where("user_name='$username' && user_pwd ='$password'")->select();
                               //判断是否能够登录
				if($result)
				{
					//登录成功,记录用户登录session值
					$_SESSION["user"]=$username;
                                        //判断用户的登录类型决定跳转到前台还是后台
                                        $utype=new \Home\Model\SysUserTypeModel();                                       
                                        $loginback=$utype->field('login_back')->where('type_no='.$result[0]['user_type'])->select()[0]['login_back'];
                                        $loginfront=$utype->field('login_front')->where('type_no='.$result[0]['user_type'])->select()[0]['login_front'];
                                        if($loginback==1)//有后台权限
                                        {  
                                             echo "<script>location.href='http://127.0.0.1/Branch/index.php/Home/Back/item';</script>";
                                        }
                                        elseif($loginfront==1)
                                        {      
                                            echo "欢迎登录前台";
                                        }
                                        else{
                                            echo "<script>alert('此用户已被禁用')</script>";
                                            $this->display();
                                        }
                                        
                                }
				else
				{
					echo "<script>alert('用户名或密码错误！')</script>";
					$this->display();
				}
			}
			else
                        {				//非法访问方式，直接跳转到页面
				echo "<script>alert('非法操作，跳转到登录页面')</script>";
				\Home\Controller\IndexController::display();
                        }
                }
}