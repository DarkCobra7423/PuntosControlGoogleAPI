<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "distance".
 *
 * @property int $idDistance
 * @property string|null $meters
 * @property string|null $kilometers
 */
class Distance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'distance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['meters', 'kilometers'], 'string', 'max' => 100],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idDistance' => 'ID',
            'meters' => 'Metros',
            'kilometers' => 'Kilometros',
        ];
    }
}
