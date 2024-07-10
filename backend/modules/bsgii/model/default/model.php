<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/** @var yii\web\View $this */
/** @var backend\modules\bsgii\model\Generator $generator */
/** @var string $tableName full table name */
/** @var string $className class name */
/** @var string $queryClassName query class name */
/** @var yii\db\TableSchema $tableSchema */
/** @var string[] $labels list of attribute labels (name => label) */
/** @var string[] $rules list of validation rules */
/** @var array $relations list of relations (name => relation declaration) */

if (array_key_exists('created_at', $labels) || array_key_exists('updated_at', $labels)) {
    $useDatetimeBehavior = true;
}
if (array_key_exists('created_by', $labels) || array_key_exists('updated_by', $labels)) {
    $useBlameableBehavior = true;
}
echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;
use yii\behaviors\AttributeBehavior;
use common\components\ActiveRecord;
<?php if (isset($useDatetimeBehavior)) : ?>
use common\components\behaviors\DatetimeBehavior;
<?php endif; ?>
<?php if (isset($useBlameableBehavior)) : ?>
use yii\behaviors\BlameableBehavior;
<?php endif; ?>

/**
 * This is the model class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php foreach ($tableSchema->columns as $column) : ?>
 * @property <?= "{$column->phpType} \${$column->name}". ' ' . "[$column->dbType]" . ' ' . ($labels[$column->name] ?? '') . "\n"; ?>
<?php endforeach; ?>
<?php if (!empty($relations)) : ?>
 *
    <?php foreach ($relations as $name => $relation) : ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
    <?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends ActiveRecord
{
    public static $modelName = '<?= $generator->generateModelName($tableName) ?>';
    public $fileAttributes = [<?= implode(",", $generator->fileAttributes) ?>];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '<?= $generator->generateTableName($tableName) ?>';
    }
<?php if ($generator->db !== 'db') : ?>
    /**
     * @return \yii\db\Connection the database connection used by this AR class.
     */
    public static function getDb()
    {
        return Yii::$app->get('<?= $generator->db ?>');
    }

<?php endif; ?>
<?php if (isset($useDatetimeBehavior) || isset($useBlameableBehavior)) : ?>
    public function behaviors()
    {
        return [
    <?php if (isset($useDatetimeBehavior)) : ?>
        DatetimeBehavior::class,
    <?php endif; ?>
    <?php if (isset($useBlameableBehavior)) : ?>
        BlameableBehavior::class,
    <?php endif; ?>];
    }

<?php endif; ?>
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [<?= "\n            " . implode(",\n            ", $rules) . "\n        " ?>];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
<?php foreach ($labels as $name => $label) : ?>
            <?= "'$name' => " . $generator->generateString($label) . ",\n" ?>
<?php endforeach; ?>
        ];
    }
<?php foreach ($relations as $name => $relation) : ?>
    /**
     * @return \yii\db\ActiveQuery
     */
    public function get<?= $name ?>()
    {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName) : ?>
    <?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
    ?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find()
    {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
}
