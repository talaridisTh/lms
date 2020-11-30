<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;
use App\Role;

class DataTablesTest extends TestCase
{
	use RefreshDatabase;

	protected function setUp(): void {

		parent::setUp();

		$this->app->make(\Spatie\Permission\PermissionRegistrar::class)->registerPermissions();

		$admin = new Role;
		$admin->name = "admin";
		$admin->guard_name = "web";
		$admin->save();
		
	}

	/** @test */
	public function mails_main_datatable() {
		$this->withoutExceptionHandling();

		$this->actingAs(User::factory()->create()->assignRole("admin"));

        $response = $this->post('/email/data-table');

        $response->assertStatus(200);
    }

    /** @test */
    public function mail_users_selection_datatable() {
		$this->withoutExceptionHandling();

		$this->actingAs(User::factory()->create()->assignRole("admin"));

        $response = $this->post('/email/select-users');

        $response->assertStatus(200);
	}
	
	/** @test */
	public function mail_recipients_datatable() {
		$this->withoutExceptionHandling();

		$this->actingAs(User::factory()->create()->assignRole("admin"));

        $response = $this->post('/email/recipients-data-table');

        $response->assertStatus(200);
    }
}
