[![Code Coverage](https://codecov.io/fuzzybaird/envoyforge/master/coverage.svg)](https://codecov.io/fuzzybaird/envoyforge/master)
Envoy Forge API
=========================
This library was build in the hopes to streamline feature branch CI/CD deployment for Envoy. It will have a partner library that turns Envoy into a UI that lets you track the status of builds and features as they move along your custom pipelines.

```php
use Fuzzybaird\Envoyforge\ForgeApiFactory as Forge;


$forge = Forge::init(FORGE_API_KEY);
$response = $forge->create_site('SERVER_KEY', 'myfeature.dev.mysite.io', 'php', '/');
$encrypt = $forge->lets_encrypt('SERVER_KEY',$response->site->id, $response->site->name);
```