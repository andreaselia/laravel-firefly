<?php

namespace Firefly\Test;

trait FakeModels
{
    /**
     * @var \Firefly\Test\Fixtures\User
     */
    public $user;

    /**
     * @var \Firefly\Test\Fixtures\Group
     */
    public $group;

    /**
     * @var \Firefly\Test\Fixtures\Discussion
     */
    public $discussion;

    /**
     * @var \Firefly\Test\Fixtures\Post
     */
    public $post;

    /**
     * Retrieve the test user.
     *
     * @return \Firefly\Test\Fixtures\User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Retrieve the test group.
     *
     * @return \Firefly\Test\Fixtures\Group
     */
    public function getGroup()
    {
        return $this->group;
    }

    /**
     * Retrieve the test $this->discussion.
     *
     * @return \Firefly\Test\Fixtures\Discussion
     */
    public function getDiscussion()
    {
        return $this->discussion;
    }

    /**
     * Retrieve the test post.
     *
     * @return \Firefly\Test\Fixtures\Post
     */
    public function getPost()
    {
        return $this->post;
    }
}