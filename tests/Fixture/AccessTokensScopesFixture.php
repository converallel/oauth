<?php
namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * AccessTokensScopesFixture
 *
 */
class AccessTokensScopesFixture extends TestFixture
{

    /**
     * Fields
     *
     * @var array
     */
    // @codingStandardsIgnoreStart
    public $fields = [
        'access_token_id' => ['type' => 'string', 'length' => 100, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        'scope_id' => ['type' => 'string', 'length' => 40, 'null' => false, 'default' => null, 'collate' => 'utf8mb4_general_ci', 'comment' => '', 'precision' => null, 'fixed' => null],
        '_indexes' => [
            'scope_id' => ['type' => 'index', 'columns' => ['scope_id'], 'length' => []],
        ],
        '_constraints' => [
            'primary' => ['type' => 'primary', 'columns' => ['access_token_id', 'scope_id'], 'length' => []],
            'access_tokens_scopes_ibfk_1' => ['type' => 'foreign', 'columns' => ['access_token_id'], 'references' => ['access_tokens', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
            'access_tokens_scopes_ibfk_2' => ['type' => 'foreign', 'columns' => ['scope_id'], 'references' => ['scopes', 'id'], 'update' => 'cascade', 'delete' => 'cascade', 'length' => []],
        ],
        '_options' => [
            'engine' => 'InnoDB',
            'collation' => 'utf8mb4_general_ci'
        ],
    ];
    // @codingStandardsIgnoreEnd

    /**
     * Init method
     *
     * @return void
     */
    public function init()
    {
        $this->records = [
            [
                'access_token_id' => 'ff69cbe5-6df0-4762-992d-83bd60d87a86',
                'scope_id' => '665595e1-6d1b-493b-acc1-68b5a822c313'
            ],
        ];
        parent::init();
    }
}
