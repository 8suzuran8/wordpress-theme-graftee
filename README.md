/* ------------------------------------
Screenshot
------------------------------------ */
<img alt="画面のスクリーンショット" src="https://github.com/8suzuran8/wordpress-theme-graftee/blob/f4d539efa2174e9f0a06da4098e8d5ecfac49e84/screenshot.png">
/* ------------------------------------
License
------------------------------------ */

graftee WordPress Theme, Copyright 2014 suzuran
graftee is distributed under the terms of the GNU GPL, Version 3 (or later)

This program is free software:
You can redistribute it and/or modify it under the terms of GNU General Public License version 3 (or later).

This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY.
Without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
See the GNU General Public License for more details.

License URI: https://www.gnu.org/licenses/gpl-3.0.html

Unless otherwise specified, all the theme files, scripts and images are licensed under the terms of the GNU GPL, Version 3 (or later).

Scripts and Image was created by suzuran, Copyright 2014 suzuran
All scripts in "/js" folder

/* ------------------------------------
Installation
------------------------------------ */

=== Installation using "Add New Theme" ===
1. From your Admin UI (Dashboard), go to Appearance => Themes. Click the "Add New" button.
2. Search for theme, or click the "Upload" button, and then select the theme you want to install.
3. Click the "Install Now" button.

=== Manual installation ===
1. Upload the "graftee" folder to the "/wp-content/themes/" directory.

=== Activiation and Use ===
1. Activate the Theme through the "Themes" menu in WordPress.
2. Go to Appearance => "graftee Settings" page in customize. Complete the input of all necessary, please click on the "Save changes" button.

/* ------------------------------------
How to develop a child theme?
------------------------------------ */

You do not need knowledge of PHP.
You need advanced knowledge of CSS and prepare oneself for images, so is enough.

1. Decide the theme name
Add the 'Child' in last of theme name.
For example 'Ocean Child', 'Forest Child', 'Kitty Child'.

2. Create directory in wp-content/themes

3. Decide the layout
Left menu or right menu or top menu.

4. Copy wp-content/themes/graftee/style-sample-???-nav.css to child theme directory.

5. Change the file name of the copied css to style.css

6. Edit theme info in style.css

7. Change the size or/and color or/and background image of style.css

8. If you want to use javascript, create a graftee.js in your child theme directory.

Kind Regards,

/* ------------------------------------
About own filters
------------------------------------ */

* graftee_get_public_word_full
Chage all public word

* graftee_get_public_word
Change some public word

* graftee_header_param
This filter is changes nav position in markup.
If returned 'first-nav', nav position is before header element.
default position is after header element.

example code

function my_graftee_header_param() {
    return 'first-nav';
}

add_filter( 'graftee_header_param', 'my_graftee_header_param' );

* graftee_custom_background_args
This filter is changes default custom-background in add_theme_support

* graftee_custom_header_args
This filter is changes default custom-header in add_theme_support

* graftee_blogname
This filter is changes blog name.
In source, 'body > header > p'

* graftee_get_footer_html
This filter is changes footer credit.

/* ------------------------------------
Translations
------------------------------------ */

Currently the following translations are available:

English (by Suzuran)

If you are translating this theme to your language,
Please send the translation to 8suzuran8@gmail.com

Please write your name in the Last-Translator.
I will write your name in the translator name in reaeme.txt.

/* ------------------------------------
Changelog
------------------------------------ */

v1.1.37
* change from 'header' to 'header::before' of header image selector.
* unsuport custom-logo. It is todo.

v1.1.36
* If the top page of the static page, to display the top page menu.

v1.1.35
* Fixed js.php.
* Add body class.

More old history
https://themes.trac.wordpress.org/log/graftee/
