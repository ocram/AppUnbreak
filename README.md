# AppUnbreak

Are you having problems with notifications, background tasks, automatic synchronization or alarms on your device?

Some manufacturers are forcing excessive restrictions upon their devices in faulty attempts at battery optimization.

While these limitations extend battery life on paper, they do so at the expense of your device’s functionality and of your own convenience.

Learn what you can do to prevent flawed power-saving features from breaking your device’s features.

**Example:** [`appunbreak.com`](https://www.appunbreak.com/) or [`undoze.com`](https://www.undoze.com/)

## Requirements

 * See [delight-im/PHP-Foundation](https://github.com/delight-im/PHP-Foundation#requirements)

## Installation

 * See [delight-im/PHP-Foundation](https://github.com/delight-im/PHP-Foundation#installation)

## Maintenance

### Updating translations

```bash
$ cd Website && sudo -u www-data php ./index.php clear-template-cache && sudo -u www-data php ./index.php precompile-templates && bash ./i18n.sh <LOCALE_CODE_UNDERSCORE> "" "" nofuzzy && cd ..
```

## Contributing

All contributions are welcome! If you wish to contribute, please create an issue first so that your feature, problem or question can be discussed.

## License

This project is licensed under the terms of the [GNU AGPL v3](https://www.gnu.org/licenses/agpl-3.0.txt).
