<?php

if (! defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class Mailhog_ext
{
    public $settings = [];
    public $version = "1.0.0";

    public function __construct($settings = [])
    {
        $this->settings = $settings;
    }

    public function activate_extension()
    {
        $data = [
            [
                'class'    => __CLASS__,
                'method'   => 'email_send',
                'hook'     => 'email_send',
                'settings' => serialize($this->settings),
                'priority' => 10,
                'version'  => $this->version,
                'enabled'  => 'y'
            ],

        ];

        foreach ($data as $hook) {
            ee()->db->insert('extensions', $hook);
        }
    }

    public function disable_extension()
    {
        ee()->db->where('class', __CLASS__);
        ee()->db->delete('extensions');

        return true;
    }

    public function update_extension($current = '')
    {
        return true;
    }

    public function settings()
    {
        // Set default settings
        $default_settings = [
            'enabled' => 'n',
        ];

        $this->settings = array_merge($this->settings, $default_settings);

        // Update the settings
        if (ee('Request')->isPost()) {
            $this->settings['enabled'] = ee('Request')->post('enabled');

            ee()->db->where('class', __CLASS__)
                ->update('extensions', ['settings' => serialize($this->settings)]);
        }

        return array(
            'enabled' => array('r', array('y' => "Yes", 'n' => "No"), $this->settings['enabled']),
        );
    }

    public function email_send($mailInfo)
    {
        $enabled = isset($this->settings['enabled']) && get_bool_from_string($this->settings['enabled']);

        if ($enabled) {
            // Set email settings needed for mailhog in config
            ee()->config->set_item('mail_protocol', 'smtp');
            ee()->config->set_item('smtp_server', '127.0.0.1');
            ee()->config->set_item('smtp_port', '1025');
            ee()->config->set_item('email_smtp_crypto', '');
            ee()->config->set_item('newline', "\r\n");
            ee()->config->set_item('crlf', "\r\n");

            // Set email settings needed for mailhog on the email object
            ee()->email->protocol = "smtp";
            ee()->email->charset = "utf-8";
            ee()->email->smtp_host = "127.0.0.1";
            ee()->email->smtp_port = '1025';
            ee()->email->smtp_crypto = "";
            ee()->email->newline = "\r\n";
            ee()->email->crlf = "\r\n";
        }
    }
}
