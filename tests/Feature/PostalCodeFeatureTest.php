<?php

namespace Tests\Feature;

use AllowDynamicProperties;
use App\Enumerators\Exceptions;
use App\Facades\Helpers;
use App\Models\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

/**
 * @property $userToken
 */
#[AllowDynamicProperties] class PostalCodeFeatureTest extends TestCase
{
    use DatabaseMigrations;

    protected function setUp(): void
    {
        parent::setUp();

        $this->userToken = Helpers::generateToken(User::factory()->create([
            'name' => 'John Doe',
            'email' => 'test@example.com',
            'password' => 'password',
        ]));

        $_SERVER['HTTP_AUTHORIZATION'] = 'Bearer ' . $this->userToken;

        Http::fake([
            'viacep.com.br/ws/SP/Barueri/*' => Http::response(self::viaCepApiMock('index'), Response::HTTP_OK),
            'viacep.com.br/ws/00000000/*' => Http::response(self::viaCepApiMock('show'), Response::HTTP_OK),
        ]);
    }

    public function test_should_return_postal_codes_list(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken,
        ])->get('api/list')
            ->assertJson(self::viaCepApiMock('index'))
            ->assertOk();
    }

    public function test_should_return_postal_codes_show(): void
    {
        $this->withHeaders([
            'Authorization' => 'Bearer ' . $this->userToken,
        ])->get('api/list/00000000')
            ->assertJson([self::viaCepApiMock('show')])
            ->assertOk();
    }

    /** @dataProvider uris */
    public function test_should_return_not_found_when_no_postal_codes_show($uri): void
    {
        unset($_SERVER['HTTP_AUTHORIZATION']);

        $this->get($uri)
            ->assertJson([
                'message' => __('exceptions.' . Exceptions::NOT_FOUND->value),
            ])->assertStatus(Response::HTTP_NOT_FOUND);
    }

    public static function uris(): array
    {
        return [
            [
                'api/list/00000000',
            ],
            [
                'api/list',
            ],
        ];
    }

    private static function viaCepApiMock(string $uri): array
    {
        return[
            'show' => [
                [
                    'cep' => '00000-000',
                    'logradouro' => 'Avenida Alphaville',
                    'complemento' => 'até 99999 - lado ímpar',
                    'unidade' => '',
                    'bairro' => 'Sítio Tamboré Alphaville',
                    'localidade' => 'Barueri',
                    'uf' => 'SP',
                    'ibge' => '3505708',
                    'gia' => '2069',
                    'ddd' => '11',
                    'siafi' => '6213',
                ],
            ],
            'index' => [
                [
                    'cep' => '06454-005',
                    'logradouro' => 'Praça Alphaville',
                    'complemento' => '',
                    'unidade' => '',
                    'bairro' => 'Alphaville Centro Industrial e Empresarial/Alphaville.',
                    'localidade' => 'Barueri',
                    'uf' => 'SP',
                    'ibge' => '3505708',
                    'gia' => '2069',
                    'ddd' => '11',
                    'siafi' => '6213',
                ],
                [
                    'cep' => '06472-900',
                    'logradouro' => 'Avenida Alphaville',
                    'complemento' => '779',
                    'unidade' => 'Bradesco Seguros Alpha Building',
                    'bairro' => 'Dezoito do Forte Empresarial/Alphaville.',
                    'localidade' => 'Barueri',
                    'uf' => 'SP',
                    'ibge' => '3505708',
                    'gia' => '2069',
                    'ddd' => '11',
                    'siafi' => '6213',
                ],
                [
                    'cep' => '06472-010',
                    'logradouro' => 'Avenida Alphaville',
                    'complemento' => 'até 99998 - lado par',
                    'unidade' => '',
                    'bairro' => 'Dezoito do Forte Empresarial/Alphaville.',
                    'localidade' => 'Barueri',
                    'uf' => 'SP',
                    'ibge' => '3505708',
                    'gia' => '2069',
                    'ddd' => '11',
                    'siafi' => '6213',
                ],
                [
                    'cep' => '06472-020',
                    'logradouro' => 'Avenida Alphaville',
                    'complemento' => 'até 99999 - lado ímpar',
                    'unidade' => '',
                    'bairro' => 'Sítio Tamboré Alphaville',
                    'localidade' => 'Barueri',
                    'uf' => 'SP',
                    'ibge' => '3505708',
                    'gia' => '2069',
                    'ddd' => '11',
                    'siafi' => '6213',
                ],
            ],
        ][$uri] ?? [];
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        unset($_SERVER['HTTP_AUTHORIZATION']);
    }
}
