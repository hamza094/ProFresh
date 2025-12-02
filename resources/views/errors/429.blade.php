@include('errors.layout', [
    'code' => 429,
    'title' => __('Too many requests'),
    'heading' => __('Easy there!'),
    'description' => __('You are sending too many requests in a short time. Please wait a moment before trying again.'),
])
