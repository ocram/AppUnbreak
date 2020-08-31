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

### Adding and starting to edit a new product configuration

```bash
$ APP_NAME="<MY_APP_NAME>" FILENAME="${APP_NAME}.json" && cd "Website/storage/app/products" && sudo cp "example.json" "$FILENAME" && sudo chown www-data:www-data "$FILENAME" && sudo chmod 0644 "$FILENAME" && sudo nano "$FILENAME" && cd ../../../..
```

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

### Adding new pieces of advice

#### Wrapper for an individual piece of advice

```
{% if androidMax >= 'XYZ_FIRST_VERSION.00.00' and androidMin <= 'XYZ_LAST_VERSION.99.99' %}
	{% include 'advice/includes/header.html.twig' with { 'uuid': 'XYZ_RANDOM_UUID' } only %}
		{# TOTAL XYZ_RATING/10 | LIKELIHOOD XYZ_RATING/5 | IMPACT XYZ_RATING/5 #}
		<li>{{ _('Open the “Settings” of your device.') }}</li>
		<!-- XYZ_SEQUENCE_OF_PHRASES_AND_STEPS -->
		<li>{{ _f('Leave by pressing %s at the bottom of your device.', include('includes/android/keys/home.html.twig', { 'vendor': vendor, 'version': androidMax }, with_context = false)) | raw }}</li>
	{% include 'advice/includes/footer.html.twig' with { 'vendor': vendor, 'device': device, 'androidMin': androidMin, 'androidMax': androidMax } only %}
{% endif %}
```

#### Single phrases and steps within an individual piece of advice

##### Constant phrases

```
<li>{{ _('At the bottom left, tap on the battery icon.') }}</li>
<li>{{ _('At the top, if the switch is turned off, i.e. with its knob or handle at the left, there’s nothing left for you to do.') }} {{ _('Otherwise, proceed with the next step.') }}</li>
<li>{{ _('At the top, if the switch is turned on, i.e. with its knob or handle at the right, there’s nothing left for you to do.') }} {{ _('Otherwise, proceed with the next step.') }}</li>
<li>{{ _('At the top, make sure the switch is turned off, i.e. with its knob or handle at the left.') }}</li>
<li>{{ _('At the top, make sure the switch is turned on, i.e. with its knob or handle at the right.') }}</li>
<li>{{ _f('At the top right, tap on %s to open the expanded menu.', include('includes/android/menu/overflow.html.twig', { 'vendor': vendor, 'version': androidMax }, with_context = false)) | raw }}</li>
<li>{{ _('At the top right, tap on the gear icon.') }}</li>
<li>{{ _('At the top right, tap on the trash icon.') }}</li>
<li>{{ _('At the very top, tap on the downward-pointing arrow (⌄ or ▾).') }}</li>
<li>{{ _('Do not press the trash icon at the bottom.') }} {{ _('Remember never to tap on the trash icon here.') }}</li>
<li>{{ _('Find the quick settings (where you can also turn on and off Wi-Fi, Bluetooth, etc.).') }}</li>
<li>{{ _f('Go back by pressing %s at the bottom of your device.', include('includes/android/keys/back.html.twig', { 'vendor': vendor, 'version': androidMax }, with_context = false)) | raw }}</li>
<li>{{ _('If the lock icon is closed and has a dot inside its bottom rectangle, there’s nothing left for you to do.') }} {{ _('Otherwise, proceed with the next step.') }}</li>
<li>{{ _c('If you really need more storage space on your device, we recommend deleting photos and videos that you don’t need anymore, or moving them to a different device or drive. In addition to that, consider uninstalling apps that require a lot of space, or managing the space inside of those apps, where possible.', 'XYZ_VENDOR') }}</li>
<li>{{ _('If you’ve opened it by accident, proceed with the next step.') }} {{ _('Otherwise, there’s nothing left for you to do.') }}</li>
<li>{{ _('Make sure that all switches are turned on, i.e. with their knobs or handles at the right, unless you have any specific objections.') }}</li>
<li>{{ _c('Open the “Optimizer” on your device.', 'XYZ_VENDOR') }}</li>
<li>{{ _c('Open the “Phone Manager” on your device.', 'XYZ_VENDOR') }}</li>
<li>{{ _c('Open the “Phone Manager” or “Optimizer” on your device.', 'XYZ_VENDOR') }}</li>
<li>{{ _c('Open the “Smart Manager” on your device.', 'XYZ_VENDOR') }}</li>
<li>{{ _f('Press %s at the bottom of your device to go back to your home screen.', include('includes/android/keys/home.html.twig', { 'vendor': vendor, 'version': androidMax }, with_context = false)) | raw }}</li>
<li>{{ _f('Press %s at the bottom of your device to open the overview of recently used apps.', include('includes/android/keys/recents.html.twig', { 'vendor': vendor, 'version': androidMax }, with_context = false)) | raw }}</li>
<li>{{ _('Scroll back to the top.') }}</li>
<li>{{ _('Scroll down to the bottom half.') }}</li>
<li>{{ _('Scroll further down.') }}</li>
<li>{{ _('Swipe down from the status bar to show notifications and quick settings.') }}</li>
<li>{{ _('Swipe from the right to the left to show the next screen.') }}</li>
<li>{{ _('Tap on the lock icon so that it closes and gets a dot inside its bottom rectangle.') }}</li>
<li>{{ _('Tap on the selected entry again.') }}</li>
<li>{{ _('You don’t need to pay any attention to what’s happening in the bottom half.') }}</li>
```

##### Phrases with a UI label

```
<li>{{ _f('A window with the title “%s” should appear.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the bottom, choose “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the bottom, choose “%s” (gear icon).', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the bottom, tap on “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the bottom, tap on “%s” (gear icon).', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the bottom center, choose “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the bottom center, tap on “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the bottom left, choose “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the bottom left, tap on “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the bottom right, choose “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the bottom right, tap on “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the top, choose “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the top, tap on “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the top, next to “%s”, make sure there’s a checkmark in the checkbox.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the top, next to “%s”, make sure the switch is turned off, i.e. with its knob or handle at the left.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the top, next to “%s”, make sure the switch is turned on, i.e. with its knob or handle at the right.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the top, next to “%s”, remove the checkmark from the checkbox.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the top left, choose “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the top left, tap on “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the top right, choose “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('At the top right, tap on “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Choose “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Choose “%s” again.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Choose “%1$s” or “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Do not press “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _f('Remember never to use “%s” here.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Do not press “%1$s” or “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _f('Remember never to use “%1$s” or “%2$s” here.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Do not press “%s” at the bottom.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _f('Remember never to use “%s” here.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Do not press “%s” at the bottom left.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _f('Remember never to use “%s” here.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Do not press “%s” at the top.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _f('Remember never to use “%s” here.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Do not press “%s” at the very bottom.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _f('Remember never to use “%s” here.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Do not press “%s” in the middle of the screen.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _f('Remember never to use “%s” here.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Do not press “%s” in the upper half.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _f('Remember never to use “%s” here.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Find the “%s” section.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('If it says “%s”, there’s nothing left for you to do.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _('Otherwise, proceed with the next step.') }}</li>
<li>{{ _f('If it says “%1$s”, tap on “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('If it says “%1$s”, tap on “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _('Otherwise, proceed with the next step.') }}</li>
<li>{{ _f('If it says “%1$s” or “%2$s”, proceed with the next step.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('If it says “%1$s” or “%2$s”, there’s nothing left for you to do.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _('Otherwise, proceed with the next step.') }}</li>
<li>{{ _f('If there are no entries in the “%s” section, there’s nothing left for you to do.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }} {{ _('Otherwise, proceed with the next step.') }}</li>
<li>{{ _f('In the “%1$s” section, find “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('In the bottom half, choose “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('In the bottom half, tap on “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('In the bottom half, next to “%1$s”, choose “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('In the bottom half, next to “%1$s”, tap on “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('In the drop-down list at the top, switch from “%1$s” to “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('In the middle of the screen, choose “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('In the middle of the screen, tap on “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Make sure that “%s” is selected.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Make sure that “%s” is turned off (gray).', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Make sure that “%s” is turned on (colored).', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Make sure that either “%1$s” or “%2$s” is selected.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Make sure that it says either “%1$s” or “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Next to “%s”, make sure there’s a checkmark in the checkbox.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Next to “%s”, make sure the switch is turned off, i.e. with its knob or handle at the left.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Next to “%s”, make sure the switch is turned on, i.e. with its knob or handle at the right.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Next to “%s”, make sure the switch is turned off, i.e. with its knob or handle at the left, unless you have any objections.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Next to “%s”, make sure the switch is turned on, i.e. with its knob or handle at the right, unless you have any objections.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Next to “%s”, remove the checkmark from the checkbox.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Next to “%s”, tap on the checkmark in the checkbox.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Next to “%s”, tap on the checkmark in the circle.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Repeat this for all entries in the “%s” section.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Scroll down to the “%s” section.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Select “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Select either “%1$s” or “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Tap on “%s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Tap on “%s” again.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Tap on “%s” at the left side of the screen.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Tap on “%1$s” or “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Tap on an entry in the “%s” section.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
<li>{{ _f('Using the tabs at the top, switch from “%1$s” to “%2$s”.', _c('XYZ_UI_LABEL', 'XYZ_VENDOR'), _c('XYZ_UI_LABEL', 'XYZ_VENDOR')) }}</li>
```

##### Phrases with the app name

```
<li>{{ _f('Find “%s” in the list of apps.', product) }}</li>
<li>{{ _f('If “%s” is in the list of apps, there’s nothing left for you to do.', product) }} {{ _('Otherwise, proceed with the next step.') }}</li>
<li>{{ _f('If “%s” is not in the list of apps, there’s nothing left for you to do.', product) }} {{ _('Otherwise, proceed with the next step.') }}</li>
<li>{{ _f('In the bottom half, find “%s”.', product) }}</li>
<li>{{ _f('In the top-right corner of the entry for “%s”, find the lock icon.', product) }}</li>
<li>{{ _f('In the top-right corner of the entry for “%s”, if there’s a lock icon, there’s nothing left for you to do.', product) }} {{ _('Otherwise, proceed with the next step.') }}</li>
<li>{{ _f('In the top-right corner of the entry for “%s”, there should be a lock icon now.', product) }}</li>
<li>{{ _f('Make sure that “%s” is in the list of apps.', product) }}</li>
<li>{{ _f('Make sure that “%s” is not in the list of apps.', product) }}</li>
<li>{{ _f('Move down the entry for “%s” by swiping to the very bottom.', product) }}</li>
<li>{{ _f('Next to “%s”, make sure there’s a checkmark in the checkbox.', product) }}</li>
<li>{{ _f('Next to “%s”, make sure there are two checkmarks in the checkboxes.', product) }}</li>
<li>{{ _f('Next to “%s”, make sure there are three checkmarks in the checkboxes.', product) }}</li>
<li>{{ _f('Next to “%s”, make sure the switch is turned off, i.e. with its knob or handle at the left.', product) }}</li>
<li>{{ _f('Next to “%s”, make sure the switch is turned on, i.e. with its knob or handle at the right.', product) }}</li>
<li>{{ _f('Next to “%s”, put a checkmark into the checkbox.', product) }}</li>
<li>{{ _f('Open “%s” on your device.', product) }}</li>
<li>{{ _f('Release the entry for “%s” by lifting your finger again.', product) }}</li>
<li>{{ _f('Tap and hold the entry for “%s”.', product) }}</li>
<li>{{ _f('Tap on “%s”.', product) }}</li>
<li>{{ _f('Tap on “%s” again to turn the switch off, i.e. with its knob or handle to the left.', product) }}</li>
<li>{{ _f('Tap on “%s” again to turn the switch on, i.e. with its knob or handle to the right.', product) }}</li>
<li>{{ _f('Tap on “%s” to turn the switch off, i.e. with its knob or handle to the left.', product) }}</li>
<li>{{ _f('Tap on “%s” to turn the switch on, i.e. with its knob or handle to the right.', product) }}</li>
```

## Contributing

All contributions are welcome! If you wish to contribute, please create an issue first so that your feature, problem or question can be discussed.

## License

This project is licensed under the terms of the [GNU AGPL v3](https://www.gnu.org/licenses/agpl-3.0.txt).
