# ⚡ Contao Flash

This is a bundle for Contao 4.4+. It makes working with flash
messages (short lived, informal messages for a single user) very convenient.

## Features

- 🔋 Ready to use frontend module, including style sheets and JavaScript  
- ⏳ Messages stay in session until rendered (or dismissed)  
- ⁉️ Display success, error, info and entirely custom messages  
- 👽 Advanced features for name-spacing and further customization  
- 📼 Simple and solid, works even in environments with disabled JS  

## Installation

Install via Contao Manager or Composer:

    composer require dieschittigs/contao-flash-bundle

## Basic Usage

Add a new frontend module "Flash Messages" to your page layout.
This is where your messages will be displayed – at the top of the main container might be a good place.

If you want to display a message, say inside a hook method, do it like this:

    // Info
    Flash::info('The weather ☀️ is great today!');

    // Success
    Flash::success('Transaction complete.');

    // Warning
    Flash::warning('Wir brauchen mehr Silos!');

    // Custom html message
    Flash::comfirmnuke('<p>Please confirm.</p><a href="…">Yes.</a><a href="…">Nope.</a>');


ℹ️ *The `Flash` class resides in the `Contao` namespace, so (probably) no `use` statement needed.*

The messages will be saved in the users session. They *wait* until they are rendered in the frontend module, then they
delete themselves. So you have longer running processes with multiple redirects and several messages? No problem 🕶️.

ℹ️ *Messages "stack", so if you have e.g. multiple warnings, they will all be displayed once the frontend module gets displayed*

The resulting HTML might look like this:

    <div class="mod_flash_messages">
        <div class="flash-messages-wrapper">
            <ul class="flash-messages">
                <li class="flash-message warning">
                    <i class="flash-icon"></i>
                    <div class="flash-content">
                        The email address you entered was malformed …
                    </div>
                </li>
                <li class="flash-message success">
                    <i class="flash-icon"></i>
                    <div class="flash-content">
                        … but we were able to fix it. Everything's fine.
                    </div>
                    <a href="flash/clear?id=id2" class="flash-dismiss"></a>
                </li>
            </ul>
            <div class="flash-comm">
                <script>
                    window.ContaoFlash = window.ContaoFlash || {};
                    window.ContaoFlash.clear = [id1, id2];
                </script>
                <noscript>
                    <img width="1" height="1" src="flash/clear?ids=id1,id2" />
                </noscript>
            </div>
        </div>
    <div>

## Advanced Usage

### Creating an advanced flash message

    Flash::warning('Your account has been compromised.')
    ->setAutoDismiss(false) // User has to dismiss this message manually
    ->addClass(['important', 'user']) // Additional CSS classes
    ->setNamespace('profile') // Only show this message in modules with the matching namespace

### Routes

Want to display your messages via JS? Got ya covered!

#### [GET] `flash/get`

Gets you an JSON array with all messages.

    // Response
    [
        {
            id: 'MIW987K',
            type: 'info',
            cssClasses: ['info'],
            message: 'Item purchased',
            autoDismiss: true,
            namespace: 'checkout'
        },
        …
    ]

#### [GET] `flash/clear?id={id}`

Purges the message with the provided id.

#### [GET] `flash/clear?ids={id1,id2}`

Purges the message*s* with the provided id*s*.

### Customize

Take a peek at `Resources/public` for CSS and JS.

MIT © [Die Schittigs](https://www.dieschittigs.de)
