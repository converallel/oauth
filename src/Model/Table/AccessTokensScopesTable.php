<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;

/**
 * AccessTokensScopes Model
 *
 * @property \App\Model\Table\AccessTokensTable|\Cake\ORM\Association\BelongsTo $AccessTokens
 * @property \App\Model\Table\ScopesTable|\Cake\ORM\Association\BelongsTo $Scopes
 *
 * @method \App\Model\Entity\AccessTokensScope get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccessTokensScope newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccessTokensScope[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccessTokensScope|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessTokensScope|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessTokensScope patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccessTokensScope[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccessTokensScope findOrCreate($search, callable $callback = null, $options = [])
 */
class AccessTokensScopesTable extends Table
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->setTable('access_tokens_scopes');
        $this->setDisplayField('access_token_id');
        $this->setPrimaryKey(['access_token_id', 'scope_id']);

        $this->belongsTo('AccessTokens', [
            'foreignKey' => 'access_token_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Scopes', [
            'foreignKey' => 'scope_id',
            'joinType' => 'INNER'
        ]);
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['access_token_id'], 'AccessTokens'));
        $rules->add($rules->existsIn(['scope_id'], 'Scopes'));

        return $rules;
    }
}
