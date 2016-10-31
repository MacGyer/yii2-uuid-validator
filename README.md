# yii2-data-uri-validator
Data URI validator for Yii2 framework

## Installation

The preferred way of installation is through Composer.
If you don't have Composer you can get it here: https://getcomposer.org/

To install the package add the following to the ```require``` section of your composer.json:
```
"require": {
    "macgyer/yii2-data-uri-validator": "*"
},
```

## Usage

Just add the validator to your Model class:
```
// rules
public function rules()
{
  return [
      // more rules
      ['some_property', \macgyer\yii2dataurivalidator\DataUriValidator::className()],
  ];
}
```