<?php

namespace Tests\Traits;

use App\Interfaces\Zoom;
use App\Services\Api\V1\Zoom\ZoomService;
use App\Services\Api\V1\Zoom\ZoomServiceFake;

trait InteractsWithZoom
{
   private function fakeZoom(): ZoomServiceFake
   {
      $zoomServiceFake = new ZoomServiceFake();

      $this->swap(Zoom::class, $zoomServiceFake);

      return $zoomServiceFake;
   }
}
	