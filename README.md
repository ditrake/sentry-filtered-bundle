# Sentry filtered bundle

## Install
Add to composer.json:
```json
"repositories": [
    {
        "type": "vcs",
        "url": "https://git.crtweb.ru/creative-packages/sentry-filtered-errors"
    }
]
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