<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccessTokensScopesTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccessTokensScopesTable Test Case
 */
class AccessTokensScopesTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccessTokensScopesTable
     */
    public $AccessTokensScopes;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AccessTokensScopes',
        'app.AccessTokens',
        'app.Scopes'
    ];

    /**
     * setUp method
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $config = TableRegistry::getTableLocator()->exists('AccessTokensScopes') ? [] : ['className' => AccessTokensScopesTable::class];
        $this->AccessTokensScopes = TableRegistry::getTableLocator()->get('AccessTokensScopes', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccessTokensScopes);

        parent::tearDown();
    }

    /**
     * Test initialize method
     *
     * @return void
     */
    public function testInitialize()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     */
    public function testBuildRules()
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
