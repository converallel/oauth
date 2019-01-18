<?php

namespace App\Model\Table;

use Cake\Auth\DefaultPasswordHasher;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\UserEntityInterface;
use League\OAuth2\Server\Repositories\UserRepositoryInterface;

/**
 * Users Model
 *
 * @property \App\Model\Table\AccessTokensTable|\Cake\ORM\Association\HasMany $AccessTokens
 * @property \App\Model\Table\AuthorizationCodesTable|\Cake\ORM\Association\HasMany $AuthorizationCodes
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\HasMany $Clients
 * @property \App\Model\Table\ContactsTable|\Cake\ORM\Association\HasMany $Contacts
 *
 * @method \App\Model\Entity\User get($primaryKey, $options = [])
 * @method \App\Model\Entity\User newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\User[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\User|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\User patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\User[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\User findOrCreate($search, callable $callback = null, $options = [])
 */
class UsersTable extends Table implements UserRepositoryInterface
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

        $this->setTable('users');
        $this->setDisplayField('id');
        $this->setPrimaryKey('id');

        $this->hasMany('AccessTokens', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('AuthorizationCodes', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Clients', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Contacts', [
            'foreignKey' => 'user_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->nonNegativeInteger('id')
            ->allowEmptyString('id', 'create');

        $validator
            ->email('email')
            ->allowEmptyString('email')
            ->add('email', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->scalar('phone_number')
            ->maxLength('phone_number', 20)
            ->allowEmptyString('phone_number')
            ->add('phone_number', 'unique', ['rule' => 'validateUnique', 'provider' => 'table']);

        $validator
            ->dateTime('email_verified_at')
            ->allowEmptyDateTime('email_verified_at');

        $validator
            ->dateTime('phone_number_verified_at')
            ->allowEmptyDateTime('phone_number_verified_at');

        $validator
            ->requirePresence('failed_login_attempts', 'create')
            ->allowEmptyString('failed_login_attempts', false);

        $validator
            ->scalar('password')
            ->maxLength('password', 60)
            ->requirePresence('password', 'create')
            ->allowEmptyString('password', false);

        return $validator;
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
        $rules->add($rules->isUnique(['email']));
        $rules->add($rules->isUnique(['phone_number']));

        return $rules;
    }


    /**
     * Get a user entity.
     *
     * @param string $username
     * @param string $password
     * @param string $grantType The grant type used
     * @param ClientEntityInterface $clientEntity
     *
     * @return UserEntityInterface
     */
    public function getUserEntityByUserCredentials(
        $username,
        $password,
        $grantType,
        ClientEntityInterface $clientEntity
    ) {
        $user = $this->find()
            ->contain(['Contacts', 'Clients'])
            ->where([
                'OR' => [
                    'email' => $username,
                    'phone_number' => $username,
                    'Contacts.contact' => $username
                ],
                'password' => (new DefaultPasswordHasher())->hash($password)
            ])->first();

        return $user;
    }
}
