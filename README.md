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

### Setting up the default product configuration

```bash
$ FILENAME="example.json" && cd "Website/storage/app/products" && sudo touch "$FILENAME" && sudo chown www-data:www-data "$FILENAME" && sudo chmod 0644 "$FILENAME" && sudo nano "$FILENAME" && cd ../../../..
```

```json
{
    "title": {
        "en": "Example App",
        "de": "Beispiel-App"
    },
    "company": {
        "en": "Fictional Company",
        "de": "Erfundene Firma"
    },
    "unofficial": false,
    "listed": false,
    "created": "2019-02-28"
}
```

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

### Managing inline UI element graphics

#### Image sizes and filenames

 * {w} × 16 px → `{ w }x16@1x.png`
 * {w} × 32 px → `{w/2}x16@2x.png`
 * {w} × 48 px → `{w/3}x16@3x.png`
 * {w} × 64 px → `{w/4}x16@4x.png`
 * {w} × 80 px → `{w/5}x16@5x.png`
 * {w} × 96 px → `{w/6}x16@6x.png`

#### Creating the folder structure

```bash
$ cd "Website/public/images"
$ mkdir "<VENDOR_SLUG_LOWERCASE>"
$ cd "<VENDOR_SLUG_LOWERCASE>"
$ mkdir "<OS_VERSION_NUMBER>"
$ cd "<OS_VERSION_NUMBER>"
$ mkdir --parents "keys/back"
$ mkdir --parents "keys/home"
$ mkdir --parents "keys/recents"
$ mkdir --parents "menu/overflow"
$ cd ../..
```

## Contributing

All contributions are welcome! If you wish to contribute, please create an issue first so that your feature, problem or question can be discussed.

## License

This project is licensed under the terms of the [GNU AGPL v3](https://www.gnu.org/licenses/agpl-3.0.txt).
