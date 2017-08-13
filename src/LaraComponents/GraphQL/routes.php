<?php

Route::match(['GET', 'POST'], 'graphql', 'GraphQLController@query');
