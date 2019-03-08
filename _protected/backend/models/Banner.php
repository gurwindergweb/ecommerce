<?php

namespace backend\models;

use Yii;
use yii\web\UploadedFile;

/**
 * This is the model class for table "banner".
 *
 * @property int $id
 * @property string $title
 * @property string $offer
 * @property string $image
 * @property string $status
 */
class Banner extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'banner';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'status','offer'], 'required'],
            [['image'], 'file'],
            [['title','offer', 'status'], 'string', 'max' => 255],
            [['title'], 'unique'],
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

    public function upload()
    {
        if ($this->validate()) {
            $this->image->saveAs('../uploads/banner/'. $this->image->baseName . '.' . $this->image->extension);
            //$this->fileupload=Yii::getalias('@backenduploads1');
            // print_r($this->fileupload);die;
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
            'title' => 'Title',
            'offer' => 'Offer',
            'image' => 'Image',
            'status' => 'Status',
        ];
    }
}
