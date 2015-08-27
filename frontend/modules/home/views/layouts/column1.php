<?php
use yii\helpers\Url;

?>
<?php $this->beginContent('@app/views/layouts/main.php')?>
<div class="row">
    <div class="col-md-3  m-b-10 navbar-default sidebar" role="navigation">
        <div class="sidebar-nav navbar-collapse">
            <ul class="nav" id="side-menu">
                <li><h3>订单中心</h3></li>
                <li><a href="<?= Url::to(['/account/order']) ?>">我的订单</a></li>
                <li><a href="<?= Url::to(['/account/order/type/1']) ?>">待支付</a></li>
                <li><a href="<?= Url::to(['/account/order/type/2']) ?>">待收货</a></li>
                <li><a href="<?= Url::to(['/account/order/type/3']) ?>">已关闭</a></li>
                <li><h3>个人中心</h3></li>
                <li><a href="<?= Url::to(['/account/my/']) ?>">我的个人中心</a></li>
                <li><a href="<?= Url::to(['/account/my/coupon']) ?>">优惠券</a></li>
                <li><a href="<?= Url::to(['/account/my/address']) ?>">收货地址</a></li>
                <li><h3>账户管理</h3></li>
                <li><a href="<?= Url::to(['/account/profile']) ?>">个人信息</a></li>
                <li><a href="<?= Url::to(['/account/security']) ?>">修改密码</a></li>
                <li><a href="<?= Url::to(['/account/credit']) ?>">认证维护</a></li>
            </ul>
        </div>
        <!-- /.sidebar-collapse -->
    </div>
    <div class="col-md-9 m-b-10 main">
        <?= $content?>
    </div>
</div>
<?php $this->endContent() ?>