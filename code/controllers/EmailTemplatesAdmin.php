<?php

/**
 * EmailTemplatesAdmin
 *
 * @author lekoala
 */
class EmailTemplatesAdmin extends ModelAdmin
{
    private static $managed_models  = array(
        'EmailTemplate',
    );
    private static $url_segment     = 'emails';
    private static $menu_title      = 'Emails';
    private static $menu_icon       = 'mandrill/images/mail.png';
    private static $allowed_actions = array(
        'ImportForm',
        'SearchForm',
        'PreviewEmail',
        'doSendTestEmail'
    );

    public function getSearchContext()
    {
        $context = parent::getSearchContext();

        return $context;
    }

    public function getList()
    {
        $list = parent::getList();

        return $list;
    }

    public function PreviewEmail()
    {
        $id = (int) $this->getRequest()->getVar('id');

        /* @var $emailTemplate EmailTemplate */
        $emailTemplate = EmailTemplate::get()->byID($id);

        $html = $emailTemplate->renderTemplate();

        return $html;
    }

    public function doSendTestEmail()
    {
        $template  = EmailTemplate::get()->byID($this->getRequest()->postVar('EmailTemplateID'));
        $emailAddr = $this->getRequest()->postVar('SendTestEmail');

        $email = $template->getEmail();

        $email->setTo($emailAddr);

        $res = $email->send();

        if ($res) {
            return 'Test email sent to '.$emailAddr;
        }
        return 'Failed to send test to '.$emailAddr;
    }
}