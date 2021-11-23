# Mailhog for EE
ExpressionEngine 5-6 add-on that overrides the email settings to use Mailhog.

To use, first install Mailhog and make sure the service is running. Then install the add-on in the control panel and go to the settings and enable the add-on in the settings. This add-on hooks into the `email_send` hook and changes the mail settings to use mailgun's default settings.
