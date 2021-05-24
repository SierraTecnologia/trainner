<?php


if (\Muleta\Modules\Features\Resources\FeatureHelper::hasActiveFeature(
    [
        'academy',
    ]
)){
    Route::resource('/trainners', 'TrainnerController')->parameters([
        'trainners' => 'id'
    ]);
}


