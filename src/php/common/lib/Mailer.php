<?php
//
//namespace App\Lib;
//
//class Mailer
//{
//    private $mailer;
//
//    private $view;
//
//    private $template_dir;
//
//    private $sender;
//
//    public function __construct($from_email, $from_name, \Swift_SmtpTransport $transport)
//    {
//        $this->mailer = \Swift_Mailer::newInstance($transport);
//        $this->sender = [$from_email => $from_name];
//    }
//
//    public function setTemplateDir($dir)
//    {
//        if (!is_dir($dir) || !is_readable($dir)) {
//            throw new \Exception('View directory is not readable: ' . $dir);
//        }
//
//        $dir = rtrim($dir, '/');
//        $this->template_dir = basename($dir);
//
//        $view = new \Phalcon\Mvc\View;
//        $view->setViewsDir(substr($dir, 0, strlen($this->template_dir) * -1));
//        $this->view = $view;
//    }
//
//    public function sendMessage($to, $subject, $body)
//    {
//        $message = \Swift_Message::newInstance($subject)
//            ->setFrom($this->sender)
//            ->setTo($to)
//            ->setBody($body);
//
//        return $this->mailer->send($message);
//    }
//
//    public function sendFromTemplate($to, $subject, $template, array $params = [])
//    {
//        if (empty($this->view)) {
//            throw new \Exception('Template dir is not set. Set it with "setTemplateDir()"');
//        }
//
//        $body = $this->view->getRender($this->template_dir, $template, $params);
//        $message = \Swift_Message::newInstance($subject)
//            ->setFrom($this->sender)
//            ->setTo($to)
//            ->addPart($body, 'text/html');
//
//        return $this->mailer->send($message);
//    }
//}

namespace App\Lib;

/**
 * Sends e-mails based on pre-defined templates
 */
class Mailer
{
    protected $_config;
    protected $_from_name;
    protected $_from_email;

    public function __construct($config)
    {
        $this->_config = $config;
    }

    public function setFrom($email, $name = false)
    {
        $this->_from_email = $email;
        $this->_from_name  = $name;
    }

    public function send($to, $subject, $body, array $attachments = null)
    {
        if (empty($this->_config['host'] || $this->_config['port'])) {
            throw new \Exception("Please specify smpt host and port");
        }

        $mail = new \PHPMailer;
        $mail->isSMTP();
        $mail->Host 	= $this->_config['host'];
        $mail->Port     = $this->_config['port'];
        $mail->CharSet  = 'UTF-8';

        if (!empty($this->_config['username']) && !empty($this->_config['password'])) {
            $mail->SMTPAuth = true;
            $mail->Username = $this->_config['username']; // SMTP username
            $mail->Password = $this->_config['password']; // SMTP password
        }

        if (!empty($this->_config['security'])) {
            $mail->SMTPSecure = $this->_config['security'];
        }

        if (!empty($this->_from_email)) {
            $mail->setFrom($this->_from_email, $this->_from_name);
        }

        $mail->addAddress($to);

        // Add attachments
        if (!empty($attachments)) {
            foreach ($attachments as $attachment) {
                if (is_readable($attachment)) {
                    $mail->addAttachment($attachment);
                }
            }
        }

        // Get template
        if (is_array($body)) {
            $body = $this->getTemplate($body[0], @$body[1]);
        }

        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;

        return $mail->send();
    }

    private function getTemplate($template, $params = null)
    {
        if (empty($this->_config['templates']) || !is_readable($this->_config['templates'])) {
            throw new \Exception("Templates path is not readable");
        }

        $template = rtrim($this->_config['templates'], '/') . '/' . $template . '.phtml';
        if (!file_exists($template)) {
            return '';
        }

        if (!empty($params)) {
            extract($params);
        }

        ob_start();
        include($template);
        return ob_get_clean();
    }
}