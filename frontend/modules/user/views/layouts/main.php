<?php
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\modules\user\assets\UserAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

$this->title = '用户中心';

$this->params['breadcrumbs'][] = array(
    'label' => '个人中心'
)
// 'url' => ['']
;
// $this->params['breadcrumbs'][] = '视图';

UserAsset::register($this);

?>
<?php $this->beginPage()?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
<meta charset="<?= Yii::$app->charset ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags()?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head()?>
    
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="http://cdn.bootcss.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
    <?php $this->beginBody()?>

    <div id="wrapper">
        <!-- Navigation -->
        
            <!-- /.navbar-header -->
            <?php
            NavBar::begin([
                'brandLabel' => Yii::$app->name,
                'brandUrl' => Yii::$app->homeUrl,
                'screenReaderToggleText' => '显示菜单',
                'options' => [
                    'class' => 'navbar-white navbar-static-top'
                ]
            ]);
            $items = [
                [
                    'label' => '在线商店',
                    'url' => [
                        '/site/index'
                    ]
                ],
                [
                    'label' => '产品',
                    'url' => [
                        '/question/default/index'
                    ]
                ],
                [
                    'label' => '服务',
                    'url' => [
                        '/question/default/index'
                    ]
                ]
            ];
            echo Nav::widget([
                'options' => [
                    'class' => 'navbar-nav'
                ],
                'encodeLabels' => false,
                'items' => $items
            ]);
            $items = [];
            if (Yii::$app->user->isGuest) {
                $items = [
                    [
                        'label' => '登录',
                        'url' => Yii::$app->user->loginUrl
                    ],
                    [
                        'label' => '注册',
                        'url' => [
                            '/user/signup'
                        ]
                    ]
                ];
            } else {
                $user = Yii::$app->user;
                $identity = $user->identity;
                $items = [
                    [
                        'label' => $identity->username,
                        'url' => [
                            '/home/'
                        ]
                    ],
                    '<li>|</li>',
                    
                    [
                        'label' => '退出',
                        'url' => [
                            '/account/logout/'
                        ]
                    ]
                ];
            }
            echo Nav::widget([
                'options' => [
                    'class' => 'navbar-nav navbar-right'
                ],
                'encodeLabels' => false,
                'items' => $items
            ]);

            
            NavBar::end();
            ?>
           
            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li><h3>订单中心</h3></li>
                        <li><a href="index.html">我的订单</a></li>
                        <li><a href="tables.html">待支付</a></li>
                        <li><a href="forms.html">待收货</a></li>
                        <li><a href="forms.html">已关闭</a></li>
                        <li><h3>个人中心</h3></li>
                        <li><a href="#">我的个人中心</a></li>
                        <li><a href="#">优惠券</a></li>
                        <li><a href="#">收货地址</a></li>
                        <li><h3>账户管理</h3></li>
                        <li><a href="#">个人信息</a></li>
                        <li><a href="#">修改密码</a></li>
                        <li><a href="#">认证维护</a></li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
            
        <div id="page-wrapper">
            <?=Breadcrumbs::widget(['homeLink' => ['label' => '首页','url' => Yii::$app->homeUrl],'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : []])?> 
            <?= $content?>
        </div>
        <!-- /#page-wrapper -->
    </div>

    <?php $this->endBody()?>
</body>
</html>
<?php $this->endPage()?>
