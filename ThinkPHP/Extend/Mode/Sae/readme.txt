
  此SAE核心最大的特点就是：它具有“跨平台”的功能，可以让相同的程序代码， 既能在SAE平台下运行，又能在普通环境下运行。

--------------------------------------------------------

  跨平台性，主要体现在一下几个方面。

（1）模版编译缓存。

  在普通环境下，编译缓存会正常的在Runtime/Cache目录下生成。

  在SAE平台下，编译缓存会用Memcache存储。编译缓存的时间和正常情况一下。不会受Memcache的影响。

（2）数据库配置。

  在普通环境下，数据库配置以config文件配置为准。

  在SAE平台下，数据库配置项固定为SAE的常量。并开启了分布式。所以在SEA平台下，不用修改数据库配置项。

（3）使用import导入类库，如import("ORG.Net.UploadFile")

  在普通环境下，导入UploadFile.class.php文件。

  在SAE平台下，如果存在UploadFile_sae.class.php文件，则导入sae专用类库；如果不存在，导入正常的UploadFile.class.php文件

（4）F和S缓存。

  在普通环境下，默认为文件缓存方式。

  在SAE平台下，默认为Memcache缓存方式。

（5）还可以使用IS_SAE常量。
  
  在普通环境下，IS_SAE的值为false。

  在SAE平台下，IS_SAE的值为true。

------------------------------------------------------------

  使用方法:

  此核心只是扩展了ThinkPHP的Mode，需要把文件放在原来的核心文件夹中， 把SaeThinkPHP.php文件放在和原本的ThinkPHP.php文件同一个文件夹。 把Mode文件夹下的文件，放在原来核心的Mode文件夹下。

  然后需要在入口文件包含Sae核心文件。

<?php
define("THINK_PATH","./ThinkPHP");
define("APP_NAME","App");
define("APP_PATH","./App");
require THINK_PATH."/SaeThinkPHP.php";//包含Sae核心文件
App::run();
?>

  在SAE平台下上传文件，只需要把UploadFile_sae.class.php文件放在和普通上传类UploadFile.class.php 同一个文件夹即可。

  上传代码不变。 如：

import("ORG.Net.UploadFile");
$upload=new UploadFile('', 'jpg,png,gif,bmp','','./Public/Upload/',"time");
if(!$upload->upload()){
            $this->error($upload->getErrorMsg());
}else{
            $info=$upload->getUploadFileInfo();
            dump($info['savename']);
}

  在普通环境下，会导入UploadFile.class.php文件，上传文件会保存到./Public/Upload/目录下。

  在SAE平台下，会导入UploadFile_sae.class.php文件，存储到domain为Upload的storage下。 
SAE平台下会把上传目录当作storage的domain， 如上传到./Public/Upload/下，domain就为Upload， 上传到 ./Public/Upload/img/下 domain就为img

