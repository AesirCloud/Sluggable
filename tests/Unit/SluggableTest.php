<?php

namespace AesirCloud\Sluggable\Tests\Unit;

use AesirCloud\Sluggable\Tests\TestCase;
use AesirCloud\Sluggable\Tests\Models\Post;

uses(TestCase::class);

it('generates a slug on create', function () {
    $post = Post::create(['title' => 'Hello World']);

    $this->assertEquals('hello-world', $post->slug);
});

it('generates a unique slug if name already exists', function () {
    $post1 = Post::create(['title' => 'Hello World']);
    $post2 = Post::create(['title' => 'Hello World']);

    $this->assertEquals('hello-world', $post1->slug);
    $this->assertEquals('hello-world-1', $post2->slug);
});

it('finds a model by slug', function () {
    $post = Post::create(['title' => 'Hello World']);

    $foundPost = Post::findBySlug('hello-world');

    $this->assertNotNull($foundPost);
    $this->assertEquals($post->id, $foundPost->id);
});

it('updates the slug on update', function () {
    $post = Post::create(['title' => 'Hello World']);
    $post->update(['title' => 'Hello Universe']);

    $this->assertEquals('hello-universe', $post->slug);
});
