<?php echo "<?php\n"; ?>

/**
 * Model class for table "<?php echo $tableName; ?>".
 *
<?php foreach($columns as $column): ?>
 * @property <?php echo $column->type.' $'.$column->name."\n"; ?>
<?php endforeach; ?>
<?php if(!empty($relations)): ?>
 *
<?php foreach($relations as $name => $relation): ?>
 * @property <?php
    if (preg_match("~^array\(self::([^,]+), '([^']+)', '([^']+)'\)$~", $relation, $matches)) {
        $relationType = $matches[1];
        $relationModel = $matches[2];

        switch ($relationType) {
            case 'HAS_ONE':
            case 'BELONGS_TO':
                echo "$relationModel \$$name\n";
                break;
            case 'HAS_MANY':
            case 'MANY_MANY':
                echo $relationModel . '[] $' . $name . "\n";
                break;
            default:
                echo "mixed \$$name\n";
        }
    }
?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?php echo $modelClass; ?> extends <?php echo $this->baseClass . "\n"; ?>
{
    public function tableName()
    {
        return '<?php echo $tableName; ?>';
    }

    public function rules()
    {
        return [
<?php foreach($rules as $rule): ?>
            <?php echo $rule . ",\n"; ?>
<?php endforeach; ?>
            // @todo: Modify the following code to remove attributes that should not be searched.
            ['<?php echo implode(', ', array_keys($columns)); ?>', 'safe', 'on' => 'search'],
        ];
    }

    public function relations()
    {
        return [
<?php foreach($relations as $name => $relation): ?>
            '<?php echo $name; ?>' => <?php echo $relation; ?>,
<?php endforeach; ?>
        ];
    }

    public function attributeLabels()
    {
        return [
<?php foreach($labels as $name => $label): ?>
            '<?php echo $name; ?>' => '<?php echo str_replace("'", "\\'", $label); ?>',
<?php endforeach; ?>
        ];
    }

    public function search()
    {
        $criteria = new CDbCriteria;

<?php foreach($columns as $name => $column): ?>
<?php if($column->type === 'string'): ?>
        $criteria->compare('<?php echo $name; ?>', $this-><?php echo $name; ?>, true);
<?php else: ?>
        $criteria->compare('<?php echo $name; ?>', $this-><?php echo $name; ?>);
<?php endif; ?>
<?php endforeach; ?>

        return new CActiveDataProvider($this, [
            'criteria' => $criteria,
        ]);
    }

<?php if($connectionId != 'db'): ?>
    public function getDbConnection()
    {
        return Yii::app()-><?php echo $connectionId; ?>;
    }
<?php endif; ?>

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }
}
