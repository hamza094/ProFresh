<?php

namespace App\Http\Controllers\Api\Webhooks;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Log;
use App\Models\Meeting;
use Illuminate\Http\Request;

class ZoomController extends Controller
{
     public function update(Request $request)
    {
       try {
            $payload = $request->input('payload');
            $meetingId = $payload['object']['id'];
            $updateData = $payload['object'];
            unset($updateData['id'], $updateData['uuid']);

            $meeting = Meeting::where('meeting_id', $meetingId)->first();

            if ($meeting) {
                $meeting->update($updateData);
                  return response()->json(['status' => 'success'], 200);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Meeting not found'], 404);
            }

        } catch (\Exception $e) {
            
            return response()->json(['status' => 'error', 'message' => 'Internal server error'], 500);
        }    
    }

    }

