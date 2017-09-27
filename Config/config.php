<?php
return array(
    /* Cookie设置 */
    'COOKIE_EXPIRE'    =>  0,       // Cookie有效期
    'COOKIE_DOMAIN'    =>  'cg.liaidi.com',      // Cookie有效域名
    'COOKIE_PATH'      =>  '/',     // Cookie路径
    'COOKIE_PREFIX'    =>  'cg_',      // Cookie前缀 避免冲突
    'COOKIE_SECURE'    =>  false,   // Cookie安全传输
    'COOKIE_HTTPONLY'  =>  '1',      // Cookie httponly设置

    //自动加载文件配置
    'AUTO_LOAD_CONFIG'=>array(),
    'AUTO_LOAD_LANGS'=>array('post'),
    'AUTO_LOAD_FUNCTIONS'=>array('wallet', 'game'),

    /*应用配置*/
    'FOUNDERS'=>array('1000000'), //创始人UID
    'AUTHKEY'=>'e94ab937b9e53366675df3b93da80725',//信息加密秘钥
    'STATICURL'=>'/static/',  //静态资源修正地址
    'ATTACHDIR'=>ROOT_PATH.'data/attachment/', //附件保存目录
    'ATTACHURL'=>getSiteURL().'/data/attachment/',  //附件修正地址
    'AVATARDIR'=>ROOT_PATH.'data/avatar/', //头像保存目录
    //IPhone App 配置
    'app_7e1805aea7e8d300'=>array(
        'appid'=>'7e1805aea7e8d300',
        'appkey'=>'51e0fd51bed3446461a6ac8e7278fe86',
        'version'=>'1.60'
    ),
    //Android App 配置
    'app_61569d34a951f553'=>array(
        'appid'=>'61569d34a951f553',
        'appkey'=>'42494c3b0ccb7b033d7cc6f7f653591e',
        'version'=>'2.1.0'
    )
);