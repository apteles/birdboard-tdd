<?php

namespace Tests\Feature;

use Tests\TestCase;
use Tests\Setup\ProjectFactory;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTasksTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_project_can_have_tasks()
    {
        $project = app(ProjectFactory::class)
                        ->ownedBy($this->signIn())
                                ->create();

        $attribute = factory('App\Task')->raw();

        $this->post($project->path() . '/tasks', $attribute);

        $this->get($project->path())->assertSee($attribute['body']);
    }

    public function test_only_the_owner_of_a_project_may_add_tasks()
    {
        $this->signIn();
        $project = factory('App\Project')->create();

        $this->post($project->path() . '/tasks', ['body' => 'test task'])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', ['body' => 'test task']);
    }

    public function test_only_the_owner_of_a_project_may_update_a_task()
    {
        $this->signIn();

        $project = app(ProjectFactory::class)
                            ->withTasks(1)
                                ->create();
        $this->patch($project->tasks[0]->path(), ['body' => 'test task (updated)'])->assertStatus(403);

        $this->assertDatabaseHas('tasks', ['body' => $project->tasks->first()->body]);
    }

    public function test_a_task_can_be_updated()
    {
        $project = app(ProjectFactory::class)
                        ->ownedBy($this->signIn())
                            ->withTasks(1)
                                ->create();

        $this->patch($project->tasks->first()->path(), [
            'body' => 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks', ['body' => 'changed', 'completed' => true]);
    }

    public function test_a_project_requires_a_body()
    {
        $project = app(ProjectFactory::class)
                        ->ownedBy($this->signIn())
                                ->create();

        $attribute = factory('App\Task')->raw(['body' => '']);

        $this->post($project->path() . '/tasks', $attribute)->assertSessionHasErrors('body');
    }
}
