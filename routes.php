<?php
/**
 * маршруты приложения
 */

Route::get('/user/{user_id}/service/{service_id}/tarifs', 'tarifs');

Route::put('/user/{user_id}/service/{service_id}/tarif', 'tarif');

Route::error('error');