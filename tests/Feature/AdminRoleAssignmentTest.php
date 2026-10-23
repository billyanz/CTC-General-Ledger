<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminRoleAssignmentTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        foreach (['admin', 'akuntan', 'staff'] as $role) {
            Role::create(['name' => $role, 'guard_name' => 'web']);
        }
    }

    public function test_admin_cannot_create_another_admin_account(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');

        $this->actingAs($admin)
            ->post(route('admin.users.store'), [
                'name' => 'Second Admin',
                'email' => 'second-admin@example.test',
                'password' => 'password',
                'role' => 'admin',
                'base_salary' => 0,
            ])
            ->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', ['email' => 'second-admin@example.test']);
    }

    public function test_admin_cannot_promote_another_user_to_admin(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $user = User::factory()->create();
        $user->assignRole('staff');

        $this->actingAs($admin)
            ->put(route('admin.users.update', $user), [
                'name' => $user->name,
                'email' => $user->email,
                'role' => 'admin',
                'base_salary' => 0,
                'is_active' => 1,
            ])
            ->assertSessionHasErrors('role');

        $this->assertFalse($user->fresh()->hasRole('admin'));
    }

    public function test_existing_admin_can_keep_the_admin_role_when_updated(): void
    {
        $admin = User::factory()->create();
        $admin->assignRole('admin');
        $this->actingAs($admin)
            ->put(route('admin.users.update', $admin), [
                'name' => $admin->name,
                'email' => $admin->email,
                'role' => 'admin',
                'base_salary' => 0,
                'is_active' => 1,
            ])
            ->assertRedirect(route('admin.users.index'));

        $this->assertTrue($admin->fresh()->hasRole('admin'));
    }

    public function test_public_registration_cannot_assign_admin_role(): void
    {
        $this->post(route('register.post'), [
            'name' => 'Unprivileged User',
            'email' => 'unprivileged@example.test',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'admin',
            'base_salary' => 0,
        ])->assertSessionHasErrors('role');

        $this->assertDatabaseMissing('users', ['email' => 'unprivileged@example.test']);
    }
}
