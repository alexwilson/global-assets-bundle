## TODO ##

- Decide a more descriptive name for this bundle.
    Currently leaning towards "StandaloneAssetsBundle"
- Investigate extracting asset URLs and potentially making them available via HTTP2-PUSH.  This would be configured on a per-block basis.
- Investigate asset inlining: this might be especially useful when dealing with multiple entrypoints exposed via something like webpack.
    i.e. entrypoint for shared CSS, used for the critical path.  This can then be inlined into a response.