<?php

$methods = config('graphql.route.methods') ?: ['GET', 'POST'];

Route::match($methods, '/', config('graphql.route.controller'));
