@include('errors.layout', [
    'code' => 403,
    'title' => __('Forbidden'),
    'heading' => __('You cannot view this page'),
    'description' => __('You do not have permission to access this resource. Please sign in with the right account or return home.'),
])
