<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "coordinatedistance".
 *
 * @property int $fkCoordinate
 * @property int $fkDistance
 * @property string|null $points
 */
class Coordinatedistance extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'coordinatedistance';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['fkCoordinate', 'fkDistance'], 'required'],
            [['fkCoordinate', 'fkDistance'], 'integer'],
            [['points'], 'string', 'max' => 100],
            [['fkCoordinate', 'fkDistance'], 'unique', 'targetAttribute' => ['fkCoordinate', 'fkDistance']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'fkCoordinate' => 'Fk Coordinate',
            'fkDistance' => 'Fk Distance',
            'points' => 'Points',
        ];
    }
}
