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

### Detecting duplicate UUIDs for pieces of advice

```bash
$ grep -r -i -F -h "{% include 'advice/includes/header.html.twig' with { 'uuid': '" Website/views/advice | sort | uniq -d
```

### Finding wrappers for pieces of advice with the correct syntax

Search for the following regular expression in an editor that easily supports multi-line regular expressions (i.e. not `grep`):

```
(?:\A\{% if androidMax >= ')|(?:#\}\n\{% if androidMax >= ')|(?:\{% endif %\}\n\{% if androidMax >= ')|(?:\{% endif %\}\Z)
```

The number of occurrences minus one should be the number of pieces of advice.

## Contributing

All contributions are welcome! If you wish to contribute, please create an issue first so that your feature, problem or question can be discussed.

## License

This project is licensed under the terms of the [GNU AGPL v3](https://www.gnu.org/licenses/agpl-3.0.txt).
