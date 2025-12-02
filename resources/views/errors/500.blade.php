@include('errors.layout', [
    'code' => 500,
    'title' => __('Server error'),
    'heading' => __('Something broke on our side'),
    'description' => __('An unexpected error occurred. Our team has been notified and is looking into it.'),
])
