# Sentry filtered bundle

## Install
Add to composer.json:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://github.com/ditrake/sentry-filtered-bundle.git"
    }
]
```
And execute:
```bash
composer require srr/sentry-filtered-bundle dev-master
```

## Config

```yaml
# config/sentry_filtered.yaml

sentry_filtered:
  filtered_exceptions: 
    - 'Your/Awesome/Exception'
    - 'Your/Another/Awesome/Exception/'
```

And in `config/packages/sentry.yaml`

```yaml
# config/packages/sentry.yaml

sentry:
  options:
    before_send: '@srr_sentry_filtered'
```