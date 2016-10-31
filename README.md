# yii2-uuid-validator
UUID validator for Yii2 framework

This validator was strongly influenced by https://github.com/ramsey/uuid. Thanks @ramsey for your great UUID package.

## Installation

The preferred way of installation is through Composer.
If you don't have Composer you can get it here: https://getcomposer.org/

To install the package add the following to the ```require``` section of your composer.json:
```
"require": {
    "macgyer/yii2-uuid-validator": "*"
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
      ['some_property', \macgyer\yii2uuidvalidator\UuidValidator::className()],
  ];
}
```