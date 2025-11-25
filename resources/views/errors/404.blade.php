@include('errors.layout', [
    'code' => 404,
    'title' => __('Page not found'),
    'heading' => __('We lost that page'),
    'description' => __('The page you are looking for may have been removed or moved. Use the link below to get back on track.'),
])
