<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;


class ParticipateInForumTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    function unauthenticated_users_may_not_add_replies(){
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $this->post('/threads/1/replies', []);
    }

    /**
     * @test
     */
    function an_authenticated_user_may_participate_in_forum_threads(){
        //$user = factory('App\User')->create();
        $this->be($user = factory('App\User')->create());

        $thread = factory('App\Thread')->create();

        //when user add a reply to a thread.
        $reply = factory('App\Reply')->create();

        $this->post($thread->path(). '/replies', $reply->toArray());

        // Then their reply should be visible on the page
        $this->get($thread->path())->assertSee($reply->body);
    }
}
