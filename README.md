# Mailhog for EE
ExpressionEngine 6 add-on that overrides the email settings to use Mailhog.

To use, first install Mailhog and make sure the service is running (see below for mac setup). Then install the add-on in the control panel and go to the settings and enable the add-on in the settings. This add-on hooks into the `email_send` hook and changes the mail settings to use mailhog's default settings.

To install mailhog on mac:
`brew install mailhog`
`brew services start mailhog`
