<?php
/**
 * @link https://github.com/MacGyer/yii2-uuid-validator
 * @copyright Copyright (c) 2016 ... MacGyer for pluspunkt coding
 * @license https://github.com/MacGyer/yii2-uuid-validator/blob/master/LICENSE
 */

namespace macgyer\yii2uuidvalidator;

use yii\validators\Validator;
use Yii;

/**
 * UuidValidator validates that the attribute value is a valid UUID.
 *
 * @package yii2uuidvalidator
 * @see https://en.wikipedia.org/wiki/Universally_unique_identifier
 * @see https://github.com/ramsey/uuid
 */
class UuidValidator extends Validator
{
    /**
     * @var string the pattern to test against the value.
     */
    private $pattern = "/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i";

    /**
     * @var string
     * @see http://tools.ietf.org/html/rfc4122#section-4.1.7
     */
    private $zero = '00000000-0000-0000-0000-000000000000';

    /**
     * Initializes the validator.
     */
    public function init()
    {
        parent::init();

        if ($this->message === null) {
            $this->message = Yii::t('yii', '{attribute} is not a valid data URI.');
        }
    }

    /**
     * Validates a single attribute.
     * @param \yii\base\Model $model the data model to be validated
     * @param string $attribute the name of the attribute to be validated.
     * @uses [[renderMessage()]]
     * @uses [[validateValue()]]
     */
    public function validateAttribute($model, $attribute)
    {
        $value = $model->$attribute;
        $result = $this->validateValue($value);

        if (!empty($result)) {
            $this->addError($model, $attribute, $this->renderMessage($model, $attribute));
        }
    }

    /**
     * Validates a value.
     * @param mixed $value the data value to be validated.
     * @return array|null the error message and the parameters to be inserted into the error message.
     */
    protected function validateValue($value)
    {
        $uuid = str_replace(['urn:', 'uuid:', '{', '}'], '', $value);

        if ($uuid == $this->zero) {
            return null;
        }

        if (preg_match($this->pattern, $uuid)) {
            return null;
        }

        return [$this->message, []];
    }

    /**
     * Returns the JavaScript needed for performing client-side validation.
     *
     * @param \yii\base\Model $model the data model being validated
     * @param string $attribute the name of the attribute to be validated.
     * @param \yii\web\View $view the view object that is going to be used to render views or view files
     * containing a model form with this validator applied.
     * @return string the client-side validation script.
     * @see [\yii\widgets\ActiveForm::enableClientValidation](http://www.yiiframework.com/doc-2.0/yii-widgets-activeform.html#$enableClientValidation-detail)
     * @uses [[renderMessage()]]
     */
    public function clientValidateAttribute($model, $attribute, $view)
    {
        $message = json_encode($this->renderMessage($model, $attribute), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $js = "if (!{$this->pattern}.test(value)) {messages.push({$message});}";
        return $js;
    }

    /**
     * Renders the attribute's error message.
     * @param [\yii\base\Model](http://www.yiiframework.com/doc-2.0/yii-base-model.html) $model the data model currently being validated.
     * @param string $attribute the name of the attribute to be validated.
     * @return string the error message.
     */
    private function renderMessage($model, $attribute)
    {
        $attributeLabel = $model->getAttributeLabel($attribute);
        $message = strtr($this->message, ['{attribute}' => $attributeLabel]);

        return $message;
    }
}
