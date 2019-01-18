<?php
namespace App\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use League\OAuth2\Server\Entities\AccessTokenEntityInterface;
use League\OAuth2\Server\Entities\ClientEntityInterface;
use League\OAuth2\Server\Entities\ScopeEntityInterface;
use League\OAuth2\Server\Exception\UniqueTokenIdentifierConstraintViolationException;
use League\OAuth2\Server\Repositories\AccessTokenRepositoryInterface;

/**
 * AccessTokens Model
 *
 * @property \App\Model\Table\UsersTable|\Cake\ORM\Association\BelongsTo $Users
 * @property \App\Model\Table\ClientsTable|\Cake\ORM\Association\BelongsTo $Clients
 * @property \App\Model\Table\RefreshTokensTable|\Cake\ORM\Association\HasMany $RefreshTokens
 * @property \App\Model\Table\ScopesTable|\Cake\ORM\Association\BelongsToMany $Scopes
 *
 * @method \App\Model\Entity\AccessToken get($primaryKey, $options = [])
 * @method \App\Model\Entity\AccessToken newEntity($data = null, array $options = [])
 * @method \App\Model\Entity\AccessToken[] newEntities(array $data, array $options = [])
 * @method \App\Model\Entity\AccessToken|bool save(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessToken|bool saveOrFail(\Cake\Datasource\EntityInterface $entity, $options = [])
 * @method \App\Model\Entity\AccessToken patchEntity(\Cake\Datasource\EntityInterface $entity, array $data, array $options = [])
 * @method \App\Model\Entity\AccessToken[] patchEntities($entities, array $data, array $options = [])
 * @method \App\Model\Entity\AccessToken findOrCreate($search, callable $callback = null, $options = [])
 */
class AccessTokensTable extends Table implements AccessTokenRepositoryInterface
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

        $this->setTable('access_tokens');
        $this->setDisplayField('name');
        $this->setPrimaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id',
            'joinType' => 'INNER'
        ]);
        $this->belongsTo('Clients', [
            'foreignKey' => 'client_id',
            'joinType' => 'INNER'
        ]);
        $this->hasMany('RefreshTokens', [
            'foreignKey' => 'access_token_id'
        ]);
        $this->belongsToMany('Scopes', [
            'foreignKey' => 'access_token_id',
            'targetForeignKey' => 'scope_id',
            'joinTable' => 'access_tokens_scopes'
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
            ->scalar('id')
            ->maxLength('id', 100)
            ->allowEmptyString('id', 'create');

        $validator
            ->scalar('name')
            ->maxLength('name', 255)
            ->allowEmptyString('name');

        $validator
            ->boolean('revoked')
            ->requirePresence('revoked', 'create')
            ->allowEmptyString('revoked', false);

        $validator
            ->dateTime('created_at')
            ->requirePresence('created_at', 'create')
            ->allowEmptyDateTime('created_at', false);

        $validator
            ->dateTime('modified_at')
            ->requirePresence('modified_at', 'create')
            ->allowEmptyDateTime('modified_at', false);

        $validator
            ->dateTime('expires_at')
            ->allowEmptyDateTime('expires_at');

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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        $rules->add($rules->existsIn(['client_id'], 'Clients'));

        return $rules;
    }

    /**
     * Create a new access token
     *
     * @param ClientEntityInterface $clientEntity
     * @param ScopeEntityInterface[] $scopes
     * @param mixed $userIdentifier
     *
     * @return AccessTokenEntityInterface
     */
    public function getNewToken(ClientEntityInterface $clientEntity, array $scopes, $userIdentifier = null)
    {
        $accessToken = $this->newEntity([
            'user_id' => $userIdentifier,
            'client_id' => $clientEntity->getIdentifier(),
            'scope' => array_map(function (ScopeEntityInterface $scope) {
                return $scope->getIdentifier();
            }, $scopes),
        ]);

        return $accessToken;
    }

    /**
     * Persists a new access token to permanent storage.
     *
     * @param AccessTokenEntityInterface $accessTokenEntity
     *
     * @throws UniqueTokenIdentifierConstraintViolationException
     */
    public function persistNewAccessToken(AccessTokenEntityInterface $accessTokenEntity)
    {
        $accessTokenId = $accessTokenEntity->getIdentifier();
        if ($this->exists(['id' => $accessTokenId])) {
            throw new UniqueTokenIdentifierConstraintViolationException('');
        }
        $accessToken = $this->newEntity();
        $data = [
            'id' => $accessTokenEntity->getIdentifier(),
            'user_id' => $accessTokenEntity->getUserIdentifier(),
            'client_id' => $accessTokenEntity->getClient()->getIdentifier(),
            'scope' => array_map(function (ScopeEntityInterface $scope) {
                return $scope->getIdentifier();
            }, $accessTokenEntity->getScopes()),
            'expires_at' => $accessTokenEntity->getExpiryDateTime()->format('Y-m-d H:i:s')
        ];
        $accessToken = $this->patchEntity($accessToken, $data);
        $this->save($accessToken);
    }

    /**
     * Revoke an access token.
     *
     * @param string $tokenId
     */
    public function revokeAccessToken($tokenId)
    {
        $accessToken = $this->get($tokenId);
        $accessToken->revoked = true;
        $this->save($accessToken);
    }

    /**
     * Check if the access token has been revoked.
     *
     * @param string $tokenId
     *
     * @return bool Return true if this token has been revoked
     */
    public function isAccessTokenRevoked($tokenId)
    {
        return $this->get($tokenId, ['fields' => 'revoked'])->revoked;
    }
}
