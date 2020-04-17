<?php

namespace Tests\Feature;

use App\User;
use Tests\TestCase;

class AuthTest extends TestCase
{

    public function RegisterUser(){
        //User's data
        $data = [
            'email' => 'test@gmail.com',
        ];
        //Send post request
        $response = $this->json('POST',route('api.register'),$data);
        //Assert it was successful
        $response->assertStatus(200);
        return json_decode($response->getContent())->success;
    }

    public function testActiveUsersOk(){
        $response = $this->json('GET',route('api.actives',['actives'=>1,'country'=>'Austria']));
        $this->assertObjectHasAttribute( 'success',json_decode($response->getContent()));
    }
    public function testActiveUsersFail(){
        $response = $this->json('GET',route('api.actives',['active'=>1,'country'=>'China']));
        $this->assertObjectHasAttribute( 'error',json_decode($response->getContent()));
    }

    public function testUpdateUsersOk(){
        $response = $this->json('GET',route('api.update',['id'=>1,'first_name'=>'Rodrigo']));
        $this->assertObjectHasAttribute( 'success',json_decode($response->getContent()));
    }
    public function testUpdateUsersFail(){
        $response = $this->json('GET',route('api.update',['active'=>1,'first_name'=>'Rodrigo']));
        $this->assertObjectHasAttribute( 'error',json_decode($response->getContent()));
    }

    public function testDeleteUsersOk(){
        $user = $this->RegisterUser();
        $response = $this->json('GET',route('api.destroy',['id'=>$user]));
        $this->assertObjectHasAttribute( 'success',json_decode($response->getContent()));
    }

    public function testDeleteUsersFail(){
        $response = $this->json('GET',route('api.destroy',['id'=>1]));
        $this->assertObjectHasAttribute( 'error',json_decode($response->getContent()));
    }





}
