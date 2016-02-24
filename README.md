# MMCmfAdminBundle

### Append to app/AppKernel.php

```
...
    public function registerBundles()
    {
        $bundles = array(
            ...
            new MandarinMedien\MMCmfNodeBundle\MMCmfNodeBundle(),
            new MandarinMedien\MMCmfRoutingBundle\MMCmfRoutingBundle(),
            new MandarinMedien\MMCmfContentBundle\MMCmfContentBundle(),
            new MandarinMedien\MMCmfAdminBundle\MMCmfAdminBundle(),
            ...
            );
    ....
    }
...
```

### Append to app/config/config.yml

```
...
imports:
    - ...
    - { resource: '@MMCmfAdminBundle/Resources/config/config.yml' }
    - { resource: '@MMCmfContentBundle/Resources/config/config.yml' }
    - ...   
...
```

### Append to App/config/routing.yml

```
...

mm_cmf_admin:
    resource: "@MMCmfAdminBundle/Resources/config/routing.yml"
    
mm_cmf_content:
    resource: "@MMCmfContentBundle/Resources/config/routing.yml"
    prefix:   /mmcmfcontent

... other routings ...
    
# put this at the very last     
mm_cmf_routing:
    resource: "@MMCmfRoutingBundle/Resources/config/routing.yml"

...
```