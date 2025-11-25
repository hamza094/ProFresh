@include('errors.layout', [
    'code' => 503,
    'title' => __('We will be right back'),
    'heading' => __('Maintenance in progress'),
    'description' => __('We are deploying fresh updates. Please check back in a minute or continue in the mobile app.'),
])
