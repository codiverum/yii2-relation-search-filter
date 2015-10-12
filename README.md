Relation Search and Filtering
=============================
Simple extension for making searching and filtering by related field simple.

Use this trait to easily add ability to display/filter by related entity attribute. 
It also allows to use table aliases.
Extension is pretty simple but makes the code cleaner, especially when using aliases 
(there are some auto-formatting bugs in some IDEs).

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist codiverum/yii2-relation-search-filter "*"
```

or add

```
"codiverum/yii2-relation-search-filter": "*"
```

to the require section of your `composer.json` file.


Usage
-----

To use the trait you need to do the following (first example without using aliases):
1. In top of your class (search-model) body put:

```
use \codiverum\relationSF\RelationSFTrait; 
```

2. Make new public attribute in your class:

```
public $relation_name;
```

3. Add your attribute to safe attributes
4. In your search function add following:
  - after creating $query add:

```
$this->joinWithRelation($query, 'relation_name');
```

  - after creating $dataProvider add:

```
$this->addRelationSort($dataProvider, 'relation_name', 'related_table_field_name', 'table_name');
```

  - after creating query filters add:

```
$this->addRelationFilter($query, 'relation_name', 'related_table_field_name', 'table_name');
```

5. Add to GridView columns array:

```
[
  'attribute' => 'relation_name',
  'value' => 'relation_name.related_table_field_name',
],

That's it.


Advanced Usage (with table aliases)
-----------------------------------

1. In top of your class (search-model) body put:

```
use \codiverum\relationSF\RelationSFTrait; 
```

2. Make new public attribute in your class:

```
public $relation_name;
```

3. Add your attribute to safe attributes
4. In your search function add following:
  - after creating $query add:

```
$this->joinWithRelation($query, 'relation_name', 'table_name', 'alias');
```

  - after creating $dataProvider add:

```
$this->addRelationSort($dataProvider, 'relation_name', 'related_table_field_name', 'alias');
```

  - after creating query filters add:

```
$this->addRelationFilter($query, 'relation_name', 'related_table_field_name', 'alias');
```

5. Add to GridView columns array:

```
[
  'attribute' => 'relation_name',
  'value' => 'relation_name.related_table_field_name',
],

That's it.