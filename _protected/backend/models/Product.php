<?php

namespace backend\models;

use Yii;

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
class Product extends \yii\db\ActiveRecord
{
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
            [['name','actual_price', 'offer_price'], 'required'],
            [['name', 'category'], 'string', 'max' => 255],
            [['image'], 'file'],
            [['actual_price', 'offer_price','status'], 'integer', 'max' => 55],
            ['image', 'required', 'when' => function ($model) {
                $data = Static::findone($model->id);
                if($data){
                    return $data->image == '';
                }
                else{
                    return $model->image == '';
                }
            }, 'whenClient' => "function (attribute, value) {
                return $('#banner-image').val();
            }"]
        ];
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
        ];
    }
}
