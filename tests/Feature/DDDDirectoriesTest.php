<?php

namespace Tests\Feature;

use Tests\TestCase;

class DDDDirectoriesTest extends TestCase
{
    /** @test */
    public function config_has_repository_generator_file()
    {
    	$this->assertEquals(config('repository.generator.paths'), array(
    		'models'       => 'Domain/Models',
            'repositories' => 'Infrastructure/EloquentRepositories',
            'interfaces'   => 'Domain/Contracts',
            'transformers' => 'Http/Transformers',
            'presenters'   => 'Http/Presenters',
            'validators'   => 'Domain/Validators',
            'controllers'  => 'Http/Controllers',
            'provider'     => 'RepositoryServiceProvider',
            'criteria'     => 'Domain/Criteria'
    	));
    }

	/** @test */
    public function app_has_domain_directory()
    {
		$this->assertTrue(is_dir(app_path('Domain/Jobs')));
		$this->assertTrue(is_dir(app_path('Domain/Models')));
        $this->assertTrue(is_dir(app_path('Domain/Traits')));
        $this->assertTrue(is_dir(app_path('Domain/Criteria')));
        // $this->assertTrue(is_dir(app_path('Domain/Services')));
		$this->assertTrue(is_dir(app_path('Domain/Listeners')));
        $this->assertTrue(is_dir(app_path('Domain/Contracts')));
        $this->assertTrue(is_dir(app_path('Domain/Validators')));
    }

    /** @test */
    // public function app_has_application_directory()
    // {
    //     $this->assertTrue(is_dir(app_path('Application/Requests')));
    //     $this->assertTrue(is_dir(app_path('Application/Providers')));
    //     $this->assertTrue(is_dir(app_path('Application/Exceptions')));
    //     $this->assertTrue(is_dir(app_path('Application/Middlewares')));

    // }

    /** @test */
    public function app_has_infrastructure_directory()
    {
      	// $this->assertTrue(is_dir(app_path('Infrastructure/Jobs')));
        $this->assertTrue(is_dir(app_path('Infrastructure/Auth')));
        // $this->assertTrue(is_dir(app_path('Infrastructure/Listeners')));
        $this->assertTrue(is_dir(app_path('Infrastructure/EloquentRepositories')));
    }

    // /** @test */
    // public function app_has_ui_directory()
    // {
    //     $this->assertTrue(is_dir(app_path('Interfaces/Web')));
    //     $this->assertTrue(is_dir(app_path('Interfaces/API')));
    //     $this->assertTrue(is_dir(app_path('Interfaces/Console')));
    // }

}
