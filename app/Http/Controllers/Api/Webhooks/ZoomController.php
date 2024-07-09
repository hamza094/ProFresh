<?php

namespace App\Http\Controllers\Api\Webhooks;

use App\Http\Controllers\Controller;
use App\Models\Meeting;
use App\Jobs\Webhooks\Zoom\UpdateMeetingWebhook;
use App\Jobs\Webhooks\Zoom\DeleteMeetingWebhook;
use App\Jobs\Webhooks\Zoom\StartMeetingWebhook;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    public function update(Request $request)
    {
       $payload = $request->input('payload');

        UpdateMeetingWebhook::dispatch($payload);

        return response()->json(['status' => 'success'], 200);    
    }

    public function delete(Request $request)
    {
       $payload = $request->input('payload');

        DeleteMeetingWebhook::dispatch($payload);

        return response()->json(['status' => 'success'], 200);    
    }

    public function start(Request $request)
    {
       $payload = $request->input('payload');

        StartMeetingWebhook::dispatch($payload);

        return response()->json(['status' => 'success'], 200);    
    }

    }

