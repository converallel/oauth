<?php
namespace App\Test\TestCase\Model\Table;

use App\Model\Table\AccessTokensTable;
use Cake\ORM\TableRegistry;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\AccessTokensTable Test Case
 */
class AccessTokensTableTest extends TestCase
{

    /**
     * Test subject
     *
     * @var \App\Model\Table\AccessTokensTable
     */
    public $AccessTokens;

    /**
     * Fixtures
     *
     * @var array
     */
    public $fixtures = [
        'app.AccessTokens',
        'app.Users',
        'app.Clients',
        'app.RefreshTokens',
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
        $config = TableRegistry::getTableLocator()->exists('AccessTokens') ? [] : ['className' => AccessTokensTable::class];
        $this->AccessTokens = TableRegistry::getTableLocator()->get('AccessTokens', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    public function tearDown()
    {
        unset($this->AccessTokens);

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
     * Test validationDefault method
     *
     * @return void
     */
    public function testValidationDefault()
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
