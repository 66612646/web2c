<?php
use yii\helpers\Url;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use frontend\assets\AppAsset;
use frontend\widgets\Alert;

/* @var $this \yii\web\View */
/* @var $content string */

AppAsset::register($this);
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
                '/shop/'
            ]
        ],
        [
            'label' => '产品',
            'url' => [
                '/products/'
            ]
        ],
        [
            'label' => '服务',
            'url' => [
                '/service/'
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
                    '/account/signup'
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
                ],
                'linkOptions' => [
                    'data-method' => 'post'
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
            
    <div class="container">
    <?= Alert::widget()?>
    <?= $content?>
    </div>
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-sm-2">
                    <dt>网站信息</dt>
                    <dd>
                        <a href="<?= Url::to(['/site/about']) ?>">关于我们</a>
                    </dd>
                </div>
                <div class="col-sm-2">
                    <dt>相关合作</dt>
                    <dd>
                        <a href="<?= Url::to(['/site/contact']) ?>">联系我们</a>
                    </dd>
                </div>
                <div class="col-sm-2">
                    <dt>关注我们</dt>
                    <dd>
                        <a href="<?= Url::to(['/site']) ?>">成长日志</a>
                    </dd>
                </div>
                <div class="col-sm-6">
                    <dt>技术采用</dt>
                    <dd>
                        由 <a href="https://github.com/callmez">CallMeZ</a> 创建 项目地址: <a
                            href="https://github.com/callmez/huajuan">huajuan</a>
                    </dd>
                    <dd> <?= Yii::powered() ?> <?= Yii::getVersion() ?> </dd>
                </div>
            </div>
        </div>
    </footer>
    <?php $this->endBody()?>
</body>
</html>
<?php $this->endPage() ?>
