<?php


namespace App\Http\GraphQL\Webapp\Mutations;


use Exception;
use GraphQL\Type\Definition\ObjectType;
use GraphQL\Type\Definition\Type;
use Illuminate\Contracts\Auth\Guard;
use Supliu\LaravelGraphQL\Mutation;

class Auth extends Mutation
{
    /**
     * @var Guard
     */
    private $auth;

    /**
     * Auth constructor.
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        parent::__construct();
        $this->auth = $auth;
    }

    /**
     * @return array
     */
    protected function args(): array
    {
        return [
            'email' => Type::string(),
            'password' => Type::string()
        ];
    }

    protected function rules(): array
    {
        return [
            'email' => 'required|email',
            'password' => 'required|string'
        ];
    }

    /**
     * @return Type
     */
    protected function typeResult(): Type
    {
        return new ObjectType([
            'name' => 'AuthResult',
            'fields' => [
                'token' => Type::string()
            ]
        ]);
    }

    /**
     * @return mixed
     * @throws Exception
     */
    protected function resolve($root, $args, $context, $info)
    {
        $credentials = [
            'email' => $args['email'],
            'password' => $args['password']
        ];
        if ($this->auth->attempt($credentials)) return ['token' => $this->auth->issue()];

        throw new Exception('Invalid Credentials');
    }
}