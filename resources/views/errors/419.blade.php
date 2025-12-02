@include('errors.layout', [
    'code' => 419,
    'title' => __('Session expired'),
    'heading' => __('Your session timed out'),
    'description' => __('Please refresh the page and try again. We keep sessions short to help protect your account.'),
])
