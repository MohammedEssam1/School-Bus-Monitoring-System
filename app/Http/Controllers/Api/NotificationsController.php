<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class NotificationsController extends Controller
{
    use ResponseTrait;
    public function index()
    {
       $notifications= auth()->user()->unreadNotifications;
       return $this->respondSuccess(NotificationResource::collection($notifications));
    }
    public function readAll()
    {
        auth()->user()->unreadNotifications->markAsRead();
        return $this->respondSuccess("Success");
    }

}
