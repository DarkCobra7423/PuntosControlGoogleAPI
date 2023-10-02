<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coordinate".
 *
 * @property int $idCoordinate
 * @property string|null $latitude
 * @property string|null $longitude
 * @property string|null $time
 */
class Coordinate extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coordinate';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['time'], 'safe'],
            [['latitude', 'longitude'], 'string', 'max' => 100],
            [['token'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'idCoordinate' => 'ID',
            'latitude' => 'Latitud',
            'longitude' => 'Longitud',
            'time' => 'Fecha',
            'token' => 'Token',
        ];
    }
}
