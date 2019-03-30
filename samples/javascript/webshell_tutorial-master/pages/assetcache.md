## Adding an Assetcache

`webshell` provides the ability to use asset caches, which are in-memory caches
for storing commonly-used static assets in memory. The cache will serve the
file from memory until it expires or is changed on disk.

### Simple Asset Caching

```
import (
        "github.com/gokyle/webshell"
        "github.com/gokyle/webshell/assetcache"
)

func main() {
        app = webshell.NewApp(...)
        assetcache.BackgroundAttachAssetCache(app, "/assets/", "assets/")
        app.Serve()
}
```

This will attach an asset cache to the app, serving requests for the route
"/assets/" (anything under /assets/) mapping the request to "assets/". This
comes preconfigured to store up to 128 2MB sized items for up to 30 days,
checking hourly for expired items. These values can be changed by modifying
the `MaxItems`, `MaxExpire`, `MaxSize` and `Every` variables in the
`assetcache` package. 


### More Complex Asset Caching

If you want to share an asset cache between two web apps, you can create
an asset cache and attach that to an app:

```
import (
        "github.com/gokyle/webshell"
        "github.com/gokyle/webshell/assetcache"
        "log"
)

func main() {
        app = webshell.NewApp(...)
        tls_app = webshell.NewTLSApp(...)
        cache := assetcache.CreateAssetCache("/assets/", "assets/")
        if err := ac.Start(); err != nil {
                log.Fatal("could not start asset cache: ", err.Error())
        }
        app.AddRoute("/assets/", assetcache.AssetHandler(cache))
        // ...
        log.Fatal(app.Serve())
}
```

That's about all there is to asset caching.
