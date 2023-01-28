<?php

test('the homepage returns 404', function () {
    $this->get(route('home'))
        ->assertNotFound();
});
