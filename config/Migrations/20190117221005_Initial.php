<?php

use Migrations\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Initial extends AbstractMigration
{

    public $autoId = false;

    public function up()
    {

        $this->table('access_tokens')
            ->addColumn('id', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('client_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => true,
            ])
            ->addColumn('revoked', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
                'signed' => false
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('expires_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'client_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('access_tokens_scopes')
            ->addColumn('access_token_id', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('scope_id', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addPrimaryKey(['access_token_id', 'scope_id'])
            ->addIndex(
                [
                    'scope_id',
                ]
            )
            ->create();

        $this->table('authorization_codes')
            ->addColumn('id', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('client_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('redirect_uri', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('id_token', 'text', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('revoked', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
                'signed' => false
            ])
            ->addColumn('expires_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'client_id',
                ]
            )
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('authorization_codes_scopes')
            ->addColumn('authorization_code_id', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('scope_id', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addPrimaryKey(['authorization_code_id', 'scope_id'])
            ->addIndex(
                [
                    'scope_id',
                ]
            )
            ->create();

        $this->table('contacts')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('type', 'enum', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'values' => ['Email', 'Phone']
            ])
            ->addColumn('contact', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addIndex(
                [
                    'contact',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('clients')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('user_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
            ])
            ->addColumn('secret', 'string', [
                'default' => null,
                'limit' => 80,
                'null' => false,
            ])
            ->addColumn('redirect_uri', 'text', [
                'default' => null,
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('grant_type', 'set', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'values' => ['authorization_code', 'client_credentials', 'implicit', 'password', 'refresh_token']
            ])
            ->addColumn('revoked', 'boolean', [
                'default' => null,
                'limit' => null,
                'null' => false,
                'signed' => false
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->addIndex(
                [
                    'user_id',
                ]
            )
            ->create();

        $this->table('clients_scopes')
            ->addColumn('client_id', 'integer', [
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('scope_id', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addPrimaryKey(['client_id', 'scope_id'])
            ->addIndex(
                [
                    'scope_id',
                ]
            )
            ->create();

        $this->table('refresh_tokens')
            ->addColumn('id', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('access_token_id', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->addColumn('revoked', 'boolean', [
                'default' => false,
                'limit' => null,
                'null' => false,
                'signed' => false
            ])
            ->addColumn('expires_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'access_token_id',
                ]
            )
            ->create();

        $this->table('scopes')
            ->addColumn('id', 'string', [
                'default' => null,
                'limit' => 40,
                'null' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('description', 'string', [
                'default' => null,
                'limit' => 100,
                'null' => false,
            ])
            ->create();

        $this->table('users')
            ->addColumn('id', 'integer', [
                'autoIncrement' => true,
                'default' => null,
                'limit' => 11,
                'null' => false,
                'signed' => false,
            ])
            ->addPrimaryKey(['id'])
            ->addColumn('email', 'string', [
                'default' => null,
                'limit' => 60,
                'null' => true,
            ])
            ->addColumn('phone_number', 'string', [
                'default' => null,
                'limit' => 20,
                'null' => true,
            ])
            ->addColumn('email_verified_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('phone_number_verified_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addColumn('failed_login_attempts', 'integer', [
                'default' => 0,
                'limit' => MysqlAdapter::INT_TINY,
                'null' => false,
                'signed' => false,
            ])
            ->addColumn('password', 'char', [
                'default' => null,
                'limit' => 60,
                'null' => false,
            ])
            ->addColumn('created_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
            ])
            ->addColumn('modified_at', 'timestamp', [
                'default' => 'CURRENT_TIMESTAMP',
                'limit' => null,
                'null' => false,
                'update' => 'CURRENT_TIMESTAMP'
            ])
            ->addColumn('deleted_at', 'timestamp', [
                'default' => null,
                'limit' => null,
                'null' => true,
            ])
            ->addIndex(
                [
                    'email',
                ],
                ['unique' => true]
            )
            ->addIndex(
                [
                    'phone_number',
                ],
                ['unique' => true]
            )
            ->create();

        $this->table('access_tokens')
            ->addForeignKey(
                'client_id',
                'clients',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('access_tokens_scopes')
            ->addForeignKey(
                'access_token_id',
                'access_tokens',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'scope_id',
                'scopes',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('authorization_codes')
            ->addForeignKey(
                'client_id',
                'clients',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('authorization_codes_scopes')
            ->addForeignKey(
                'authorization_code_id',
                'authorization_codes',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'scope_id',
                'scopes',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('contacts')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('clients')
            ->addForeignKey(
                'user_id',
                'users',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();

        $this->table('clients_scopes')
            ->addForeignKey(
                'client_id',
                'clients',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->addForeignKey(
                'scope_id',
                'scopes',
                'id',
                [
                    'update' => 'CASCADE',
                    'delete' => 'CASCADE'
                ]
            )
            ->update();
    }

    public function down()
    {
        $this->table('access_tokens')
            ->dropForeignKey(
                'client_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('access_tokens_scopes')
            ->dropForeignKey(
                'access_token_id'
            )
            ->dropForeignKey(
                'scope_id'
            )->save();

        $this->table('authorization_codes')
            ->dropForeignKey(
                'client_id'
            )
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('authorization_codes_scopes')
            ->dropForeignKey(
                'authorization_code_id'
            )
            ->dropForeignKey(
                'scope_id'
            )->save();

        $this->table('contacts')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('clients')
            ->dropForeignKey(
                'user_id'
            )->save();

        $this->table('clients_scopes')
            ->dropForeignKey(
                'client_id'
            )
            ->dropForeignKey(
                'scope_id'
            )->save();

        $this->table('access_tokens')->drop()->save();
        $this->table('access_tokens_scopes')->drop()->save();
        $this->table('authorization_codes')->drop()->save();
        $this->table('authorization_codes_scopes')->drop()->save();
        $this->table('contacts')->drop()->save();
        $this->table('clients')->drop()->save();
        $this->table('clients_scopes')->drop()->save();
        $this->table('refresh_tokens')->drop()->save();
        $this->table('scopes')->drop()->save();
        $this->table('users')->drop()->save();
    }
}
