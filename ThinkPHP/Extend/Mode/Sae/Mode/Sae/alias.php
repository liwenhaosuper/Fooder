<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2010 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
// $Id: alias.php 2504 2011-12-28 07:35:29Z liu21st $

// 导入别名定义
alias_import(array(
    'Model'         => THINK_PATH.'Lib/Think/Core/Model.class.php',
    'Dispatcher'    => THINK_PATH.'Lib/Think/Core/Dispatcher.class.php',
    'HtmlCache'     => MODE_PATH.'Sae/HtmlCache.class.php',
    'Db'            => THINK_PATH.'Lib/Think/Db/Db.class.php',
    'ThinkTemplate' => MODE_PATH.'Sae/ThinkTemplate.class.php',
    'Template'      => THINK_PATH.'Lib/Think/Util/Template.class.php',
    'TagLib'        => THINK_PATH.'Lib/Think/Template/TagLib.class.php',
    'Cache'         => MODE_PATH.'Sae/Cache.class.php',
    'Debug'         => THINK_PATH.'Lib/Think/Util/Debug.class.php',
    'Session'       => THINK_PATH.'Lib/Think/Util/Session.class.php',
    'TagLibCx'      => THINK_PATH.'Lib/Think/Template/TagLib/TagLibCx.class.php',
    'TagLibHtml'    => THINK_PATH.'Lib/Think/Template/TagLib/TagLibHtml.class.php',
    'ViewModel'     => THINK_PATH.'Lib/Think/Core/Model/ViewModel.class.php',
    'AdvModel'      => THINK_PATH.'Lib/Think/Core/Model/AdvModel.class.php',
    'RelationModel' => THINK_PATH.'Lib/Think/Core/Model/RelationModel.class.php',
    'MongoModel'  => THINK_PATH.'Lib/Think/Core/Model/MongoModel.class.php',
    )
);
?>