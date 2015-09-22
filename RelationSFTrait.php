<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace codiverum\RelationSF;

use yii\data\DataProviderInterface;
use yii\db\QueryInterface;

/**
 * Description of SearchTrait
 * 
 * Use this trait to easily add ability to display/filter by related entity attribute. 
 * It also allows to use table aliases.
 * Extension is pretty simple but makes the code cleaner, especially when using aliases 
 * (there are some auto-formatting bugs in some IDEs).
 * 
 * To use the trait you need to do the following (first example without using aliases):
 * 1. In top of your class body put:
 * 
 * ```
 * use codiverum\RelationSF\RelationSFTrait; 
 * ```
 * 
 * 2. Make new public attribute in your class:
 * 
 * ```
 * public $relation_name;
 * ```
 * 
 * 3. Add your attribute to safe attributes
 * 4. In your search function add following:
 *   - after creating $query add:
 * 
 * ```
 * $this->joinWithRelation($query, 'relation_name');
 * ```
 * 
 *   - after creating $dataProvider add:
 * 
 * ```
 * $this->addRelationSort($dataProvider, 'relation_name', 'related_table_field_name');
 * ```
 * 
 *   - after creating query filters add:
 * 
 * ```
 * $this->addRelationFilter($query, 'relation_name', 'related_table_field_name');
 * ```
 * 
 * 5. Add to GridView columns array:
 * 
 * ```
 * [
 *   'attribute' => 'relation_name',
 *   'value' => 'relation_name.related_table_field_name',
 * ],
 * 
 * That's it.
 *
 * @author Jozek
 */
trait RelationSFTrait {

    /**
     * 
     * @param DataProviderInterface $dataProvider
     * @param string $attribute
     * @param string $relationFieldName
     * @param string $tableName defaults to $attribute
     */
    public function addRelationSort(&$dataProvider, $attribute, $relationFieldName, $tableName = null) {
        $dataProvider->sort->attributes[$attribute] = [
            'asc' => [$this->getRelationSearchTableName($tableName, $attribute) . '.' . $relationFieldName => SORT_ASC],
            'desc' => [$this->getRelationSearchTableName($tableName, $attribute) . '.' . $relationFieldName => SORT_DESC],
        ];
    }

    /**
     * 
     * @param QueryInterface $query
     * @param string $attribute
     * @param string $fieldName
     * @param string $tableName defaults to nullF
     * @param string $operator defaults to 'like'
     */
    public function addRelationFilter(&$query, $attribute, $fieldName, $tableName = null, $operator = 'like') {
        $query->andFilterWhere([$operator, $this->getRelationSearchTableName($tableName, $attribute) . '.' . $fieldName, $this->{$attribute}]);
    }

    /**
     * 
     * @param string $tableName
     * @return string
     */
    protected function getRelationSearchTableName($tableName, $attribute) {
        return empty($tableName) ? $attribute : $tableName;
    }

    /**
     * 
     * @param QueryInterface $query
     * @param string $relationName
     * @param string $relationTableName defaults to null
     * @param string $relationTableAlias defaults to null
     */
    public function joinWithRelation(&$query, $relationName, $relationTableName = null, $relationTableAlias = null) {
        if (empty($relationTableAlias))
            $query->joinWith([$relationName]);
        else {
            $query->joinWith([
                $relationName => function($query) use ($relationTableAlias, $relationTableName) {
                    $query->from([$relationTableAlias => $relationTableName]);
                }
                    ]);
                }
            }

        }
        