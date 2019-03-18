<?php
/**
 * Created by PhpStorm.
 * User: Gnetwebs
 * Date: 3/11/2019
 * Time: 12:35 PM
 */
// print_r($model);
use yii\helpers\Url;?>
<?php if(empty($model))
{?>

        <h3 class="heading-tittle text-center font-italic">No search results Found</h3>

<?php } else {?>
    <div>
        <h3 class="heading-tittle text-center font-italic">Search for <?= $model_data ?> :</h3>
    </div>
<div class="product-sec1 px-sm-4 px-3 py-sm-5  py-3 mb-4">
    <div class="row">
        <?php foreach($model as $products) { ?>
        <div class="col-md-4 product-men mt-md-0 mt-5">
            <div class="men-pro-item simpleCart_shelfItem">
                <div class="men-thumb-item text-center">
                    <img src="<?php echo Url::to('@appRoot',true).'/uploads/product/'.$products->image ; ?>" alt="">
                    <div class="men-cart-pro">
                        <div class="inner-men-cart-pro">
                            <a href="<?php echo Url::base(); ?>/site/single?id=<?php echo $products->id; ?>" class="link-product-add-cart">Quick View</a>
                        </div>
                    </div>
                </div>
                <div class="item-info-product text-center border-top mt-4">
                    <h4 class="pt-1">
                        <a href="<?php echo Url::base(); ?>/site/single?id=<?php echo $products->id; ?>"><?php echo $products->name; ?></a>
                    </h4>
                    <div class="info-product-price my-2">
                        <span class="item_price"><?php echo '$'.$products->offer_price; ?></span>
                        <del><?php echo '$'.$products->actual_price; ?></del>
                    </div>
                    <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                        <form action="#" method="post">
                            <fieldset>
                                <input type="hidden" name="cmd" value="_cart">
                                <input type="hidden" name="add" value="1">
                                <input type="hidden" name="business" value=" ">
                                <input type="hidden" name="item_name" value="Samsung Galaxy J7">
                                <input type="hidden" name="amount" value="200.00">
                                <input type="hidden" name="discount_amount" value="1.00">
                                <input type="hidden" name="currency_code" value="USD">
                                <input type="hidden" name="return" value=" ">
                                <input type="hidden" name="cancel_return" value=" ">
                                <input type="submit" name="submit" value="Add to cart" class="button btn">
                            </fieldset>
                        </form>
                    </div>

                </div>
            </div>
        </div>
        <?php } ?>

    </div>
</div>
<?php } ?>