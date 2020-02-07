# Sentry filtered bundle

For simple configured:

```yaml
# config/services.yaml

parameters:
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
    before_send: '@sentry_filtered'
```