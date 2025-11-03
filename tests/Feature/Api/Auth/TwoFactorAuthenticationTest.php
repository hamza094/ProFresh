<?php

declare(strict_types=1);

namespace Tests\Feature\Api\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Laravel\Sanctum\Sanctum;
use Mockery;
use Tests\TestCase;

/**
 * Two-Factor Authentication Feature Tests
 *
 * Tests the complete 2FA flow including setup, confirmation, login, and management.
 */
class TwoFactorAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected string $testPassword = 'Testpassword@3';

    protected string $testEmail = '2fauser@example.com';

    private const TWO_FA_SESSION = '2fa_login';

    protected function setUp(): void
    {
        parent::setUp();
        $this->createTestUser();
    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }

    // =========================================================================
    // STATUS & SETUP TESTS
    // =========================================================================

    /** @test */
    public function it_returns_2fa_status_disabled_by_default()
    {
        Sanctum::actingAs($this->user);

        $response = $this->getJson('/api/v1/twofactor/fetch-user');

        $response->assertOk()
            ->assertJson(['status' => 'disabled']);
    }

    /** @test */
    public function it_can_prepare_two_factor()
    {
        Sanctum::actingAs($this->user);

        // Assert no 2FA before setup
        $this->assertDatabaseMissing('two_factor_authentications', [
            'authenticatable_id' => $this->user->id,
            'authenticatable_type' => $this->user::class,
        ]);

        $response = $this->postJson('/api/v1/twofactor/setup', [
            'password' => $this->testPassword,
        ]);

        $response->assertOk()
            ->assertJson(['status' => 'in_progress'])
            ->assertJsonStructure(['qr_code', 'uri', 'string', 'status']);

        // Assert 2FA was created in database
        $this->assertDatabaseHas('two_factor_authentications', [
            'authenticatable_id' => $this->user->id,
            'authenticatable_type' => $this->user::class,
        ]);
    }

    /** @test */
    public function it_can_confirm_two_factor()
    {
        $mockedUser = $this->createMockedUser([
            'confirmTwoFactorAuth' => ['123456', true],
            'hasTwoFactorEnabled' => false,
            'getRecoveryCodes' => collect(['abc123', 'xyz789']),
        ]);

        Sanctum::actingAs($mockedUser);

        $response = $this->postJson('/api/v1/twofactor/confirm', [
            'code' => '123456',
        ]);

        $response->assertOk()
            ->assertJson([
                'status' => 'enabled',
                'message' => 'success',
                'recoveryCodes' => ['abc123', 'xyz789'],
            ]);
    }

    /** @test */
    public function it_can_show_and_regenerate_recovery_codes()
    {
        $mockedUser = $this->createMockedUser([
            'hasTwoFactorEnabled' => true,
            'generateRecoveryCodes' => collect(['abc123', 'xyz789']),
        ]);

        Sanctum::actingAs($mockedUser);

        $response = $this->getJson('/api/v1/twofactor/recovery-codes');

        $response->assertOk()
            ->assertJson([
                'message' => 'success',
                'recoveryCodes' => ['abc123', 'xyz789'],
            ]);
    }

    /** @test */
    public function it_can_disable_two_factor()
    {
        Sanctum::actingAs($this->user);

        // First setup 2FA
        $this->postJson('/api/v1/twofactor/setup', [
            'password' => $this->testPassword,
        ]);

        // Then disable it
        $response = $this->deleteJson('/api/v1/twofactor/disable');

        $response->assertOk()
            ->assertJson(['status' => 'disabled']);
    }

    /** @test */
    public function it_shows_2fa_required_message_during_login_when_enabled()
    {
        $this->enableTwoFactorForUser();

        $response = $this->postJson('/api/v1/login', [
            'email' => $this->user->email,
            'password' => $this->testPassword,
        ]);

        $response->assertOk()
            ->assertJson([
                'message' => 'Two-factor authentication is enabled. Please provide the verification code.',
                'status' => '2fa_required',
            ]);

        // Assert session exists and is encrypted

    $this->assertTrue(session()->has(self::TWO_FA_SESSION));

        // Verify encrypted session contents
    $encryptedSession = session(self::TWO_FA_SESSION);
        $this->assertIsString($encryptedSession);

        $decryptedSession = decrypt($encryptedSession);
        $this->assertEquals($this->user->email, $decryptedSession['email']);
        $this->assertEquals($this->testPassword, $decryptedSession['password']);
        $this->assertNotNull($decryptedSession['expires_at']);
    }

    /** @test */
    public function it_fails_two_factor_login_with_missing_session()
    {
        $response = $this->postJson('/api/v1/twofactor/login-confirm', [
            'code' => '123456',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['code']);

        $this->assertStringContainsString(
            'Session expired or invalid',
            $response->json('errors.code.0')
        );
    }

    /** @test */
    public function it_fails_two_factor_login_with_expired_session()
    {
        // Setup encrypted session data with expired timestamp
        session()->put(self::TWO_FA_SESSION, encrypt([
            'email' => $this->user->email,
            'password' => $this->testPassword,
            'expires_at' => now()->subMinutes(1), // Expired 1 minute ago
        ]));

        $response = $this->postJson('/api/v1/twofactor/login-confirm', [
            'code' => '123456',
        ]);

        $response->assertUnprocessable()
            ->assertJsonValidationErrors(['code']);

        $this->assertStringContainsString(
            'Session expired or invalid',
            $response->json('errors.code.0')
        );
    }

    // =========================================================================
    // SETUP & HELPER METHODS
    // =========================================================================

    /**
     * Create a test user with known credentials
     */
    private function createTestUser(): void
    {
        $this->user = User::factory()->create([
            'email' => $this->testEmail,
            'password' => Hash::make($this->testPassword),
        ]);
    }

    /**
     * Enable 2FA for the test user
     */
    private function enableTwoFactorForUser(): void
    {
        DB::table('two_factor_authentications')->insert([
            'authenticatable_type' => User::class,
            'authenticatable_id' => $this->user->id,
            'shared_secret' => encrypt('JBSWY3DPEHPK3PXP'),
            'recovery_codes' => encrypt(json_encode(['RCODE-1234-5678'])),
            'enabled_at' => now(),
            'label' => "ProFresh:{$this->user->email}",
        ]);
    }

    /**
     * Create a mocked user with specific 2FA behavior
     */
    private function createMockedUser(array $expectations = []): User
    {
        $mockedUser = Mockery::mock(User::class)->makePartial();

        // Set default expectations
        $defaultExpectations = [
            'confirmTwoFactorAuth' => ['123456', true],
            'hasTwoFactorEnabled' => [false],
            'getRecoveryCodes' => [collect(['abc123', 'xyz789'])],
        ];

        // Merge with provided expectations
        $expectations = array_merge($defaultExpectations, $expectations);

        foreach ($expectations as $method => $params) {
            if (is_array($params)) {
                $mockedUser->shouldReceive($method)
                    ->with(...array_slice($params, 0, -1))
                    ->andReturn(end($params));
            } else {
                $mockedUser->shouldReceive($method)->andReturn($params);
            }
        }

        // Set up basic user properties
        $mockedUser->id = $this->user->id;
        $mockedUser->email = $this->user->email;
        $mockedUser->password = $this->user->password;

        return $mockedUser;
    }
}
