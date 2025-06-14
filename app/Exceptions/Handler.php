<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Laravel\Paddle\Exceptions\PaddleException as LaravelPaddleException;
use Throwable;
use App\Exceptions\Integrations\Zoom\ZoomException;
use App\Exceptions\Integrations\Zoom\NotFoundException;
use App\Exceptions\Integrations\Zoom\UnauthorizedException;
use Saloon\RateLimitPlugin\Exceptions\RateLimitReachedException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [

    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
       * Register the exception handling callbacks for the application.
       *
       * @return void
       */
      public function register()
      {
          $this->reportable(function (Throwable $e) {

          });

    $this->renderable(function (NotFoundHttpException $e, $request) {
      if($request->is('api/*')){
        return response()->json([
          'message' => 'Sorry Record not found.'
        ], 404);
      }
    });

  $this->renderable(function (HttpException $e, $request) {
  if ($request->is('api/*')) {
    return response()->json([
      'message' => $e->getMessage(),
    ], $e->getStatusCode());
  }
 });

 $this->renderable(function (MethodNotAllowedHttpException $e, $request) {
   if ($request->is('api/*')) {
     return response()->json([
       'message' => 'The HTTP method used for the request is not allowed.',
     ], 405);
   }
 });
   
$this->renderable(function (\Illuminate\Validation\ValidationException $e, $request) {
       if ($request->is('api/*')) {
           return response()->json([
               'message' => 'Validation Error',
               'errors' => $e->errors(),
           ], 422);
       }
   });

        $this->renderable(function (LaravelPaddleException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'message' => 'A payment error occurred: ' . $e->getMessage(),
                ], 422);
            }
        });

        $this->renderable(function (ZoomException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => $e->getMessage() ?: 'Zoom error',
                ], 400);
            }
        });

        $this->renderable(function (NotFoundException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => $e->getMessage() ?: 'Resource not found',
                ], 404);
            }
        });

        $this->renderable(function (UnauthorizedException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => $e->getMessage() ?: 'Unauthorized',
                ], 403);
            }
        });

        $this->renderable(function (RateLimitReachedException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'error' => 'Rate limit exceeded. Please try again in ' . $e->getLimit()->getRemainingSeconds() . ' seconds.'
                ], 429);
            }
        });
  }
}
