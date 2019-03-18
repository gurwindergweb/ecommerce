<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;
use yz\shoppingcart\CartPositionInterface;
use yz\shoppingcart\CartPositionTrait;

/**
 * This is the model class for table "product".
 *
 * @property int $id
 * @property string $name
 * @property string $status
 * @property string $category
 * @property string $image
 * @property string $actual_price
 * @property string $offer_price
 */
class Product extends \yii\db\ActiveRecord implements CartPositionInterface
{
    use CartPositionTrait;

    public function getPrice()
    {
        return $this->offer_price;
    }

    public function getId()
    {
        return $this->id;
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name','stock','actual_price','sub_category', 'offer_price','category','status'], 'required'],
            [['name'], 'string', 'max' => 255],
            [['description','features'], 'string', 'max' => 555],
            [['image'], 'file'],
            [['stock','actual_price', 'offer_price','status'], 'integer'],
            ['image', 'required', 'when' => function ($model) {
                $data = Static::findone($model->id);
                if($data){
                    return $data->image == '';
                }
                else{
                    return $model->image == '';
                }
            }, 'whenClient' => "function (attribute, value) {
                return $('#product-image').val();
            }"]
        ];
    }

    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('../uploads/product/'. $this->image->baseName . '.' . $this->image->extension);
            return true;
        } else {
            return false;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'status' => 'Status',
            'category' => 'Category',
            'image' => 'Image',
            'actual_price' => 'Actual Price',
            'offer_price' => 'Offer Price',
            'sub_category' => 'Sub Category',
            'description' => 'Description',
            'features' => 'Features',
            'stock' => 'Stock',
        ];
    }

}
