<?php

namespace App\Http\Controllers\Api\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Meeting;
use App\Jobs\Webhooks\Zoom\UpdateMeetingWebhook;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
    public function update(Request $request)
    {
       $payload = $request->input('payload');

        UpdateMeetingWebhook::dispatch($payload);

        return response()->json(['status' => 'success'], 200);    
    }

    }

