<?php
use yii\helpers\Url;

$count=1;
        foreach($model as $banner) {
            if($count==1) { ?>
                <div class="carousel-item item1 active" style="background: url(<?php echo Url::to('@appRoot',true).'/uploads/banner/'.$banner->image ; ?>) no-repeat center;">
                <?php  }
            elseif($count==2) { ?>
                <div class="carousel-item item2" style="background: url(<?php echo Url::to('@appRoot',true).'/uploads/banner/'.$banner->image ; ?>) no-repeat center;">
            <?php }
            elseif($count==3) { ?>
               <div class="carousel-item item3" style="background: url(<?php echo Url::to('@appRoot',true).'/uploads/banner/'.$banner->image ; ?>) no-repeat center;">
           <?php  }
            else{  ?>
                <div class="carousel-item item4" style="background: url(<?php echo Url::to('@appRoot',true).'/uploads/banner/'.$banner->image ; ?>) no-repeat center;">
           <?php } ?>
           <div class="container">
                <div class="w3l-space-banner">
                    <div class="carousel-caption p-lg-5 p-sm-4 p-3">
                        <p><?php echo $banner->offer; ?></p>
                        <h3 class="font-weight-bold pt-2 pb-lg-5 pb-4"><?php echo $banner->title; ?></h3>
                        <a class="button2" href="product.html">Shop Now </a>
                    </div>
                </div>
            </div>
        </div>
       <?php $count++; } ?>