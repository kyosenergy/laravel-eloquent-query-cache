<?php

namespace Rennokki\QueryCache\Test;

use Livewire\Component;
use Livewire\Features\SupportTesting\Testable;
use Livewire\Livewire;
use Rennokki\QueryCache\Test\Models\Post;

class LivewireTest extends TestCase
{
    /**
     * @dataProvider strictModeContextProvider
     */
    public function test_livewire_component_poll_doesnt_break_when_callback_is_already_set()
    {
        // See: https://github.com/renoki-co/laravel-eloquent-query-cache/issues/163
        Livewire::component('post', PostComponent::class);

        $posts = factory(Post::class, 30)->create();

        /** @var Testable $component */
        Livewire::test(PostComponent::class, ['post' => $posts->first()])
            ->assertOk()
            ->refresh()
            ->assertSee($posts[0]->name);
    }
}

class PostComponent extends Component
{
    public Post $post;

    public function getName(): string
    {
        return 'post';
    }
}
